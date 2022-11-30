<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\ExtractStrategies;

use Closure;
use Fi1a\Hydrator\NameHelper;
use ReflectionClass;

/**
 * Стратегия переноса данных из объекта в массив
 */
class ExtractStrategy implements ExtractStrategyInterface
{
    /**
     * @var Closure
     */
    private $fn;

    /**
     * @var string[][]
     */
    private $cacheFields = [];

    /**
     * @var Closure[]
     */
    private $cache = [];

    public function __construct()
    {
        /**
         * @param string[] $fields
         *
         * @return mixed[]
         */
        $this->fn = static function (object $model, array $fields): array {
            $data = [];
            /**
             * @psalm-suppress MixedAssignment
             * @psalm-suppress MixedArrayOffset
             */
            foreach ($fields as $name => $key) {
                $data[$key] = $model->$name;
            }

            return $data;
        };
    }

    /**
     * @inheritDoc
     */
    public function extract(object $model, ?array $fields = null): array
    {
        $class = get_class($model);
        if (is_null($fields)) {
            if (!isset($this->cacheFields[$class])) {
                $this->cacheFields[$class] = $this->getExtractFields($model);
            }
            $fields = $this->cacheFields[$class];
        }

        if (!count($fields)) {
            return [];
        }

        if (!isset($this->cache[$class])) {
            $this->cache[$class] = Closure::bind($this->fn, null, $class);
        }

        /**
         * @psalm-suppress PossiblyInvalidFunctionCall
         */
        return (array) $this->cache[$class]($model, $fields);
    }

    /**
     * Возвращает свойства для переноса данных из объекта в массив
     *
     * @return string[]
     */
    protected function getExtractFields(object $model): array
    {
        $fields = [];
        $reflection = new ReflectionClass($model);
        foreach ($reflection->getProperties() as $property) {
            $fields[$property->getName()] = NameHelper::humanize($property->getName());
        }

        return $fields;
    }
}
