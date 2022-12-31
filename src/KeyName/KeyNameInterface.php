<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\KeyName;

/**
 * Определяет название ключа массива
 */
interface KeyNameInterface
{
    /**
     * Определяет название ключа массива
     */
    public function getArrayKeyName(string $name): string;

    /**
     * Определяет название метода объекта
     */
    public function getMethodName(string $name): string;

    /**
     * Определяет название метода объекта
     */
    public function getPropertyName(string $name): string;
}
