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