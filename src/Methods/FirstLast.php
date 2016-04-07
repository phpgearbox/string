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

trait FirstLast
{
    /**
     * Returns the first $n characters of the string.
     *
     * @param  int $n Number of characters to retrieve from the start.
     *
     * @return static String being the first $n chars.
     */
    public function first($n)
    {
        $first = '';

        if ($n > 0)
        {
            $first = UTF8::substr
            (
                $this->scalarString,
                0,
                $n,
                $this->encoding
            );
        }

        return $this->newSelf($first);
    }

    /**
     * Returns the last $n characters of the string.
     *
     * @param  int $n Number of characters to retrieve from the end.
     *
     * @return static String being the last $n chars.
     */
    public function last($n)
    {
        $last = '';

        if ($n > 0)
        {
            $last = UTF8::substr
            (
                $this->scalarString,
                -$n,
                null,
                $this->encoding
            );
        }

        return $this->newSelf($last);
    }
}
