<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\Hydrates;

use Fi1a\Hydrator\Method;
use Fi1a\Hydrator\NameHelper;
use ReflectionClass;

/**
 * Стратегия для переноса данных из массива в объект с вызовом только публичных сеттеров
 */
class HydratePublicCallSetters extends AbstractHydrateCallSetters
{
    /**
     * @inheritDoc
     */
    protected function getCallMethods(array $data, object $model): array
    {
        $methods = [];
        $reflection = new ReflectionClass($model);
        foreach (array_keys($data) as $name) {
            $methodName = 'set' . NameHelper::classify((string) $name);
            $method = new Method(
                $methodName,
                $reflection->hasMethod($methodName) && $reflection->getMethod($methodName)->isPublic()
            );

            $methods[$name] = $method;
        }

        return $methods;
    }
}
