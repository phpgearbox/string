<?php

use Gears\String\Str;

class TrimTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider trimProvider()
     */
    public function testTrim($expected, $string, $chars = null, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->trim($chars);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function trimProvider()
    {
        return array
        (
            array('foo   bar', '  foo   bar  '),
            array('foo bar', ' foo bar'),
            array('foo bar', 'foo bar '),
            array('foo bar', "\n\t foo bar \n\t"),
            array('fòô   bàř', '  fòô   bàř  '),
            array('fòô bàř', ' fòô bàř'),
            array('fòô bàř', 'fòô bàř '),
            array(' foo bar ', "\n\t foo bar \n\t", "\n\t"),
            array('fòô bàř', "\n\t fòô bàř \n\t", null, 'UTF-8'),
            array('fòô', ' fòô ', null, 'UTF-8'), // narrow no-break space (U+202F)
            array('fòô', '  fòô  ', null, 'UTF-8'), // medium mathematical space (U+205F)
            array('fòô', '           fòô', null, 'UTF-8') // spaces U+2000 to U+200A
        );
    }

    /**
     * @dataProvider trimLeftProvider()
     */
    public function testTrimLeft($expected, $string, $chars = null, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->trimLeft($chars);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function trimLeftProvider()
    {
        return array
        (
            array('foo   bar  ', '  foo   bar  '),
            array('foo bar', ' foo bar'),
            array('foo bar ', 'foo bar '),
            array("foo bar \n\t", "\n\t foo bar \n\t"),
            array('fòô   bàř  ', '  fòô   bàř  '),
            array('fòô bàř', ' fòô bàř'),
            array('fòô bàř ', 'fòô bàř '),
            array('foo bar', '--foo bar', '-'),
            array('fòô bàř', 'òòfòô bàř', 'ò', 'UTF-8'),
            array("fòô bàř \n\t", "\n\t fòô bàř \n\t", null, 'UTF-8'),
            array('fòô ', ' fòô ', null, 'UTF-8'), // narrow no-break space (U+202F)
            array('fòô  ', '  fòô  ', null, 'UTF-8'), // medium mathematical space (U+205F)
            array('fòô', '           fòô', null, 'UTF-8') // spaces U+2000 to U+200A
        );
    }

    /**
     * @dataProvider trimRightProvider()
     */
    public function testTrimRight($expected, $string, $chars = null, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->trimRight($chars);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function trimRightProvider()
    {
        return array
        (
            array('  foo   bar', '  foo   bar  '),
            array('foo bar', 'foo bar '),
            array(' foo bar', ' foo bar'),
            array("\n\t foo bar", "\n\t foo bar \n\t"),
            array('  fòô   bàř', '  fòô   bàř  '),
            array('fòô bàř', 'fòô bàř '),
            array(' fòô bàř', ' fòô bàř'),
            array('foo bar', 'foo bar--', '-'),
            array('fòô bàř', 'fòô bàřòò', 'ò', 'UTF-8'),
            array("\n\t fòô bàř", "\n\t fòô bàř \n\t", null, 'UTF-8'),
            array(' fòô', ' fòô ', null, 'UTF-8'), // narrow no-break space (U+202F)
            array('  fòô', '  fòô  ', null, 'UTF-8'), // medium mathematical space (U+205F)
            array('fòô', 'fòô           ', null, 'UTF-8') // spaces U+2000 to U+200A
        );
    }
}
