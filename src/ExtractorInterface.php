<?php

declare(strict_types=1);

namespace Fi1a\Hydrator;

use Fi1a\Hydrator\ExtractStrategies\ExtractStrategyInterface;

/**
 * Перенос данных из объекта в массив
 */
interface ExtractorInterface
{
    /**
     * Конструктор
     */
    public function __construct(?ExtractStrategyInterface $extractStrategy = null);

    /**
     * Перенос данных из объекта в массив
     *
     * @param string[]|null $fields
     *
     * @return mixed[]
     */
    public function extract(object $model, ?array $fields = null): array;
}
