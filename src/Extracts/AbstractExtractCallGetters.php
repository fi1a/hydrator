<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\Extracts;

use Closure;
use Fi1a\Hydrator\KeyName\Camelize;
use Fi1a\Hydrator\KeyName\KeyNameInterface;
use Fi1a\Hydrator\Method;
use ReflectionClass;

abstract class AbstractExtractCallGetters implements ExtractInterface
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
     * @var KeyNameInterface
     */
    protected $keyName;

    /**
     * Возвращает класс описывающий вызываемые методы
     *
     * @param string[]|null $fields
     *
     * @return Method[]
     */
    abstract protected function getCallMethods(object $model, ?array $fields): array;

    /**
     * Конструктор
     */
    public function __construct(?KeyNameInterface $keyName = null)
    {
        if (is_null($keyName)) {
            $keyName = new Camelize();
        }
        $this->keyName = $keyName;
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
                if (isset($getters[$name])) {
                    /**
                     * @var Method $method
                     */
                    $method = $getters[$name];
                    if ($method->isCall()) {
                        $data[$key] = call_user_func([$model, $method->getName()]);

                        continue;
                    }
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

        if (!isset($this->methods[$class])) {
            $this->methods[$class] = $this->getCallMethods($model, $fields);
        }

        if (is_null($fields)) {
            if (!isset($this->cacheFields[$class])) {
                $fields = $this->getExtractFields($model);
                /**
                 * @var string $name
                 */
                foreach ($this->methods[$class] as $name => $method) {
                    if (isset($fields[$name]) || !$method->isCall()) {
                        continue;
                    }

                    $fields[$name] = $this->keyName->getArrayKeyName($name);
                }
                $this->cacheFields[$class] = $fields;
            }
            $fields = $this->cacheFields[$class];
        }

        if (!count($fields)) {
            return [];
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
            $fields[$property->getName()] = $this->keyName->getArrayKeyName($property->getName());
        }

        return $fields;
    }
}
