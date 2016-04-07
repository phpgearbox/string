<?php

use Gears\String\Str;

class EnsureTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider ensureLeftProvider()
     */
    public function testEnsureLeft($expected, $string, $substring, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->ensureLeft($substring);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function ensureLeftProvider()
    {
        return array
        (
            array('foobar', 'foobar', 'f'),
            array('foobar', 'foobar', 'foo'),
            array('foo/foobar', 'foobar', 'foo/'),
            array('http://foobar', 'foobar', 'http://'),
            array('http://foobar', 'http://foobar', 'http://'),
            array('fòôbàř', 'fòôbàř', 'f', 'UTF-8'),
            array('fòôbàř', 'fòôbàř', 'fòô', 'UTF-8'),
            array('fòô/fòôbàř', 'fòôbàř', 'fòô/', 'UTF-8'),
            array('http://fòôbàř', 'fòôbàř', 'http://', 'UTF-8'),
            array('http://fòôbàř', 'http://fòôbàř', 'http://', 'UTF-8')
        );
    }

    /**
     * @dataProvider ensureRightProvider()
     */
    public function testEnsureRight($expected, $string, $substring, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->ensureRight($substring);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function ensureRightProvider()
    {
        return array
        (
            array('foobar', 'foobar', 'r'),
            array('foobar', 'foobar', 'bar'),
            array('foobar/bar', 'foobar', '/bar'),
            array('foobar.com/', 'foobar', '.com/'),
            array('foobar.com/', 'foobar.com/', '.com/'),
            array('fòôbàř', 'fòôbàř', 'ř', 'UTF-8'),
            array('fòôbàř', 'fòôbàř', 'bàř', 'UTF-8'),
            array('fòôbàř/bàř', 'fòôbàř', '/bàř', 'UTF-8'),
            array('fòôbàř.com/', 'fòôbàř', '.com/', 'UTF-8'),
            array('fòôbàř.com/', 'fòôbàř.com/', '.com/', 'UTF-8')
        );
    }
}
