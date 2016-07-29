## Examples
```php
$expected = [['<p>Hello</p>', '<p>World</p>'], ['Hello', 'World']];
$str = new Str('<p>Hello</p><p>World</p>');
assert($str->betweenAll('<p>', '</p>') == $expected); // true
```

> NOTE: The first array will be inclusive of `$start` & `$end`, the second array will not.
