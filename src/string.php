<?php

namespace Equip\String;

/**
 * Convert a snake_case string to a camelCase one.
 *
 * @param string $snake_string The original snake_case string.
 * @param bool $first Whether the first letter should be capitalized
 *
 * @return string The converted string.
 */
function snakeToCamelCase($snake_string, $first = false)
{
    $camel = implode('', array_map(static function($piece) {
        return empty($piece) ? '' : ucfirst(strtolower($piece));
    }, explode('_', $snake_string)));

    return $first ? $camel : lcfirst($camel);
}
