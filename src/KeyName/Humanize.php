<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\KeyName;

use Fi1a\Hydrator\NameHelper;

/**
 * Преобразует в "string_helper"
 */
class Humanize implements KeyNameInterface
{
    /**
     * @inheritDoc
     */
    public function getArrayKeyName(string $name): string
    {
        return NameHelper::humanize($name);
    }

    /**
     * @inheritDoc
     */
    public function getMethodName(string $name): string
    {
        return NameHelper::classify($name);
    }

    /**
     * @inheritDoc
     */
    public function getPropertyName(string $name): string
    {
        return lcfirst(NameHelper::classify($name));
    }
}
