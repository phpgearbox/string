# insert
Inserts $substring into the string at the $index provided.

## Description
`static insert(string $substring, int $index)`

### Parameters
* _string_ __$substring__  
String to be inserted.

* _int_ __$index__  
The index at which to insert the substring.


### Return Value
_static_  
String after the insertion.

## Examples

## Changelog
```
commit 55e35d3959bf93433bda49493e92a866915fd3a0
Author: Brad Jones <brad@harvestdp.com>
Date:   Fri Jul 1 17:00:37 2016 +1000

    Fix for UTF8::substr_count.

    Not sure when this changed or if it's always been wrong, anyway this code now calls the method correctly.

commit cecb498d4031044811359c8feb6dcc36104829db
Author: Brad Jones <brad@bjc.id.au>
Date:   Mon Apr 18 17:31:20 2016 +1000

    Various other docblock fixes.

commit cb4957efce416b1679a51b29fe15b422e7f460d3
Author: Brad Jones <brad@bjc.id.au>
Date:   Mon Apr 18 14:41:48 2016 +1000

    Fixed up a bunch of bad indentation.

commit d16955df4394ab54713c145453511935f2336724
Author: Brad Jones <brad@bjc.id.au>
Date:   Thu Apr 14 17:03:39 2016 +1000

    Added new normaliseLineEndings method.

commit ceb21752a7b131831a756fedabb6eeef2d4afc66
Author: Brad Jones <brad@bjc.id.au>
Date:   Fri Apr 8 16:43:24 2016 +1000

    Unit test refactor now complete.

commit 1d66201f0571cf151db8bacccee62b25ed8ee923
Author: Brad Jones <brad@bjc.id.au>
Date:   Thu Apr 7 17:32:05 2016 +1000

    About half way through porting unit tests.

commit fe7c7b2d56888901c94e8fd150b7399d38bee5d4
Author: Brad Jones <brad@bjc.id.au>
Date:   Tue Mar 15 18:17:21 2016 +1100

    More refactoring's - still broken, still a WIP!

commit aa76a0507fc4398bd9f2a5b6744737e772fa621f
Author: Brad Jones <brad@bjc.id.au>
Date:   Fri Mar 11 19:20:05 2016 +1100

    So basically this is a refactored version of Stringy, we use traits to split up all the methods into categories for easier management. The refactor is still a WIP...
```