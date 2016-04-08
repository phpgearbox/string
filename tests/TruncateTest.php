<?php

use Gears\String\Str;

class TruncateTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider truncateProvider()
     */
    public function testTruncate($expected, $string, $length, $substring = '', $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->truncate($length, $substring);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function truncateProvider()
    {
        return array
        (
            array('Test foo bar', 'Test foo bar', 12),
            array('Test foo ba', 'Test foo bar', 11),
            array('Test foo', 'Test foo bar', 8),
            array('Test fo', 'Test foo bar', 7),
            array('Test', 'Test foo bar', 4),
            array('Test foo bar', 'Test foo bar', 12, '...'),
            array('Test foo...', 'Test foo bar', 11, '...'),
            array('Test ...', 'Test foo bar', 8, '...'),
            array('Test...', 'Test foo bar', 7, '...'),
            array('T...', 'Test foo bar', 4, '...'),
            array('Test fo....', 'Test foo bar', 11, '....'),
            array('Test fòô bàř', 'Test fòô bàř', 12, '', 'UTF-8'),
            array('Test fòô bà', 'Test fòô bàř', 11, '', 'UTF-8'),
            array('Test fòô', 'Test fòô bàř', 8, '', 'UTF-8'),
            array('Test fò', 'Test fòô bàř', 7, '', 'UTF-8'),
            array('Test', 'Test fòô bàř', 4, '', 'UTF-8'),
            array('Test fòô bàř', 'Test fòô bàř', 12, 'ϰϰ', 'UTF-8'),
            array('Test fòô ϰϰ', 'Test fòô bàř', 11, 'ϰϰ', 'UTF-8'),
            array('Test fϰϰ', 'Test fòô bàř', 8, 'ϰϰ', 'UTF-8'),
            array('Test ϰϰ', 'Test fòô bàř', 7, 'ϰϰ', 'UTF-8'),
            array('Teϰϰ', 'Test fòô bàř', 4, 'ϰϰ', 'UTF-8'),
            array('What are your pl...', 'What are your plans today?', 19, '...')
        );
    }

    /**
     * @dataProvider safeTruncateProvider()
     */
    public function testSafeTruncate($expected, $string, $length, $substring = '', $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->safeTruncate($length, $substring);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function safeTruncateProvider()
    {
        return array
        (
            array('Test foo bar', 'Test foo bar', 12),
            array('Test foo', 'Test foo bar', 11),
            array('Test foo', 'Test foo bar', 8),
            array('Test', 'Test foo bar', 7),
            array('Test', 'Test foo bar', 4),
            array('Test foo bar', 'Test foo bar', 12, '...'),
            array('Test foo...', 'Test foo bar', 11, '...'),
            array('Test...', 'Test foo bar', 8, '...'),
            array('Test...', 'Test foo bar', 7, '...'),
            array('...', 'Test foo bar', 4, '...'),
            array('Test....', 'Test foo bar', 11, '....'),
            array('Test fòô bàř', 'Test fòô bàř', 12, '', 'UTF-8'),
            array('Test fòô', 'Test fòô bàř', 11, '', 'UTF-8'),
            array('Test fòô', 'Test fòô bàř', 8, '', 'UTF-8'),
            array('Test', 'Test fòô bàř', 7, '', 'UTF-8'),
            array('Test', 'Test fòô bàř', 4, '', 'UTF-8'),
            array('Test fòô bàř', 'Test fòô bàř', 12, 'ϰϰ', 'UTF-8'),
            array('Test fòôϰϰ', 'Test fòô bàř', 11, 'ϰϰ', 'UTF-8'),
            array('Testϰϰ', 'Test fòô bàř', 8, 'ϰϰ', 'UTF-8'),
            array('Testϰϰ', 'Test fòô bàř', 7, 'ϰϰ', 'UTF-8'),
            array('ϰϰ', 'Test fòô bàř', 4, 'ϰϰ', 'UTF-8'),
            array('What are your plans...', 'What are your plans today?', 22, '...')
        );
    }
}
