The String Gear
================================================================================
A collection of basic string manipulation functions.
There are 2 APIs, one procedural based and one object based.

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
Gears\String\Contains('this is a test', 'test');

// returns 'this is a test'
Gears\String\Between('<p>this is a test</p>', '<p>', '</p>');

// returns 'cde'
Gears\String\SubString('abcdeg', 2, 5);
```

And here are the same examples but using the Gears\String\Object class:

```php
// $new_string = true
$string = new Gears\String\Object('this is a test');
$new_string = $string->Contains('test');

// $new_string = 'this is a test'
$string = new Gears\String\Object('<p>this is a test</p>');
$new_string = $string->Between('<p>', '</p>');

// $new_string = 'cde'
$string = new Gears\String\Object('abcdeg');
$new_string = $string->SubString(2, 5);
```

Where ever a new string is returned it is in fact a new instance of the Object
class, thus you can also do things like this with the Object API:

```php
// $new_string = 'this is a test'
$string = new Gears\String\Object('<div><p>this is a test</p></div>');
$new_string = $string->Between('<div>', '</div>')->Between('<p>', '</p>');
```

If an array is returned for example when using the Match method, the array
will be an array of Gears\String\Object instances not simple PHP strings.

```php
// $results would look like:
// Array( Gears\String\Object(I), Gears\String\Object(a) )
$string = new Gears\String\Object('I am going to perform a test');
$results = $string->Match('/ \w /');

// So I can do this:
foreach ($results as $result)
{
	if ($result->Contains('a'))
	{
		echo 'we found the letter a';
	}
}
```

> NOTE: That the procedural API will only ever return standard PHP strings.

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