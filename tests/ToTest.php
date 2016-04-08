<?php

use Gears\String\Str;

class ToTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider toStringProvider()
     */
    public function testToString($expected, $string)
    {
        $str = new Str($string);
        $this->assertEquals($expected, (string)$str);
        $this->assertEquals($expected, $str->toString());
    }

    public function toStringProvider()
    {
        return array
        (
            array('', null),
            array('', false),
            array('1', true),
            array('-9', -9),
            array('1.18', 1.18),
            array(' string  ', ' string  ')
        );
    }

    /**
     * @dataProvider toArrayProvider()
     */
    public function testToArray($expected, $string, $encoding = null)
    {
        $result = Str::s($string, $encoding)->toArray();

        $this->assertInternalType('array', $result);

        foreach ($result as $char)
        {
            $this->assertInstanceOf('Gears\\String\\Str', $char);
        }

        $this->assertEquals($expected, $result);
    }

    public function toArrayProvider()
    {
        return array
        (
            array(array(), ''),
            array(array('T', 'e', 's', 't'), 'Test'),
            array(array('F', 'ò', 'ô', ' ', 'B', 'à', 'ř'), 'Fòô Bàř', 'UTF-8')
        );
    }

    /**
     * @dataProvider toLowerCaseProvider()
     */
    public function testToLowerCase($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->toLowerCase();
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function toLowerCaseProvider()
    {
        return array
        (
            array('foo bar', 'FOO BAR'),
            array(' foo_bar ', ' FOO_bar '),
            array('fòô bàř', 'FÒÔ BÀŘ', 'UTF-8'),
            array(' fòô_bàř ', ' FÒÔ_bàř ', 'UTF-8'),
            array('αυτοκίνητο', 'ΑΥΤΟΚΊΝΗΤΟ', 'UTF-8')
        );
    }

    /**
     * @dataProvider toUpperCaseProvider()
     */
    public function testToUpperCase($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->toUpperCase();
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function toUpperCaseProvider()
    {
        return array
        (
            array('FOO BAR', 'foo bar'),
            array(' FOO_BAR ', ' FOO_bar '),
            array('FÒÔ BÀŘ', 'fòô bàř', 'UTF-8'),
            array(' FÒÔ_BÀŘ ', ' FÒÔ_bàř ', 'UTF-8'),
            array('ΑΥΤΟΚΊΝΗΤΟ', 'αυτοκίνητο', 'UTF-8')
        );
    }

    /**
     * @dataProvider toSingularProvider()
     */
    public function testToSingular($expected, $string)
    {
        $result = Str::s($string)->toSingular();
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
    }

    public function toSingularProvider()
    {
        // NOTE: These test cases are really just to prove that Gears\String\Str
        // is working as it should, a full complement of tests can be found
        // here: https://github.com/ICanBoogie/Inflector/tree/master/tests
        return
        [
            ['car', 'cars'],
            ['dog', 'dogs'],
            ['cat', 'cats'],
        ];
    }

    /**
     * @dataProvider toPluralProvider()
     */
    public function testToPlural($expected, $string)
    {
        $result = Str::s($string)->toPlural();
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
    }

    public function toPluralProvider()
    {
        // NOTE: These test cases are really just to prove that Gears\String\Str
        // is working as it should, a full complement of tests can be found
        // here: https://github.com/ICanBoogie/Inflector/tree/master/tests
        return
        [
            ['cars', 'car'],
            ['dogs', 'dog'],
            ['cats', 'cat'],
        ];
    }

    /**
     * @dataProvider toAsciiProvider()
     */
    public function testToAscii($expected, $string)
    {
        $str = new Str($string);
        $result = $str->toAscii();
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function toAsciiProvider()
    {
        return array
        (
            array('foo bar', 'fòô bàř'),
            array(' TEST ', ' ŤÉŚŢ '),
            array('ph = z = 3', 'φ = ź = 3'),
            array('pierievirka', 'перевірка'),
            array('lysaia ghora', 'лысая гора'),
            array('shchuka', 'щука'),
            array('Han Zi ', '漢字'),
            array('xin chao the gioi', 'xin chào thế giới'),
            array('XIN CHAO THE GIOI', 'XIN CHÀO THẾ GIỚI'),
            array('dam phat chet luon', 'đấm phát chết luôn'),
            array(' ', ' '), // no-break space (U+00A0)
            array('           ', '           '), // spaces U+2000 to U+200A
            array(' ', ' '), // narrow no-break space (U+202F)
            array(' ', ' '), // medium mathematical space (U+205F)
            array(' ', '　'), // ideographic space (U+3000)
            array('', '𐍉'), // some uncommon, unsupported character (U+10349)
        );
    }

    /**
     * @dataProvider toBooleanProvider()
     */
    public function testToBoolean($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->toBoolean();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function toBooleanProvider()
    {
        return array
        (
            array(true, 'true'),
            array(true, '1'),
            array(true, 'on'),
            array(true, 'ON'),
            array(true, 'yes'),
            array(true, '999'),
            array(false, 'false'),
            array(false, '0'),
            array(false, 'off'),
            array(false, 'OFF'),
            array(false, 'no'),
            array(false, '-999'),
            array(false, ''),
            array(false, ' '),
            array(false, '  ', 'UTF-8') // narrow no-break space (U+202F)
        );
    }

    /**
     * @dataProvider toSpacesProvider()
     */
    public function testToSpaces($expected, $string, $tabLength = 4)
    {
        $str = new Str($string);
        $result = $str->toSpaces($tabLength);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function toSpacesProvider()
    {
        return array
        (
            array('    foo    bar    ', '	foo	bar	'),
            array('     foo     bar     ', '	foo	bar	', 5),
            array('    foo  bar  ', '		foo	bar	', 2),
            array('foobar', '	foo	bar	', 0),
            array("    foo\n    bar", "	foo\n	bar"),
            array("    fòô\n    bàř", "	fòô\n	bàř")
        );
    }

    /**
     * @dataProvider toTabsProvider()
     */
    public function testToTabs($expected, $string, $tabLength = 4)
    {
        $str = new Str($string);
        $result = $str->toTabs($tabLength);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function toTabsProvider()
    {
        return array
        (
            array('	foo	bar	', '    foo    bar    '),
            array('	foo	bar	', '     foo     bar     ', 5),
            array('		foo	bar	', '    foo  bar  ', 2),
            array("	foo\n	bar", "    foo\n    bar"),
            array("	fòô\n	bàř", "    fòô\n    bàř")
        );
    }

    /**
     * @dataProvider toDashedProvider()
     */
    public function testToDashed($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->toDashed();
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function toDashedProvider()
    {
        return array
        (
            array('test-case', 'testCase'),
            array('test-case', 'Test-Case'),
            array('test-case', 'test case'),
            array('-test-case', '-test -case'),
            array('test-case', 'test - case'),
            array('test-case', 'test_case'),
            array('test-c-test', 'test c test'),
            array('test-d-case', 'TestDCase'),
            array('test-c-c-test', 'TestCCTest'),
            array('string-with1number', 'string_with1number'),
            array('string-with-2-2-numbers', 'String-with_2_2 numbers'),
            array('1test2case', '1test2case'),
            array('data-rate', 'dataRate'),
            array('car-speed', 'CarSpeed'),
            array('yes-we-can', 'yesWeCan'),
            array('background-color', 'backgroundColor'),
            array('dash-σase', 'dash Σase', 'UTF-8'),
            array('στανιλ-case', 'Στανιλ case', 'UTF-8'),
            array('σash-case', 'Σash  Case', 'UTF-8')
        );
    }

    /**
     * @dataProvider toUnderScoredProvider()
     */
    public function testToUnderScored($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->toUnderScored();
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function toUnderScoredProvider()
    {
        return array
        (
            array('test_case', 'testCase'),
            array('test_case', 'Test-Case'),
            array('test_case', 'test case'),
            array('test_case', 'test -case'),
            array('_test_case', '-test - case'),
            array('test_case', 'test_case'),
            array('test_c_test', '  test c test'),
            array('test_u_case', 'TestUCase'),
            array('test_c_c_test', 'TestCCTest'),
            array('string_with1number', 'string_with1number'),
            array('string_with_2_2_numbers', 'String-with_2_2 numbers'),
            array('1test2case', '1test2case'),
            array('yes_we_can', 'yesWeCan'),
            array('test_σase', 'test Σase', 'UTF-8'),
            array('στανιλ_case', 'Στανιλ case', 'UTF-8'),
            array('σash_case', 'Σash  Case', 'UTF-8')
        );
    }

    /**
     * @dataProvider toCamelCaseProvider()
     */
    public function testToCamelCase($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->toCamelCase();
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function toCamelCaseProvider()
    {
        return array
        (
            array('camelCase', 'CamelCase'),
            array('camelCase', 'Camel-Case'),
            array('camelCase', 'camel case'),
            array('camelCase', 'camel -case'),
            array('camelCase', 'camel - case'),
            array('camelCase', 'camel_case'),
            array('camelCTest', 'camel c test'),
            array('stringWith1Number', 'string_with1number'),
            array('stringWith22Numbers', 'string-with-2-2 numbers'),
            array('dataRate', 'data_rate'),
            array('backgroundColor', 'background-color'),
            array('yesWeCan', 'yes_we_can'),
            array('mozSomething', '-moz-something'),
            array('carSpeed', '_car_speed_'),
            array('serveHTTP', 'ServeHTTP'),
            array('1Camel2Case', '1camel2case'),
            array('camelΣase', 'camel σase', 'UTF-8'),
            array('στανιλCase', 'Στανιλ case', 'UTF-8'),
            array('σamelCase', 'σamel  Case', 'UTF-8')
        );
    }

    /**
     * @dataProvider toSnakeCaseProvider()
     */
    public function testToSnakeCase($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->toSnakeCase();
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function toSnakeCaseProvider()
    {
        return array
        (
            array('snake_case', 'SnakeCase'),
            array('snake_case', 'Snake-Case'),
            array('snake_case', 'snake case'),
            array('snake_case', 'snake -case'),
            array('snake_case', 'snake - case'),
            array('snake_case', 'snake_case'),
            array('camel_c_test', 'camel c test'),
            array('string_with_1_number', 'string_with 1 number'),
            array('string_with_1_number', 'string_with1number'),
            array('string_with_2_2_numbers', 'string-with-2-2 numbers'),
            array('data_rate', 'data_rate'),
            array('background_color', 'background-color'),
            array('yes_we_can', 'yes_we_can'),
            array('moz_something', '-moz-something'),
            array('car_speed', '_car_speed_'),
            array('serve_h_t_t_p', 'ServeHTTP'),
            array('1_camel_2_case', '1camel2case'),
            array('camel_σase', 'camel σase', 'UTF-8'),
            array('Στανιλ_case', 'Στανιλ case', 'UTF-8'),
            array('σamel_case', 'σamel  Case', 'UTF-8')
        );
    }

    /**
     * @dataProvider toTitleCaseProvider()
     */
    public function testToTitleCase($expected, $string, $ignore = null, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->toTitleCase($ignore);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function toTitleCaseProvider()
    {
        $ignore = ['at', 'by', 'for', 'in', 'of', 'on', 'out', 'to', 'the'];

        return
        [
            ['Title Case', 'TITLE CASE'],
            ['Testing The Method', 'testing the method'],
            ['Testing the Method', 'testing the method', $ignore],
            ['I Like to Watch Dvds at Home', 'i like to watch DVDs at home', $ignore],
            ['Θα Ήθελα Να Φύγει', '  Θα ήθελα να φύγει  ', null, 'UTF-8']
        ];
    }

    /**
     * @dataProvider toSentenceCaseProvider()
     */
    public function testToSentenceCase($expected, $string, $encoding = null)
    {
        $str = new Str($string, $encoding);
        $result = $str->toSentenceCase();
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function toSentenceCaseProvider()
    {
        return
        [
            ['Sentence case', ' SENTENCE CASE '],
            ['Sentence case', ' sentence case '],
            ['Ήθελα να φύγει', '  ήθελα να φύγει  ', null, 'UTF-8']
        ];
    }

    /**
     * @dataProvider toSlugCaseProvider()
     */
    public function testToSlugCase($expected, $string, $replacement = '-')
    {
        $str = new Str($string);
        $result = $str->toSlugCase($replacement);
        $this->assertInstanceOf('Gears\\String\\Str', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($string, $str);
    }

    public function toSlugCaseProvider()
    {
        return array
        (
            array('foo-bar', ' foo  bar '),
            array('foo-bar', 'foo -.-"-...bar'),
            array('another-foo-bar', 'another..& foo -.-"-...bar'),
            array('foo-d-bar', " Foo d'Bar "),
            array('a-string-with-dashes', 'A string-with-dashes'),
            array('using-strings-like-foo-bar', 'Using strings like fòô bàř'),
            array('numbers-1234', 'numbers 1234'),
            array('perevirka-ryadka', 'перевірка рядка'),
            array('bukvar-s-bukvoj-y', 'букварь с буквой ы'),
            array('podehal-k-podezdu-moego-doma', 'подъехал к подъезду моего дома'),
            array('foo:bar:baz', 'Foo bar baz', ':'),
            array('a_string_with_underscores', 'A_string with_underscores', '_'),
            array('a_string_with_dashes', 'A string-with-dashes', '_'),
            array('a\string\with\dashes', 'A string-with-dashes', '\\'),
            array('an_odd_string', '--   An odd__   string-_', '_')
        );
    }
}
