<?php

use Gears\String\Str;

class FirstLastTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider firstProvider()
     */
    public function testFirst($expected, $string, $n, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->first($n);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function firstProvider()
    {
        return array
        (
            array('', 'foo bar', -5),
            array('', 'foo bar', 0),
            array('f', 'foo bar', 1),
            array('foo', 'foo bar', 3),
            array('foo bar', 'foo bar', 7),
            array('foo bar', 'foo bar', 8),
            array('', 'fòô bàř', -5, 'UTF-8'),
            array('', 'fòô bàř', 0, 'UTF-8'),
            array('f', 'fòô bàř', 1, 'UTF-8'),
            array('fòô', 'fòô bàř', 3, 'UTF-8'),
            array('fòô bàř', 'fòô bàř', 7, 'UTF-8'),
            array('fòô bàř', 'fòô bàř', 8, 'UTF-8')
        );
    }

    /**
     * @dataProvider lastProvider()
     */
    public function testLast($expected, $string, $n, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->last($n);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function lastProvider()
    {
        return array
        (
            array('', 'foo bar', -5),
            array('', 'foo bar', 0),
            array('r', 'foo bar', 1),
            array('bar', 'foo bar', 3),
            array('foo bar', 'foo bar', 7),
            array('foo bar', 'foo bar', 8),
            array('', 'fòô bàř', -5, 'UTF-8'),
            array('', 'fòô bàř', 0, 'UTF-8'),
            array('ř', 'fòô bàř', 1, 'UTF-8'),
            array('bàř', 'fòô bàř', 3, 'UTF-8'),
            array('fòô bàř', 'fòô bàř', 7, 'UTF-8'),
            array('fòô bàř', 'fòô bàř', 8, 'UTF-8')
        );
    }
}
