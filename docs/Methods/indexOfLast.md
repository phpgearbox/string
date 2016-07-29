# indexOfLast
Returns the index of the last occurrence of $needle in the string,
and false if not found. Accepts an optional offset from which to begin
the search. Offsets may be negative to count from the last character
in the string.

## Description
`int|bool indexOfLast(string $needle, int $offset)`

### Parameters
* _string_ __$needle__  
Substring to look for.

* _int_ __$offset__  
Offset from which to search.


### Return Value
_int|bool_  
The last occurrence's index if found,
otherwise false.