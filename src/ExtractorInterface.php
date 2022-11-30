<?php

declare(strict_types=1);

namespace Fi1a\Hydrator;

/**
 * Перенос данных из объекта в массив
 */
interface ExtractorInterface
{
    /**
     * Перенос данных из объекта в массив
     *
     * @return mixed[]
     */
    public function extract(object $model): array;
}
