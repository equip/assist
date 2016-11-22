<?php

namespace Equip\String;

use PHPUnit_Framework_TestCase as TestCase;

class StringTest extends TestCase
{
    /**
     * @return array
     */
    public function snakeStringProvider()
    {
        return [
            [
                'SnakeCase',
                'snake_case',
                true,
            ],
            [
                'snakeCase',
                'snake_case',
                false,
            ],
            [
                'SnakeCamelCase',
                'snake_camel_case',
                true,
            ],
            [
                'snakeCamelCase',
                'snake_camel_case',
                false,
            ],
            [
                'Snake',
                'snake',
                true,
            ],
            [
                'snake',
                'snake',
                false,
            ]
        ];
    }

    /**
     * @param $snake_string
     * @param $camel_string
     * @param $first
     * @dataProvider snakeStringProvider
     */
    public function testSnakeToCamelCase($snake_string, $camel_string, $first)
    {
        $this->assertSame($snake_string, snakeToCamelCase($camel_string, $first));
    }
}
