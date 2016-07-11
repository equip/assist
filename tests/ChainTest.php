<?php

namespace Equip;

use PHPUnit_Framework_TestCase as TestCase;

class ChainTest extends TestCase
{
    public function testChain()
    {
        $arr = Chain::from([
                'foo' => 'hello',
                'bar' => 'world',
                'baz' => '!',
            ])
            ->filter(function ($value) {
                return ctype_alpha($value);
            });

        $this->assertTrue($arr->hasKey('foo'));
        $this->assertFalse($arr->hasKey('baz'));

        $this->assertTrue($arr->hasValue('hello'));
        $this->assertFalse($arr->hasValue('pirate'));

        $arr = $arr->keys();

        $this->assertFalse($arr->hasKey('foo'));
        $this->assertTrue($arr->hasValue('foo'));

    }
}
