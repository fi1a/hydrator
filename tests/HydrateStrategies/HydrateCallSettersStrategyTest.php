<?php

declare(strict_types=1);

namespace Fi1a\Unit\Hydrator\HydrateStrategies;

use Fi1a\Hydrator\HydrateStrategies\HydrateCallSettersStrategy;
use Fi1a\Unit\Hydrator\Fixtures\Fixture1;
use PHPUnit\Framework\TestCase;

/**
 * Стратегия для переноса данных из массива в объект с вызовом сеттеров
 */
class HydrateCallSettersStrategyTest extends TestCase
{
    /**
     * Стратегия для переноса данных из массива в объект с вызовом сеттеров
     */
    public function testHydrate(): void
    {
        $model = new Fixture1();
        $data = [
            'foo' => 'string',
            'bar' => 1,
            'baz' => true,
        ];
        $strategy = new HydrateCallSettersStrategy();
        $strategy->hydrate($data, $model);
        $this->assertEquals('string_setter', $model->foo);
        $this->assertEquals(2, $model->getBar());
        $this->assertEquals(false, $model->getBaz());
    }
}
