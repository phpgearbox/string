<?php

use Gears\String\Str;

class ReplaceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider replaceProvider()
     */
    public function testReplace($expected, $string, $search, $replacement, $encoding = null, $caseSensitive = true)
    {
        $str = new Str($string, $encoding);
        $result = $str->replace($search, $replacement, $caseSensitive);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function replaceProvider()
    {
        return array
        (
            array('', '', '', ''),
            array('foo', ' ', ' ', 'foo'),
            array('foo', '\s', '\s', 'foo'),
            array('foo bar', 'foo bar', '', ''),
            array('foo bar', 'foo bar', 'f(o)o', '\1'),
            array('\1 bar', 'foo bar', 'foo', '\1'),
            array('bar', 'foo bar', 'foo ', ''),
            array('far bar', 'foo bar', 'foo', 'far'),
            array('bar bar', 'foo bar foo bar', 'foo ', ''),
            array('', '', '', '', 'UTF-8'),
            array('fòô', ' ', ' ', 'fòô', 'UTF-8'),
            array('fòô', '\s', '\s', 'fòô', 'UTF-8'),
            array('fòô bàř', 'fòô bàř', '', '', 'UTF-8'),
            array('bàř', 'fòô bàř', 'fòô ', '', 'UTF-8'),
            array('far bàř', 'fòô bàř', 'fòô', 'far', 'UTF-8'),
            array('bàř bàř', 'fòô bàř fòô bàř', 'fòô ', '', 'UTF-8'),
            array('bàř bàř', 'fòô bàř fòô bàř', 'fòô ', '',),
            array('bàř bàř', 'fòô bàř fòô bàř', 'fòô ', ''),
            array('fòô bàř fòô bàř', 'fòô bàř fòô bàř', 'Fòô ', ''),
            array('fòô bàř fòô bàř', 'fòô bàř fòô bàř', 'fòÔ ', ''),
            array('fòô bàř bàř', 'fòô bàř [[fòô]] bàř', '[[fòô]] ', ''),
            array('', '', '', '', 'UTF-8', false),
            array('òô', ' ', ' ', 'òô', 'UTF-8', false),
            array('fòô', '\s', '\s', 'fòô', 'UTF-8', false),
            array('fòô bàř', 'fòô bàř', '', '', 'UTF-8', false),
            array('bàř', 'fòô bàř', 'Fòô ', '', 'UTF-8', false),
            array('far bàř', 'fòô bàř', 'fòÔ', 'far', 'UTF-8', false),
            array('bàř bàř', 'fòô bàř fòô bàř', 'Fòô ', '', 'UTF-8', false),
        );
    }

    /**
     * @dataProvider replaceExactProvider()
     */
    public function testReplaceExact($expected, $string, $search, $replacement)
    {
        $str = new Str($string);
        $result = $str->replaceExact($search, $replacement);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function replaceExactProvider()
    {
        return
        [
            ['foo bar', 'foobar', 'foobar', 'foo bar'],
            ['foobar', 'foobar', 'bazbar', 'foo bar'],
            ['foo bar', 'foobar', ['bar', 'bazbar', 'foobar'], ['bar bar', 'baz bar', 'foo bar']],
            ['bar bar', 'bar', ['bar', 'bazbar', 'foobar'], ['bar bar', 'baz bar', 'foo bar']],
            ['baz bar', 'bazbar', ['bar', 'bazbar', 'foobar'], ['bar bar', 'baz bar', 'foo bar']]
        ];
    }

    /**
     * @dataProvider replaceBeginningProvider()
     */
    public function testReplaceBeginning($expected, $string, $search, $replacement, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->replaceBeginning($search, $replacement);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function replaceBeginningProvider()
    {
        return array
        (
            array('', '', '', ''),
            array('foo', '', '', 'foo'),
            array('foo', '\s', '\s', 'foo'),
            array('foo bar', 'foo bar', '', ''),
            array('foo bar', 'foo bar', 'f(o)o', '\1'),
            array('\1 bar', 'foo bar', 'foo', '\1'),
            array('bar', 'foo bar', 'foo ', ''),
            array('far bar', 'foo bar', 'foo', 'far'),
            array('bar foo bar', 'foo bar foo bar', 'foo ', ''),
            array('', '', '', '', 'UTF-8'),
            array('fòô', '', '', 'fòô', 'UTF-8'),
            array('fòô', '\s', '\s', 'fòô', 'UTF-8'),
            array('fòô bàř', 'fòô bàř', '', '', 'UTF-8'),
            array('bàř', 'fòô bàř', 'fòô ', '', 'UTF-8'),
            array('far bàř', 'fòô bàř', 'fòô', 'far', 'UTF-8'),
            array('bàř fòô bàř', 'fòô bàř fòô bàř', 'fòô ', '', 'UTF-8')
        );
    }

    /**
     * @dataProvider replaceEndingProvider()
     */
    public function testReplaceEnding($expected, $string, $search, $replacement, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->replaceEnding($search, $replacement);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function replaceEndingProvider()
    {
        return array
        (
            array('', '', '', ''),
            array('foo', '', '', 'foo'),
            array('foo', '\s', '\s', 'foo'),
            array('foo bar', 'foo bar', '', ''),
            array('foo bar', 'foo bar', 'f(o)o', '\1'),
            array('foo bar', 'foo bar', 'foo', '\1'),
            array('foo bar', 'foo bar', 'foo ', ''),
            array('foo lall', 'foo bar', 'bar', 'lall'),
            array('foo bar foo ', 'foo bar foo bar', 'bar', ''),
            array('', '', '', '', 'UTF-8'),
            array('fòô', '', '', 'fòô', 'UTF-8'),
            array('fòô', '\s', '\s', 'fòô', 'UTF-8'),
            array('fòô bàř', 'fòô bàř', '', '', 'UTF-8'),
            array('fòô', 'fòô bàř', ' bàř', '', 'UTF-8'),
            array('fòôfar', 'fòô bàř', ' bàř', 'far', 'UTF-8'),
            array('fòô bàř fòô', 'fòô bàř fòô bàř', ' bàř', '', 'UTF-8')
        );
    }
}
