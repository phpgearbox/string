<?php

use Gears\String\Str;

class HtmlTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider htmlDecodeProvider()
     */
    public function testHtmlDecode($expected, $string, $flags = ENT_COMPAT, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->htmlDecode($flags);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function htmlDecodeProvider()
    {
        return array
        (
            array('&', '&amp;'),
            array('"', '&quot;'),
            array("'", '&#039;', ENT_QUOTES),
            array('<', '&lt;'),
            array('>', '&gt;')
        );
    }

    /**
     * @dataProvider htmlEncodeProvider()
     */
    public function testHtmlEncode($expected, $string, $flags = ENT_COMPAT, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->htmlEncode($flags);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function htmlEncodeProvider()
    {
        return array
        (
            array('&amp;', '&'),
            array('&quot;', '"'),
            array('&#039;', "'", ENT_QUOTES),
            array('&lt;', '<'),
            array('&gt;', '>')
        );
    }

    /**
     * @dataProvider htmlXssCleanProvider()
     */
    public function testHtmlXssClean($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->htmlXssClean();
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function htmlXssCleanProvider()
    {
        // NOTE: This is just a subset of tests just to prove Str is working.
        // A full complement of tests can be found here:
        // https://github.com/voku/anti-xss/tree/master/tests
        return array
        (
            array('', ''),
            array('Hello, i try to alert&#40;\'Hack\'&#41;; your site', 'Hello, i try to <script>alert(\'Hack\');</script> your site'),
            array('<IMG >', '<IMG SRC=&#x6A&#x61&#x76&#x61&#x73&#x63&#x72&#x69&#x70&#x74&#x3A&#x61&#x6C&#x65&#x72&#x74&#x28&#x27&#x58&#x53&#x53&#x27&#x29>'),
            array('', '<XSS STYLE="behavior: url(xss.htc);">'),
            array('<∂∆ > ˚åß', '<∂∆ onerror="alert(xss)"> ˚åß'),
            array('\'œ … <a href="#foo"> \'’)', '\'œ … <a href="#foo"> \'’)')
        );
    }

    /**
     * @dataProvider htmlStripTagsProvider()
     */
    public function testHtmlStripTags($expected, $string, $allowableTags = '', $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->htmlStripTags($allowableTags);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function htmlStripTagsProvider()
    {
        return array
        (
            array('', ''),
            array('raboof ', 'raboof <3', '<3>'),
            array('řàbôòf>', 'řàbôòf<foo<lall>>>', '<lall><lall/>'),
            array('řàb òf\', ô<br/>foo lall', 'řàb <ô>òf\', ô<br/>foo <a href="#">lall</a>', '<br><br/>'),
            array(' ˚åß', '<∂∆ onerror="alert(xss)"> ˚åß'),
            array('\'œ … \'’)', '\'œ … \'’)')
        );
    }
}
