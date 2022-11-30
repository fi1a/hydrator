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
    public $foo;

    /**
     * @var int
     */
    protected $bar;

    /**
     * @var bool
     */
    private $baz;

    /**
     * Сеттер
     */
    public function setFoo(string $foo): void
    {
        $this->foo = $foo . '_setter';
    }

    /**
     * Сеттер
     */
    protected function setBar(int $bar): void
    {
        $this->bar = $bar + 1;
    }

    /**
     * Геттер
     */
    public function getBar(): int
    {
        return $this->bar;
    }

    /**
     * Сеттер
     */
    private function setBaz(bool $baz): void
    {
        $this->baz = !$baz;
    }

    /**
     * Геттер
     */
    public function getBaz(): bool
    {
        return $this->baz;
    }
}
