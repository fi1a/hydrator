<?php

declare(strict_types=1);

namespace Fi1a\Unit\Hydrator;

use Fi1a\Hydrator\Extractor;
use Fi1a\Hydrator\Hydrator;
use Fi1a\Unit\Hydrator\Fixtures\Fixture1;
use PHPUnit\Framework\TestCase;

/**
 * Перенос данных из объекта в массив
 */
class ExtractorTest extends TestCase
{
    /**
     * Перенос данных из объекта в массив
     */
    public function testExtract(): void
    {
        $hydrator = new Hydrator();
        $data = [
            'propertyFoo' => 'string',
            'propertyBar' => 1,
            'propertyBaz' => true,
        ];
        $model = $hydrator->hydrate($data, Fixture1::class);
        $extractor = new Extractor();
        $this->assertEquals($data, $extractor->extract($model));
    }

    /**
     * Перенос данных из объекта в массив
     */
    public function testExtractKeys(): void
    {
        $hydrator = new Hydrator();
        $data = [
            'propertyFoo' => 'string',
            'propertyBar' => 1,
            'propertyBaz' => true,
        ];
        $model = $hydrator->hydrate($data, Fixture1::class);
        $extractor = new Extractor();
        $this->assertEquals(['property_bar' => 1,], $extractor->extract($model, ['property_bar']));
    }
}
