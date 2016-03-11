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
     * Returns a lowercase and trimmed string separated by the given delimiter.
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
        $str = $this->trim();

        $str = preg_replace('/\B([A-Z])/u', '-\1', (string)$str);

        $str = UTF8::strtolower($str, $this->encoding);

        $str = preg_replace('/[-_\s]+/u', $delimiter, $str);

        return $this->newSelf($str);
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
     * Returns the substring between $start and $end, if found, or an empty
     * string. An optional offset may be supplied from which to begin the
     * search for the start string.
     *
     * @param  string $start   Delimiter marking the start of the substring.
     * @param  string $end     Delimiter marking the end of the substring.
     * @param  int    $offset  Index from which to begin the search.
     * @param  bool   $include If true, we include the start & end in the result.
     * @return static          Str object between $start & $end.
     */
    public function between($start, $end, $offset = 0, $include = false)
    {
        $startIndex = $this->indexOf($start, $offset);
        if ($startIndex === false) return static::s('', $this->encoding);

        $substrIndex = $startIndex + UTF8::strlen($start, $this->encoding);

        $endIndex = $this->indexOf($end, $substrIndex);
        if ($endIndex === false) return static::s('', $this->encoding);

        $result = UTF8::substr
        (
            $this->scalarString,
            $substrIndex,
            $endIndex - $substrIndex,
            $this->encoding
        );

        if ($include === true) $result = $start.$result.$end;

        return $this->newSelf($result);
    }

    /**
     * Trims and replaces consecutive whitespace characters with a single space.
     *
     * This includes tabs and newline characters, as well as multibyte
     * whitespace such as the thin space and ideographic space.
     *
     * @return static Trimmed and condensed whitespace.
     */
    public function collapseWhitespace()
    {
        return $this->regexReplace('[[:space:]]+', ' ')->trim();
    }

    /**
     * Splits on newlines and carriage returns, returning an array of Str
     * objects corresponding to the lines in the string.
     *
     * @return Str[] An array of Str objects
     */
    public function lines()
    {
        $array = preg_split('/[\r\n]{1,2}/u', $this->scalarString);

        /** @noinspection CallableInLoopTerminationConditionInspection */
        /** @noinspection ForeachInvariantsInspection */
        for ($i = 0; $i < count($array); $i++)
        {
            $array[$i] = $this->newSelf($array[$i]);
        }

        return $array;
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
     * @return Stringy Object with a reversed $str
     */
    public function reverse()
    {
        return $this->newSelf(UTF8::strrev($this->scalarString));
    }

    /**
     * Truncates the string to a given length, while ensuring that it does not
     * split words. If $substring is provided, and truncating occurs, the
     * string is further truncated so that the substring may be appended without
     * exceeding the desired length.
     *
     * @param  int    $length    Desired length of the truncated string
     * @param  string $substring The substring to append if it can fit
     *
     * @return static
     */
    public function safeTruncate($length, $substring = '')
    {
        if ($length >= $this->getLength()) return $this;

        // Need to further trim the string so we can append the substring
        $substringLength = UTF8::strlen($substring, $this->encoding);
        $length -= $substringLength;

        $truncated = UTF8::substr($this->scalarString, 0, $length, $this->encoding);

        // If the last word was truncated
        if (UTF8::strpos($this->scalarString, ' ', $length - 1, $this->encoding) != $length)
        {
            // Find pos of the last occurrence of a space, get up to that
            $lastPos = UTF8::strrpos($truncated, ' ', 0, $this->encoding);
            $truncated = UTF8::substr($truncated, 0, $lastPos, $this->encoding);
        }

        return $this->newSelf($truncated . $substring);
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
    * @param  int $start Initial index from which to begin extraction
    * @param  int $end   Optional index at which to end extraction
    *
    * @return Stringy Object with its $str being the extracted substring
    */
    public function slice($start, $end = null)
    {
    if ($end === null) {
      $length = $this->length();
    } elseif ($end >= 0 && $end <= $start) {
      return static::create('', $this->encoding);
    } elseif ($end < 0) {
      $length = $this->length() + $end - $start;
    } else {
      $length = $end - $start;
    }

    $str = UTF8::substr($this->str, $start, $length, $this->encoding);

    return static::create($str, $this->encoding);
    }

    /**
    * Splits the string with the provided regular expression, returning an
    * array of Stringy objects. An optional integer $limit will truncate the
    * results.
    *
    * @param  string $pattern The regex with which to split the string
    * @param  int    $limit   Optional maximum number of results to return
    *
    * @return Stringy[] An array of Stringy objects
    */
    public function split($pattern, $limit = null)
    {
    if ($limit === 0) {
      return array();
    }

    // UTF8::split errors when supplied an empty pattern in < PHP 5.4.13
    // and current versions of HHVM (3.8 and below)
    if ($pattern === '') {
      return array(static::create($this->str, $this->encoding));
    }

    // UTF8::split returns the remaining unsplit string in the last index when
    // supplying a limit
    if ($limit > 0) {
      $limit += 1;
    } else {
      $limit = -1;
    }

    $array = preg_split('/' . preg_quote($pattern, '/') . '/u', $this->str, $limit);

    if ($limit > 0 && count($array) === $limit) {
      array_pop($array);
    }

    /** @noinspection CallableInLoopTerminationConditionInspection */
    /** @noinspection ForeachInvariantsInspection */
    for ($i = 0; $i < count($array); $i++) {
      $array[$i] = static::create($array[$i], $this->encoding);
    }

    return $array;
    }

    /**
    * Surrounds $str with the given substring.
    *
    * @param  string $substring The substring to add to both sides
    *
    * @return Stringy Object whose $str had the substring both prepended and
    *                 appended
    */
    public function surround($substring)
    {
    $str = implode('', array($substring, $this->str, $substring));

    return static::create($str, $this->encoding);
    }



    /**
    * Returns a string with smart quotes, ellipsis characters, and dashes from
    * Windows-1252 (commonly used in Word documents) replaced by their ASCII
    * equivalents.
    *
    * @return Stringy Object whose $str has those characters removed
    */
    public function tidy()
    {
    $str = UTF8::normalize_msword($this->str);

    return static::create($str, $this->encoding);
    }















    /**
    * Truncates the string to a given length. If $substring is provided, and
    * truncating occurs, the string is further truncated so that the substring
    * may be appended without exceeding the desired length.
    *
    * @param  int    $length    Desired length of the truncated string
    * @param  string $substring The substring to append if it can fit
    *
    * @return Stringy Object with the resulting $str after truncating
    */
    public function truncate($length, $substring = '')
    {
    $stringy = static::create($this->str, $this->encoding);
    if ($length >= $stringy->length()) {
      return $stringy;
    }

    // Need to further trim the string so we can append the substring
    $substringLength = UTF8::strlen($substring, $stringy->encoding);
    $length -= $substringLength;

    $truncated = UTF8::substr($stringy->str, 0, $length, $stringy->encoding);
    $stringy->str = $truncated . $substring;

    return $stringy;
    }



    /**
    * shorten the string after $length, but also after the next word
    *
    * @param int    $length
    * @param string $strAddOn
    *
    * @return Stringy
    */
    public function shortenAfterWord($length, $strAddOn = '...')
    {
    $string = $this->str;

    if (UTF8::strlen($string) > $length) {
      if (UTF8::substr($string, $length - 1, 1) != ' ') {
        $string = UTF8::substr($string, '0', $length);
        $array = explode(' ', $string);
        array_pop($array);
        $new_string = implode(' ', $array);

        if ($new_string == '') {
          $string = UTF8::substr($string, '0', $length - 1) . $strAddOn;
        } else {
          $string = $new_string . $strAddOn;
        }

      } else {
        $string = UTF8::substr($string, '0', $length - 1) . $strAddOn;
      }
    }

    return static::create($string);
    }
}
