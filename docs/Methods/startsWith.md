# startsWith
Returns true if the string begins with $substring, false otherwise.

## Description
`bool startsWith(string $substring, bool $caseSensitive = 1)`

By default, the comparison is case-sensitive,
but can be made insensitive by setting $caseSensitive
to false.

### Parameters
* _string_ __$substring__  
The substring to look for

* _bool_ __$caseSensitive__  
Whether or not to enforce case-sensitivity


### Return Value
_bool_  
Whether or not $str starts with $substring

## Examples

## Changelog
```
commit aa76a0507fc4398bd9f2a5b6744737e772fa621f
Author: Brad Jones <brad@bjc.id.au>
Date:   Fri Mar 11 19:20:05 2016 +1100

    So basically this is a refactored version of Stringy, we use traits to split up all the methods into categories for easier management. The refactor is still a WIP...
```