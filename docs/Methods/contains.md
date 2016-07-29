# contains
Returns true if the string contains $needle, false otherwise.

## Description
`bool contains(string $needle, bool $caseSensitive = 1)`

By default the comparison is case-sensitive, but can be made
insensitive by setting $caseSensitive to false.

### Parameters
* _string_ __$needle__  
Substring to look for.

* _bool_ __$caseSensitive__  
Whether or not to enforce case-sensitivity.


### Return Value
_bool_  
Whether or not $str contains $needle.