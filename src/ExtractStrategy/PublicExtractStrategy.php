<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\ExtractStrategy;

use Fi1a\Hydrator\NameHelper;
use ReflectionClass;

/**
 * Стратегия переноса публичных свойств из объекта в массив
 */
class PublicExtractStrategy extends ExtractStrategy
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
            $fields[$property->getName()] = NameHelper::humanize($property->getName());
        }

        return $fields;
    }
}
