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

trait Html
{
    /**
     * Convert all HTML entities to their applicable characters.
     *
     * @link http://php.net/manual/en/function.html-entity-decode.php
     *
     * @param  int|null $flags Optional flags
     *
     * @return static          String after being html decoded.
     */
    public function htmlDecode($flags = ENT_COMPAT)
    {
        return $this->newSelf
        (
            UTF8::html_entity_decode
            (
                $this->scalarString,
                $flags,
                $this->encoding
            )
        );
    }

    /**
     * Convert all applicable characters to HTML entities.
     *
     * @link http://php.net/manual/en/function.htmlentities.php
     *
     * @param  int|null $flags        Optional flags.
     *
     * @param  bool     $doubleEncode When double_encode is turned off PHP
     *                                will not encode existing html entities.
     *                                The default is to convert everything.
     *
     * @return static                 String after being html encoded.
     */
    public function htmlEncode($flags = null, $doubleEncode = true)
    {
        if ($flags === null) $flags = ENT_QUOTES | ENT_SUBSTITUTE;

        return $this->newSelf
        (
            UTF8::htmlentities
            (
                $this->scalarString,
                $flags,
                $this->encoding,
                $doubleEncode
            )
        );
    }

    /**
     * Sanitizes data so that Cross Site Scripting Hacks can be prevented.
     *
     * This method does a fair amount of work and it is extremely thorough,
     * designed to prevent even the most obscure XSS attempts. Nothing is ever
     * 100 percent foolproof, of course, but I haven't been able to get anything
     * passed the filter.
     *
     * > NOTE: Should only be used to deal with data upon submission.
     * > It's not something that should be used for general runtime processing.
     *
     * __In other words it is still critically important
     * to escape anything that you output!!!__
     *
     * This uses a packaged version of the Anti XSS Library from CodeIgniter.
     * @link https://github.com/voku/anti-xss
     *
     * @return static
     */
    public function htmlXssClean()
    {
        static $antiXss = null;

        if ($antiXss === null)
        {
            if (class_exists('\\voku\\helper\\AntiXSS'))
            {
                $antiXss = new \voku\helper\AntiXSS();
            }
            else
            {
                throw new \RuntimeException
                (
                    "This method requires \voku\helper\AntiXSS. ".
                    "Install with: composer require voku/anti-xss"
                );
            }
        }

        return $this->newSelf($antiXss->xss_clean($this->scalarString));
    }

    /**
     * Strip HTML and PHP tags from a string.
     *
     * This function tries to return a string with all NULL bytes,
     * HTML and PHP tags stripped from a given str.
     *
     * @param  string|null  $allowableTags You can use the optional second
     *                                     parameter to specify tags which
     *                                     should not be stripped.
     *
     * @return static
     */
    public function htmlStripTags($allowableTags = null)
    {
        return $this->newSelf
        (
            UTF8::strip_tags($this->scalarString, $allowableTags)
        );
    }
}
