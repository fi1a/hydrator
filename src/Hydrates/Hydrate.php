<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\Hydrates;

use Closure;
use Fi1a\Hydrator\KeyName\Camelize;
use Fi1a\Hydrator\KeyName\KeyNameInterface;

/**
 * Стратегия для переноса данных из массива в объект
 */
class Hydrate implements HydrateInterface
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
    public function __construct(?KeyNameInterface $keyName = null)
    {
        if (is_null($keyName)) {
            $keyName = new Camelize();
        }
        /**
         * @param mixed[] $data
         */
        $this->fn = static function (array $data, object $model) use ($keyName): void {
            /**
             * @var mixed $value
             */
            foreach ($data as $name => $value) {
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
        /** @psalm-suppress PossiblyInvalidFunctionCall */
        $this->cache[$class]($data, $model);
    }
}
