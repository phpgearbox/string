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
     * @param string $search        The needle to search for
     * @param string $replacement   The string to replace with
     * @param bool   $caseSensitive Whether or not to enforce case-sensitivity
     *
     * @return Stringy Object with the resulting $str after the replacements
     */
    public function replace($search, $replacement, $caseSensitive = true)
    {
      if ($caseSensitive) {
        $return = UTF8::str_replace($search, $replacement, $this->str);
      } else {
        $return = UTF8::str_ireplace($search, $replacement, $this->str);
      }

      return static::create($return);
    }

    /**
     * Replaces all occurrences of $search in $str by $replacement.
     *
     * @param array        $search        The elements to search for
     * @param string|array $replacement   The string to replace with
     * @param bool         $caseSensitive Whether or not to enforce case-sensitivity
     *
     * @return Stringy Object with the resulting $str after the replacements
     */
    public function replaceAll(array $search, $replacement, $caseSensitive = true)
    {
      if ($caseSensitive) {
        $return = UTF8::str_replace($search, $replacement, $this->str);
      } else {
        $return = UTF8::str_ireplace($search, $replacement, $this->str);
      }

      return static::create($return);
    }

    /**
     * Replaces all occurrences of $search from the beginning of string with $replacement
     *
     * @param string $search
     * @param string $replacement
     *
     * @return Stringy Object with the resulting $str after the replacements
     */
    public function replaceBeginning($search, $replacement)
    {
      $str = $this->regexReplace('^' . preg_quote($search, '/'), UTF8::str_replace('\\', '\\\\', $replacement));

      return static::create($str, $this->encoding);
    }

    /**
     * Replaces all occurrences of $search from the ending of string with $replacement
     *
     * @param string $search
     * @param string $replacement
     *
     * @return Stringy Object with the resulting $str after the replacements
     */
    public function replaceEnding($search, $replacement)
    {
      $str = $this->regexReplace(preg_quote($search, '/') . '$', UTF8::str_replace('\\', '\\\\', $replacement));

      return static::create($str, $this->encoding);
    }
}
