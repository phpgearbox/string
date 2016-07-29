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