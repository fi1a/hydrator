<?php

declare(strict_types=1);

namespace Fi1a\Hydrator;

use Fi1a\Hydrator\ExtractStrategies\ExtractPublicCallGettersStrategy;
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
            $extractStrategy = new ExtractPublicCallGettersStrategy();
        }
        $this->extractStrategy = $extractStrategy;
    }

    /**
     * @inheritDoc
     */
    public function extract(object $model, ?array $keys = null): array
    {
        $fields = null;
        if (!is_null($keys)) {
            foreach ($keys as $key) {
                $fields[NameHelper::camelize($key)] = $key;
            }
        }

        return $this->extractStrategy->extract($model, $fields);
    }
}
