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

trait Replace
{
    /**
     * Replaces all occurrences of $search in $str by $replacement.
     *
     * @param  string|array $search        The needle to search for.
     *
     * @param  string|array $replacement   The string to replace with.
     *
     * @param  bool         $caseSensitive To enforce case-sensitivity or not.
     *
     * @return static                      String after the replacements.
     */
    public function replace($search, $replacement, $caseSensitive = true)
    {
        if ($caseSensitive)
        {
            $return = UTF8::str_replace
            (
                $search,
                $replacement,
                $this->scalarString
            );
        }
        else
        {
            $return = UTF8::str_ireplace
            (
                $search,
                $replacement,
                $this->scalarString
            );
        }

        return $this->newSelf($return);
    }

    /**
     * Replaces only if an exact match is found.
     *
     * Essentially all this does is swaps one string for another.
     * I needed this in a db migration script to map a bunch of
     * old column names to new column names.
     *
     * @param  string|string[] $search      Either a single search term or
     *                                      an array of search terms.
     *
     * @param  string|string[] $replacement Must be the same length as $search.
     *                                      So if you provide a single search
     *                                      term, you must provide a single
     *                                      replacement, if you provide 10
     *                                      search terms you must provide 10
     *                                      replacements.
     *
     * @return static
     */
    public function replaceExact($search, $replacement)
    {
        if (!is_array($search)) $search = [$search];
        if (!is_array($replacement)) $replacement = [$replacement];

        if (count($search) !== count($replacement))
        {
            throw new \InvalidArgumentException
            (
                '$search and $replacement must the same length!'
            );
        }

        foreach ($search as $key => $term)
        {
            if ($this->scalarString == (string)$term)
            {
                return $this->newSelf($replacement[$key]);
            }
        }

        return $this;
    }

    /**
     * Replaces all occurrences of $search from the
     * beginning of string with $replacement.
     *
     * @param string $search
     * @param string $replacement
     * @return static
     */
    public function replaceBeginning($search, $replacement)
    {
        return $this->regexReplace
        (
            '^'.preg_quote($search, '/'),
            UTF8::str_replace('\\', '\\\\', $replacement)
        );
    }

    /**
     * Replaces all occurrences of $search from the
     * ending of string with $replacement.
     *
     * @param string $search
     * @param string $replacement
     * @return static
     */
    public function replaceEnding($search, $replacement)
    {
        return $this->regexReplace
        (
            preg_quote($search, '/').'$',
            UTF8::str_replace('\\', '\\\\', $replacement)
        );
    }
}
