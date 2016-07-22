# replaceExact
Replaces only if an exact match is found.

## Description
`static replaceExact(string|string[] $search, string|string[] $replacement)`

Essentially all this does is swaps one string for another.
I needed this in a db migration script to map a bunch of
old column names to new column names.

### Parameters
* _string|string[]_ __$search__  
Either a single search term or
an array of search terms.

* _string|string[]_ __$replacement__  
Must be the same length as $search.
So if you provide a single search
term, you must provide a single
replacement, if you provide 10
search terms you must provide 10
replacements.


### Return Value
_static_  


## Examples

## Changelog
```
commit 217d38a51d57d718eb5bf6650eba23514de09f32
Author: Brad Jones <brad@bjc.id.au>
Date:   Thu Apr 14 19:13:23 2016 +1000

    Added new method replaceExact.

commit 4d94a26d397c3d060064f80c1d8167107483f122
Author: Brad Jones <brad@bjc.id.au>
Date:   Thu Mar 17 17:56:50 2016 +1100

    A few more updates. Next step it to resetup the unit tests.

commit aa76a0507fc4398bd9f2a5b6744737e772fa621f
Author: Brad Jones <brad@bjc.id.au>
Date:   Fri Mar 11 19:20:05 2016 +1100

    So basically this is a refactored version of Stringy, we use traits to split up all the methods into categories for easier management. The refactor is still a WIP...
```