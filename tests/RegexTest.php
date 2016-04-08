<?php

use Gears\String\Str;

class RegexTest extends PHPUnit_Framework_TestCase
{
    public function testSetRegexDelimiter()
    {
        $str = new Str('foobar');

        $reflection = new ReflectionClass($str);
        $property = $reflection->getProperty('regexDelimiter');
        $property->setAccessible(true);

        $this->assertEquals('/', $property->getValue($str));
        $str->setRegexDelimiter('#');
        $this->assertEquals('#', $property->getValue($str));
    }

    /**
     * @dataProvider matchesPatternProvider()
     */
    public function testMatchesPattern($expected, $string, $pattern, $options = '', $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->matchesPattern($pattern, $options);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function matchesPatternProvider()
    {
        return
        [
            [true, 'Gears\\String\\Str', 'Gears\\\.*\\\Str'],
            [false, 'Gears\\String\\Str', 'Gears\\\.*\\\Builder'],
            [true, 'Gears\\String\\Str', 'Gears\\\.*\\\Str', 'u'],
            [true, 'fòô bàř test fòô bàř', '^fòô bàř .* fòô bàř$', '', 'UTF-8']
        ];
    }

    /**
     * @dataProvider regexReplaceProvider()
     */
    public function testRegexReplace($expected, $string, $pattern, $replacement, $options = 'msr', $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->regexReplace($pattern, $replacement, $options);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function regexReplaceProvider()
    {
        return array
        (
            array('', '', '', ''),
            array('bar', 'foo', 'f[o]+', 'bar'),
            array('o bar', 'foo bar', 'f(o)o', '\1'),
            array('bar', 'foo bar', 'f[O]+\s', '', 'i'),
            array('foo', 'bar', '[[:alpha:]]{3}', 'foo'),
            array('', '', '', '', 'msr', 'UTF-8'),
            array('bàř', 'fòô ', 'f[òô]+\s', 'bàř', 'msr', 'UTF-8'),
            array('fòô', 'fò', '(ò)', '\\1ô', 'msr', 'UTF-8'),
            array('fòô', 'bàř', '[[:alpha:]]{3}', 'fòô', 'msr', 'UTF-8'),
        );
    }

    /**
     * @dataProvider splitProvider()
     */
    public function testSplit($expected, $string, $pattern, $limit = null, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->split($pattern, $limit);
        $this->assertInternalType('array', $result);

        foreach ($result as $segment)
        {
            $this->assertInstanceOf('Gears\\String\\Str', $segment);
        }

        $counter = count($expected);

        for ($i = 0; $i < $counter; $i++)
        {
            $this->assertEquals($expected[$i], $result[$i]);
        }
    }

    public function splitProvider()
    {
        return array
        (
            array(array('foo,bar,baz'), 'foo,bar,baz', ''),
            array(array('foo,bar,baz'), 'foo,bar,baz', '-'),
            array(array('foo', 'bar', 'baz'), 'foo,bar,baz', ','),
            array(array('foo', 'bar', 'baz'), 'foo,bar,baz', ',', null),
            array(array('foo', 'bar', 'baz'), 'foo,bar,baz', ',', -1),
            array(array(), 'foo,bar,baz', ',', 0),
            array(array('foo'), 'foo,bar,baz', ',', 1),
            array(array('foo', 'bar'), 'foo,bar,baz', ',', 2),
            array(array('foo', 'bar', 'baz'), 'foo,bar,baz', ',', 3),
            array(array('foo', 'bar', 'baz'), 'foo,bar,baz', ',', 10),
            array(array('fòô,bàř,baz'), 'fòô,bàř,baz', '-', null, 'UTF-8'),
            array(array('fòô', 'bàř', 'baz'), 'fòô,bàř,baz', ',', null, 'UTF-8'),
            array(array('fòô', 'bàř', 'baz'), 'fòô,bàř,baz', ',', null, 'UTF-8'),
            array(array('fòô', 'bàř', 'baz'), 'fòô,bàř,baz', ',', -1, 'UTF-8'),
            array(array(), 'fòô,bàř,baz', ',', 0, 'UTF-8'),
            array(array('fòô'), 'fòô,bàř,baz', ',', 1, 'UTF-8'),
            array(array('fòô', 'bàř'), 'fòô,bàř,baz', ',', 2, 'UTF-8'),
            array(array('fòô', 'bàř', 'baz'), 'fòô,bàř,baz', ',', 3, 'UTF-8'),
            array(array('fòô', 'bàř', 'baz'), 'fòô,bàř,baz', ',', 10, 'UTF-8'),
        );
    }
}
