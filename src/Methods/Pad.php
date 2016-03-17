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
     * Pads the string to a given length with $padStr.
     *
     * If length is less than or equal to the length of the string, no padding
     * takes places. The default string used for padding is a space, and the
     * default type (one of 'left', 'right', 'both') is 'right'.
     *
     * @param  int    $length  Desired string length after padding.
     *
     * @param  string $padStr  String used to pad, defaults to space.
     *
     * @param  string $padType One of 'left', 'right', 'both'.
     *
     * @return static          String after being padded.
     *
     * @throws \InvalidArgumentException If $padType isn't one of 'right',
     *                                   'left' or 'both'.
     */
    public function pad($length, $padStr = ' ', $padType = 'right')
    {
        if (!in_array($padType, ['left', 'right', 'both'], true))
        {
            throw new \InvalidArgumentException
            (
                'Pad expects $padType '."to be one of 'left', 'right' or 'both'"
            );
        }

        switch ($padType)
        {
            case 'left':
                return $this->padLeft($length, $padStr);

            case 'right':
                return $this->padRight($length, $padStr);

            default:
                return $this->padBoth($length, $padStr);
        }
    }

    /**
     * Adds padding to the left of the string.
     *
     * @param  int    $length Desired string length after padding.
     *
     * @param  string $padStr String used to pad, defaults to space.
     *
     * @return static         String with left padding.
     */
    public function padLeft($length, $padStr = ' ')
    {
        return $this->applyPadding($length - $this->getLength(), 0, $padStr);
    }

    /**
     * Adds padding to the right of the string.
     *
     * @param  int    $length Desired string length after padding.
     *
     * @param  string $padStr String used to pad, defaults to space.
     *
     * @return static         String with right padding.
     */
    public function padRight($length, $padStr = ' ')
    {
        return $this->applyPadding(0, $length - $this->getLength(), $padStr);
    }

    /**
     * Adds padding to both sides of the string, equally.
     *
     * @param  int    $length Desired string length after padding.
     *
     * @param  string $padStr String used to pad, defaults to space.
     *
     * @return static         String with padding applied to both sides.
     */
    public function padBoth($length, $padStr = ' ')
    {
        $padding = $length - $this->getLength();
        return $this->applyPadding(floor($padding / 2), ceil($padding / 2), $padStr);
    }

    /**
     * Pad internal helper, adds padding to the left and right of the string.
     *
     * @param  int    $left   Length of left padding.
     *
     * @param  int    $right  Length of right padding.
     *
     * @param  string $padStr String used to pad, default is a space.
     *
     * @return static         String with padding applied.
     */
    protected function applyPadding($left = 0, $right = 0, $padStr = ' ')
    {
        $length = UTF8::strlen($padStr, $this->encoding);
        $strLength = $this->getLength();
        $paddedLength = $strLength + $left + $right;

        if (!$length || $paddedLength <= $strLength) return $this;

        $leftPadding = UTF8::substr
        (
            UTF8::str_repeat($padStr, ceil($left / $length)),
            0,
            $left,
            $this->encoding
        );

        $rightPadding = UTF8::substr
        (
            UTF8::str_repeat($padStr, ceil($right / $length)),
            0,
            $right,
            $this->encoding
        );

        return $this->newSelf($leftPadding.$this->scalarString.$rightPadding);
    }
}
