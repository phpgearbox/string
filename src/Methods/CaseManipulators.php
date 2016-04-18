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

trait CaseManipulators
{
    /**
     * Converts the first character of the string to lower case.
     *
     * @return static String with the first character of $str being lower case
     */
    public function lowerCaseFirst()
    {
        $first = UTF8::substr($this->scalarString, 0, 1, $this->encoding);

        $rest = UTF8::substr
        (
            $this->scalarString,
            1,
            $this->getLength() - 1,
            $this->encoding
        );

        return $this->newSelf(UTF8::strtolower($first, $this->encoding).$rest);
    }

    /**
     * Converts the first character of the supplied string to upper case.
     *
     * @return static String with the first character of $str being upper case
     */
    public function upperCaseFirst()
    {
        $first = UTF8::substr($this->scalarString, 0, 1, $this->encoding);

        $rest = UTF8::substr
        (
            $this->scalarString,
            1,
            $this->getLength() - 1,
            $this->encoding
        );

        return $this->newSelf(UTF8::strtoupper($first, $this->encoding).$rest);
    }

    /**
     * Returns a case swapped version of the string.
     *
     * @return Stringy Object whose $str has each character's case swapped
     */
    public function swapCase()
    {
        return $this->newSelf(preg_replace_callback
        (
            '/[\S]/u',
            function ($match)
            {
                $marchToUpper = UTF8::strtoupper($match[0], $this->encoding);

                if ($match[0] == $marchToUpper)
                {
                    return UTF8::strtolower($match[0], $this->encoding);
                }
                else
                {
                    return $marchToUpper;
                }
            },
            $this->scalarString
        ));
    }
}
