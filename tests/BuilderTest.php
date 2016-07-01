<?php

use Gears\String\Str;
use Gears\String\Builder;

class BuilderTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $builder = new Builder('foo');
        $this->assertInstanceOf('Gears\\String\\Builder', $builder);
        $this->assertEquals('foo', $builder);
    }

    public function testGetStr()
    {
        $builder = new Builder('foo');

        $this->assertInstanceOf('Gears\\String\\Str', $builder->getStr());
    }

    public function testToStringMagicMethod()
    {
        $builder = new Builder('foo');
        $result = $builder->__toString();
        $this->assertTrue(is_string($result));
        $this->assertEquals('foo', $result);
        $this->assertEquals('foo', (string)$builder);
    }

    public function testAppend()
    {
        $builder = new Builder('foo');
        $builder->append(' bar');
        $this->assertEquals('foo bar', $builder);
        $builder->append(new Str(' baz'));
        $this->assertEquals('foo bar baz', $builder);
    }

    public function testMisMatchedEncodingException()
    {
        $this->setExpectedException
        (
            '\\Gears\\String\\Exceptions\\MisMatchedEncodingException'
        );

        $builder = new Builder('foo', 'UTF-8');
        $builder->append(new Str(' bar', 'UTF-7'));
    }

    public function testAppendFormat()
    {
        $builder = new Builder();
        $builder->appendFormat('There are %d monkeys in the %s', [5, 'tree']);
        $this->assertEquals('There are 5 monkeys in the tree', $builder);
    }

    public function testAppendLine()
    {
        $builder = new Builder('foo');
        $builder->appendLine();
        $this->assertEquals("foo\n", $builder);
        $builder->appendLine('bar');
        $this->assertEquals("foo\nbar\n", $builder);
        $builder->appendLine('baz', "\r\n");
        $this->assertEquals("foo\nbar\nbaz\r\n", $builder);
    }

    public function testClear()
    {
        $builder = new Builder('foo');
        $builder->clear();
        $this->assertEquals('', $builder);
    }

    public function testCompare()
    {
        $builder1 = new Builder('foo');
        $builder2 = new Builder('foo');
        $builder3 = new Builder('bar');

        $this->assertEquals(0, $builder1->compare($builder2));

        if (defined('HHVM_VERSION') || strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
        {
            $this->assertEquals(-1, $builder1->compare($builder3));
        }
        else
        {
            $this->assertEquals(-4, $builder1->compare($builder3));
        }
    }

    public function testEquals()
    {
        $builder1 = new Builder('foo');
        $builder2 = new Builder('foo');
        $builder3 = new Builder('bar');

        $this->assertTrue($builder1->equals($builder2));
        $this->assertFalse($builder1->equals($builder3));
        $this->assertFalse($builder1->equals('foo'));
    }

    public function testInsert()
    {
        $builder = new Builder('foobar');
        $builder->insert(3, ' ');
        $this->assertEquals('foo bar', $builder);
    }

    public function testRemove()
    {
        $builder = new Builder('foo bar');
        $builder->remove(3, 1);
        $this->assertEquals('foobar', $builder);
    }

    public function testReplace()
    {
        $builder = new Builder('foo bar foo');
        $builder->replace('foo', 'baz');
        $this->assertEquals('baz bar baz', $builder);
    }
}
