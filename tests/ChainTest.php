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
        $this->markTestIncomplete();
    }

    public function testValues()
    {
        $this->markTestIncomplete();
    }

    public function testMerge()
    {
        $this->markTestIncomplete();
    }

    public function testIntersect()
    {
        $this->markTestIncomplete();
    }

    public function testDiff()
    {
        $this->markTestIncomplete();
    }

    public function testUnique()
    {
        $this->markTestIncomplete();
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
