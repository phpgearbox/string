# String Builder
In addition to the `Str` class, I have also created a string builder class that
is inspired by .NET's [StringBuilder](https://goo.gl/utVtKG) class.

Classic example, lets say you wanted to build some HTML.

```php
use Gears\String\Builder;

$html = new Builder();

$html->append('<ul>');

foreach ($rows as $row)
{
    $html->append('<li>');
    $html->append($row);
    $html->append('</li>');
}

$html->append('</ul>');

echo $html;
```

> Naturally the Builder is compatible with the `Str` objects also.

## Why:
There is much debate about performance of such String Builders in PHP.
Most suggest PHP simply doesn't need such a class because strings are
mutable and for the most part I completely agree.

Further reading: http://stackoverflow.com/questions/124067

However this is not a performance thing for me, personally I just like the
API that the C# StringBuilder class provides. Coming back to PHP development
after a lengthy .NET project, it was one of many things I missed.

Also the main `Gears\String\Str` class is immutable anyway.
