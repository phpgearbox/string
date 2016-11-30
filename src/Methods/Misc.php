<?php namespace Gears\String\Methods;
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

trait Misc
{
    /**
     * Normalise all line endings in string to `$newLineEnding`.
     *
     * @link http://stackoverflow.com/questions/7836632
     *
     * @param  string $newLineEnding Defaults to a LINE FEED. You may provide
     *                               any string to replace all line endings.
     *
     * @return static
     */
    public function normaliseLineEndings($newLineEnding = "\n")
    {
        return $this->regexReplace('\R', $newLineEnding);
    }

    /**
     * Returns a lowercase and trimmed string separated by the given delimiter.
     *
     * Delimiters are inserted before uppercase characters (with the exception
     * of the first character of the string), and in place of spaces, dashes,
     * and underscores. Alpha delimiters are not converted to lowercase.
     *
     * @param  string $delimiter Sequence used to separate parts of the string
     *
     * @return static
     */
    public function delimit($delimiter)
    {
        return $this
            ->trim()
            ->regexReplace('\B([A-Z])', '-\1')
            ->toLowerCase()
            ->regexReplace('[-_\s]+', $delimiter)
        ;
    }

    /**
     * Inserts $substring into the string at the $index provided.
     *
     * @param  string $substring     String to be inserted.
     *
     * @param  int    $index         The index at which to insert the substring.
     *
     * @return static                String after the insertion.
     *
     * @throws \OutOfBoundsException When the index is greater than the length.
     */
    public function insert($substring, $index)
    {
        if ($index > $this->getLength()) throw new \OutOfBoundsException();

        $start = UTF8::substr
        (
            $this->scalarString,
            0,
            $index,
            $this->encoding
        );

        $end = UTF8::substr
        (
            $this->scalarString,
            $index,
            $this->getLength(),
            $this->encoding
        );

        return $this->newSelf($start.$substring.$end);
    }

    /**
     * Splits on newlines and carriage returns.
     *
     * @return static[]
     */
    public function lines()
    {
        return $this->split('[\r\n]{1,2}', null, false);
    }

    /**
     * Returns a repeated string given a multiplier.
     *
     * @param  int $multiplier The number of times to repeat the string
     *
     * @return static
     */
    public function repeat($multiplier)
    {
        return $this->newSelf
        (
            UTF8::str_repeat($this->scalarString, $multiplier)
        );
    }

    /**
     * Returns a reversed string. A multibyte version of strrev().
     *
     * @return static Object with a reversed $str
     */
    public function reverse()
    {
        return $this->newSelf(UTF8::strrev($this->scalarString));
    }

    /**
     * A multibyte string shuffle function.
     *
     * It returns a string with its characters in random order.
     *
     * @return static
     */
    public function shuffle()
    {
        return $this->newSelf(UTF8::str_shuffle($this->scalarString));
    }

    /**
     * Returns the substring beginning at $start, and up to, but not including
     * the index specified by $end. If $end is omitted, the function extracts
     * the remaining string. If $end is negative, it is computed from the end
     * of the string.
     *
     * @param  int      $start Initial index from which to begin extraction.
     *
     * @param  int|null $end   Optional index at which to end extraction.
     *
     * @return static          The extracted substring.
     */
    public function slice($start, $end = null)
    {
        if ($end === null)
        {
            $length = $this->getLength();
        }
        elseif ($end >= 0 && $end <= $start)
        {
            return $this->newSelf('');
        }
        elseif ($end < 0)
        {
            $length = $this->getLength() + $end - $start;
        }
        else
        {
            $length = $end - $start;
        }

        return $this->newSelf
        (
            UTF8::substr($this->scalarString, $start, $length, $this->encoding)
        );
    }

    /**
     * Surrounds string with the given substring.
     *
     * @param  string $substring The substring to add to both sides.
     *
     * @return static            String with $substring both prepended
     *                           and appended.
     */
    public function surround($substring)
    {
        return $this->newSelf
        (
            implode('', [$substring, $this->scalarString, $substring])
        );
    }

    /**
     * Returns a string with smart quotes, ellipsis characters, and dashes from
     * Windows-1252 (commonly used in Word documents) replaced by their ASCII
     * equivalents.
     *
     * @return static
     */
    public function tidy()
    {
        return $this->newSelf(UTF8::normalize_msword($this->scalarString));
    }

    /**
     * Returns the number of occurrences of $substring in the given string.
     *
     * By default, the comparison is case-sensitive, but can be made
     * insensitive by setting $caseSensitive to false.
     *
     * @param  string $substring     The substring to search for.
     *
     * @param  bool   $caseSensitive Whether or not to enforce case-sensitivity.
     *
     * @return int                   The number of $substring occurrences
     */
    public function countSubstr($substring, $caseSensitive = true)
    {
    	  if (!isset($this->scalarString[0]))
    	  {
    	  	return 0;
	      }

        if ($caseSensitive)
        {
            return UTF8::substr_count
            (
                $this->scalarString,
                $substring
            );
        }

        $str = UTF8::strtoupper($this->scalarString, $this->encoding);
        $substring = UTF8::strtoupper($substring, $this->encoding);
        return UTF8::substr_count($str, $substring);
    }
    
    /**
     * Formats the current string, using the provided array of arguments.
     *
     * For details on the syntax of the $format string:
     * http://php.net/manual/en/function.sprintf.php
     *
     * @param  array      $args   The arguments that will be inserted
     *                            into the $format string.
     *
     * @return static
     */
    public function format($args)
    {
        return $this->newSelf(vsprintf($this->scalarString, $args));
    }
}
