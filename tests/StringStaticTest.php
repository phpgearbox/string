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

use Gears\String as Str;

class StringStaticTest extends PHPUnit_Framework_TestCase
{
	protected $string = 'This is a string.';

	public function testMethodChaining()
	{
		$this->assertEquals('THIS IS A GEARS\STRING.', Str::s($this->string)->replace('string', 'Gears\String')->upper());
	}

	public function testSearch()
	{
		$this->assertEquals(8, Str::search($this->string, 'a'));
		$this->assertEquals(-1, Str::search($this->string, 'b'));
		$this->assertEquals(4, Str::search($this->string, '/ is /', true));
		$this->assertEquals(-1, Str::search($this->string, '/ foo /', true));
	}

	public function testReplace()
	{
		$this->assertEquals('This is a Gears\String.', Str::replace($this->string, 'string', 'Gears\String'));
		$this->assertEquals($this->string, Str::replace($this->string, 'foo', 'Gears\String'));
		$this->assertEquals('This is a Gears\String.', Str::replace($this->string, '/string/', 'Gears\String', true));
		$this->assertEquals($this->string, Str::replace($this->string, '/ string /', 'Gears\String', true));
		$this->assertEquals('This is a STRING.', Str::replace($this->string, '/string/', function($matches){ return strtoupper($matches[0]); }, true));
	}

	public function testMatch()
	{
		$this->assertEquals(['is a', 'is a'], Str::match($this->string.' '.$this->string, '/is a/'));
		$this->assertEquals([], Str::match($this->string.' '.$this->string, '/is foo/'));
	}

	public function testBetween()
	{
		$this->assertEquals($this->string, Str::between('<start>'.$this->string.'</end>', '<start>', '</end>'));
		$this->assertEquals('', Str::between('<start>'.$this->string.'</end>', '<start1>', '</end>'));
		$this->assertEquals('', Str::between('<start>'.$this->string.'</end>', '<start>', '</end1>'));
		$this->assertEquals('<start>'.$this->string.'</end>', Str::between('<start>'.$this->string.'</end>', '<start>', '</end>', true));
	}

	public function testBetweenRegx()
	{
		$xml = file_get_contents(__DIR__.'/data/books.xml');
		$expected = require(__DIR__.'/data/books.php');
		$this->assertEquals($expected, Str::betweenRegx($xml, '<author>', '</author>'));
	}

	public function testSubString()
	{
		$this->assertEquals('is a', Str::substring($this->string, 5, 9));
		$this->assertEquals('is a string.', Str::substring($this->string, 5));
	}

	public function testSlice()
	{
		$this->assertEquals('is a', Str::slice($this->string, 5, 9));
		$this->assertEquals('is a string.', Str::slice($this->string, 5));
	}

	public function testConCat()
	{
		$this->assertEquals($this->string.$this->string, Str::conCat($this->string, $this->string));
	}

	public function testSplit()
	{
		$this->assertEquals(['T','h','i','s',' ','i','s',' ','a',' ','s','t','r','i','n','g','.'], Str::split($this->string));
		$this->assertEquals(['This','is','a','string.'], Str::split($this->string, ' '));
	}

	public function testRange()
	{
		$this->assertEquals(true, Str::range($this->string, 0, 20));
		$this->assertEquals(true, Str::range($this->string, 5, 20));
		$this->assertEquals(false, Str::range($this->string, 0, 10));
		$this->assertEquals(false, Str::range($this->string, 30, 40));
	}

	public function testCharAt()
	{
		$this->assertEquals('T', Str::charAt($this->string, 0));
		$this->assertEquals('h', Str::charAt($this->string, 1));
		$this->assertEquals('i', Str::charAt($this->string, 2));
		$this->assertEquals('s', Str::charAt($this->string, 3));
	}

	public function testCharCodeAt()
	{
		$this->assertEquals(84, Str::charCodeAt($this->string, 0));
		$this->assertEquals(104, Str::charCodeAt($this->string, 1));
		$this->assertEquals(105, Str::charCodeAt($this->string, 2));
		$this->assertEquals(115, Str::charCodeAt($this->string, 3));
	}

	public function testFromCharCode()
	{
		$this->assertEquals('T', Str::fromCharCode(84));
		$this->assertEquals('h', Str::fromCharCode(104));
		$this->assertEquals('i', Str::fromCharCode(105));
		$this->assertEquals('s', Str::fromCharCode(115));
	}

	public function testIndexOf()
	{
		$this->assertEquals(2, Str::indexOf($this->string, 'is'));
		$this->assertEquals(false, Str::indexOf($this->string, 'foo'));
	}

	public function testLastIndexOf()
	{
		$this->assertEquals(5, Str::lastIndexOf($this->string, 'is'));
		$this->assertEquals(false, Str::lastIndexOf($this->string, 'foo'));
	}

	// TODO: Ideally we should probably test the remaining laravel functions.
}