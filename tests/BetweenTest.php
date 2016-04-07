<?php

use Gears\String\Str;

class BetweenTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider betweenProvider()
     */
    public function testBetween($expected, $string, $start, $end, $offset = null, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->between($start, $end, $offset);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function betweenProvider()
    {
        return array
        (
            array('', 'foo', '{', '}'),
            array('', '{foo', '{', '}'),
            array('foo', '{foo}', '{', '}'),
            array('{foo', '{{foo}', '{', '}'),
            array('', '{}foo}', '{', '}'),
            array('foo', '}{foo}', '{', '}'),
            array('foo', 'A description of {foo} goes here', '{', '}'),
            array('bar', '{foo} and {bar}', '{', '}', 1),
            array('', 'fòô', '{', '}', 0, 'UTF-8'),
            array('', '{fòô', '{', '}', 0, 'UTF-8'),
            array('fòô', '{fòô}', '{', '}', 0, 'UTF-8'),
            array('{fòô', '{{fòô}', '{', '}', 0, 'UTF-8'),
            array('', '{}fòô}', '{', '}', 0, 'UTF-8'),
            array('fòô', '}{fòô}', '{', '}', 0, 'UTF-8'),
            array('fòô', 'A description of {fòô} goes here', '{', '}', 0, 'UTF-8'),
            array('bàř', '{fòô} and {bàř}', '{', '}', 1, 'UTF-8')
        );
    }

    public function testBetweenAll()
    {
        $str = new Str
        ('
            <?xml version="1.0" encoding="UTF-8"?>
            <CATALOG>
                <CD>
                    <TITLE>Empire Burlesque</TITLE>
                    <ARTIST>Bob Dylan</ARTIST>
                    <COUNTRY>USA</COUNTRY>
                    <COMPANY>Columbia</COMPANY>
                    <PRICE>10.90</PRICE>
                    <YEAR>1985</YEAR>
                </CD>
                <CD>
                    <TITLE>Hide your heart</TITLE>
                    <ARTIST>Bonnie Tyler</ARTIST>
                    <COUNTRY>UK</COUNTRY>
                    <COMPANY>CBS Records</COMPANY>
                    <PRICE>9.90</PRICE>
                    <YEAR>1988</YEAR>
                </CD>
                <CD>
                    <TITLE>Greatest Hits</TITLE>
                    <ARTIST>Dolly Parton</ARTIST>
                    <COUNTRY>USA</COUNTRY>
                    <COMPANY>RCA</COMPANY>
                    <PRICE>9.90</PRICE>
                    <YEAR>1982</YEAR>
                </CD>
            </CATALOG>
        ');

        $titles = $str->betweenAll('<TITLE>', '</TITLE>');

        $this->assertEquals('<TITLE>Empire Burlesque</TITLE>', $titles[0][0]);
        $this->assertEquals('<TITLE>Hide your heart</TITLE>', $titles[0][1]);
        $this->assertEquals('<TITLE>Greatest Hits</TITLE>', $titles[0][2]);

        $this->assertEquals('Empire Burlesque', $titles[1][0]);
        $this->assertEquals('Hide your heart', $titles[1][1]);
        $this->assertEquals('Greatest Hits', $titles[1][2]);
    }
}
