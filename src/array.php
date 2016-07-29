<?php

namespace Equip\Arr;

use Traversable;

/**
 * Check if a key exists in an array.
 *
 * @param array|Traversable $array
 * @param string|integer $key
 *
 * @return boolean
 */
function exists($array, $key)
{
    return array_key_exists($key, to_array($array));
}

/**
 * Convert a value to an array.
 *
 * If the value is an array it will be returned.
 * If the value is Traversable it will be converted to an array.
 * If the value is anything else it will be cast to an array.
 *
 * @param mixed $value
 *
 * @return array
 */
function to_array($value)
{
    if (is_array($value)) {
        return $value;
    }

    if ($value instanceof Traversable) {
        return iterator_to_array($value);
    }

    return (array) $value;
}

/**
 * Get a single value from an array.
 *
 * If the value does not exist, the default will be returned.
 *
 * @param array|Traversable $source
 * @param string|integer $key
 * @param mixed $default
 *
 * @return mixed
 */
function get($source, $key, $default = null)
{
    if (exists($source, $key)) {
        return $source[$key];
    }

    return $default;
}

/**
 * Grab some values from an array.
 *
 * @param array|Traversable $source
 * @param array|string $keys
 *
 * @return array
 */
function some($source, $keys)
{
    return array_intersect_key(
        to_array($source),
        array_flip(to_array($keys))
    );
}

/**
 * Exclude some values from an array.
 *
 * This is the inverse of some().
 *
 * @param array|Traversable $source
 * @param array|string $keys
 *
 * @return array
 */
function without($source, $keys)
{
    return array_diff_key(
        to_array($source),
        array_flip(to_array($keys))
    );
}

/**
 * Grab some values from an array, ensuring that all keys are defined.
 *
 * If a given key does not exist, the default value will be set.
 *
 * @param array|Traversable $source
 * @param array|string $keys
 * @param mixed $default
 *
 * @return array
 */
function expect($source, $keys, $default = null)
{
    $defaults = array_fill_keys(
        to_array($keys),
        $default
    );

    $source = to_array($source);

    return array_replace(
        array_intersect_key($source, $defaults),
        array_diff_key($defaults, $source)
    );
}

/**
 * Take the first value from an array.
 *
 * @param array $list
 *
 * @return mixed
 */
function head($list)
{
    $list = to_array($list);
    return array_shift($list);
}

/**
 * Take the last value from an array.
 *
 * @param array $list
 *
 * @return mixed
 */
function tail($list)
{
    $list = to_array($list);
    return array_pop($list);
}

/**
 * Index an collection by a key.
 *
 * Rows in the collection can be arrays or objects.
 *
 * @param array|Traversable $source
 *
 * @return array
 */
function index_by($source, $key)
{
    $indexed = [];

    foreach ($source as $row) {
        if (is_object($row)) {
            $indexed[$row->$key] = $row;
        } else {
            $indexed[$row[$key]] = $row;
        }
    }

    return $indexed;
}

/**
 * Search and replace keys in an array. Keys that are not found will be left as is.
 *
 * @param array|Traversable $source
 * @param array $keys_to_replace key/value pairs [search => replace]
 * @return array
 */
function array_replace_keys($source, $keys_to_replace)
{
    $source = to_array($source);

    $keys = array_keys($source);
    $replaced_keys = array_replace(array_combine($keys, $keys), $keys_to_replace);

    return array_combine($replaced_keys, $source);
}
