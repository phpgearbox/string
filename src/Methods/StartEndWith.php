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

trait StartEndWith
{
    /**
     * Returns true if the string begins with $substring, false otherwise.
     *
     * By default, the comparison is case-sensitive,
     * but can be made insensitive by setting $caseSensitive
     * to false.
     *
     * @param  string $substring     The substring to look for
     * @param  bool   $caseSensitive Whether or not to enforce case-sensitivity
     *
     * @return bool   Whether or not $str starts with $substring
     */
    public function startsWith($substring, $caseSensitive = true)
    {
        $startOfStr = UTF8::substr
        (
            $this->scalarString,
            0,
            UTF8::strlen($substring, $this->encoding),
            $this->encoding
        );

        if (!$caseSensitive)
        {
            $substring = UTF8::strtolower($substring, $this->encoding);
            $startOfStr = UTF8::strtolower($startOfStr, $this->encoding);
        }

        return (string)$substring === $startOfStr;
    }

    /**
     * Returns true if the string ends with $substring, false otherwise. By
     * default, the comparison is case-sensitive, but can be made insensitive
     * by setting $caseSensitive to false.
     *
     * @param  string $substring     The substring to look for
     * @param  bool   $caseSensitive Whether or not to enforce case-sensitivity
     *
     * @return bool   Whether or not $str ends with $substring
     */
    public function endsWith($substring, $caseSensitive = true)
    {
        $substringLength = UTF8::strlen($substring, $this->encoding);

        $endOfStr = UTF8::substr
        (
            $this->scalarString,
            $this->getLength() - $substringLength,
            $substringLength,
            $this->encoding
        );

        if (!$caseSensitive)
        {
            $substring = UTF8::strtolower($substring, $this->encoding);
            $endOfStr = UTF8::strtolower($endOfStr, $this->encoding);
        }

        return (string)$substring === $endOfStr;
    }
}
