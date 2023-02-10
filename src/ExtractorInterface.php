<?php

declare(strict_types=1);

namespace Fi1a\Hydrator;

use Fi1a\Hydrator\Extracts\ExtractInterface;

/**
 * Перенос данных из объекта в массив
 */
interface ExtractorInterface
{
    /**
     * Конструктор
     */
    public function __construct(?ExtractInterface $extractStrategy = null);

    /**
     * Перенос данных из объекта в массив
     *
     * @param string[]|null $keys
     *
     * @return mixed[]
     */
    public function extract(object $model, ?array $keys = null): array;
}
