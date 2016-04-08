<?php

use Gears\String\Str;

class StartEndWithTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider startsWithProvider()
     */
    public function testStartsWith($expected, $string, $substring, $caseSensitive = true, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->startsWith($substring, $caseSensitive);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function startsWithProvider()
    {
        return array
        (
            array(true, 'foo bars', 'foo bar'),
            array(true, 'FOO bars', 'foo bar', false),
            array(true, 'FOO bars', 'foo BAR', false),
            array(true, 'FÒÔ bàřs', 'fòô bàř', false, 'UTF-8'),
            array(true, 'fòô bàřs', 'fòô BÀŘ', false, 'UTF-8'),
            array(false, 'foo bar', 'bar'),
            array(false, 'foo bar', 'foo bars'),
            array(false, 'FOO bar', 'foo bars'),
            array(false, 'FOO bars', 'foo BAR'),
            array(false, 'FÒÔ bàřs', 'fòô bàř', true, 'UTF-8'),
            array(false, 'fòô bàřs', 'fòô BÀŘ', true, 'UTF-8')
        );
    }

    /**
     * @dataProvider endsWithProvider()
     */
    public function testEndsWith($expected, $string, $substring, $caseSensitive = true, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->endsWith($substring, $caseSensitive);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function endsWithProvider()
    {
        return array
        (
            array(true, 'foo bars', 'o bars'),
            array(true, 'FOO bars', 'o bars', false),
            array(true, 'FOO bars', 'o BARs', false),
            array(true, 'FÒÔ bàřs', 'ô bàřs', false, 'UTF-8'),
            array(true, 'fòô bàřs', 'ô BÀŘs', false, 'UTF-8'),
            array(false, 'foo bar', 'foo'),
            array(false, 'foo bar', 'foo bars'),
            array(false, 'FOO bar', 'foo bars'),
            array(false, 'FOO bars', 'foo BARS'),
            array(false, 'FÒÔ bàřs', 'fòô bàřs', true, 'UTF-8'),
            array(false, 'fòô bàřs', 'fòô BÀŘS', true, 'UTF-8')
        );
    }
}
