# replace
Replaces all occurrences of $search in $str by $replacement.

## Description
`static replace(string|array $search, string|array $replacement, bool $caseSensitive = 1)`

### Parameters
* _string|array_ __$search__  
The needle to search for.

* _string|array_ __$replacement__  
The string to replace with.

* _bool_ __$caseSensitive__  
To enforce case-sensitivity or not.


### Return Value
_static_  
String after the replacements.

## Examples

## Changelog
```
commit 217d38a51d57d718eb5bf6650eba23514de09f32
Author: Brad Jones <brad@bjc.id.au>
Date:   Thu Apr 14 19:13:23 2016 +1000

    Added new method replaceExact.

commit 4d94a26d397c3d060064f80c1d8167107483f122
Author: Brad Jones <brad@bjc.id.au>
Date:   Thu Mar 17 17:56:50 2016 +1100

    A few more updates. Next step it to resetup the unit tests.

commit aa76a0507fc4398bd9f2a5b6744737e772fa621f
Author: Brad Jones <brad@bjc.id.au>
Date:   Fri Mar 11 19:20:05 2016 +1100

    So basically this is a refactored version of Stringy, we use traits to split up all the methods into categories for easier management. The refactor is still a WIP...
```