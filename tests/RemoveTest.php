<?php

use Gears\String\Str;

class RemoveTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider removeLeftProvider()
     */
    public function testRemoveLeft($expected, $string, $substring, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->removeLeft($substring);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function removeLeftProvider()
    {
        return array
        (
            array('foo bar', 'foo bar', ''),
            array('oo bar', 'foo bar', 'f'),
            array('bar', 'foo bar', 'foo '),
            array('foo bar', 'foo bar', 'oo'),
            array('foo bar', 'foo bar', 'oo bar'),
            array('fòô bàř', 'fòô bàř', '', 'UTF-8'),
            array('òô bàř', 'fòô bàř', 'f', 'UTF-8'),
            array('bàř', 'fòô bàř', 'fòô ', 'UTF-8'),
            array('fòô bàř', 'fòô bàř', 'òô', 'UTF-8'),
            array('fòô bàř', 'fòô bàř', 'òô bàř', 'UTF-8')
        );
    }

    /**
     * @dataProvider removeRightProvider()
     */
    public function testRemoveRight($expected, $string, $substring, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->removeRight($substring);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function removeRightProvider()
    {
        return array
        (
            array('foo bar', 'foo bar', ''),
            array('foo ba', 'foo bar', 'r'),
            array('foo', 'foo bar', ' bar'),
            array('foo bar', 'foo bar', 'ba'),
            array('foo bar', 'foo bar', 'foo ba'),
            array('fòô bàř', 'fòô bàř', '', 'UTF-8'),
            array('fòô bà', 'fòô bàř', 'ř', 'UTF-8'),
            array('fòô', 'fòô bàř', ' bàř', 'UTF-8'),
            array('fòô bàř', 'fòô bàř', 'bà', 'UTF-8'),
            array('fòô bàř', 'fòô bàř', 'fòô bà', 'UTF-8')
        );
    }

    /**
     * @dataProvider removeWhitespaceProvider()
     */
    public function testRemoveWhitespace($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->removeWhitespace();
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function removeWhitespaceProvider()
    {
        return array
        (
            array('foo bar', '  foo   bar  '),
            array('test string', 'test string'),
            array('Ο συγγραφέας', '   Ο     συγγραφέας  '),
            array('123', ' 123 '),
            array('', ' ', 'UTF-8'), // no-break space (U+00A0)
            array('', '           ', 'UTF-8'), // spaces U+2000 to U+200A
            array('', ' ', 'UTF-8'), // narrow no-break space (U+202F)
            array('', ' ', 'UTF-8'), // medium mathematical space (U+205F)
            array('', '　', 'UTF-8'), // ideographic space (U+3000)
            array('1 2 3', '  1  2  3　　', 'UTF-8'),
            array('', ' '),
            array('', '')
        );
    }
}
