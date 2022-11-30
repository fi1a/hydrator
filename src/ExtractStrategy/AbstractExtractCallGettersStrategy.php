<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\ExtractStrategy;

use Closure;
use Fi1a\Hydrator\Method;
use Fi1a\Hydrator\NameHelper;
use ReflectionClass;

abstract class AbstractExtractCallGettersStrategy implements ExtractStrategyInterface
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

    /**
     * @var Method[][]
     */
    private $methods = [];

    /**
     * Возвращает класс описывающий вызываемые методы
     *
     * @return Method[]
     */
    abstract protected function getCallMethods(object $model): array;

    /**
     * Конструктор
     */
    public function __construct()
    {
        /**
         * @param mixed[] $data
         */
        $this->fn = static function (object $model, array $fields, array $getters): array {
            $data = [];
            /**
             * @psalm-suppress MixedAssignment
             * @psalm-suppress MixedArrayOffset
             */
            foreach ($fields as $name => $key) {
                /**
                 * @var Method $method
                 */
                $method = $getters[$name];
                if ($method->isCall()) {
                    $data[$key] = call_user_func([$model, $method->getName()]);

                    continue;
                }

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

        if (!isset($this->methods[$class])) {
            $this->methods[$class] = $this->getCallMethods($model);
        }

        if (!isset($this->cache[$class])) {
            $this->cache[$class] = Closure::bind($this->fn, null, $class);
        }

        /** @psalm-suppress PossiblyInvalidFunctionCall */
        return (array) $this->cache[$class]($model, $fields, $this->methods[$class]);
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
