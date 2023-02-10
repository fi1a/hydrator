<?php

declare(strict_types=1);

namespace Fi1a\Unit\Hydrator\Extracts;

use Fi1a\Hydrator\Extracts\ExtractCallGetters;
use Fi1a\Hydrator\Hydrates\Hydrate;
use Fi1a\Hydrator\KeyName\Humanize;
use Fi1a\Unit\Hydrator\Fixtures\Fixture1;
use Fi1a\Unit\Hydrator\Fixtures\Fixture2;
use PHPUnit\Framework\TestCase;

/**
 * Стратегия переноса данных из объекта в массив с вызовом геттеров
 */
class ExtractCallGettersTest extends TestCase
{
    /**
     * Стратегия переноса данных из объекта в массив с вызовом геттеров
     */
    public function testExtract(): void
    {
        $model = new Fixture1();
        $data = [
            'propertyFoo' => 'string',
            'propertyBar' => 1,
            'propertyBaz' => true,
        ];
        $hydrateStrategy = new Hydrate();
        $hydrateStrategy->hydrate($data, $model);
        $extractStrategy = new ExtractCallGetters();
        $this->assertEquals($data, $extractStrategy->extract($model));

        $model = new Fixture2();
        $this->assertEquals([], $extractStrategy->extract($model));
    }

    /**
     * Стратегия переноса данных из объекта в массив с вызовом геттеров
     */
    public function testExtractHumanize(): void
    {
        $model = new Fixture1();
        $data = [
            'property_foo' => 'string',
            'property_bar' => 1,
            'property_baz' => true,
        ];
        $hydrateStrategy = new Hydrate(new Humanize());
        $hydrateStrategy->hydrate($data, $model);
        $extractStrategy = new ExtractCallGetters(new Humanize());
        $this->assertEquals($data, $extractStrategy->extract($model));

        $model = new Fixture2();
        $this->assertEquals([], $extractStrategy->extract($model));
    }
}
