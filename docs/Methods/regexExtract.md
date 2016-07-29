# regexExtract
Given an expression with capture groups, this will return those captures.

## Description
`array regexExtract(string $pattern, string $options)`

Basically this is the same as `regexMatch()` but returns the array
of matches from `preg_match()` where as `regexMatch()` just returns
a boolean result.

### Parameters
* _string_ __$pattern__  
Regex pattern to match against.

* _string_ __$options__  
Matching conditions to be used.


### Return Value
_array_  
The matches discovered by `preg_match()`.