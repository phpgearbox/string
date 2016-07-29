# htmlStripTags
Strip HTML and PHP tags from a string.

## Description
`static htmlStripTags(string|null $allowableTags)`

This function tries to return a string with all NULL bytes,
HTML and PHP tags stripped from a given str.

### Parameters
* _string|null_ __$allowableTags__  
You can use the optional second
parameter to specify tags which
should not be stripped.


### Return Value
_static_