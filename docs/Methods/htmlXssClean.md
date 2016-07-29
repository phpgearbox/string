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