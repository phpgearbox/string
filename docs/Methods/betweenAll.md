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