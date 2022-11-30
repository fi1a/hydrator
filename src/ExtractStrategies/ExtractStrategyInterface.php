<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\ExtractStrategies;

/**
 * Стратегия переноса данных из объекта в массив
 */
interface ExtractStrategyInterface
{
    /**
     * Стратегия переноса данных из объекта в массив
     *
     * @param string[]|null $fields
     *
     * @return mixed[]
     */
    public function extract(object $model, ?array $fields): array;
}
