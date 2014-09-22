<?php
////////////////////////////////////////////////////////////////////////////////
// __________ __             ________                   __________              
// \______   \  |__ ______  /  _____/  ____ _____ ______\______   \ _______  ___
//  |     ___/  |  \\____ \/   \  ____/ __ \\__  \\_  __ \    |  _//  _ \  \/  /
//  |    |   |   Y  \  |_> >    \_\  \  ___/ / __ \|  | \/    |   (  <_> >    < 
//  |____|   |___|  /   __/ \______  /\___  >____  /__|  |______  /\____/__/\_ \
//                \/|__|           \/     \/     \/             \/            \/
// -----------------------------------------------------------------------------
//          Designed and Developed by Brad Jones <brad @="bjc.id.au" />         
// -----------------------------------------------------------------------------
////////////////////////////////////////////////////////////////////////////////

class StringObjectTest extends PHPUnit_Framework_TestCase
{
	protected $string = 'This is a string.';

	public function testFactory()
	{
		$this->assertTrue(is_a(Gears\String::s($this->string), 'Gears\String'));
	}

	public function testToString()
	{
		$this->assertEquals($this->string, new Gears\String($this->string));
	}

	public function testArrayAccess()
	{
		$this->assertEquals('T', Gears\String::s($this->string)[0]);
	}

	public function testMethodChaining()
	{
		$this->assertEquals('THIS IS A GEARS\STRING.', Gears\String::s($this->string)->replace('string', 'Gears\String')->upper());
	}

	public function testSearch()
	{
		$this->assertEquals(8, Gears\String::s($this->string)->search('a'));
		$this->assertEquals(-1, Gears\String::s($this->string)->search('b'));
		$this->assertEquals(4, Gears\String::s($this->string)->search('/ is /', true));
		$this->assertEquals(-1, Gears\String::s($this->string)->search('/ foo /', true));
	}

	public function testReplace()
	{
		$this->assertEquals('This is a Gears\String.', Gears\String::s($this->string)->replace('string', 'Gears\String'));
		$this->assertEquals($this->string, Gears\String::s($this->string)->replace('foo', 'Gears\String'));
		$this->assertEquals('This is a Gears\String.', Gears\String::s($this->string)->replace('/string/', 'Gears\String', true));
		$this->assertEquals($this->string, Gears\String::s($this->string)->replace('/ string /', 'Gears\String', true));
		$this->assertEquals('This is a STRING.', Gears\String::s($this->string)->replace('/string/', function($matches){ return strtoupper($matches[0]); }, true));
	}

	public function testMatch()
	{
		$this->assertEquals(['is a', 'is a'], Gears\String::s($this->string.' '.$this->string)->match('/is a/'));
		$this->assertEquals([], Gears\String::s($this->string.' '.$this->string)->match('/is foo/'));
	}

	public function testBetween()
	{
		$this->assertEquals($this->string, Gears\String::s('<start>'.$this->string.'</end>')->between('<start>', '</end>'));
		$this->assertEquals('', Gears\String::s('<start>'.$this->string.'</end>')->between('<start1>', '</end>'));
		$this->assertEquals('', Gears\String::s('<start>'.$this->string.'</end>')->between('<start>', '</end1>'));
		$this->assertEquals('<start>'.$this->string.'</end>', Gears\String::s('<start>'.$this->string.'</end>')->between('<start>', '</end>', true));
	}

	public function testBetweenRegx()
	{
		$xml = file_get_contents(__DIR__.'/data/books.xml');
		$expected = require(__DIR__.'/data/books.php');
		$this->assertEquals($expected, Gears\String::s($xml)->betweenRegx('<author>', '</author>'));
	}

	public function testSubString()
	{
		$this->assertEquals('is a', Gears\String::s($this->string)->substring(5, 9));
		$this->assertEquals('is a string.', Gears\String::s($this->string)->substring(5));
	}

	public function testSlice()
	{
		$this->assertEquals('is a', Gears\String::s($this->string)->slice(5, 9));
		$this->assertEquals('is a string.', Gears\String::s($this->string)->slice(5));
	}

	public function testConCat()
	{
		$this->assertEquals($this->string.$this->string, Gears\String::s($this->string)->conCat($this->string));
	}

	public function testSplit()
	{
		$this->assertEquals(['T','h','i','s',' ','i','s',' ','a',' ','s','t','r','i','n','g','.'], Gears\String::s($this->string)->split());
		$this->assertEquals(['This','is','a','string.'], Gears\String::s($this->string)->split(' '));
	}

	public function testRange()
	{
		$this->assertEquals(true, Gears\String::s($this->string)->range(0, 20));
		$this->assertEquals(true, Gears\String::s($this->string)->range(5, 20));
		$this->assertEquals(false, Gears\String::s($this->string)->range(0, 10));
		$this->assertEquals(false, Gears\String::s($this->string)->range(30, 40));
	}

	public function testCharAt()
	{
		$this->assertEquals('T', Gears\String::s($this->string)->charAt(0));
		$this->assertEquals('h', Gears\String::s($this->string)->charAt(1));
		$this->assertEquals('i', Gears\String::s($this->string)->charAt(2));
		$this->assertEquals('s', Gears\String::s($this->string)->charAt(3));
	}

	public function testCharCodeAt()
	{
		$this->assertEquals(84, Gears\String::s($this->string)->charCodeAt(0));
		$this->assertEquals(104, Gears\String::s($this->string)->charCodeAt(1));
		$this->assertEquals(105, Gears\String::s($this->string)->charCodeAt(2));
		$this->assertEquals(115, Gears\String::s($this->string)->charCodeAt(3));
	}

	/*
	public function testFromCharCode()
	{
		// This method doesn't really work in the oo api
		$this->assertEquals('T', Gears\String::s($this->string)->fromCharCode(84));
		$this->assertEquals('h', Gears\String::s($this->string)->fromCharCode(104));
		$this->assertEquals('i', Gears\String::s($this->string)->fromCharCode(105));
		$this->assertEquals('s', Gears\String::s($this->string)->fromCharCode(115));
	}
	*/

	public function testIndexOf()
	{
		$this->assertEquals(2, Gears\String::s($this->string)->indexOf('is'));
		$this->assertEquals(false, Gears\String::s($this->string)->indexOf('foo'));
	}

	public function testLastIndexOf()
	{
		$this->assertEquals(5, Gears\String::s($this->string)->lastIndexOf('is'));
		$this->assertEquals(false, Gears\String::s($this->string)->lastIndexOf('foo'));
	}

	// TODO: Ideally we should probably test the remaining laravel functions.
}