<?php

declare(strict_types=1);

namespace Fi1a\Unit\Hydrator\HydrateStrategies;

use Fi1a\Hydrator\HydrateStrategies\HydratePublicCallSettersStrategy;
use Fi1a\Unit\Hydrator\Fixtures\Fixture1;
use PHPUnit\Framework\TestCase;

/**
 * Стратегия для переноса данных из массива в объект с вызовом только публичных сеттеров
 */
class HydratePublicCallSettersStrategyTest extends TestCase
{
    /**
     * Стратегия для переноса данных из массива в объект с вызовом только публичных сеттеров
     */
    public function testHydrate(): void
    {
        $model = new Fixture1();
        $data = [
            'foo' => 'string',
            'bar' => 1,
            'baz' => true,
        ];
        $strategy = new HydratePublicCallSettersStrategy();
        $strategy->hydrate($data, $model);
        $this->assertEquals('string_setter', $model->foo);
        $this->assertEquals(1, $model->getBar());
        $this->assertEquals(true, $model->getBaz());
    }
}
