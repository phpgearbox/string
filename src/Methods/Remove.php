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

trait Remove
{
    /**
     * Returns a new string with the prefix $substring removed, if present.
     *
     * @param  string $substring The prefix to remove
     *
     * @return Stringy Object having a $str without the prefix $substring
     */
    public function removeLeft($substring)
    {
      $stringy = static::create($this->str, $this->encoding);

      if ($stringy->startsWith($substring)) {
        $substringLength = UTF8::strlen($substring, $stringy->encoding);

        return $stringy->substr($substringLength);
      }

      return $stringy;
    }

    /**
     * Returns a new string with the suffix $substring removed, if present.
     *
     * @param  string $substring The suffix to remove
     *
     * @return Stringy Object having a $str without the suffix $substring
     */
    public function removeRight($substring)
    {
      $stringy = static::create($this->str, $this->encoding);

      if ($stringy->endsWith($substring)) {
        $substringLength = UTF8::strlen($substring, $stringy->encoding);

        return $stringy->substr(0, $stringy->length() - $substringLength);
      }

      return $stringy;
    }
}
