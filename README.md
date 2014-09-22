The String Gear
================================================================================
[![Build Status](https://travis-ci.org/phpgearbox/string.svg?branch=master)](https://travis-ci.org/phpgearbox/string)
[![Latest Stable Version](https://poser.pugx.org/gears/string/v/stable.svg)](https://packagist.org/packages/gears/string)
[![Total Downloads](https://poser.pugx.org/gears/string/downloads.svg)](https://packagist.org/packages/gears/string)
[![License](https://poser.pugx.org/gears/string/license.svg)](https://packagist.org/packages/gears/string)

A collection of basic string manipulation functions.
There are 2 APIs:

  - One procedural based using name spaced functions.
  - And an object based API.

I am not going to bother documenting every single last function here but please
see below for some general usage examples. The rest you can work out for
yourself by reading the source, it's fairly straight forward and well commented.

How to Install
--------------------------------------------------------------------------------
Installation via composer is easy:

	composer require gears/string:*

How to Use
--------------------------------------------------------------------------------
Here are a few procedural examples:

```php
// returns true
Gears\String\contains('this is a test', 'test');

// returns 'this is a test'
Gears\String\between('<p>this is a test</p>', '<p>', '</p>');

// returns 'cde'
Gears\String\subString('abcdeg', 2, 5);
```

In PHP 5.6 you can import functions so you could change the above to:

```php
// Import the functions
use function Gears\String\contains;
use function Gears\String\between;
use function Gears\String\subString;

// returns true
contains('this is a test', 'test');

// returns 'this is a test'
between('<p>this is a test</p>', '<p>', '</p>');

// returns 'cde'
subString('abcdeg', 2, 5);
```

> NOTE: All function names are camelCased.

Prior to PHP 5.6 this is not possible. So you can do this instead:

```php
// Import the string class
use Gears\String as Str;

// returns true
Str::contains('this is a test', 'test');

// returns 'this is a test'
Str::between('<p>this is a test</p>', '<p>', '</p>');

// returns 'cde'
Str::subString('abcdeg', 2, 5);
```

**The factory method:** You may wish to use the factory method to intiate a
new Gears\String object. When you do, please note how the subsequent method
call signature changes. You no longer need to provide the string to be performed
on as the first argument. This is automatically done for you.
Here is an example:

```php
// using the factory method - returns true
Str::s('This is a test')->contains('test');

// Method chaining is possible - returns 'this is a test'
Str::s('<div><p>this is a test</p></div>')->between('<div>', '</div>')->between('<p>', '</p>');
```

If an array is returned for example when using the match method, the array
will be an array of Gears\String instances not simple PHP strings.

```php
// $results would look like:
// Array( Gears\String(I), Gears\String(a) )
$string = new Gears\String('I am going to perform a test');
$results = $string->match('/ \w /');

// So I can do this:
foreach ($results as $result)
{
	if ($result->contains('a'))
	{
		echo 'we found the letter a';
	}
}
```

> NOTE: Using the namespaced functions directly will only ever return
standard PHP strings unlike the above.

The Roadmap
--------------------------------------------------------------------------------
My ultimate goal is to provide a fluent human like interface.
For example, a replace call might look like this:

```php
Str::s('A string would go here...')->replace('would')->with('will');
```

Credits
--------------------------------------------------------------------------------
Thanks to *alecgorge* for the inspiration, I have taken his methods refactored
them slightly and added a few of my own methods, into the mix. The one notable
feature removal was the MultiByte support. The reason I dropped this was 2 fold.

1. I have never ever used it before, I come from an English Speaking country.
Perhaps this is a little nieve of me but I put more emphasis on creating a
light weight solution, we all hate bloatware.

2. I found out Multibyte has this function overloading support. Okay perhaps
it's not preferable but when I tested it out it worked fine for me. Again this
could be a nieve view point...

Anyway all the same thanks *alecgorge*
https://github.com/alecgorge/PHP-String-Class/

--------------------------------------------------------------------------------
Developed by Brad Jones - brad@bjc.id.au