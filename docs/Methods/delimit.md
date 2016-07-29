# delimit
Returns a lowercase and trimmed string separated by the given delimiter.

## Description
`static delimit(string $delimiter)`

Delimiters are inserted before uppercase characters (with the exception
of the first character of the string), and in place of spaces, dashes,
and underscores. Alpha delimiters are not converted to lowercase.

### Parameters
* _string_ __$delimiter__  
Sequence used to separate parts of the string


### Return Value
_static_