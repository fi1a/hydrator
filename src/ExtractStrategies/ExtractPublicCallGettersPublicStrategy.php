<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\ExtractStrategies;

use Fi1a\Hydrator\Method;
use Fi1a\Hydrator\NameHelper;
use ReflectionClass;

/**
 * Стратегия переноса данных из объекта в массив с вызовом публичных геттеров и публичных свойств
 */
class ExtractPublicCallGettersPublicStrategy extends AbstractExtractCallGettersStrategy
{
    /**
     * @inheritDoc
     */
    protected function getCallMethods(object $model): array
    {
        $methods = [];
        $reflection = new ReflectionClass($model);
        foreach ($reflection->getProperties() as $property) {
            $name = $property->getName();
            $methodName = 'get' . NameHelper::classify($name);
            $method = new Method(
                $methodName,
                $reflection->hasMethod($methodName) && $reflection->getMethod($methodName)->isPublic()
            );

            $methods[$name] = $method;
        }

        return $methods;
    }

    /**
     * @inheritDoc
     */
    protected function getExtractFields(object $model): array
    {
        $fields = [];
        $reflection = new ReflectionClass($model);
        foreach ($reflection->getProperties() as $property) {
            if (!$property->isPublic()) {
                continue;
            }
            $fields[$property->getName()] = NameHelper::humanize($property->getName());
        }

        return $fields;
    }
}
