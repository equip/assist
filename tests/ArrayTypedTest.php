<?php

namespace Equip\Arr;

use ArrayObject;
use PHPUnit_Framework_TestCase as TestCase;

class ArrayTypedTest extends TestCase
{
    public function testTyped()
    {
        $values = [
            'user_id' => '5',
            'account_id' => 1,
            'created_by' => null,
            'is_active' => 1,
        ];

        $output = typed($values, [
            'user_id' => 'int',
            'account_id' => 'int',
            'created_by' => 'int',
            'is_active' => 'bool',
            'email' => 'string',
        ]);

        $this->assertSame($output, [
            'user_id' => 5,
            'account_id' => 1,
            'created_by' => null,
            'is_active' => true,
        ]);
    }
}
