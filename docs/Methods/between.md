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