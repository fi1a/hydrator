<?php

declare(strict_types=1);

namespace Fi1a\Unit\Hydrator\ExtractStrategy;

use Fi1a\Hydrator\ExtractStrategy\ExtractCallGettersStrategy;
use Fi1a\Hydrator\HydrateStrategies\HydrateStrategy;
use Fi1a\Unit\Hydrator\Fixtures\Fixture1;
use Fi1a\Unit\Hydrator\Fixtures\Fixture2;
use PHPUnit\Framework\TestCase;

/**
 * Стратегия переноса данных из объекта в массив с вызовом геттеров
 */
class ExtractCallGettersStrategyTest extends TestCase
{
    /**
     * Стратегия переноса данных из объекта в массив с вызовом геттеров
     */
    public function testExtract(): void
    {
        $model = new Fixture1();
        $data = [
            'foo' => 'string',
            'bar' => 1,
            'baz' => true,
        ];
        $hydrateStrategy = new HydrateStrategy();
        $hydrateStrategy->hydrate($data, $model);
        $extractStrategy = new ExtractCallGettersStrategy();
        $this->assertEquals($data, $extractStrategy->extract($model));

        $model = new Fixture2();
        $this->assertEquals([], $extractStrategy->extract($model));
    }
}
