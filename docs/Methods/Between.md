# between(string $start, string $end [, int $offset = 0 [, bool $include = false]])
Returns the substring between $start and $end.

```php
$str = new Str('<p>Hello</p>');
var_dump($str->between('<p>', '</p>') == 'Hello'); // true
```

An optional offset may be supplied from which to begin the search for the start string.

```php
$str = new Str('<p>Hello</p><p>World</p>');
var_dump($str->between('<p>', '</p>', 12) == 'World'); // true
```

By default this method will discard the `$start` & `$end` substrings.
If you wish to include them, set the `$include` parameter to true.

```php
$str = new Str('<p>Hello</p><p>World</p>');
var_dump($str->between('<p>', '</p>', 12, true) == '<p>World</p>'); // true
```

# betweenAll(string $start, string $end)
Returns an array of substrings between $start and $end.

```php
$str = new Str('<p>Hello</p><p>World</p>');
var_dump($str->betweenAll('<p>', '</p>') == [['<p>Hello</p>', '<p>World</p>'], ['Hello', 'World']]); // true
```

> NOTE: The first array will be inclusive of `$start` & `$end`, the second
> array will not. You are getting the matches returned from preg_match_all.
