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

trait Truncate
{
    /**
     * Truncates the string to a given length.
     *
     * If $substring is provided, and truncating occurs, the string is further
     * truncated so that the substring may be appended without exceeding the
     * desired length.
     *
     * @param  int    $length    Desired length of the truncated string.
     *
     * @param  string $substring The substring to append if it can fit.
     *
     * @return static            String after truncating.
     */
    public function truncate($length, $substring = '')
    {
        if ($length >= $this->getLength()) return $this;

        // Need to further trim the string so we can append the substring
        $substringLength = UTF8::strlen($substring, $this->encoding);
        $length -= $substringLength;

        $truncated = UTF8::substr
        (
            $this->scalarString,
            0,
            $length,
            $this->encoding
        );

        return $this->newSelf($truncated . $substring);
    }

    /**
     * Truncates the string to a given length,
     * while ensuring that it does not split words.
     *
     * If $substring is provided, and truncating occurs, the string is further
     * truncated so that the substring may be appended without exceeding the
     * desired length.
     *
     * @param  int    $length    Desired length of the truncated string.
     *
     * @param  string $substring The substring to append if it can fit.
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
            if (!is_integer($lastPos)) $lastPos = 0;
            $truncated = UTF8::substr($truncated, 0, $lastPos, $this->encoding);
        }

        return $this->newSelf($truncated . $substring);
    }
}
