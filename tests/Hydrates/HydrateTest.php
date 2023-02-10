<?php

declare(strict_types=1);

namespace Fi1a\Unit\Hydrator\Hydrates;

use Fi1a\Hydrator\Hydrates\Hydrate;
use Fi1a\Hydrator\KeyName\Humanize;
use Fi1a\Unit\Hydrator\Fixtures\Fixture1;
use PHPUnit\Framework\TestCase;

/**
 * Стратегия для переноса данных из массива в объект
 */
class HydrateTest extends TestCase
{
    /**
     * Стратегия переноса данных из массива в объект
     */
    public function testHydrate(): void
    {
        $model = new Fixture1();
        $data = [
            'propertyFoo' => 'string',
            'propertyBar' => 1,
            'propertyBaz' => true,
        ];
        $strategy = new Hydrate();
        $strategy->hydrate($data, $model);
        $this->assertEquals('string', $model->propertyFoo);
        $this->assertEquals(1, $model->getPropertyBar());
        $this->assertEquals(true, $model->getPropertyBaz());
    }

    /**
     * Стратегия переноса данных из массива в объект
     */
    public function testHydrateHumanize(): void
    {
        $model = new Fixture1();
        $data = [
            'property_foo' => 'string',
            'property_bar' => 1,
            'property_baz' => true,
        ];
        $strategy = new Hydrate(new Humanize());
        $strategy->hydrate($data, $model);
        $this->assertEquals('string', $model->propertyFoo);
        $this->assertEquals(1, $model->getPropertyBar());
        $this->assertEquals(true, $model->getPropertyBaz());
    }
}
