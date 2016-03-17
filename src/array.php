<?php

namespace Equip;

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
 * Take the first value from an array.
 *
 * @param array $list
 *
 * @return mixed
 */
function head(array $list)
{
    return $list ? current(array_slice($list, 0, 1)) : null;
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
    return $list ? current(array_slice($list, -1, 1)) : null;
}
