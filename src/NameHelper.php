<?php

declare(strict_types=1);

namespace Fi1a\Hydrator;

/**
 * Вспомогательные методы для формирования имен ключей и методов объекта
 */
class NameHelper
{
    /**
     * Преобразует строку из ("string_helper" или "string.helper" или "string-helper") в "StringHelper"
     */
    public static function classify(string $value, string $delimiter = ''): string
    {
        return trim(preg_replace_callback('/(^|_|\.|\-|\/)([a-z ]+)/im', function ($matches) use ($delimiter) {
            return ucfirst(mb_strtolower($matches[2])) . $delimiter;
        }, $value . ' '), ' ' . $delimiter);
    }

    /**
     * Преобразует строку из "StringHelper" в "string_helper"
     *
     * @param string $value     значение для преобразования
     * @param string $delimiter разделитель между словами
     */
    public static function humanize(string $value, string $delimiter = '_'): string
    {
        $result = mb_strtolower(preg_replace('/(?<=\w)([A-Z])/m', '_\\1', $value));
        /**
         * @var string $search
         */
        $search = '\\';
        if (strpos($search, $result) === false) {
            $search = '_';
        }

        return str_replace($search, $delimiter, $result);
    }

    /**
     * Преобразует строку из ("string_helper" или "string.helper" или "string-helper") в "stringHelper"
     *
     * @param string $value значение для преобразования
     */
    public static function camelize(string $value, string $delimiter = ''): string
    {
        return lcfirst(static::classify($value, $delimiter));
    }
}
