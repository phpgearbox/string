# htmlXssClean
Sanitizes data so that Cross Site Scripting Hacks can be prevented.

## Description
`static htmlXssClean()`

This method does a fair amount of work and it is extremely thorough,
designed to prevent even the most obscure XSS attempts. Nothing is ever
100 percent foolproof, of course, but I haven't been able to get anything
passed the filter.

> NOTE: Should only be used to deal with data upon submission.
> It's not something that should be used for general runtime processing.

__In other words it is still critically important
to escape anything that you output!!!__

This uses a packaged version of the Anti XSS Library from CodeIgniter.


### Return Value
_static_  


## Examples

## Changelog
```
commit cecb498d4031044811359c8feb6dcc36104829db
Author: Brad Jones <brad@bjc.id.au>
Date:   Mon Apr 18 17:31:20 2016 +1000

    Various other docblock fixes.

commit cb4957efce416b1679a51b29fe15b422e7f460d3
Author: Brad Jones <brad@bjc.id.au>
Date:   Mon Apr 18 14:41:48 2016 +1000

    Fixed up a bunch of bad indentation.

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