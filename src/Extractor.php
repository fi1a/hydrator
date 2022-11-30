<?php

declare(strict_types=1);

namespace Fi1a\Hydrator;

use Fi1a\Hydrator\ExtractStrategies\ExtractStrategy;
use Fi1a\Hydrator\ExtractStrategies\ExtractStrategyInterface;

/**
 * Перенос данных из объекта в массив
 */
class Extractor implements ExtractorInterface
{
    /**
     * @var ExtractStrategyInterface
     */
    private $extractStrategy;

    public function __construct(?ExtractStrategyInterface $extractStrategy = null)
    {
        if (!$extractStrategy) {
            $extractStrategy = new ExtractStrategy();
        }
        $this->extractStrategy = $extractStrategy;
    }

    /**
     * @inheritDoc
     */
    public function extract(object $model, ?array $fields = null): array
    {
        return $this->extractStrategy->extract($model, $fields);
    }
}
