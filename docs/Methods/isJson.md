# isJson
Returns true if the string is JSON, false otherwise. Unlike json_decode
in PHP 5.x, this method is consistent with PHP 7 and other JSON parsers,
in that an empty string is not considered valid JSON.

## Description
`bool isJson()`


### Return Value
_bool_  
Whether or not $str is JSON