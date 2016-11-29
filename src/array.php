<?php

namespace Equip\Arr;

use Traversable;

/**
 * Check if a key or keys exist in an array.
 *
 * @param array|Traversable $array
 * @param string|integer|array $keys
 *
 * @return boolean
 */
function exists($array, $keys)
{
    $keys = to_array($keys);

    $intersection = array_intersect_key(to_array($array), array_flip($keys));
    return count($intersection) === count($keys);
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
 * Get a list from an array.
 *
 * Similar to array_column(), with the following exceptions:
 *
 * 1. Only returns a list from a single column.
 * 2. Works with iterator collections.
 * 3. Works with object rows.
 *
 * @param array|Traversable $source
 * @param string $column
 *
 * @return array
 */
function column($source, $column = null)
{
    $values = [];

    foreach ($source as $row) {
        if (is_object($row)) {
            if (isset($row->$column)) {
                $values[] = $row->$column;
            }
        } else {
            if (isset($row[$column])) {
                $values[] = $row[$column];
            }
        }
    }

    return $values;
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
 * Search and replace keys in an array.
 * Keys in $source that are not found in $keys_to_replace will be left as is.
 * Keys in $keys_to_replace not found in $source will be ignored.
 *
 * @param array|Traversable $source
 * @param array $keys_to_replace key/value pairs [search => replace]
 *
 * @return array
 */
function array_replace_keys($source, $keys_to_replace)
{
    $source = to_array($source);

    //Only use keys that are present in source
    $keys_to_replace = array_intersect_key($keys_to_replace, $source);

    $keys = array_keys($source);
    $replaced_keys = array_replace(array_combine($keys, $keys), $keys_to_replace);

    return array_combine($replaced_keys, $source);
}

/**
 * Type cast some values in an array.
 *
 * Only defined values will be typed.
 *
 * @param array|Traversable $source
 * @param array $types
 *
 * @return array
 */
function typed($source, array $types)
{
    $source = to_array($source);
    $values = array_intersect_key($source, $types);

    foreach ($values as $key => $value) {
        if ($value !== null) {
            settype($values[$key], $types[$key]);
        }
    }

    return array_replace($source, $values);
}
