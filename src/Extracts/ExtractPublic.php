<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\Extracts;

use ReflectionClass;

/**
 * Стратегия переноса публичных свойств из объекта в массив
 */
class ExtractPublic extends Extract
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
