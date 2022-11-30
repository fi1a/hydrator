<?php

declare(strict_types=1);

namespace Fi1a\Hydrator;

use Fi1a\Hydrator\HydrateStrategies\HydrateStrategyInterface;

/**
 * Перенос данных из массива в объект
 */
interface HydratorInterface
{
    /**
     * Конструктор
     */
    public function __construct(?HydrateStrategyInterface $hydrateStrategy = null);

    /**
     * Перенос данных из массива в создаваемый объект
     *
     * @param mixed[] $data
     * @param class-string  $class
     */
    public function hydrate(array $data, string $class): object;

    /**
     * Перенос данных из массива в переданный объект
     *
     * @param mixed[]  $data
     */
    public function hydrateModel(array $data, object $model): void;
}
