<?php

declare(strict_types=1);

namespace Fi1a\Unit\Hydrator\HydrateStrategies;

use Fi1a\Hydrator\HydrateStrategies\HydrateStrategy;
use Fi1a\Unit\Hydrator\Fixtures\Fixture1;
use PHPUnit\Framework\TestCase;

/**
 * Стратегия для переноса данных из массива в объект
 */
class HydrateStrategyTest extends TestCase
{
    /**
     * Стратегия переноса данных из массива в объект
     */
    public function testHydrate(): void
    {
        $model = new Fixture1();
        $data = [
            'foo' => 'string',
            'bar' => 1,
            'baz' => true,
        ];
        $strategy = new HydrateStrategy();
        $strategy->hydrate($data, $model);
        $this->assertEquals('string', $model->foo);
        $this->assertEquals(1, $model->getBar());
        $this->assertEquals(true, $model->getBaz());
    }
}
