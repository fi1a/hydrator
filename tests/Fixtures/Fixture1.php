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
    public $bar;

    /**
     * @var bool
     */
    public $baz;

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
     * Сеттер
     */
    private function setBaz(bool $baz): void
    {
        $this->baz = !$baz;
    }
}
