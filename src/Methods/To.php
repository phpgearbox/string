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

trait To
{
    /**
     * Explicitly turn Str back into a scalar string.
     *
     * @return string
     */
    public function toString()
    {
        return $this->__toString();
    }

    /**
     * Converts the string to an array of characters.
     *
     * Each character is an instance of Str.
     *
     * @return static[]
     */
    public function toArray()
    {
        return $this->getIterator()->getArrayCopy();
    }

    /**
     * Converts all characters in the string to lowercase.
     *
     * @return static
     */
    public function toLowerCase()
    {
        return $this->newSelf
        (
            UTF8::strtolower($this->scalarString, $this->encoding)
        );
    }

    /**
     * Converts all characters in the string to lowercase.
     *
     * @return static
     */
    public function toUpperCase()
    {
        return $this->newSelf
        (
            UTF8::strtoupper($this->scalarString, $this->encoding)
        );
    }

    /**
     * Returns the singular version of the word.
     *
     * @param  string $language The language for the inflector.
     *
     * @return static
     */
    public function toSingular($language = 'en')
    {
        if (!class_exists('\\ICanBoogie\\Inflector'))
        {
            throw new \RuntimeException
            (
                "This method requires ICanBoogie\Inflector. ".
                "Install with: composer require icanboogie/inflector"
            );
        }

        return $this->newSelf
        (
            \ICanBoogie\Inflector::get($language)
            ->singularize($this->scalarString)
        );
    }

    /**
     * Returns the plural version of the word.
     *
     * @param  string $language The language for the inflector.
     *
     * @return static
     */
    public function toPlural($language = 'en')
    {
        if (!class_exists('\\ICanBoogie\\Inflector'))
        {
            throw new \RuntimeException
            (
                "This method requires ICanBoogie\Inflector. ".
                "Install with: composer require icanboogie/inflector"
            );
        }

        return $this->newSelf
        (
            \ICanBoogie\Inflector::get($language)
            ->pluralize($this->scalarString)
        );
    }

    /**
     * Returns an ASCII version of the string.
     *
     * A set of non-ASCII characters are replaced with their closest ASCII
     * counterparts, and the rest are removed unless instructed otherwise.
     *
     * @return static
     */
    public function toAscii()
    {
        return $this->newSelf
        (
            UTF8::toAscii($this->scalarString)
        );
    }

    /**
     * Returns a boolean representation of the given logical string value.
     *
     * For example, 'true', '1', 'on' and 'yes' will return true. 'false', '0',
     * 'off', and 'no' will return false. In all instances, case is ignored.
     * For other numeric strings, their sign will determine the return value.
     * In addition, blank strings consisting of only whitespace will return
     * false. For all other strings, the return value is a result of a
     * boolean cast.
     *
     * @return bool
     */
    public function toBoolean()
    {
        $key = $this->toLowerCase()->scalarString;

        $map =
        [
            'true'  => true,
            '1'     => true,
            'on'    => true,
            'yes'   => true,
            'false' => false,
            '0'     => false,
            'off'   => false,
            'no'    => false
        ];

        if (array_key_exists($key, $map))
        {
            return $map[$key];
        }
        elseif (is_numeric($this->scalarString))
        {
            return ((int)$this->scalarString > 0);
        }
        else
        {
            return (bool)$this->regexReplace('[[:space:]]', '')->scalarString;
        }
    }

    /**
     * Converts tabs to spaces.
     *
     * Each tab in the string is replaced with some number of spaces,
     * as defined by $tabLength. By default, each tab is converted to
     * 4 consecutive spaces.
     *
     * @param  int    $tabLength Number of spaces to replace each tab with.
     *
     * @return static
     */
    public function toSpaces($tabLength = 4)
    {
        return $this->newSelf
        (
            UTF8::str_replace
            (
                "\t",
                UTF8::str_repeat(' ', $tabLength),
                $this->scalarString
            )
        );
    }

    /**
     * Converts spaces to tabs.
     *
     * Replaces each occurrence of some consecutive number of spaces,
     * as defined by $tabLength, to a tab. By default, each 4 consecutive
     * spaces are converted to a tab.
     *
     * @param  int    $tabLength Number of spaces to replace with a tab.
     *
     * @return static
     */
    public function toTabs($tabLength = 4)
    {
        return $this->newSelf
        (
            UTF8::str_replace
            (
                UTF8::str_repeat(' ', $tabLength),
                "\t",
                $this->scalarString
            )
        );
    }

    /**
     * Returns a lowercase and trimmed string separated by dashes.
     *
     * Dashes are inserted before uppercase characters (with the exception of
     * the first character of the string), and in place of spaces as well as
     * underscores.
     *
     * @return static
     */
    public function toDashed()
    {
        return $this->delimit('-');
    }

    /**
     * Returns a lowercase and trimmed string separated by underscores.
     *
     * Underscores are inserted before uppercase characters (with the exception
     * of the first character of the string), and in place of spaces as well as
     * dashes.
     *
     * @return static
     */
    public function toUnderScored()
    {
        return $this->delimit('_');
    }

    /**
     * Returns a camelCase version of the string.
     *
     * Trims surrounding spaces, capitalizes letters following digits, spaces,
     * dashes & underscores and removes spaces & dashes as well as underscores.
     *
     * @param  bool    $upperFirst If true, the first char will be UPPERCASE.
     *
     * @return static
     */
    public function toCamelCase($upperFirst = false)
    {
        $camelCase = $this->trim()->lowerCaseFirst();

        $camelCase = preg_replace('/^[-_]+/', '', (string)$camelCase);

        $camelCase = preg_replace_callback
        (
            '/[-_\s]+(.)?/u',
            function ($match)
            {
                if (isset($match[1]))
                {
                    return UTF8::strtoupper($match[1], $this->encoding);
                }
                else
                {
                    return '';
                }
            },
            $camelCase
        );

        $camelCase = preg_replace_callback
        (
            '/[\d]+(.)?/u',
            function ($match)
            {
                return UTF8::strtoupper($match[0], $this->encoding);
            },
            $camelCase
        );

        $camelCase = $this->newSelf($camelCase);

        if ($upperFirst === true) $camelCase = $camelCase->upperCaseFirst();

        return $camelCase;
    }

    /**
     * Convert a string to e.g.: "snake_case"
     *
     * @return static
     */
    public function toSnakeCase()
    {
        $snake = UTF8::normalize_whitespace($this->scalarString);

        $snake = str_replace('-', '_', $snake);

        $snake = preg_replace_callback
        (
            '/([\d|A-Z])/u',
            function ($matches)
            {
                $match = $matches[1];
                $matchInt = (int)$match;

                if ("$matchInt" == $match)
                {
                    return '_' . $match . '_';
                }
                else
                {
                    return '_' . UTF8::strtolower($match, $this->encoding);
                }
            },
            $snake
        );

        $snake = preg_replace
        (
            [
                '/\s+/',        // convert spaces to "_"
                '/^\s+|\s+$/',  // trim leading & trailing spaces
                '/_+/'          // remove double "_"
            ],
            [
                '_',
                '',
                '_'
            ],
            $snake
        );

        // trim leading & trailing "_"
        $snake = UTF8::trim($snake, '_');

        // trim leading & trailing whitespace
        $snake = UTF8::trim($snake);

        return $this->newSelf($snake);
    }

    /**
     * Returns a trimmed string with the first letter of each word capitalized.
     *
     * Also accepts an array, $ignore, allowing you to
     * list words not to be capitalized.
     *
     * @param  array|null $ignore An array of words not to capitalize
     *
     * @return static
     */
    public function toTitleCase($ignore = null)
    {
        return $this->newSelf(preg_replace_callback
        (
            '/([\S]+)/u',
            function ($match) use ($ignore)
            {
                if ($ignore && in_array($match[0], $ignore, true))
                {
                    return $match[0];
                }
                else
                {
                    return (string)$this->newSelf($match[0])
                    ->toLowerCase()->upperCaseFirst();
                }
            },
            (string)$this->trim()
        ));
    }

    /**
     * Returns a trimmed string with the first letter capitalized.
     *
     * TODO: Be smarter and capitalise after every period.
     *
     * @return static
     */
    public function toSentenceCase()
    {
        return $this->trim()->toLowerCase()->upperCaseFirst();
    }

    /**
     * Converts the string into an URL slug.
     *
     * This includes replacing non-ASCII characters with their closest ASCII
     * equivalents, removing remaining non-ASCII and non-alphanumeric
     * characters, and replacing whitespace with $replacement.
     *
     * The replacement defaults to a single dash
     * and the string is also converted to lowercase.
     *
     * @param string $replacement The string used to replace whitespace
     * @param string $language    The language for the url
     * @param bool   $strToLower  string to lower
     *
     * @return static
     */
    public function toSlugCase($replacement = '-', $language = 'en', $strToLower = true)
    {
        if (!class_exists('\\voku\\helper\\URLify'))
        {
            throw new \RuntimeException
            (
                "This method requires \voku\helper\URLify. ".
                "Install with: composer require voku/urlify"
            );
        }

        return $this->newSelf
        (
            \voku\helper\URLify::slug
            (
                $this->scalarString,
                $language,
                $replacement,
                $strToLower
            )
        );
    }
}
