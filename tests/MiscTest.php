<?php

use Gears\String\Str;

class MiscTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider delimitProvider()
     */
    public function testDelimit($expected, $string, $delimiter, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->delimit($delimiter);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function delimitProvider()
    {
        return array
        (
            array('test*case', 'testCase', '*'),
            array('test&case', 'Test-Case', '&'),
            array('test#case', 'test case', '#'),
            array('test**case', 'test -case', '**'),
            array('~!~test~!~case', '-test - case', '~!~'),
            array('test*case', 'test_case', '*'),
            array('test%c%test', '  test c test', '%'),
            array('test+u+case', 'TestUCase', '+'),
            array('test=c=c=test', 'TestCCTest', '='),
            array('string#>with1number', 'string_with1number', '#>'),
            array('1test2case', '1test2case', '*'),
            array('test ύα σase', 'test Σase', ' ύα ', 'UTF-8',),
            array('στανιλαcase', 'Στανιλ case', 'α', 'UTF-8',),
            array('σashΘcase', 'Σash  Case', 'Θ', 'UTF-8')
        );
    }

    /**
     * @dataProvider insertProvider()
     */
    public function testInsert($expected, $string, $substring, $index, $encoding = null)
    {
        if (Str::s($expected)->contains('Exception'))
        {
            $this->setExpectedException($expected);
        }

        $str = new Str($string, $encoding);
        $result = $str->insert($substring, $index);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function insertProvider()
    {
        return array
        (
            array('foo bar', 'oo bar', 'f', 0),
            array('foo bar', 'f bar', 'oo', 1),
            array('OutOfBoundsException', 'f bar', 'oo', 20),
            array('foo bar', 'foo ba', 'r', 6),
            array('fòôbàř', 'fòôbř', 'à', 4, 'UTF-8'),
            array('fòô bàř', 'òô bàř', 'f', 0, 'UTF-8'),
            array('fòô bàř', 'f bàř', 'òô', 1, 'UTF-8'),
            array('fòô bàř', 'fòô bà', 'ř', 6, 'UTF-8')
        );
    }

    /**
     * @dataProvider linesProvider()
     */
    public function testLines($expected, $string, $encoding = null)
    {
        $result = Str::s($string, $encoding)->lines();

        $this->assertInternalType('array', $result);

        foreach ($result as $line)
        {
            $this->assertInstanceOf('Gears\\String\\Str', $line);
        }

        $counter = count($expected);

        for ($i = 0; $i < $counter; $i++)
        {
            $this->assertEquals($expected[$i], $result[$i]);
        }
    }

    public function linesProvider()
    {
        return array
        (
            array(array(), ''),
            array(array(''), "\r\n"),
            array(array('foo', 'bar'), "foo\nbar"),
            array(array('foo', 'bar'), "foo\rbar"),
            array(array('foo', 'bar'), "foo\r\nbar"),
            array(array('foo', '', 'bar'), "foo\r\n\r\nbar"),
            array(array('foo', 'bar', ''), "foo\r\nbar\r\n"),
            array(array('', 'foo', 'bar'), "\r\nfoo\r\nbar"),
            array(array('fòô', 'bàř'), "fòô\nbàř", 'UTF-8'),
            array(array('fòô', 'bàř'), "fòô\rbàř", 'UTF-8'),
            array(array('fòô', 'bàř'), "fòô\n\rbàř", 'UTF-8'),
            array(array('fòô', 'bàř'), "fòô\r\nbàř", 'UTF-8'),
            array(array('fòô', '', 'bàř'), "fòô\r\n\r\nbàř", 'UTF-8'),
            array(array('fòô', 'bàř', ''), "fòô\r\nbàř\r\n", 'UTF-8'),
            array(array('', 'fòô', 'bàř'), "\r\nfòô\r\nbàř", 'UTF-8')
        );
    }

    /**
     * @dataProvider repeatProvider()
     */
    public function testRepeat($expected, $string, $multiplier, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->repeat($multiplier);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function repeatProvider()
    {
        return array
        (
            array('', 'foo', 0),
            array('foo', 'foo', 1),
            array('foofoo', 'foo', 2),
            array('foofoofoo', 'foo', 3),
            array('fòô', 'fòô', 1, 'UTF-8'),
            array('fòôfòô', 'fòô', 2, 'UTF-8'),
            array('fòôfòôfòô', 'fòô', 3, 'UTF-8')
        );
    }

    /**
     * @dataProvider reverseProvider()
     */
    public function testReverse($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->reverse();
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function reverseProvider()
    {
        return array
        (
            array('', ''),
            array('raboof', 'foobar'),
            array('řàbôòf', 'fòôbàř', 'UTF-8'),
            array('řàb ôòf', 'fòô bàř', 'UTF-8'),
            array('∂∆ ˚åß', 'ßå˚ ∆∂', 'UTF-8')
        );
    }

    /**
     * @dataProvider shuffleProvider()
     */
    public function testShuffle($string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $encoding = $encoding ?: mb_internal_encoding();
        $result = $str->shuffle();
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($string, $str);
        $this->assertEquals
        (
            mb_strlen($string, $encoding),
            mb_strlen($result, $encoding)
        );

        // We'll make sure that the chars are present after shuffle
        $length = mb_strlen($string, $encoding);
        for ($i = 0; $i < $length; $i++)
        {
            $char = mb_substr($string, $i, 1, $encoding);
            $countBefore = mb_substr_count($string, $char, $encoding);
            $countAfter = mb_substr_count($result, $char, $encoding);
            $this->assertEquals($countBefore, $countAfter);
        }
    }

    public function shuffleProvider()
    {
        return array
        (
            array('foo bar'),
            array('∂∆ ˚åß', 'UTF-8'),
            array('å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', 'UTF-8')
        );
    }

    /**
     * @dataProvider sliceProvider()
     */
    public function testSlice($expected, $string, $start, $end = null, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->slice($start, $end);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function sliceProvider()
    {
        return array
        (
            array('foobar', 'foobar', 0),
            array('foobar', 'foobar', 0, null),
            array('foobar', 'foobar', 0, 6),
            array('fooba', 'foobar', 0, 5),
            array('', 'foobar', 3, 0),
            array('', 'foobar', 3, 2),
            array('ba', 'foobar', 3, 5),
            array('ba', 'foobar', 3, -1),
            array('fòôbàř', 'fòôbàř', 0, null, 'UTF-8'),
            array('fòôbàř', 'fòôbàř', 0, null),
            array('fòôbàř', 'fòôbàř', 0, 6, 'UTF-8'),
            array('fòôbà', 'fòôbàř', 0, 5, 'UTF-8'),
            array('', 'fòôbàř', 3, 0, 'UTF-8'),
            array('', 'fòôbàř', 3, 2, 'UTF-8'),
            array('bà', 'fòôbàř', 3, 5, 'UTF-8'),
            array('bà', 'fòôbàř', 3, -1, 'UTF-8')
        );
    }

    /**
     * @dataProvider surroundProvider()
     */
    public function testSurround($expected, $string, $substring)
    {
        $str = new Str($string);
        $result = $str->surround($substring);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function surroundProvider()
    {
        return array
        (
            array('__foobar__', 'foobar', '__'),
            array('test', 'test', ''),
            array('**', '', '*'),
            array('¬fòô bàř¬', 'fòô bàř', '¬'),
            array('ßå∆˚ test ßå∆˚', ' test ', 'ßå∆˚')
        );
    }

    /**
     * @dataProvider tidyProvider()
     */
    public function testTidy($expected, $string)
    {
        $str = new Str($string);
        $result = $str->tidy();
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function tidyProvider()
    {
        return array
        (
            array('"I see..."', '“I see…”'),
            array("'This too'", '‘This too’'),
            array('test-dash', 'test—dash'),
            array('Ο συγγραφέας είπε...', 'Ο συγγραφέας είπε…')
        );
    }

    /**
     * @dataProvider countSubstrProvider()
     */
    public function testCountSubstr($expected, $string, $substring, $caseSensitive = true, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->countSubstr($substring, $caseSensitive);
        $this->assertInternalType('int', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function countSubstrProvider()
    {
        return array
        (
            array(0, '', 'foo'),
            array(0, 'foo', 'bar'),
            array(1, 'foo bar', 'foo'),
            array(2, 'foo bar', 'o'),
            array(0, '', 'fòô', 'UTF-8'),
            array(0, 'fòô', 'bàř', 'UTF-8'),
            array(1, 'fòô bàř', 'fòô', 'UTF-8'),
            array(2, 'fôòô bàř', 'ô', 'UTF-8'),
            array(0, 'fÔÒÔ bàř', 'ô', 'UTF-8'),
            array(0, 'foo', 'BAR', false),
            array(1, 'foo bar', 'FOo', false),
            array(2, 'foo bar', 'O', false),
            array(1, 'fòô bàř', 'fÒÔ', false, 'UTF-8'),
            array(2, 'fôòô bàř', 'Ô', false, 'UTF-8'),
            array(2, 'συγγραφέας', 'Σ', false, 'UTF-8')
        );
    }
}
