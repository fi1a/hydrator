<?php

declare(strict_types=1);

namespace Fi1a\Hydrator;

/**
 * Метод
 */
interface MethodInterface
{
    /**
     * Конструктор
     */
    public function __construct(string $name, bool $isCall);

    /**
     * Возвращает название метода
     */
    public function getName(): string;

    /**
     * Сущществует метод или нет
     */
    public function isCall(): bool;
}
