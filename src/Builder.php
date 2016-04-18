<?php namespace Gears\String;
////////////////////////////////////////////////////////////////////////////////
// __________ __             ________                   __________
// \______   \  |__ ______  /  _____/  ____ _____ ______\______   \ _______  ___
//  |     ___/  |  \\____ \/   \  ____/ __ \\__  \\_  __ \    |  _//  _ \  \/  /
//  |    |   |   Y  \  |_> >    \_\  \  ___/ / __ \|  | \/    |   (  <_> >    <
//  |____|   |___|  /   __/ \______  /\___  >____  /__|  |______  /\____/__/\_ \
//                \/|__|           \/     \/     \/             \/            \/
// -----------------------------------------------------------------------------
//          Designed and Developed by Brad Jones <brad @="bjc.id.au" />
// -----------------------------------------------------------------------------
////////////////////////////////////////////////////////////////////////////////

use voku\helper\UTF8;
use Icecave\Parity\Parity;
use Icecave\Parity\SubClassComparableInterface as Comparable;
use Gears\String\Exceptions\MisMatchedEncodingException;

/**
 * String Builder Class.
 *
 * This class is modeled off the .NET C# version.
 * @see https://goo.gl/utVtKG
 *
 * There is much debate about performance of such String Builders in PHP.
 * Most suggest PHP simply doesn't need such a class because strings are
 * mutable and for the most part I completely agree.
 * @see http://stackoverflow.com/questions/124067
 *
 * However this is not a performance thing for me, personally I just like the
 * API that the C# StringBuilder class provides. Coming back to PHP development
 * after a lengthy .NET project, it was one of many things I missed.
 *
 * Also the main Gears\String\Str class is immutable anyway.
 *
 * @package Gears\String
 */
class Builder implements Comparable
{
    /**
     * The string that this builder is building.
     *
     * @var \Gears\String\Str
     */
    protected $str;

    /**
     * After building your string, you may retreive the underlying Str object.
     *
     * @return \Gears\String\Str
     */
    public function getStr()
    {
        return $this->str;
    }

    /**
     * String Builder Constructor.
     *
     * @param string|Str  $string   Optionally provide an intial string.
     *
     * @param string|null $encoding The character encoding to use for this
     *                              string builder. If not specified, defaults
     *                              to the value returned from
     *                              mb_internal_encoding().
     */
    public function __construct($string = '', $encoding = null)
    {
        // If the provided $string is in fact a Str object and the builder has
        // not been given a specfic encoding to use lets carry the encoding over
        // to the new Str object.
        if ($encoding === null && $string instanceof Str)
        {
            $encoding = $string->getEncoding();
        }

        // Str will throw exceptions if the provided $string is not string like.
        $this->str = new Str($string, $encoding);
    }

    /**
     * Magic method to automatically turn the builder back into a scalar string.
     *
     * @see http://php.net/manual/en/language.oop5.magic.php#object.tostring
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->str;
    }

    /**
     * Appends a copy of the specified string to this instance.
     *
     * @param  string|Str $string The string to append.
     *
     * @return static
     */
    public function append($string)
    {
        // Grab the current encoding
        $encoding = $this->str->getEncoding();

        if ($string instanceof Str)
        {
            // Ensure the encoding's match of both strings
            if ($string->getEncoding() !== $encoding)
            {
                throw new MisMatchedEncodingException();
            }

            $toBeAppended = $string;
        }
        else
        {
            // Ensure the incoming string is string like... Str will throw
            // exceptions if not. We also make the assumption that any "scalar"
            // strings are in the same encoding as the internal Str object.
            $toBeAppended = new Str($string, $encoding);
        }

        // Create the new Str object
        $this->str = new Str($this->str.$toBeAppended, $encoding);

        // Return ourselves to enable method chaining.
        return $this;
    }

    /**
     * Appends the string returned by vsprintf given the $format and $args.
     *
     * For details on the syntax of the $format string:
     * @see http://php.net/manual/en/function.sprintf.php
     *
     * @param  string|Str $format The format string is composed of zero or more
     *                            directives: ordinary characters (excluding %)
     *                            that are copied directly to the result, and
     *                            conversion specifications.
     *
     * @param  array      $args   The arguments that will be inserted
     *                            into the $format string.
     *
     * @return static
     */
    public function appendFormat($format, $args)
    {
        return $this->append(vsprintf((string)$format, $args));
    }

    /**
     * Appends the default line terminator to the end of the current Builder.
     *
     * @param  string|Str $string Optional, a string to append before
     *                            the line terminator.
     *
     * @param  string|Str $type   The line terminator to append,
     *                            defaults to LINE FEED.
     *
     * @return static
     */
    public function appendLine($string = '', $type = "\n")
    {
        return $this->append($string)->append($type);
    }

    /**
     * Removes all characters from the current Builder instance.
     *
     * @return static
     */
    public function clear()
    {
        $this->str = new Str('');

        return $this;
    }

    /**
     * Implements Icecave\Parity\SubClassComparableInterface compare method.
     *
     * @see https://git.io/vVxSz
     *
     * @param  object  $value The object to compare.
     *
     * @return integer        The result of the comparison.
     */
    public function compare($value)
    {
        return strcmp((string)$value, (string)$this);
    }

    /**
     * Returns a value indicating whether this instance is equal to another.
     *
     * @param  object  $value  The object to compare.
     *
     * @return boolean
     */
    public function equals($value)
    {
        return Parity::isEqualTo($this, $value);
    }

    /**
     * Inserts a string into this instance at the specified character position.
     *
     * @param  int        $index  The index at which to insert the substring.
     *
     * @param  string|Str $string The substring to insert.
     *
     * @return static
     */
    public function insert($index, $string)
    {
        // NOTE: This could be slightly confusing as the parameters
        // are back to front. I guess I could change the Str version...

        $this->str = $this->str->insert((string)$string, $index);

        return $this;
    }

    /**
     * Removes the specified range of characters from this instance.
     *
     * @param  int    $startIndex The zero-based position in this instance
     *                            where removal begins.
     *
     * @param  int    $length     The number of characters to remove.
     *
     * @return static
     */
    public function remove($startIndex, $length)
    {
        $start = UTF8::substr
        (
            (string)$this->str,
            0,
            $startIndex,
            $this->str->getEncoding()
        );

        $end = UTF8::substr
        (
            (string)$this->str,
            $startIndex + $length,
            $this->str->getLength(),
            $this->str->getEncoding()
        );

        $this->str = new Str($start.$end);

        return $this;
    }

    /**
     * Replaces all occurrences of $old in this instance with $new.
     *
     * @param  string|Str $old The string to replace.
     *
     * @param  string|Str $new The string that replaces $old.
     *
     * @return static
     */
    public function replace($old, $new)
    {
        $this->str = $this->str->replace((string)$old, (string)$new);

        return $this;
    }
}
