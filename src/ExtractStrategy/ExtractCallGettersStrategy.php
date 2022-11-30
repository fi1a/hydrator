<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\ExtractStrategy;

use Fi1a\Hydrator\Method;
use Fi1a\Hydrator\NameHelper;
use ReflectionClass;

/**
 * Стратегия переноса данных из объекта в массив с вызовом геттеров
 */
class ExtractCallGettersStrategy extends AbstractExtractCallGettersStrategy
{
    /**
     * @inheritDoc
     */
    protected function getCallMethods(array $fields, object $model): array
    {
        $methods = [];
        $reflection = new ReflectionClass($model);
        foreach ($fields as $name) {
            $methodName = 'get' . NameHelper::classify($name);
            $method = new Method($methodName, $reflection->hasMethod($methodName));

            $methods[$name] = $method;
        }

        return $methods;
    }
}
