<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\HydrateStrategies;

use Closure;
use Fi1a\Hydrator\Method;

/**
 * Абстрактная стратегия для переноса данных из массива в объект с вызовом сеттеров
 */
abstract class AbstractCallSettersStrategy implements HydrateStrategyInterface
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
    public function __construct()
    {
        /**
         * @param mixed[]  $data
         * @param Method[]  $setters
         */
        $this->fn = static function (array $data, object $model, array $setters): void {
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
        if (!isset($this->methods[$class])) {
            $this->methods[$class] = $this->getCallMethods($data, $model);
        }
        /** @psalm-suppress PossiblyInvalidFunctionCall */
        $this->cache[$class]($data, $model, $this->methods[$class]);
    }

    /**
     * Преобразует строку из ("string_helper" или "string.helper" или "string-helper") в "StringHelper"
     */
    protected function classify(string $value, string $delimiter = ''): string
    {
        return trim(preg_replace_callback('/(^|_|\.|\-|\/)([a-z ]+)/im', function ($matches) use ($delimiter) {
            return ucfirst(mb_strtolower($matches[2])) . $delimiter;
        }, $value . ' '), ' ' . $delimiter);
    }
}
