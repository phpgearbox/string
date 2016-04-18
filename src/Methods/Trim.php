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

trait Trim
{
    /**
     * Removes whitespace from the start and end of the string.
     *
     * Supports the removal of unicode whitespace.
     * Accepts an optional string of characters to
     * strip instead of the defaults.
     *
     * @param  string|null $chars Optional string of characters to strip.
     *
     * @return static
     */
    public function trim($chars = null)
    {
        $chars = $this->getTrimChars($chars);

        return $this->regexReplace("^[$chars]+|[$chars]+\$", '');
    }

    /**
     * Returns a string with whitespace removed from the start of the string.
     * Supports the removal of unicode whitespace. Accepts an optional
     * string of characters to strip instead of the defaults.
     *
     * @param  string|null $chars Optional string of characters to strip.
     *
     * @return static
     */
    public function trimLeft($chars = null)
    {
        return $this->regexReplace("^[".$this->getTrimChars($chars)."]+", '');
    }

    /**
     * Returns a string with whitespace removed from the end of the string.
     * Supports the removal of unicode whitespace. Accepts an optional
     * string of characters to strip instead of the defaults.
     *
     * @param  string|null $chars Optional string of characters to strip.
     *
     * @return static
     */
    public function trimRight($chars = null)
    {
        return $this->regexReplace("[".$this->getTrimChars($chars)."]+\$", '');
    }

    /**
     * Internal helper method for trim methods.
     *
     * @param  string $chars
     * @return string
     */
    protected function getTrimChars($chars)
    {
        if (!$chars)
        {
            return '[:space:]';
        }
        else
        {
            return preg_quote($chars, $this->regexDelimiter);
        }
    }
}
