<?php

use Gears\String\Str;

class BaseStrTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $this->assertInstanceOf('Gears\\String\\Str', new Str('foo'));
    }

    public function testFactory()
    {
        $this->assertInstanceOf('Gears\\String\\Str', Str::s('foo'));
    }

    public function testArrayInput()
    {
        $this->setExpectedException
        (
            'InvalidArgumentException',
            'Passed value cannot be an array'
        );

        new Str(['foo']);
    }

    public function testCastableObjectInput()
    {
        $this->assertInstanceOf('Gears\\String\\Str', new Str(new Str('foo')));
    }

    public function testNonCastableObjectInput()
    {
        $this->setExpectedException
        (
            'InvalidArgumentException',
            'Passed object must have a __toString method'
        );

        new Str(new \stdClass());
    }

    public function testToStringMagicMethod()
    {
        $str = new Str('öäü - foo');
        $result = $str->__toString();
        $this->assertTrue(is_string($result));
        $this->assertEquals((string)$str, $result);
        $this->assertEquals('öäü - foo', $result);
    }

    public function testDefaultEncoding()
    {
        $this->assertEquals('UTF-8', Str::s('foo')->getEncoding());
    }

    public function testLength()
    {
        $this->assertEquals(3, Str::s('foo')->getLength());
    }

    public function testCountable()
    {
        $this->assertInstanceOf('\\Countable', new Str('foo'));
        $this->assertEquals(3, count(Str::s('foo')));
    }

    public function testIterable()
    {
        $foo = new Str('foo');
        $this->assertInstanceOf('\\IteratorAggregate', $foo);

        $iterator = $foo->getIterator();
        $this->assertInstanceOf('\\ArrayIterator', $iterator);

        $chars = $iterator->getArrayCopy();
        $this->assertEquals(['f', 'o', 'o'], $chars);
    }

    public function testOffsetExists()
    {
        $foo = new Str('foo');
        $this->assertTrue(isset($foo[0]));
        $this->assertTrue(isset($foo[1]));
        $this->assertTrue(isset($foo[2]));
        $this->assertFalse(isset($foo[3]));
    }

    public function testOffsetGet()
    {
        $foo = new Str('foo');
        $this->assertEquals('f', $foo[0]);
        $this->assertEquals('o', $foo[1]);
        $this->assertEquals('o', $foo[2]);
        $this->assertInstanceOf('Gears\\String\\Str', $foo[0]);
    }

    public function testOffsetGetOutofBounds()
    {
        $this->setExpectedException
        (
            'OutOfBoundsException',
            'No character exists at the index'
        );

        Str::s('foo')[3];
    }

    public function testOffsetSet()
    {
        $this->setExpectedException
        (
            'Exception',
            'Str object is immutable, cannot modify char'
        );

        Str::s('foo')[0] = 'a';
    }

    public function testOffsetUnset()
    {
        $this->setExpectedException
        (
            'Exception',
            'Str object is immutable, cannot unset char'
        );

        unset(Str::s('foo')[0]);
    }

    public function testCompare()
    {
        $this->assertEquals(0, Str::s('foo')->compare(Str::s('foo')));

        if (defined('HHVM_VERSION'))
        {
            $this->assertEquals(-1, Str::s('foo')->compare(Str::s('bar')));
        }
        else
        {
            $this->assertEquals(-4, Str::s('foo')->compare(Str::s('bar')));
        }
    }

    public function testEquals()
    {
        $this->assertTrue(Str::s('foo')->equals(Str::s('foo')));
        $this->assertFalse(Str::s('foo')->equals(Str::s('bar')));
        $this->assertFalse(Str::s('foo')->equals('foo'));
    }
}
