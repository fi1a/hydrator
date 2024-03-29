<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\Hydrates;

use Closure;
use Fi1a\Hydrator\KeyName\Camelize;
use Fi1a\Hydrator\KeyName\KeyNameInterface;
use Fi1a\Hydrator\Method;

/**
 * Абстрактная стратегия для переноса данных из массива в объект с вызовом сеттеров
 */
abstract class AbstractHydrateCallSetters implements HydrateInterface
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
     * @var Method[][]
     */
    private $methods = [];

    /**
     * Возвращает класс описывающий вызываемые методы
     *
     * @param mixed[]  $data
     *
     * @return Method[]
     */
    abstract protected function getCallMethods(array $data, object $model): array;

    /**
     * Конструктор
     */
    public function __construct(?KeyNameInterface $keyName = null)
    {
        if (is_null($keyName)) {
            $keyName = new Camelize();
        }

        /**
         * @param mixed[]  $data
         * @param Method[]  $setters
         */
        $this->fn = static function (array $data, object $model, array $setters) use ($keyName): void {
            /**
             * @var mixed $value
             */
            foreach ($data as $name => $value) {
                /**
                 * @var Method $method
                 */
                $method = $setters[$name];
                if ($method->isCall()) {
                    call_user_func([$model, $method->getName()], $value);

                    continue;
                }
                $property = $keyName->getPropertyName((string) $name);
                $model->$property = $value;
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
        if (!isset($this->methods[$class])) {
            $this->methods[$class] = $this->getCallMethods($data, $model);
        }
        /** @psalm-suppress PossiblyInvalidFunctionCall */
        $this->cache[$class]($data, $model, $this->methods[$class]);
    }
}
