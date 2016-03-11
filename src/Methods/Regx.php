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

trait Regx
{
    /**
	 * Returns true if $str matches the supplied pattern, false otherwise.
	 *
	 * @param  string $pattern Regex pattern to match against
	 *
	 * @return bool   Whether or not $str matches the pattern
	 */
	public function matchesPattern($pattern)
	{
		if (preg_match('/' . $pattern . '/u', $this->scalarString) === 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Replaces all occurrences of $pattern in $str by $replacement.
	 *
	 * @param  string $pattern     The regular expression pattern
	 * @param  string $replacement The string to replace with
	 * @param  string $options     Matching conditions to be used
	 *
	 * @return static              Resulting string after the replacements
	 */
	public function regexReplace($pattern, $replacement, $options = '')
	{
		// PHP doesn't support the "r" modifier,
		// as it has a dedicated function for replacing.
		if ($options === 'msr') $options = 'ms';

		return $this->newSelf(preg_replace
		(
			'/' . $pattern . '/u' . $options,
			$replacement,
			$this->scalarString
		));
	}
}
