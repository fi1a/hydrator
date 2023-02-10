<?php

declare(strict_types=1);

namespace Fi1a\Hydrator;

use Fi1a\Hydrator\Extracts\ExtractInterface;
use Fi1a\Hydrator\Extracts\ExtractPublicCallGetters;

/**
 * Перенос данных из объекта в массив
 */
class Extractor implements ExtractorInterface
{
    /**
     * @var ExtractInterface
     */
    private $extractStrategy;

    public function __construct(?ExtractInterface $extractStrategy = null)
    {
        if (!$extractStrategy) {
            $extractStrategy = new ExtractPublicCallGetters();
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
