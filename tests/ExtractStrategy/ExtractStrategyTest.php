<?php

declare(strict_types=1);

namespace Fi1a\Unit\Hydrator\ExtractStrategy;

use Fi1a\Hydrator\ExtractStrategy\ExtractStrategy;
use Fi1a\Hydrator\HydrateStrategies\HydrateStrategy;
use Fi1a\Unit\Hydrator\Fixtures\Fixture1;
use Fi1a\Unit\Hydrator\Fixtures\Fixture2;
use PHPUnit\Framework\TestCase;

/**
 * Стратегия переноса данных из объекта в массив
 */
class ExtractStrategyTest extends TestCase
{
    /**
     * Стратегия переноса данных из объекта в массив
     */
    public function testExtract(): void
    {
        $model = new Fixture1();
        $data = [
            'property_foo' => 'string',
            'property_bar' => 1,
            'property_baz' => true,
        ];
        $hydrateStrategy = new HydrateStrategy();
        $hydrateStrategy->hydrate($data, $model);
        $extractStrategy = new ExtractStrategy();
        $this->assertEquals($data, $extractStrategy->extract($model));

        $model = new Fixture2();
        $this->assertEquals([], $extractStrategy->extract($model));
    }
}
