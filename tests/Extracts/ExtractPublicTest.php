<?php

declare(strict_types=1);

namespace Fi1a\Unit\Hydrator\Extracts;

use Fi1a\Hydrator\Extracts\ExtractPublic;
use Fi1a\Hydrator\Hydrates\Hydrate;
use Fi1a\Hydrator\KeyName\Humanize;
use Fi1a\Unit\Hydrator\Fixtures\Fixture1;
use Fi1a\Unit\Hydrator\Fixtures\Fixture2;
use PHPUnit\Framework\TestCase;

/**
 * Стратегия переноса публичных свойств из объекта в массив
 */
class ExtractPublicTest extends TestCase
{
    /**
     * Стратегия переноса публичных свойств из объекта в массив
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
        $extractStrategy = new ExtractPublic();
        $this->assertEquals(['propertyFoo' => 'string',], $extractStrategy->extract($model));

        $model = new Fixture2();
        $this->assertEquals([], $extractStrategy->extract($model));
    }

    /**
     * Стратегия переноса публичных свойств из объекта в массив
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
        $extractStrategy = new ExtractPublic(new Humanize());
        $this->assertEquals(['property_foo' => 'string',], $extractStrategy->extract($model));

        $model = new Fixture2();
        $this->assertEquals([], $extractStrategy->extract($model));
    }
}
