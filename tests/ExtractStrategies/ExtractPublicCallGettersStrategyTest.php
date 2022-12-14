<?php

declare(strict_types=1);

namespace Fi1a\Unit\Hydrator\ExtractStrategies;

use Fi1a\Hydrator\ExtractStrategies\ExtractPublicCallGettersStrategy;
use Fi1a\Hydrator\HydrateStrategies\HydrateStrategy;
use Fi1a\Hydrator\KeyName\Humanize;
use Fi1a\Unit\Hydrator\Fixtures\Fixture1;
use Fi1a\Unit\Hydrator\Fixtures\Fixture2;
use PHPUnit\Framework\TestCase;

/**
 * Стратегия переноса данных из объекта в массив с вызовом публичных геттеров
 */
class ExtractPublicCallGettersStrategyTest extends TestCase
{
    /**
     * Стратегия переноса данных из объекта в массив с вызовом публичных геттеров
     */
    public function testExtract(): void
    {
        $model = new Fixture1();
        $data = [
            'propertyFoo' => 'string',
            'propertyBar' => 1,
            'propertyBaz' => true,
        ];
        $hydrateStrategy = new HydrateStrategy();
        $hydrateStrategy->hydrate($data, $model);
        $extractStrategy = new ExtractPublicCallGettersStrategy();
        $this->assertEquals($data, $extractStrategy->extract($model));

        $model = new Fixture2();
        $this->assertEquals([], $extractStrategy->extract($model));
    }

    /**
     * Стратегия переноса данных из объекта в массив с вызовом публичных геттеров
     */
    public function testExtractHuminize(): void
    {
        $model = new Fixture1();
        $data = [
            'property_foo' => 'string',
            'property_bar' => 1,
            'property_baz' => true,
        ];
        $hydrateStrategy = new HydrateStrategy(new Humanize());
        $hydrateStrategy->hydrate($data, $model);
        $extractStrategy = new ExtractPublicCallGettersStrategy(new Humanize());
        $this->assertEquals($data, $extractStrategy->extract($model));

        $model = new Fixture2();
        $this->assertEquals([], $extractStrategy->extract($model));
    }
}
