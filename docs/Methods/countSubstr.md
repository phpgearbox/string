# countSubstr
Returns the number of occurrences of $substring in the given string.

## Description
`int countSubstr(string $substring, bool $caseSensitive = 1)`

By default, the comparison is case-sensitive, but can be made
insensitive by setting $caseSensitive to false.

### Parameters
* _string_ __$substring__  
The substring to search for.

* _bool_ __$caseSensitive__  
Whether or not to enforce case-sensitivity.


### Return Value
_int_  
The number of $substring occurrences