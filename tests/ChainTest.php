<?php

namespace Equip;

use PHPUnit_Framework_TestCase as TestCase;

class ChainTest extends TestCase
{
    /**
     * @var array
     */
    private $raw = [
        'foo' => 'hello',
        'bar' => 'world',
        'baz' => '!',
    ];

    /**
     * @var Chain
     */
    private $chain;

    public function setUp()
    {
        $this->chain = Chain::from($this->raw);
    }

    public function testToArray()
    {
        $this->assertSame($this->raw, $this->chain->toArray());
    }

    public function testHasKey()
    {
        $this->assertTrue($this->chain->hasKey('foo'));
        $this->assertFalse($this->chain->hasKey('fizz'));
    }

    public function testValue()
    {
        $this->assertTrue($this->chain->hasValue('hello'));
        $this->assertFalse($this->chain->hasValue('pirates'));
    }

    public function testKeys()
    {
        $arr = $this->chain->keys()->toArray();

        $this->assertSame(array_keys($this->raw), $arr);
    }

    public function testValues()
    {
        $arr = $this->chain->values()->toArray();

        $this->assertSame(array_values($this->raw), $arr);
    }

    public function testMerge()
    {
        $values = [
            'fizz' => 'test',
            'buzz' => 'friends',
        ];
        $arr = $this->chain
            ->merge($values)
            ->toArray();

        $this->assertSame(array_merge($this->raw, $values), $arr);
    }

    public function testIntersect()
    {
        $values = [
            'fizz' => 'test',
            'buzz' => 'world',
        ];
        $arr = $this->chain
            ->intersect($values)
            ->toArray();

        $this->assertSame(array_intersect($this->raw, $values), $arr);
    }

    public function testDiff()
    {
        $values = [
            'fizz' => 'hello',
            'buzz' => 'test',
        ];
        $arr = $this->chain
            ->diff($values)
            ->toArray();

        $this->assertSame(array_diff($this->raw, $values), $arr);
    }

    public function testUnique()
    {
        $arr = $this->chain
            ->unique()
            ->toArray();

        $this->assertSame(array_unique($this->raw), $arr);
    }

    public function testReduce()
    {
        $want = 'world';
        $value = $this->chain->reduce(function ($carry, $item) use ($want) {
            if ($item === $want) {
                return $item;
            }
            return $carry;
        });

        $this->assertSame($want, $value);
    }

    public function testFilter()
    {
        $arr = $this->chain
            ->filter(function ($item) {
                return ctype_alpha($item);
            })
            ->toArray();

        $this->assertArrayHasKey('foo', $arr);
        $this->assertArrayHasKey('bar', $arr);

        $this->assertArrayNotHasKey('baz', $arr);
    }

    public function testMap()
    {
        $arr = $this->chain
            ->map(function ($item) {
                return strrev($item);
            })
            ->toArray();

        $this->assertSame('olleh', $arr['foo']);
        $this->assertSame('dlrow', $arr['bar']);
        $this->assertSame('!', $arr['baz']);
    }
}
