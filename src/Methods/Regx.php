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

trait Regx
{
    /**
     * The delimiter we will use for all regular expressions.
     *
     * @link http://php.net/manual/en/regexp.reference.delimiters.php
     *
     * @var string
     */
    protected $regexDelimiter = '/';

    /**
     * Allows you to change the the default regular expression delimiter.
     *
     * @param string $value The delimiter to use for all future expressions.
     *
     * @return static
     */
    public function setRegexDelimiter($value)
    {
        $this->regexDelimiter = $value;

        return $this;
    }

    /**
     * Returns true if the string matches the supplied pattern, false otherwise.
     *
     * @param  string $pattern Regex pattern to match against.
     *
     * @param  string $options Matching conditions to be used.
     *
     * @return bool
     *
     * @throws PcreException   When PCRE Error occurs.
     */
    public function regexMatch($pattern, $options = '')
    {
        // Ensure the options contain the "u" modifier.
        if (!$this->newSelf($options)->contains('u')) $options .= 'u';

        // Build the expression
        $expression =
            $this->regexDelimiter.
            $pattern.
            $this->regexDelimiter.
            $options
        ;

        // Run the expression
        $result = preg_match($expression, $this->scalarString);

        // If no errors return true or false based on number of matches found.
        if ($result !== false) return $result === 1;

        // Otherwise throw with last known PCRE Error.
        throw new PcreException();
    }

    /**
     * Given an expression with capture groups, this will return those captures.
     *
     * Basically this is the same as `regexMatch()` but returns the array
     * of matches from `preg_match()` where as `regexMatch()` just returns
     * a boolean result.
     *
     * @param  string $pattern Regex pattern to match against.
     *
     * @param  string $options Matching conditions to be used.
     *
     * @return array           The matches discovered by `preg_match()`.
     *
     * @throws PcreException   When PCRE Error occurs.
     */
    public function regexExtract($pattern, $options = '')
    {
        // Define the array that will be filled by preg_match().
        $matches = [];

        // Ensure the options contain the "u" modifier.
        if (!$this->newSelf($options)->contains('u')) $options .= 'u';

        // Build the expression
        $expression =
            $this->regexDelimiter.
            $pattern.
            $this->regexDelimiter.
            $options
        ;

        // Run the expression
        $result = preg_match($expression, $this->scalarString, $matches);

        // If no errors return the $matches array
        if ($result !== false) return $this->newSelfs($matches);

        // Otherwise throw with last known PCRE Error.
        throw new PcreException();
    }

    /**
     * Replaces all occurrences of $pattern in $str by $replacement.
     *
     * @param  string $pattern     The regular expression pattern.
     *
     * @param  string $replacement The string to replace with.
     *
     * @param  string $options     Matching conditions to be used.
     *
     * @return static              Resulting string after the replacements
     *
     * @throws PcreException       When PCRE Error occurs.
     */
    public function regexReplace($pattern, $replacement, $options = '')
    {
        // The original regexReplace method in danielstjules/Stringy used
        // mb_ereg_replace() which supports an "r" flag, PCRE does not.
        if ($options === 'msr') $options = 'ms';

        // Ensure the options contain the "u" modifier.
        if (!$this->newSelf($options)->contains('u')) $options .= 'u';

        // Build the expression
        $expression =
            $this->regexDelimiter.
            $pattern.
            $this->regexDelimiter.
            $options
        ;

        // Run the regular expression replacement
        $replaced = preg_replace($expression, $replacement, $this->scalarString);

        // If no errors return the replacement
        if ($replaced !== null) return $this->newSelf($replaced);

        // Otherwise throw with last known PCRE Error.
        throw new PcreException();
    }

    /**
     * Splits the string with the provided regular expression.
     *
     * @param  string   $pattern The regex with which to split the string.
     *
     * @param  int|null $limit   Optional maximum number of results to return.
     *
     * @param  bool     $quote   By default this method will run the provided
     *                           $pattern through preg_quote(), this allows the
     *                           method to be used to split on simple substrings.
     *
     * @return static[]          An array of Str objects.
     */
    public function split($pattern, $limit = null, $quote = true)
    {
        // Not sure why you would do this but your wish is our command :)
        if ($limit === 0) return [];

        // UTF8::split errors when supplied an empty pattern in < PHP 5.4.13
        // and current versions of HHVM (3.8 and below)
        if ($pattern === '') return [$this->newSelf($this->scalarString)];

        // UTF8::split returns the remaining unsplit string
        // in the last index when supplying a limit.
        if ($limit > 0)
        {
            $limit += 1;
        }
        else
        {
            $limit = -1;
        }

        // TODO: As per the above comments, all well and good but we are not
        // using UTF8::split here, we are using preg_split???

        // Build the expression
        $expression = $this->regexDelimiter;

        if ($quote === true)
        {
            $expression .= preg_quote($pattern, $this->regexDelimiter);
        }
        else
        {
            $expression .= $pattern;
        }

        $expression .= $this->regexDelimiter.'u';

        // Split the string
        $array = preg_split($expression, $this->scalarString, $limit);

        // Remove any remaining unsplit string.
        if ($limit > 0 && count($array) === $limit) array_pop($array);

        return $this->newSelfs($array);
    }
}
