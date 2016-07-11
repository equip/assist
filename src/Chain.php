<?php

namespace Equip;

use function Equip\Arr\to_array;

class Chain
{
    public static function from($source)
    {
        return new static(to_array($source));
    }

    /**
     * @var array
     */
    private $source;

    public function __construct(array $source)
    {
        $this->source = $source;
    }

    public function toArray()
    {
        return $this->source;
    }

    public function hasKey($needle)
    {
        return array_key_exists($needle, $this->source);
    }

    public function hasValue($needle)
    {
        return in_array($needle, $this->source);
    }

    public function reduce(callable $fn, $initial = null)
    {
        return array_reduce($this->source, $fn, $initial);
    }

    public function filter(callable $fn)
    {
        $copy = clone $this;
        $copy->source = array_filter($this->source, $fn);

        return $copy;
    }

    public function map(callable $fn)
    {
        $copy = clone $this;
        $copy->source = array_map($fn, $this->source);

        return $copy;
    }

    public function merge(array $values)
    {
        $copy = clone $this;
        $copy->source = array_merge($this->source, $values);

        return $copy;
    }

    public function intersect(array $values)
    {
        $copy = clone $this;
        $copy->source = array_intersect($this->source, $values);

        return $copy;
    }

    public function diff(array $values)
    {
        $copy = clone $this;
        $copy->source = array_diff($this->source, $values);

        return $copy;
    }

    public function unique()
    {
        $copy = clone $this;
        $copy->source = array_unique($this->source);

        return $copy;
    }

    public function values()
    {
        $copy = clone $this;
        $copy->source = array_values($this->source);

        return $copy;
    }

    public function keys()
    {
        $copy = clone $this;
        $copy->source = array_keys($this->source);

        return $copy;
    }
}
