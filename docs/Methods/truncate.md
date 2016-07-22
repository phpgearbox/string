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

## Examples

## Changelog
```
commit dc4a3304792b1fbb945bd1d8a576d24fcda7deb6
Author: Brad Jones <brad@bjc.id.au>
Date:   Mon Apr 18 17:01:48 2016 +1000

    Fixes #2 by setting $lastPos to 0 if we get anything other than an integer.

commit c7154a7ee1052efa8cb90cdfc858fd816ac4963b
Author: Brad Jones <brad@bjc.id.au>
Date:   Mon Apr 18 16:52:54 2016 +1000

    Fixes #2 by checking for an integer.

commit ceb21752a7b131831a756fedabb6eeef2d4afc66
Author: Brad Jones <brad@bjc.id.au>
Date:   Fri Apr 8 16:43:24 2016 +1000

    Unit test refactor now complete.

commit fe7c7b2d56888901c94e8fd150b7399d38bee5d4
Author: Brad Jones <brad@bjc.id.au>
Date:   Tue Mar 15 18:17:21 2016 +1100

    More refactoring's - still broken, still a WIP!
```