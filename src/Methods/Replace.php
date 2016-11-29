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
