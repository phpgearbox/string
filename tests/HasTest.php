<?php

use Gears\String\Str;

class HasTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider hasLowerCaseProvider()
     */
    public function testHasLowerCase($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->hasLowerCase();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function hasLowerCaseProvider()
    {
        return array
        (
            array(false, ''),
            array(true, 'foobar'),
            array(false, 'FOO BAR'),
            array(true, 'fOO BAR'),
            array(true, 'foO BAR'),
            array(true, 'FOO BAr'),
            array(true, 'Foobar'),
            array(false, 'FÒÔBÀŘ', 'UTF-8'),
            array(true, 'fòôbàř', 'UTF-8'),
            array(true, 'fòôbàř2', 'UTF-8'),
            array(true, 'Fòô bàř', 'UTF-8'),
            array(true, 'fòôbÀŘ', 'UTF-8')
        );
    }

    /**
     * @dataProvider hasUpperCaseProvider()
     */
    public function testHasUpperCase($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->hasUpperCase();
        self::assertInternalType('boolean', $result);
        self::assertEquals($expected, $result);
        self::assertEquals($string, $str);
    }

    public function hasUpperCaseProvider()
    {
        return array
        (
            array(false, ''),
            array(true, 'FOOBAR'),
            array(false, 'foo bar'),
            array(true, 'Foo bar'),
            array(true, 'FOo bar'),
            array(true, 'foo baR'),
            array(true, 'fOOBAR'),
            array(false, 'fòôbàř', 'UTF-8'),
            array(true, 'FÒÔBÀŘ', 'UTF-8'),
            array(true, 'FÒÔBÀŘ2', 'UTF-8'),
            array(true, 'fÒÔ BÀŘ', 'UTF-8'),
            array(true, 'FÒÔBàř', 'UTF-8')
        );
    }
}
