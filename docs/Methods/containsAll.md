# containsAll
Returns true if the string contains all $needles, false otherwise.

## Description
`bool containsAll(array $needles, bool $caseSensitive = 1)`

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