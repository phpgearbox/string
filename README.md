The String Gear
================================================================================
[![Build Status](https://travis-ci.org/phpgearbox/string.svg?branch=master)](https://travis-ci.org/phpgearbox/string)
[![Latest Stable Version](https://poser.pugx.org/gears/string/v/stable.svg)](https://packagist.org/packages/gears/string)
[![Total Downloads](https://poser.pugx.org/gears/string/downloads.svg)](https://packagist.org/packages/gears/string)
[![License](https://poser.pugx.org/gears/string/license.svg)](https://packagist.org/packages/gears/string)
[![HHVM Tested](http://hhvm.h4cc.de/badge/gears/string.svg?style=flat)](http://hhvm.h4cc.de/package/gears/string)

An object oriented way to work with strings in PHP,
with multibyte support baked in.

Credit & Inspiration
--------------------------------------------------------------------------------
The original library https://github.com/danielstjules/Stringy
The voku fork https://github.com/voku/Stringy

This version builds on voku's work. The main aim was to make the management of
the code base easier by splitting the mountain of methods that make up the
Stringy class into traits.

This does mean we have bumped the minimum PHP version to 5.4+

> NOTE: There are also a few other changes, this is not an API compatible fork.

How to Install
--------------------------------------------------------------------------------
Installation via composer is easy:

```
composer require gears/string
```

Then import the ```Str``` class into your script:

```php
use Gears\String\Str;
```

OO and Chaining
--------------------------------------------------------------------------------
The library offers OO method chaining, as seen below:

```php
echo Str::s('fòô     bàř')->removeWhitespace()->swapCase(); // 'FÒÔ BÀŘ'
```

`Gears\String\Str` has a `__toString()` method, which returns the current string
when the object is used in a string context, ie: `(string) Str::s('foo')`

Implemented Interfaces
--------------------------------------------------------------------------------
`Gears\String\Str` implements the `IteratorAggregate` interface, meaning that
`foreach` can be used with an instance of the class:

``` php
$str = Str::s('fòôbàř');
foreach ($str as $char) {
    echo $char;
}
// 'fòôbàř'
```

It implements the `Countable` interface, enabling the use of `count()` to
retrieve the number of characters in the string:

``` php
$str = Str::s('fòô');
count($str);  // 3
```

Furthermore, the `ArrayAccess` interface has been implemented. As a result,
`isset()` can be used to check if a character at a specific index exists. And
since `Gears\String\Str` is immutable, any call to `offsetSet` or `offsetUnset`
will throw an exception. `offsetGet` has been implemented, however, and accepts
both positive and negative indexes. Invalid indexes result in an
`OutOfBoundsException`.

``` php
$str = Str::s('bàř');
echo $str[2];     // 'ř'
echo $str[-2];    // 'à'
isset($str[-4]);  // false

$str[3];          // OutOfBoundsException
$str[2] = 'a';    // Exception
```

The Methods
--------------------------------------------------------------------------------
Instead of re-documenting all the possible methods here in this readme, which
is only likely to become outdated when changes are made to the methods overtime,
I will suggest you look at the source code directly.

I know this sounds like a cop-out but I honestly
believe this is for the greater good :)

All methods are documented with PSR-5 docblocks that provide autocomplete hints
to any decent IDE such as [PHP Storm](https://www.jetbrains.com/phpstorm/) or
Atom with [atom-autocomplete-php](https://atom.io/packages/atom-autocomplete-php).

String Builder
--------------------------------------------------------------------------------
In addition to the `Str` class, I have also created a string builder class that
is inspired by .NET's [StringBuilder](https://goo.gl/utVtKG) class.

Classic example, lets say you wanted to build some HTML.

```php
use Gears\String\Builder;

$html = new Builder();

$html->append('<ul>');

foreach ($rows as $row)
{
    $html->append('<li>');
    $html->append($row);
    $html->append('</li>');
}

$html->append('</ul>');

echo $html;
```

> Naturally the Builder is compatible with the `Str` objects also.

### Why:
There is much debate about performance of such String Builders in PHP.
Most suggest PHP simply doesn't need such a class because strings are
mutable and for the most part I completely agree.

Further reading: http://stackoverflow.com/questions/124067

However this is not a performance thing for me, personally I just like the
API that the C# StringBuilder class provides. Coming back to PHP development
after a lengthy .NET project, it was one of many things I missed.

Also the main `Gears\String\Str` class is immutable anyway.

--------------------------------------------------------------------------------
Developed by Brad Jones - brad@bjc.id.au
