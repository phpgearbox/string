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

trait Pad
{
    /**
    * Pads the string to a given length with $padStr. If length is less than
    * or equal to the length of the string, no padding takes places. The
    * default string used for padding is a space, and the default type (one of
    * 'left', 'right', 'both') is 'right'. Throws an InvalidArgumentException
    * if $padType isn't one of those 3 values.
    *
    * @param  int    $length  Desired string length after padding
    * @param  string $padStr  String used to pad, defaults to space
    * @param  string $padType One of 'left', 'right', 'both'
    *
    * @return Stringy Object with a padded $str
    * @throws \InvalidArgumentException If $padType isn't one of 'right', 'left' or 'both'
    */
    public function pad($length, $padStr = ' ', $padType = 'right')
    {
    if (!in_array($padType, array('left', 'right', 'both'), true)) {
      throw new \InvalidArgumentException(
          'Pad expects $padType ' . "to be one of 'left', 'right' or 'both'"
      );
    }

    switch ($padType) {
      case 'left':
        return $this->padLeft($length, $padStr);
      case 'right':
        return $this->padRight($length, $padStr);
      default:
        return $this->padBoth($length, $padStr);
    }
    }

    /**
    * Returns a new string of a given length such that the beginning of the
    * string is padded. Alias for pad() with a $padType of 'left'.
    *
    * @param  int    $length Desired string length after padding
    * @param  string $padStr String used to pad, defaults to space
    *
    * @return Stringy String with left padding
    */
    public function padLeft($length, $padStr = ' ')
    {
    return $this->applyPadding($length - $this->length(), 0, $padStr);
    }

    /**
    * Adds the specified amount of left and right padding to the given string.
    * The default character used is a space.
    *
    * @param  int    $left   Length of left padding
    * @param  int    $right  Length of right padding
    * @param  string $padStr String used to pad
    *
    * @return Stringy String with padding applied
    */
    private function applyPadding($left = 0, $right = 0, $padStr = ' ')
    {
    $stringy = static::create($this->str, $this->encoding);

    $length = UTF8::strlen($padStr, $stringy->encoding);

    $strLength = $stringy->length();
    $paddedLength = $strLength + $left + $right;

    if (!$length || $paddedLength <= $strLength) {
      return $stringy;
    }

    $leftPadding = UTF8::substr(
        UTF8::str_repeat(
            $padStr,
            ceil($left / $length)
        ),
        0,
        $left,
        $stringy->encoding
    );

    $rightPadding = UTF8::substr(
        UTF8::str_repeat(
            $padStr,
            ceil($right / $length)
        ),
        0,
        $right,
        $stringy->encoding
    );

    $stringy->str = $leftPadding . $stringy->str . $rightPadding;

    return $stringy;
    }

    /**
    * Returns a new string of a given length such that the end of the string
    * is padded. Alias for pad() with a $padType of 'right'.
    *
    * @param  int    $length Desired string length after padding
    * @param  string $padStr String used to pad, defaults to space
    *
    * @return Stringy String with right padding
    */
    public function padRight($length, $padStr = ' ')
    {
    return $this->applyPadding(0, $length - $this->length(), $padStr);
    }

    /**
    * Returns a new string of a given length such that both sides of the
    * string are padded. Alias for pad() with a $padType of 'both'.
    *
    * @param  int    $length Desired string length after padding
    * @param  string $padStr String used to pad, defaults to space
    *
    * @return Stringy String with padding applied
    */
    public function padBoth($length, $padStr = ' ')
    {
    $padding = $length - $this->length();

    return $this->applyPadding(floor($padding / 2), ceil($padding / 2), $padStr);
    }
}
