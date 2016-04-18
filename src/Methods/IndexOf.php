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

trait IndexOf
{
    /**
     * Returns the index of the first occurrence of $needle in the string,
     * and false if not found. Accepts an optional offset from which to begin
     * the search.
     *
     * @param  string   $needle Substring to look for.
     *
     * @param  int      $offset Offset from which to search.
     *
     * @return int|bool         The occurrence's index if found,
     *                          otherwise false.
     */
    public function indexOf($needle, $offset = 0)
    {
        return UTF8::strpos
        (
            $this->scalarString,
            (string)$needle,
            (int)$offset,
            $this->encoding
        );
    }

    /**
     * Returns the index of the last occurrence of $needle in the string,
     * and false if not found. Accepts an optional offset from which to begin
     * the search. Offsets may be negative to count from the last character
     * in the string.
     *
     * @param  string   $needle Substring to look for.
     *
     * @param  int      $offset Offset from which to search.
     *
     * @return int|bool         The last occurrence's index if found,
     *                          otherwise false.
     */
    public function indexOfLast($needle, $offset = 0)
    {
        return UTF8::strrpos
        (
            $this->scalarString,
            (string)$needle,
            (int)$offset,
            $this->encoding
        );
    }
}
