<?php

use Gears\String\Str;

class PadTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider padProvider()
     */
    public function testPad($expected, $string, $length, $padStr = ' ', $padType = 'right', $encoding = null)
    {
        if (Str::s($expected)->contains('Exception'))
        {
            $this->setExpectedException($expected);
        }

        $str = new Str($string, $encoding);
        $result = $str->pad($length, $padStr, $padType);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function padProvider()
    {
        return array
        (
            // length <= str
            array('foo bar', 'foo bar', -1),
            array('foo bar', 'foo bar', 7),
            array('fòô bàř', 'fòô bàř', 7, ' ', 'right', 'UTF-8'),

            // right
            array('foo bar  ', 'foo bar', 9),
            array('foo bar_*', 'foo bar', 9, '_*', 'right'),
            array('fòô bàř¬ø¬', 'fòô bàř', 10, '¬ø', 'right', 'UTF-8'),

            // left
            array('  foo bar', 'foo bar', 9, ' ', 'left'),
            array('_*foo bar', 'foo bar', 9, '_*', 'left'),
            array('¬ø¬fòô bàř', 'fòô bàř', 10, '¬ø', 'left', 'UTF-8'),

            // both
            array('foo bar ', 'foo bar', 8, ' ', 'both'),
            array('¬fòô bàř¬ø', 'fòô bàř', 10, '¬ø', 'both', 'UTF-8'),
            array('¬øfòô bàř¬øÿ', 'fòô bàř', 12, '¬øÿ', 'both', 'UTF-8'),

            // exceptions
            array('InvalidArgumentException', 'foo', 5, 'foo', 'bar')
        );
    }

    /**
     * @dataProvider padLeftProvider()
     */
    public function testPadLeft($expected, $string, $length, $padStr = ' ', $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->padLeft($length, $padStr);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function padLeftProvider()
    {
        return array
        (
            array('  foo bar', 'foo bar', 9),
            array('_*foo bar', 'foo bar', 9, '_*'),
            array('_*_foo bar', 'foo bar', 10, '_*'),
            array('  fòô bàř', 'fòô bàř', 9, ' ', 'UTF-8'),
            array('¬øfòô bàř', 'fòô bàř', 9, '¬ø', 'UTF-8'),
            array('¬ø¬fòô bàř', 'fòô bàř', 10, '¬ø', 'UTF-8'),
            array('¬ø¬øfòô bàř', 'fòô bàř', 11, '¬ø', 'UTF-8')
        );
    }

    /**
     * @dataProvider padRightProvider()
     */
    public function testPadRight($expected, $string, $length, $padStr = ' ', $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->padRight($length, $padStr);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function padRightProvider()
    {
        return array
        (
            array('foo bar  ', 'foo bar', 9),
            array('foo bar_*', 'foo bar', 9, '_*'),
            array('foo bar_*_', 'foo bar', 10, '_*'),
            array('fòô bàř  ', 'fòô bàř', 9, ' ', 'UTF-8'),
            array('fòô bàř¬ø', 'fòô bàř', 9, '¬ø', 'UTF-8'),
            array('fòô bàř¬ø¬', 'fòô bàř', 10, '¬ø', 'UTF-8'),
            array('fòô bàř¬ø¬ø', 'fòô bàř', 11, '¬ø', 'UTF-8')
        );
    }

    /**
     * @dataProvider padBothProvider()
     */
    public function testPadBoth($expected, $string, $length, $padStr = ' ', $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->padBoth($length, $padStr);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function padBothProvider()
    {
        return array
        (
            array('foo bar ', 'foo bar', 8),
            array(' foo bar ', 'foo bar', 9, ' '),
            array('fòô bàř ', 'fòô bàř', 8, ' ', 'UTF-8'),
            array(' fòô bàř ', 'fòô bàř', 9, ' ', 'UTF-8'),
            array('fòô bàř¬', 'fòô bàř', 8, '¬ø', 'UTF-8'),
            array('¬fòô bàř¬', 'fòô bàř', 9, '¬ø', 'UTF-8'),
            array('¬fòô bàř¬ø', 'fòô bàř', 10, '¬ø', 'UTF-8'),
            array('¬øfòô bàř¬ø', 'fòô bàř', 11, '¬ø', 'UTF-8'),
            array('¬fòô bàř¬ø', 'fòô bàř', 10, '¬øÿ', 'UTF-8'),
            array('¬øfòô bàř¬ø', 'fòô bàř', 11, '¬øÿ', 'UTF-8'),
            array('¬øfòô bàř¬øÿ', 'fòô bàř', 12, '¬øÿ', 'UTF-8')
        );
    }
}
