# is
Poor mans WildCard regular expression.

## Description
`bool is(string $pattern)`

Asterisks are translated into zero-or-more regular expression wildcards
to make it convenient to check if the strings starts with the given
pattern such as "library/*", making any string check convenient.

### Parameters
* _string_ __$pattern__  
The string or pattern to match against.


### Return Value
_bool_  
Whether or not we match the provided pattern.