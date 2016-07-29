# slice
Returns the substring beginning at $start, and up to, but not including
the index specified by $end. If $end is omitted, the function extracts
the remaining string. If $end is negative, it is computed from the end
of the string.

## Description
`static slice(int $start, int|null $end)`

### Parameters
* _int_ __$start__  
Initial index from which to begin extraction.

* _int|null_ __$end__  
Optional index at which to end extraction.


### Return Value
_static_  
The extracted substring.