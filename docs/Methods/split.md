# split
Splits the string with the provided regular expression.

## Description
`static[] split(string $pattern, int|null $limit, bool $quote = 1)`

### Parameters
* _string_ __$pattern__  
The regex with which to split the string.

* _int|null_ __$limit__  
Optional maximum number of results to return.

* _bool_ __$quote__  
By default this method will run the provided
$pattern through preg_quote(), this allows the
method to be used to split on simple substrings.


### Return Value
_static[]_  
An array of Str objects.