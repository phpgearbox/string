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
