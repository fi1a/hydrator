<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\ExtractStrategies;

use Fi1a\Hydrator\Method;
use ReflectionClass;

/**
 * Стратегия переноса данных из объекта в массив с вызовом геттеров
 */
class ExtractCallGettersStrategy extends AbstractExtractCallGettersStrategy
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
            $method = new Method($methodName, $reflection->hasMethod($methodName));

            $methods[$name] = $method;
        }

        return $methods;
    }
}
