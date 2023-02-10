<?php

declare(strict_types=1);

namespace Fi1a\Hydrator\Hydrates;

/**
 * Стратегия переноса данных из массива в объект
 */
interface HydrateInterface
{
    /**
     * Стратегия переноса данных из массива в объект
     *
     * @param mixed[]  $data
     */
    public function hydrate(array $data, object $model): void;
}
