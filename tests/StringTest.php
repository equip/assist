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
                'snake_case',
                'SnakeCase',
                true,
            ],
            [
                'snake_case',
                'snakeCase',
                false,
            ],
            [
                'snake_camel_case',
                'SnakeCamelCase',
                true,
            ],
            [
                'snake_camel_case',
                'snakeCamelCase',
                false,
            ],
            [
                'snake',
                'Snake',
                true,
            ],
            [
                'snake',
                'snake',
                false,
            ],
            [
                'snake__case',
                'SnakeCase',
                true,
            ],
            [
                'snake__case',
                'snakeCase',
                false,
            ],
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
        $this->assertSame($camel_string, snakeToCamelCase($snake_string, $first));
    }
}
