<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\KeyName;

/**
 * Преобразует в "stringHelper"
 */
class Camelize implements KeyNameInterface
{
    /**
     * @inheritDoc
     */
    public function getArrayKeyName(string $name): string
    {
        return $name;
    }

    /**
     * @inheritDoc
     */
    public function getMethodName(string $name): string
    {
        return ucfirst($name);
    }

    /**
     * @inheritDoc
     */
    public function getPropertyName(string $name): string
    {
        return $name;
    }
}
