# indexOfLast
Returns the index of the last occurrence of $needle in the string,
and false if not found. Accepts an optional offset from which to begin
the search. Offsets may be negative to count from the last character
in the string.

## Description
`int|bool indexOfLast(string $needle, int $offset)`

### Parameters
* _string_ __$needle__  
Substring to look for.

* _int_ __$offset__  
Offset from which to search.


### Return Value
_int|bool_  
The last occurrence's index if found,
otherwise false.

## Examples

## Changelog
```
commit cb4957efce416b1679a51b29fe15b422e7f460d3
Author: Brad Jones <brad@bjc.id.au>
Date:   Mon Apr 18 14:41:48 2016 +1000

    Fixed up a bunch of bad indentation.

commit fe7c7b2d56888901c94e8fd150b7399d38bee5d4
Author: Brad Jones <brad@bjc.id.au>
Date:   Tue Mar 15 18:17:21 2016 +1100

    More refactoring's - still broken, still a WIP!

commit aa76a0507fc4398bd9f2a5b6744737e772fa621f
Author: Brad Jones <brad@bjc.id.au>
Date:   Fri Mar 11 19:20:05 2016 +1100

    So basically this is a refactored version of Stringy, we use traits to split up all the methods into categories for easier management. The refactor is still a WIP...
```