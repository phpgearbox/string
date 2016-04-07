<?php

use Gears\String\Str;

class ContainsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider containsProvider()
     */
    public function testContains($expected, $haystack, $needle, $caseSensitive = true, $encoding = null)
    {
        $str = new Str($haystack, $encoding);
        $result = $str->contains($needle, $caseSensitive);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($haystack, $str);
    }

    public function containsProvider()
    {
        return array
        (
            array(true, 'Str contains foo bar', 'foo bar'),
            array(true, '12398!@(*%!@# @!%#*&^%', ' @!%#*&^%'),
            array(true, 'Ο συγγραφέας είπε', 'συγγραφέας', 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', 'å´¥©', true, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', 'å˚ ∆', true, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', 'øœ¬', true, 'UTF-8'),
            array(false, 'Str contains foo bar', 'Foo bar'),
            array(false, 'Str contains foo bar', 'foobar'),
            array(false, 'Str contains foo bar', 'foo bar '),
            array(false, 'Ο συγγραφέας είπε', '  συγγραφέας ', true, 'UTF-8'),
            array(false, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', ' ßå˚', true, 'UTF-8'),
            array(true, 'Str contains foo bar', 'Foo bar', false),
            array(true, '12398!@(*%!@# @!%#*&^%', ' @!%#*&^%', false),
            array(true, 'Ο συγγραφέας είπε', 'ΣΥΓΓΡΑΦΈΑΣ', false, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', 'Å´¥©', false, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', 'Å˚ ∆', false, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', 'ØŒ¬', false, 'UTF-8'),
            array(false, 'Str contains foo bar', 'foobar', false),
            array(false, 'Str contains foo bar', 'foo bar ', false),
            array(false, 'Ο συγγραφέας είπε', '  συγγραφέας ', false, 'UTF-8'),
            array(false, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', ' ßÅ˚', false, 'UTF-8'),
        );
    }

    /**
     * @dataProvider containsAnyProvider()
     */
    public function testcontainsAny($expected, $haystack, $needles, $caseSensitive = true, $encoding = null)
    {
        $str = new Str($haystack, $encoding);
        $result = $str->containsAny($needles, $caseSensitive);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($haystack, $str);
    }

    public function containsAnyProvider()
    {
        // One needle
        $singleNeedle = array_map
        (
            function ($array)
            {
                $array[2] = array($array[2]);
                return $array;
            },
            $this->containsProvider()
        );

        $provider = array
        (
            // No needles
            array(false, 'Str contains foo bar', array()),

            // Multiple needles
            array(true, 'Str contains foo bar', array('foo', 'bar')),
            array(true, '12398!@(*%!@# @!%#*&^%', array(' @!%#*', '&^%')),
            array(true, 'Ο συγγραφέας είπε', array('συγγρ', 'αφέας'), 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('å´¥', '©'), true, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('å˚ ', '∆'), true, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('øœ', '¬'), true, 'UTF-8'),
            array(false, 'Str contains foo bar', array('Foo', 'Bar')),
            array(false, 'Str contains foo bar', array('foobar', 'bar ')),
            array(false, 'Str contains foo bar', array('foo bar ', '  foo')),
            array(false, 'Ο συγγραφέας είπε', array('  συγγραφέας ', '  συγγραφ '), true, 'UTF-8'),
            array(false, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array(' ßå˚', ' ß '), true, 'UTF-8'),
            array(true, 'Str contains foo bar', array('Foo bar', 'bar'), false),
            array(true, '12398!@(*%!@# @!%#*&^%', array(' @!%#*&^%', '*&^%'), false),
            array(true, 'Ο συγγραφέας είπε', array('ΣΥΓΓΡΑΦΈΑΣ', 'ΑΦΈΑ'), false, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('Å´¥©', '¥©'), false, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('Å˚ ∆', ' ∆'), false, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('ØŒ¬', 'Œ'), false, 'UTF-8'),
            array(false, 'Str contains foo bar', array('foobar', 'none'), false),
            array(false, 'Str contains foo bar', array('foo bar ', ' ba '), false),
            array(false, 'Ο συγγραφέας είπε', array('  συγγραφέας ', ' ραφέ '), false, 'UTF-8'),
            array(false, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array(' ßÅ˚', ' Å˚ '), false, 'UTF-8'),
        );

        return array_merge($singleNeedle, $provider);
    }

    /**
     * @dataProvider containsAllProvider()
     */
    public function testContainsAll($expected, $haystack, $needles, $caseSensitive = true, $encoding = null)
    {
        $str = new Str($haystack, $encoding);
        $result = $str->containsAll($needles, $caseSensitive);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($haystack, $str);
    }

    public function containsAllProvider()
    {
        // One needle
        $singleNeedle = array_map
        (
            function ($array)
            {
                $array[2] = array($array[2]);
                return $array;
            },
            $this->containsProvider()
        );

        $provider = array
        (
            // One needle
            array(false, 'Str contains foo bar', array()),

            // Multiple needles
            array(true, 'Str contains foo bar', array('foo', 'bar')),
            array(true, '12398!@(*%!@# @!%#*&^%', array(' @!%#*', '&^%')),
            array(true, 'Ο συγγραφέας είπε', array('συγγρ', 'αφέας'), 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('å´¥', '©'), true, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('å˚ ', '∆'), true, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('øœ', '¬'), true, 'UTF-8'),
            array(false, 'Str contains foo bar', array('Foo', 'bar')),
            array(false, 'Str contains foo bar', array('foobar', 'bar')),
            array(false, 'Str contains foo bar', array('foo bar ', 'bar')),
            array(false, 'Ο συγγραφέας είπε', array('  συγγραφέας ', '  συγγραφ '), true, 'UTF-8'),
            array(false, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array(' ßå˚', ' ß '), true, 'UTF-8'),
            array(true, 'Str contains foo bar', array('Foo bar', 'bar'), false),
            array(true, '12398!@(*%!@# @!%#*&^%', array(' @!%#*&^%', '*&^%'), false),
            array(true, 'Ο συγγραφέας είπε', array('ΣΥΓΓΡΑΦΈΑΣ', 'ΑΦΈΑ'), false, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('Å´¥©', '¥©'), false, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('Å˚ ∆', ' ∆'), false, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('ØŒ¬', 'Œ'), false, 'UTF-8'),
            array(false, 'Str contains foo bar', array('foobar', 'none'), false),
            array(false, 'Str contains foo bar', array('foo bar ', ' ba'), false),
            array(false, 'Ο συγγραφέας είπε', array('  συγγραφέας ', ' ραφέ '), false, 'UTF-8'),
            array(false, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array(' ßÅ˚', ' Å˚ '), false, 'UTF-8')
        );

        return array_merge($singleNeedle, $provider);
    }
}
