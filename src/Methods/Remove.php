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
     * @param  string $substring The prefix to remove.
     *
     * @return static            String without the prefix $substring.
     */
    public function removeLeft($substring)
    {
        if ($this->startsWith($substring))
        {
            return $this->newSelf
            (
                UTF8::substr
                (
                    $this->scalarString,
                    UTF8::strlen($substring, $this->encoding),
                    null,
                    $this->encoding
                )
            );
        }

        return $this;
    }

    /**
     * Returns a new string with the suffix $substring removed, if present.
     *
     * @param  string $substring The suffix to remove.
     *
     * @return static            String without the suffix $substring.
     */
    public function removeRight($substring)
    {
        if ($this->endsWith($substring))
        {
            return $this->newSelf
            (
                UTF8::substr
                (
                    $this->scalarString,
                    0,
                    $this->getLength() - UTF8::strlen($substring, $this->encoding),
                    $this->encoding
                )
            );
        }

        return $this;
    }

    /**
     * Trims and replaces consecutive whitespace characters with a single space.
     *
     * This includes tabs and newline characters, as well as multibyte
     * whitespace such as the thin space and ideographic space.
     *
     * @return static Trimmed and condensed whitespace.
     */
    public function removeWhitespace()
    {
        return $this->regexReplace('[[:space:]]+', ' ')->trim();
    }
}
