# toSlugCase
Converts the string into an URL slug.

## Description
`static toSlugCase(string $replacement = '-', string $language = 'en', bool $strToLower = 1)`

This includes replacing non-ASCII characters with their closest ASCII
equivalents, removing remaining non-ASCII and non-alphanumeric
characters, and replacing whitespace with $replacement.

The replacement defaults to a single dash
and the string is also converted to lowercase.

### Parameters
* _string_ __$replacement__  
The string used to replace whitespace

* _string_ __$language__  
The language for the url

* _bool_ __$strToLower__  
string to lower


### Return Value
_static_