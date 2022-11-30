<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\HydrateStrategies;

use Fi1a\Hydrator\Method;
use ReflectionClass;

/**
 * Стратегия для переноса данных из массива в объект с вызовом сеттеров
 */
class HydrateCallSettersStrategy extends AbstractCallSettersStrategy
{
    /**
     * @inheritDoc
     */
    protected function getCallMethods(array $data, object $model): array
    {
        $methods = [];
        $reflection = new ReflectionClass($model);
        foreach (array_keys($data) as $name) {
            $methodName = 'set' . $this->classify((string) $name);
            $method = new Method($methodName, $reflection->hasMethod($methodName));

            $methods[$name] = $method;
        }

        return $methods;
    }
}
