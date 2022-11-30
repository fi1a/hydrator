<?php

declare(strict_types=1);

namespace Fi1a\Unit\Hydrator;

use Fi1a\Hydrator\Method;
use PHPUnit\Framework\TestCase;

/**
 * Вызываемый метод
 */
class MethodTest extends TestCase
{
    /**
     * Вызываемый метод
     */
    public function testMethod(): void
    {
        $method = new Method('setName', true);
        $this->assertEquals('setName', $method->getName());
        $this->assertEquals(true, $method->isCall());

        $method = new Method('getName', false);
        $this->assertEquals('getName', $method->getName());
        $this->assertEquals(false, $method->isCall());
    }
}
