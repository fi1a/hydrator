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
            'property_foo' => 'string',
            'property_bar' => 1,
            'property_baz' => true,
        ];
        $strategy = new HydrateCallSettersStrategy();
        $strategy->hydrate($data, $model);
        $this->assertEquals('string_setter', $model->propertyFoo);
        $this->assertEquals(2, $model->getPropertyBar());
        $this->assertEquals(false, $model->getPropertyBaz());
    }
}
