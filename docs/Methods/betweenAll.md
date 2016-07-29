# betweenAll
Returns an array of substrings between $start and $end.

## Description
`static[] betweenAll(string $start, string $end)`

### Parameters
* _string_ __$start__  
Delimiter marking the start of the substring.

* _string_ __$end__  
Delimiter marking the end of the substring.


### Return Value
_static[]_  


## Examples
```php
$expected = [['<p>Hello</p>', '<p>World</p>'], ['Hello', 'World']];
$str = new Str('<p>Hello</p><p>World</p>');
assert($str->betweenAll('<p>', '</p>') == $expected); // true
```

> NOTE: The first array will be inclusive of `$start` & `$end`, the second array will not.