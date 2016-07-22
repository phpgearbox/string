# padBoth
Adds padding to both sides of the string, equally.

## Description
`static padBoth(int $length, string $padStr = ' ')`

### Parameters
* _int_ __$length__  
Desired string length after padding.

* _string_ __$padStr__  
String used to pad, defaults to space.


### Return Value
_static_  
String with padding applied to both sides.

## Examples

## Changelog
```
commit 4d94a26d397c3d060064f80c1d8167107483f122
Author: Brad Jones <brad@bjc.id.au>
Date:   Thu Mar 17 17:56:50 2016 +1100

    A few more updates. Next step it to resetup the unit tests.

commit aa76a0507fc4398bd9f2a5b6744737e772fa621f
Author: Brad Jones <brad@bjc.id.au>
Date:   Fri Mar 11 19:20:05 2016 +1100

    So basically this is a refactored version of Stringy, we use traits to split up all the methods into categories for easier management. The refactor is still a WIP...
```