<?php

declare(strict_types=1);

namespace Fi1a\Hydrator;

/**
 * Вызываемый метод
 */
class Method implements MethodInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $isCall;

    /**
     * @inheritDoc
     */
    public function __construct(string $name, bool $isCall)
    {
        $this->name = $name;
        $this->isCall = $isCall;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function isCall(): bool
    {
        return $this->isCall;
    }
}
