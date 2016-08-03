<?php

namespace Equip\Arr;

use ArrayObject;
use PHPUnit_Framework_TestCase as TestCase;

class ArrayTest extends TestCase
{
    private $hash = [
        'company' => 'Acme',
        'owner' => 'Dr Acme',
        'industry' => 'Financial',
    ];

    private $list = [
        ['a'],
        ['b'],
        ['c'],
    ];

    public function testGet()
    {
        // Works with hash
        $this->assertSame(
            'Acme',
            get($this->hash, 'company')
        );

        // Or with list
        $this->assertSame(
            ['b'],
            get($this->list, 1)
        );

        // Value does not exist
        $this->assertSame(
            null,
            get($this->hash, 'missing')
        );

        // Default value can be provided
        $this->assertSame(
            true,
            get($this->hash, 'profitable', true)
        );
    }

    public function testSome()
    {
        // Works with a single key
        $this->assertSame(
            ['company' => 'Acme'],
            some($this->hash, 'company')
        );

        // Or an array of keys
        $this->assertSame(
            ['company' => 'Acme', 'owner' => 'Dr Acme'],
            some($this->hash, ['company', 'owner'])
        );

        // Missing keys do not cause errors
        $this->assertSame(
            [],
            some($this->hash, ['never', 'gonna'])
        );
    }

    public function testWithout()
    {
        // Works with a single key
        $this->assertSame(
            [
                'owner' => 'Dr Acme',
                'industry' => 'Financial',
            ],
            without($this->hash, 'company')
        );

        // Or an array of keys
        $this->assertSame(
            ['industry' => 'Financial'],
            without($this->hash, ['company', 'owner'])
        );

        // Missing keys do not cause errors
        $this->assertSame(
            [
                'company' => 'Acme',
                'owner' => 'Dr Acme',
                'industry' => 'Financial',
            ],
            without($this->hash, ['never', 'gonna'])
        );
    }

    public function testExpect()
    {
        // Works with a single key
        $this->assertSame(
            ['company' => 'Acme'],
            expect($this->hash, 'company')
        );

        // Defines missing keys
        $this->assertSame(
            [
                'company' => 'Acme',
                'owner' => 'Dr Acme',
                'lawyer' => null,
            ],
            expect($this->hash, ['company', 'owner', 'lawyer'])
        );

        // Works with a string for the key
        $this->assertSame(
            ['janitor' => null],
            expect($this->hash, 'janitor')
        );

        // Default value can be set
        $this->assertSame(
            ['janitor' => false],
            expect($this->hash, 'janitor', false)
        );
    }

    public function testHead()
    {
        // Works with no value
        $this->assertNull(head([]));

        // Pulls the first key in hash
        $this->assertSame('Acme', head($this->hash));

        // Array is unchanged
        $this->assertSame('Acme', $this->hash['company']);

        // Works with collections
        $this->assertSame(['a'], head($this->list));
    }

    public function testTail()
    {
        // Works with no value
        $this->assertNull(tail([]));

        // Pulls the last key in hash
        $this->assertSame('Financial', tail($this->hash));

        // Array is unchanged
        $this->assertSame('Financial', $this->hash['industry']);

        // Works with collections
        $this->assertSame(['c'], tail($this->list));
    }

    public function testToArray()
    {
        // Works with arrays
        $this->assertSame([], to_array([]));
        $this->assertSame(['b'], to_array(['b']));

        // And with traversables
        $source = new ArrayObject(['foo' => 'bar']);
        $this->assertSame(['foo' => 'bar'], to_array($source));

        // And with objects
        $source = new \stdClass;
        $source->obj = true;
        $this->assertSame(['obj' => true], to_array($source));

        // And with scalars
        $this->assertSame([true], to_array(true));
        $this->assertSame([3], to_array(3));
        $this->assertSame(['str'], to_array('str'));
    }

    public function testIndexBy()
    {
        $collection = [
            [
                'id' => 1,
                'name' => 'joe',
            ],
            [
                'id' => 2,
                'name' => 'joe',
            ],
            [
                'id' => 3,
                'name' => 'sue',
            ],
        ];

        $indexed = index_by($collection, 'id');

        foreach ($indexed as $key => $row) {
            $this->assertSame($key, $row['id']);
        }

        $collection = array_map(function ($row) {
            return (object) $row;
        }, $collection);

        $indexed = index_by($collection, 'id');

        foreach ($indexed as $key => $row) {
            $this->assertSame($key, $row->id);
        }
    }

    public function testArrayReplaceKeys()
    {
        $source = [
            'foo' => true,
            'bar' => false,
        ];

        $keys_to_replace = [
            'bar' => 'baz',
        ];

        $new_source = array_replace_keys($source, $keys_to_replace);

        $this->assertSame([
            'foo' => true,
            'baz' => false,
        ], $new_source);

        //Test that keys not found in source are ignored
        $source = [
            'foo' => true,
            'baz' => false,
        ];

        $new_source = array_replace_keys($source, $keys_to_replace);
        $this->assertSame($source, $new_source);
    }
}
