# between
Returns the substring between `$start` and `$end`.

## Signature
`string between(string $start, string $end [, int $offset = 0 [, bool $include = false]])`

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

# betweenAll
Returns an array of substrings between $start and $end.

## Signature
`array betweenAll(string $start, string $end)`

## Examples
```php
$expected = [['<p>Hello</p>', '<p>World</p>'], ['Hello', 'World']];
$str = new Str('<p>Hello</p><p>World</p>');
assert($str->betweenAll('<p>', '</p>') == $expected); // true
```

> NOTE: The first array will be inclusive of `$start` & `$end`, the second
> array will not. You are getting the matches returned from `preg_match_all()`.
