<?php

declare(strict_types=1);

namespace Fi1a\Hydrator;

use Fi1a\Hydrator\HydrateStrategies\HydrateStrategy;
use Fi1a\Hydrator\HydrateStrategies\HydrateStrategyInterface;
use ReflectionClass;
use ReflectionException;

/**
 * Перенос данных из массива в объект
 */
class Hydrator implements HydratorInterface
{
    /**
     * @var object[]
     */
    private $models = [];

    /**
     * @var HydrateStrategyInterface
     */
    private $hydrateStrategy;

    /**
     * @inheritDoc
     */
    public function __construct(?HydrateStrategyInterface $hydrateStrategy = null)
    {
        if (!$hydrateStrategy) {
            $hydrateStrategy = new HydrateStrategy();
        }
        $this->hydrateStrategy = $hydrateStrategy;
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, string $class): object
    {
        $model = $this->createModel($class);
        $this->hydrateModel($data, $model);

        return $model;
    }

    /**
     * @inheritDoc
     */
    public function hydrateModel(array $data, object $model): void
    {
        $this->hydrateStrategy->hydrate($data, $model);
    }

    /**
     * Создать модель из класса
     *
     * @param class-string $class
     *
     * @throws ReflectionException
     */
    private function createModel(string $class): object
    {
        if (!isset($this->models[$class])) {
            $reflection = new ReflectionClass($class);
            $this->models[$class] = $reflection->newInstanceWithoutConstructor();
        }

        return clone $this->models[$class];
    }
}
