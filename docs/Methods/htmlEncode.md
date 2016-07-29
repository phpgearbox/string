# htmlEncode
Convert all applicable characters to HTML entities.

## Description
`static htmlEncode(int|null $flags, bool $doubleEncode = 1)`

### Parameters
* _int|null_ __$flags__  
Optional flags.

* _bool_ __$doubleEncode__  
When double_encode is turned off PHP
will not encode existing html entities.
The default is to convert everything.


### Return Value
_static_  
String after being html encoded.