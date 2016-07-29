# truncate
Truncates the string to a given length.

## Description
`static truncate(int $length, string $substring)`

If $substring is provided, and truncating occurs, the string is further
truncated so that the substring may be appended without exceeding the
desired length.

### Parameters
* _int_ __$length__  
Desired length of the truncated string.

* _string_ __$substring__  
The substring to append if it can fit.


### Return Value
_static_  
String after truncating.