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
	public function matchesPattern($pattern, $options = '')
	{
		// Ensure the options contain the "u" modifier.
		if (!$this->newSelf($options)->contains('u')) $options .= 'u';

		// Run the expression
		$result = preg_match('/'.$pattern.'/'.$options, $this->scalarString);

		// If no errors return true or false based on number of matches found.
		if ($result !== false) return $result === 1;

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

		// Run the regular expression replacement
		$replaced = preg_replace
		(
			'/'.$pattern.'/'.$options,
			$replacement,
			$this->scalarString
		);

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
     * @param  int      $limit   Optional maximum number of results to return.
     *
     * @return static[]          An array of Str objects.
     */
    public function split($pattern, $limit = null)
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

		// Split the string
		$pattern = '/' . preg_quote($pattern, '/') . '/u';
        $array = preg_split($pattern, $this->scalarString, $limit);

		// Remove any remaining unsplit string.
        if ($limit > 0 && count($array) === $limit) array_pop($array);

		// Convert each of the splits into the Str objects.
        for ($i = 0; $i < count($array); $i++)
        {
            $array[$i] = $this->newSelf($array[$i]);
        }

        return $array;
    }
}
