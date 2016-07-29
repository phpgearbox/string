# pad
Pads the string to a given length with $padStr.

## Description
`static pad(int $length, string $padStr = ' ', string $padType = 'right')`

If length is less than or equal to the length of the string, no padding
takes places. The default string used for padding is a space, and the
default type (one of 'left', 'right', 'both') is 'right'.

### Parameters
* _int_ __$length__  
Desired string length after padding.

* _string_ __$padStr__  
String used to pad, defaults to space.

* _string_ __$padType__  
One of 'left', 'right', 'both'.


### Return Value
_static_  
String after being padded.