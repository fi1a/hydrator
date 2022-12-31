<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\ExtractStrategies;

use Fi1a\Hydrator\Method;
use ReflectionClass;

/**
 * Стратегия переноса данных из объекта в массив с вызовом публичных геттеров
 */
class ExtractPublicCallGettersStrategy extends AbstractExtractCallGettersStrategy
{
    /**
     * @inheritDoc
     */
    protected function getCallMethods(object $model, ?array $fields = null): array
    {
        $methods = [];
        $reflection = new ReflectionClass($model);

        if (is_null($fields)) {
            $fields = [];
            foreach ($reflection->getProperties() as $property) {
                $fields[] = $property->getName();
            }
        }

        foreach ($fields as $name) {
            $methodName = 'get' . $this->keyName->getMethodName($name);
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
            $fields[$property->getName()] = $this->keyName->getArrayKeyName($property->getName());
        }

        return $fields;
    }
}
