# toBoolean
Returns a boolean representation of the given logical string value.

## Description
`bool toBoolean()`

For example, 'true', '1', 'on' and 'yes' will return true. 'false', '0',
'off', and 'no' will return false. In all instances, case is ignored.
For other numeric strings, their sign will determine the return value.
In addition, blank strings consisting of only whitespace will return
false. For all other strings, the return value is a result of a
boolean cast.


### Return Value
_bool_