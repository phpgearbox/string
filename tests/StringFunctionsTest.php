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

class StringFunctionsTest extends PHPUnit_Framework_TestCase
{
	protected $string = 'This is a string.';

	public function testSearch()
	{
		$this->assertEquals(8, Gears\String\search($this->string, 'a'));
		$this->assertEquals(-1, Gears\String\search($this->string, 'b'));
		$this->assertEquals(4, Gears\String\search($this->string, '/ is /', true));
		$this->assertEquals(-1, Gears\String\search($this->string, '/ foo /', true));
	}

	public function testReplace()
	{
		$this->assertEquals('This is a Gears\String.', Gears\String\replace($this->string, 'string', 'Gears\String'));
		$this->assertEquals($this->string, Gears\String\replace($this->string, 'foo', 'Gears\String'));
		$this->assertEquals('This is a Gears\String.', Gears\String\replace($this->string, '/string/', 'Gears\String', true));
		$this->assertEquals($this->string, Gears\String\replace($this->string, '/ string /', 'Gears\String', true));
		$this->assertEquals('This is a STRING.', Gears\String\replace($this->string, '/string/', function($matches){ return strtoupper($matches[0]); }, true));
	}

	public function testMatch()
	{
		$this->assertEquals(['is a', 'is a'], Gears\String\match($this->string.' '.$this->string, '/is a/'));
		$this->assertEquals([], Gears\String\match($this->string.' '.$this->string, '/is foo/'));
	}

	public function testBetween()
	{
		$this->assertEquals($this->string, Gears\String\between('<start>'.$this->string.'</end>', '<start>', '</end>'));
		$this->assertEquals('', Gears\String\between('<start>'.$this->string.'</end>', '<start1>', '</end>'));
		$this->assertEquals('', Gears\String\between('<start>'.$this->string.'</end>', '<start>', '</end1>'));
		$this->assertEquals('<start>'.$this->string.'</end>', Gears\String\between('<start>'.$this->string.'</end>', '<start>', '</end>', true));
	}

	public function testBetweenRegx()
	{
		$xml = file_get_contents(__DIR__.'/data/books.xml');
		$expected = require(__DIR__.'/data/books.php');
		$this->assertEquals($expected, Gears\String\betweenRegx($xml, '<author>', '</author>'));
	}

	public function testSubString()
	{
		$this->assertEquals('is a', Gears\String\substring($this->string, 5, 9));
		$this->assertEquals('is a string.', Gears\String\substring($this->string, 5));
	}

	public function testSlice()
	{
		$this->assertEquals('is a', Gears\String\slice($this->string, 5, 9));
		$this->assertEquals('is a string.', Gears\String\slice($this->string, 5));
	}

	public function testConCat()
	{
		$this->assertEquals($this->string.$this->string, Gears\String\conCat($this->string, $this->string));
	}

	public function testSplit()
	{
		$this->assertEquals(['T','h','i','s',' ','i','s',' ','a',' ','s','t','r','i','n','g','.'], Gears\String\split($this->string));
		$this->assertEquals(['This','is','a','string.'], Gears\String\split($this->string, ' '));
	}

	public function testRange()
	{
		$this->assertEquals(true, Gears\String\range($this->string, 0, 20));
		$this->assertEquals(true, Gears\String\range($this->string, 5, 20));
		$this->assertEquals(false, Gears\String\range($this->string, 0, 10));
		$this->assertEquals(false, Gears\String\range($this->string, 30, 40));
	}

	public function testCharAt()
	{
		$this->assertEquals('T', Gears\String\charAt($this->string, 0));
		$this->assertEquals('h', Gears\String\charAt($this->string, 1));
		$this->assertEquals('i', Gears\String\charAt($this->string, 2));
		$this->assertEquals('s', Gears\String\charAt($this->string, 3));
	}

	public function testCharCodeAt()
	{
		$this->assertEquals(84, Gears\String\charCodeAt($this->string, 0));
		$this->assertEquals(104, Gears\String\charCodeAt($this->string, 1));
		$this->assertEquals(105, Gears\String\charCodeAt($this->string, 2));
		$this->assertEquals(115, Gears\String\charCodeAt($this->string, 3));
	}

	public function testFromCharCode()
	{
		$this->assertEquals('T', Gears\String\fromCharCode(84));
		$this->assertEquals('h', Gears\String\fromCharCode(104));
		$this->assertEquals('i', Gears\String\fromCharCode(105));
		$this->assertEquals('s', Gears\String\fromCharCode(115));
	}

	public function testIndexOf()
	{
		$this->assertEquals(2, Gears\String\indexOf($this->string, 'is'));
		$this->assertEquals(false, Gears\String\indexOf($this->string, 'foo'));
	}

	public function testLastIndexOf()
	{
		$this->assertEquals(5, Gears\String\lastIndexOf($this->string, 'is'));
		$this->assertEquals(false, Gears\String\lastIndexOf($this->string, 'foo'));
	}

	// TODO: Ideally we should probably test the remaining laravel functions.
}