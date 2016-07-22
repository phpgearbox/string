# between
Returns the substring between `$start` and `$end`.

## Description
`static between(string $start, string $end, int $offset, bool $include)`

An optional offset may be supplied from which
to begin the search for the start string.

### Parameters
* _string_ __$start__  
Delimiter marking the start of the substring.

* _string_ __$end__  
Delimiter marking the end of the substring.

* _int_ __$offset__  
Index from which to begin the search.

* _bool_ __$include__  
If true, we include the start & end in the result.


### Return Value
_static_  
Str object between $start & $end.

## Examples
```php
$expected = 'Hello';
$str = new Str('<p>Hello</p>');
assert($str->between('<p>', '</p>') == $expected);
```

An optional offset may be supplied from which to begin the search for the start string.

```php
$expected = 'World';
$str = new Str('<p>Hello</p><p>World</p>');
assert($str->between('<p>', '</p>', 12) == $expected); // true
```

By default this method will discard the `$start` & `$end` substrings.
If you wish to include them, set the `$include` parameter to true.

```php
$expected = '<p>World</p>';
$str = new Str('<p>Hello</p><p>World</p>');
assert($str->between('<p>', '</p>', 12, true) == $expected); // true
```

## Changelog
```
commit 1d66201f0571cf151db8bacccee62b25ed8ee923
Author: Brad Jones <brad@bjc.id.au>
Date:   Thu Apr 7 17:32:05 2016 +1000

    About half way through porting unit tests.

commit fe7c7b2d56888901c94e8fd150b7399d38bee5d4
Author: Brad Jones <brad@bjc.id.au>
Date:   Tue Mar 15 18:17:21 2016 +1100

    More refactoring's - still broken, still a WIP!
```