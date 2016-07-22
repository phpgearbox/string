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
use Gears\String\Exceptions\PcreException;

trait Between
{
    /**
     * Returns the substring between `$start` and `$end`.
     *
     * An optional offset may be supplied from which
     * to begin the search for the start string.
     *
     * @param  string $start   Delimiter marking the start of the substring.
     *
     * @param  string $end     Delimiter marking the end of the substring.
     *
     * @param  int    $offset  Index from which to begin the search.
     *
     * @param  bool   $include If true, we include the start & end in the result.
     *
     * @return static          Str object between $start & $end.
     */
    public function between($start, $end, $offset = 0, $include = false)
    {
        $startIndex = $this->indexOf($start, $offset);
        if ($startIndex === false) return $this->newSelf('');

        $substrIndex = $startIndex + UTF8::strlen($start, $this->encoding);

        $endIndex = $this->indexOf($end, $substrIndex);
        if ($endIndex === false) return $this->newSelf('');

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
     * Returns an array of substrings between $start and $end.
     *
     * @param  string   $start Delimiter marking the start of the substring.
     *
     * @param  string   $end   Delimiter marking the end of the substring.
     *
     * @return static[]
     *
     * @throws PcreException   When PCRE Error occurs.
     */
    public function betweenAll($start, $end)
    {
        $matches = [];

        // Create the regular expression
        $find = '/'.preg_quote($start, '/').'(.*?)'.preg_quote($end, '/').'/su';

        // Run the regular expression
        if (preg_match_all($find, $this->scalarString, $matches) !== false)
        {
            return $this->newSelfs($matches);
        }

        // Throw with the last known pcre error code.
        throw new PcreException();
    }
}
