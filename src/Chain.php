<?php

namespace Equip;

use function Equip\Arr\to_array;

class Chain
{
    /**
     * Create a new chain from a source.
     *
     * @param array|Traversable $source
     *
     * @return static
     */
    public static function from($source)
    {
        return new static(to_array($source));
    }

    /**
     * @var array
     */
    private $source;

    /**
     * @param array $source
     */
    public function __construct(array $source)
    {
        $this->source = $source;
    }

    /**
     * Get the current source.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->source;
    }

    /**
     * Check if a key is defined in the source.
     *
     * @param mixed $needle
     *
     * @return boolean
     */
    public function hasKey($needle)
    {
        return array_key_exists($needle, $this->source);
    }

    /**
     * Check if a value is defined in the source.
     *
     * @param mixed $needle
     *
     * @return boolean
     */
    public function hasValue($needle)
    {
        return in_array($needle, $this->source);
    }

    /**
     * Get a copy with only values.
     *
     * @return static
     */
    public function values()
    {
        $copy = clone $this;
        $copy->source = array_values($this->source);

        return $copy;
    }

    /**
     * Get a copy with only keys.
     *
     * @return static
     */
    public function keys()
    {
        $copy = clone $this;
        $copy->source = array_keys($this->source);

        return $copy;
    }

    /**
     * Get a copy merged with new values.
     *
     * @param array $values
     *
     * @return static
     */
    public function merge(array $values)
    {
        $copy = clone $this;
        $copy->source = array_merge($this->source, $values);

        return $copy;
    }

    /**
     * Get a copy intersected with new values.
     *
     * @param array $values
     *
     * @return static
     */
    public function intersect(array $values)
    {
        $copy = clone $this;
        $copy->source = array_intersect($this->source, $values);

        return $copy;
    }

    /**
     * Get a copy diffed with other values.
     *
     * @param array $values
     *
     * @return static
     */
    public function diff(array $values)
    {
        $copy = clone $this;
        $copy->source = array_diff($this->source, $values);

        return $copy;
    }

    /**
     * Get a copy with only unique values.
     *
     * @return static
     */
    public function unique()
    {
        $copy = clone $this;
        $copy->source = array_unique($this->source);

        return $copy;
    }

    /**
     * Reduce the array with a callback.
     *
     * @param callable $fn
     * @param mixed $initial
     *
     * @return mixed
     */
    public function reduce(callable $fn, $initial = null)
    {
        return array_reduce($this->source, $fn, $initial);
    }

    /**
     * Get a copy filtered with a callback.
     *
     * @param callable $fn
     *
     * @return static
     */
    public function filter(callable $fn)
    {
        $copy = clone $this;
        $copy->source = array_filter($this->source, $fn);

        return $copy;
    }

    /**
     * Get a copy mapped with a callback.
     *
     * @param callable $fn
     *
     * @return static
     */
    public function map(callable $fn)
    {
        $copy = clone $this;
        $copy->source = array_map($fn, $this->source);

        return $copy;
    }
}
