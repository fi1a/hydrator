<?php

declare(strict_types=1);

namespace Fi1a\Unit\Hydrator\ExtractStrategies;

use Fi1a\Hydrator\ExtractStrategies\ExtractPublicStrategy;
use Fi1a\Hydrator\HydrateStrategies\HydrateStrategy;
use Fi1a\Unit\Hydrator\Fixtures\Fixture1;
use Fi1a\Unit\Hydrator\Fixtures\Fixture2;
use PHPUnit\Framework\TestCase;

/**
 * Стратегия переноса публичных свойств из объекта в массив
 */
class ExtractPublicStrategyTest extends TestCase
{
    /**
     * Стратегия переноса публичных свойств из объекта в массив
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
        $extractStrategy = new ExtractPublicStrategy();
        $this->assertEquals(['property_foo' => 'string',], $extractStrategy->extract($model));

        $model = new Fixture2();
        $this->assertEquals([], $extractStrategy->extract($model));
    }
}
