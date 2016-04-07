<?php

use Gears\String\Str;

class IndexOfTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider indexOfProvider()
     */
    public function testIndexOf($expected, $str, $subStr, $offset = 0, $encoding = null)
    {
        $result = Str::s($str, $encoding)->indexOf($subStr, $offset);
        $this->assertEquals($expected, $result);
    }

    public function indexOfProvider()
    {
        return array
        (
            array(6, 'foo & bar', 'bar'),
            array(6, 'foo & bar', 'bar', 0),
            array(false, 'foo & bar', 'baz'),
            array(false, 'foo & bar', 'baz', 0),
            array(0, 'foo & bar & foo', 'foo', 0),
            array(12, 'foo & bar & foo', 'foo', 5),
            array(6, 'fòô & bàř', 'bàř', 0, 'UTF-8'),
            array(false, 'fòô & bàř', 'baz', 0, 'UTF-8'),
            array(0, 'fòô & bàř & fòô', 'fòô', 0, 'UTF-8'),
            array(12, 'fòô & bàř & fòô', 'fòô', 5, 'UTF-8')
        );
    }

    /**
     * @dataProvider indexOfLastProvider()
     */
    public function testIndexOfLast($expected, $str, $subStr, $offset = 0, $encoding = null)
    {
        $result = Str::s($str, $encoding)->indexOfLast($subStr, $offset);
        $this->assertEquals($expected, $result);
    }

    public function indexOfLastProvider()
    {
        return array
        (
            array(6, 'foo & bar', 'bar'),
            array(6, 'foo & bar', 'bar', 0),
            array(false, 'foo & bar', 'baz'),
            array(false, 'foo & bar', 'baz', 0),
            array(12, 'foo & bar & foo', 'foo', 0),
            array(0, 'foo & bar & foo', 'foo', -5),
            array(6, 'fòô & bàř', 'bàř', 0, 'UTF-8'),
            array(false, 'fòô & bàř', 'baz', 0, 'UTF-8'),
            array(12, 'fòô & bàř & fòô', 'fòô', 0, 'UTF-8'),
            array(0, 'fòô & bàř & fòô', 'fòô', -5, 'UTF-8')
        );
    }
}
