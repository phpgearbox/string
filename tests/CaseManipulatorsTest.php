<?php

use Gears\String\Str;

class CaseManipulatorsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider caseFirstProvider()
     */
    public function testCaseFirst($method, $expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $method = $method.'CaseFirst';
        $result = $str->$method();
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function caseFirstProvider()
    {
        return array
        (
            array('lower', 'test', 'Test'),
            array('lower', 'test', 'test'),
            array('lower', '1a', '1a'),
            array('lower', 'σ test', 'Σ test', 'UTF-8'),
            array('lower', ' Σ test', ' Σ test', 'UTF-8'),
            array('upper', 'Test', 'Test'),
            array('upper', 'Test', 'test'),
            array('upper', '1a', '1a'),
            array('upper', 'Σ test', 'σ test', 'UTF-8'),
            array('upper', ' σ test', ' σ test', 'UTF-8')
        );
    }

    /**
     * @dataProvider swapCaseProvider()
     */
    public function testSwapCase($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->swapCase();
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function swapCaseProvider()
    {
        return array
        (
            array('TESTcASE', 'testCase'),
            array('tEST-cASE', 'Test-Case'),
            array(' - σASH  cASE', ' - Σash  Case', 'UTF-8'),
            array('νΤΑΝΙΛ', 'Ντανιλ', 'UTF-8')
        );
    }
}
