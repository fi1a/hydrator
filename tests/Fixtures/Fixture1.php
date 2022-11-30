<?php

declare(strict_types=1);

namespace Fi1a\Unit\Hydrator\Fixtures;

/**
 * Класс для тестирования
 */
class Fixture1
{
    /**
     * @var string
     */
    public $propertyFoo;

    /**
     * @var int
     */
    protected $propertyBar;

    /**
     * @var bool
     */
    private $propertyBaz;

    /**
     * Сеттер
     */
    public function setPropertyFoo(string $propertyFoo): void
    {
        $this->propertyFoo = $propertyFoo . '_setter';
    }

    /**
     * Сеттер
     */
    protected function setPropertyBar(int $propertyBar): void
    {
        $this->propertyBar = $propertyBar + 1;
    }

    /**
     * Геттер
     */
    public function getPropertyBar(): int
    {
        return $this->propertyBar;
    }

    /**
     * Сеттер
     */
    private function setPropertyBaz(bool $propertyBaz): void
    {
        $this->propertyBaz = !$propertyBaz;
    }

    /**
     * Геттер
     */
    public function getPropertyBaz(): bool
    {
        return $this->propertyBaz;
    }
}
