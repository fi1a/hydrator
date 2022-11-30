<?php

declare(strict_types=1);

namespace Fi1a\Unit\Hydrator;

use Fi1a\Hydrator\Hydrator;
use Fi1a\Unit\Hydrator\Fixtures\Fixture1;
use PHPUnit\Framework\TestCase;

/**
 * Перенос данных из массива в объект
 */
class HydratorTest extends TestCase
{
    /**
     * Перенос данных из массива в создаваемый объект
     */
    public function testHydrate(): void
    {
        $hydrator = new Hydrator();
        $data = [
            'foo' => 'string',
            'bar' => 1,
            'baz' => true,
        ];
        $model = $hydrator->hydrate($data, Fixture1::class);
        $this->assertEquals('string', $model->foo);
        $this->assertEquals(1, $model->bar);
        $this->assertEquals(true, $model->baz);
    }

    /**
     * Перенос данных из массива в переданный объект
     */
    public function testHydrateModel(): void
    {
        $hydrator = new Hydrator();
        $model = new Fixture1();
        $data = [
            'foo' => 'string',
            'bar' => 1,
            'baz' => true,
        ];
        $hydrator->hydrateModel($data, $model);
        $this->assertEquals('string', $model->foo);
        $this->assertEquals(1, $model->bar);
        $this->assertEquals(true, $model->baz);
    }
}
