<?php

use Gears\String\Str;

class LongestCommonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider longestCommonPrefixProvider()
     */
    public function testLongestCommonPrefix($expected, $string, $otherStr, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->longestCommonPrefix($otherStr);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function longestCommonPrefixProvider()
    {
        return array
        (
            array('foo', 'foobar', 'foo bar'),
            array('foo bar', 'foo bar', 'foo bar'),
            array('f', 'foo bar', 'far boo'),
            array('', 'toy car', 'foo bar'),
            array('', 'foo bar', ''),
            array('fòô', 'fòôbar', 'fòô bar', 'UTF-8'),
            array('fòô bar', 'fòô bar', 'fòô bar', 'UTF-8'),
            array('fò', 'fòô bar', 'fòr bar', 'UTF-8'),
            array('', 'toy car', 'fòô bar', 'UTF-8'),
            array('', 'fòô bar', '', 'UTF-8')
        );
    }

    /**
     * @dataProvider longestCommonSuffixProvider()
     */
    public function testLongestCommonSuffix($expected, $string, $otherStr, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->longestCommonSuffix($otherStr);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function longestCommonSuffixProvider()
    {
        return array
        (
            array('bar', 'foobar', 'foo bar'),
            array('foo bar', 'foo bar', 'foo bar'),
            array('ar', 'foo bar', 'boo far'),
            array('', 'foo bad', 'foo bar'),
            array('', 'foo bar', ''),
            array('bàř', 'fòôbàř', 'fòô bàř', 'UTF-8'),
            array('fòô bàř', 'fòô bàř', 'fòô bàř', 'UTF-8'),
            array(' bàř', 'fòô bàř', 'fòr bàř', 'UTF-8'),
            array('', 'toy car', 'fòô bàř', 'UTF-8'),
            array('', 'fòô bàř', '', 'UTF-8')
        );
    }

    /**
     * @dataProvider longestCommonSubstringProvider()
     */
    public function testLongestCommonSubstring($expected, $string, $otherStr, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->longestCommonSubstring($otherStr);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function longestCommonSubstringProvider()
    {
        return array
        (
            array('foo', 'foobar', 'foo bar'),
            array('foo bar', 'foo bar', 'foo bar'),
            array('oo ', 'foo bar', 'boo far'),
            array('foo ba', 'foo bad', 'foo bar'),
            array('', 'foo bar', ''),
            array('fòô', 'fòôbàř', 'fòô bàř', 'UTF-8'),
            array('fòô bàř', 'fòô bàř', 'fòô bàř', 'UTF-8'),
            array(' bàř', 'fòô bàř', 'fòr bàř', 'UTF-8'),
            array(' ', 'toy car', 'fòô bàř', 'UTF-8'),
            array('', 'fòô bàř', '', 'UTF-8')
        );
    }
}
