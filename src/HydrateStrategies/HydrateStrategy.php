<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\HydrateStrategies;

use Closure;

/**
 * Стратегия для переноса данных из массива в объект
 */
class HydrateStrategy implements HydrateStrategyInterface
{
    /**
     * @var Closure
     */
    private $fn;

    /**
     * @var Closure[]
     */
    private $cache = [];

    /**
     * Конструктор
     */
    public function __construct()
    {
        /**
         * @param mixed[] $data
         */
        $this->fn = static function (array $data, object $model): void {
            /**
             * @var mixed $value
             */
            foreach ($data as $name => $value) {
                $model->$name = $value;
            }
        };
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, object $model): void
    {
        $class = get_class($model);
        if (!isset($this->cache[$class])) {
            $this->cache[$class] = Closure::bind($this->fn, null, $class);
        }
        /** @psalm-suppress PossiblyInvalidFunctionCall */
        $this->cache[$class]($data, $model);
    }
}
