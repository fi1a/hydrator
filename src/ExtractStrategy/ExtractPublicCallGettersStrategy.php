<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\ExtractStrategy;

use Fi1a\Hydrator\Method;
use Fi1a\Hydrator\NameHelper;
use ReflectionClass;

/**
 * Стратегия переноса данных из объекта в массив с вызовом публичных геттеров
 */
class ExtractPublicCallGettersStrategy extends AbstractExtractCallGettersStrategy
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
            $method = new Method(
                $methodName,
                $reflection->hasMethod($methodName) && $reflection->getMethod($methodName)->isPublic()
            );

            $methods[$name] = $method;
        }

        return $methods;
    }
}
