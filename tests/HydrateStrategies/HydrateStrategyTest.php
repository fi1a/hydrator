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
            'property_foo' => 'string',
            'property_bar' => 1,
            'property_baz' => true,
        ];
        $strategy = new HydrateStrategy();
        $strategy->hydrate($data, $model);
        $this->assertEquals('string', $model->propertyFoo);
        $this->assertEquals(1, $model->getPropertyBar());
        $this->assertEquals(true, $model->getPropertyBaz());
    }
}
