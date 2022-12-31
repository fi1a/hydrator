<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\ExtractStrategies;

use ReflectionClass;

/**
 * Стратегия переноса публичных свойств из объекта в массив
 */
class ExtractPublicStrategy extends ExtractStrategy
{
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
