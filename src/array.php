<?php

namespace Equip;

/**
 * Get a single value from an array.
 *
 * If the value does not exist, the default will be returned.
 *
 * @param array $source
 * @param string|integer $key
 * @param mixed $default
 *
 * @return mixed
 */
function take(array $source, $key, $default = null)
{
    if (isset($source[$key])) {
        return $source[$key];
    }

    return $default;
}

/**
 * Grab some values from an array.
 *
 * @param array $source
 * @param array|string $keys
 *
 * @return array
 */
function grab(array $source, $keys)
{
    return array_intersect_key(
        $source,
        array_flip((array) $keys)
    );
}

/**
 * Exclude some values from an array.
 *
 * This is the inverse of grab().
 *
 * @param array $source
 * @param array|string $keys
 *
 * @return array
 */
function except(array $source, $keys)
{
    return array_diff_key(
        $source,
        array_flip((array) $keys)
    );
}

/**
 * Take the first value from an array.
 *
 * @param array $list
 *
 * @return mixed
 */
function head(array $list)
{
    return array_shift($list);
}

/**
 * Take the last value from an array.
 *
 * @param array $list
 *
 * @return mixed
 */
function tail(array $list)
{
    return array_pop($list);
}

/**
 * Get an array from a value.
 *
 * If the value is not an array, it is assumed to be a Traversable.
 *
 * @param Traversable|array $value
 *
 * @return array
 */
function to_array($value)
{
    if (is_array($value)) {
        return $value;
    }

    return iterator_to_array($value);
}
