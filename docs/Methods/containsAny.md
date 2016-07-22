# containsAny
Returns true if the string contains any $needles, false otherwise.

## Description
`bool containsAny(array $needles, bool $caseSensitive = 1)`

By default the comparison is case-sensitive, but can be made
insensitive by setting $caseSensitive to false.

### Parameters
* _array_ __$needles__  
SubStrings to look for.

* _bool_ __$caseSensitive__  
Whether or not to enforce case-sensitivity.


### Return Value
_bool_  
Whether or not $str contains $needle.

## Examples

## Changelog
```
commit cb4957efce416b1679a51b29fe15b422e7f460d3
Author: Brad Jones <brad@bjc.id.au>
Date:   Mon Apr 18 14:41:48 2016 +1000

    Fixed up a bunch of bad indentation.

commit 1d66201f0571cf151db8bacccee62b25ed8ee923
Author: Brad Jones <brad@bjc.id.au>
Date:   Thu Apr 7 17:32:05 2016 +1000

    About half way through porting unit tests.

commit fe7c7b2d56888901c94e8fd150b7399d38bee5d4
Author: Brad Jones <brad@bjc.id.au>
Date:   Tue Mar 15 18:17:21 2016 +1100

    More refactoring's - still broken, still a WIP!

commit aa76a0507fc4398bd9f2a5b6744737e772fa621f
Author: Brad Jones <brad@bjc.id.au>
Date:   Fri Mar 11 19:20:05 2016 +1100

    So basically this is a refactored version of Stringy, we use traits to split up all the methods into categories for easier management. The refactor is still a WIP...
```