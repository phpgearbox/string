<?php

use Gears\String\Str;

class IsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider isLowerCaseProvider()
     */
    public function testIsLowerCase($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->isLowerCase();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function isLowerCaseProvider()
    {
        return array
        (
            array(true, ''),
            array(true, 'foobar'),
            array(false, 'foo bar'),
            array(false, 'Foobar'),
            array(true, 'fòôbàř', 'UTF-8'),
            array(false, 'fòôbàř2', 'UTF-8'),
            array(false, 'fòô bàř', 'UTF-8'),
            array(false, 'fòôbÀŘ', 'UTF-8')
        );
    }

    /**
     * @dataProvider isUpperCaseProvider()
     */
    public function testIsUpperCase($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->isUpperCase();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function isUpperCaseProvider()
    {
        return array
        (
            array(true, ''),
            array(true, 'FOOBAR'),
            array(false, 'FOO BAR'),
            array(false, 'fOOBAR'),
            array(true, 'FÒÔBÀŘ', 'UTF-8'),
            array(false, 'FÒÔBÀŘ2', 'UTF-8'),
            array(false, 'FÒÔ BÀŘ', 'UTF-8'),
            array(false, 'FÒÔBàř', 'UTF-8')
        );
    }

    /**
     * @dataProvider isAlphaProvider()
     */
    public function testIsAlpha($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->isAlpha();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function isAlphaProvider()
    {
        return array
        (
            array(true, ''),
            array(true, 'foobar'),
            array(false, 'foo bar'),
            array(false, 'foobar2'),
            array(true, 'fòôbàř', 'UTF-8'),
            array(false, 'fòô bàř', 'UTF-8'),
            array(false, 'fòôbàř2', 'UTF-8'),
            array(true, 'ҠѨњфгШ', 'UTF-8'),
            array(false, 'ҠѨњ¨ˆфгШ', 'UTF-8'),
            array(true, '丹尼爾', 'UTF-8')
        );
    }

    /**
     * @dataProvider isAlphanumericProvider()
     */
    public function testIsAlphanumeric($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->isAlphanumeric();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function isAlphanumericProvider()
    {
        return array
        (
            array(true, ''),
            array(true, 'foobar1'),
            array(false, 'foo bar'),
            array(false, 'foobar2"'),
            array(false, "\nfoobar\n"),
            array(true, 'fòôbàř1', 'UTF-8'),
            array(false, 'fòô bàř', 'UTF-8'),
            array(false, 'fòôbàř2"', 'UTF-8'),
            array(true, 'ҠѨњфгШ', 'UTF-8'),
            array(false, 'ҠѨњ¨ˆфгШ', 'UTF-8'),
            array(true, '丹尼爾111', 'UTF-8'),
            array(true, 'دانيال1', 'UTF-8'),
            array(false, 'دانيال1 ', 'UTF-8')
        );
    }

    /**
     * @dataProvider isBlankProvider()
     */
    public function testIsBlank($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->isBlank();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function isBlankProvider()
    {
        return array
        (
            array(true, ''),
            array(true, ' '),
            array(true, "\n\t "),
            array(true, "\n\t  \v\f"),
            array(false, "\n\t a \v\f"),
            array(false, "\n\t ' \v\f"),
            array(false, "\n\t 2 \v\f"),
            array(true, '', 'UTF-8'),
            array(true, ' ', 'UTF-8'), // no-break space (U+00A0)
            array(true, '           ', 'UTF-8'), // spaces U+2000 to U+200A
            array(true, ' ', 'UTF-8'), // narrow no-break space (U+202F)
            array(true, ' ', 'UTF-8'), // medium mathematical space (U+205F)
            array(true, '　', 'UTF-8'), // ideographic space (U+3000)
            array(false, '　z', 'UTF-8'),
            array(false, '　1', 'UTF-8')
        );
    }

    /**
     * @dataProvider isHexadecimalProvider()
     */
    public function testIsHexadecimal($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->isHexadecimal();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function isHexadecimalProvider()
    {
        return array
        (
            array(true, ''),
            array(true, 'abcdef'),
            array(true, 'ABCDEF'),
            array(true, '0123456789'),
            array(true, '0123456789AbCdEf'),
            array(false, '0123456789x'),
            array(false, 'ABCDEFx'),
            array(true, 'abcdef', 'UTF-8'),
            array(true, 'ABCDEF', 'UTF-8'),
            array(true, '0123456789', 'UTF-8'),
            array(true, '0123456789AbCdEf', 'UTF-8'),
            array(false, '0123456789x', 'UTF-8'),
            array(false, 'ABCDEFx', 'UTF-8')
        );
    }

    /**
     * @dataProvider isJsonProvider()
     */
    public function testIsJson($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->isJson();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function isJsonProvider()
    {
        return array
        (
            array(false, ''),
            array(false, '  '),
            array(true, 'null'),
            array(true, 'true'),
            array(true, 'false'),
            array(true, '[]'),
            array(true, '{}'),
            array(true, '123'),
            array(true, '{"foo": "bar"}'),
            array(false, '{"foo":"bar",}'),
            array(false, '{"foo"}'),
            array(true, '["foo"]'),
            array(false, '{"foo": "bar"]'),
            array(true, '123', 'UTF-8'),
            array(true, '{"fòô": "bàř"}', 'UTF-8'),
            array(false, '{"fòô":"bàř",}', 'UTF-8'),
            array(false, '{"fòô"}', 'UTF-8'),
            array(false, '["fòô": "bàř"]', 'UTF-8'),
            array(true, '["fòô"]', 'UTF-8'),
            array(false, '{"fòô": "bàř"]', 'UTF-8')
        );
    }

    /**
     * @dataProvider isSerializedProvider()
     */
    public function testIsSerialized($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->isSerialized();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function isSerializedProvider()
    {
        return array
        (
            array(false, ''),
            array(true, 'a:1:{s:3:"foo";s:3:"bar";}'),
            array(false, 'a:1:{s:3:"foo";s:3:"bar"}'),
            array(true, serialize(array('foo' => 'bar'))),
            array(true, 'a:1:{s:5:"fòô";s:5:"bàř";}', 'UTF-8'),
            array(false, 'a:1:{s:5:"fòô";s:5:"bàř"}', 'UTF-8'),
            array(true, serialize(array('fòô' => 'bár')), 'UTF-8')
        );
    }

    /**
     * @dataProvider isBase64Provider()
     */
    public function testIsBase64($expected, $string)
    {
        $str = new Str($string);
        $result = $str->isBase64();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function isBase64Provider()
    {
        return array
        (
            array(false, ' '),
            array(false, ''),
            array(true, base64_encode('FooBar')),
            array(true, base64_encode(' ')),
            array(true, base64_encode('FÒÔBÀŘ')),
            array(true, base64_encode('συγγραφέας')),
            array(false, 'Foobar')
        );
    }
}
