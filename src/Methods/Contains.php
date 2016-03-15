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

trait Contains
{
    /**
	 * Returns true if the string contains $needle, false otherwise.
	 *
	 * By default the comparison is case-sensitive, but can be made
	 * insensitive by setting $caseSensitive to false.
	 *
	 * @param  string $needle        Substring to look for.
	 *
	 * @param  bool   $caseSensitive Whether or not to enforce case-sensitivity.
	 *
	 * @return bool                  Whether or not $str contains $needle.
	 */
	public function contains($needle, $caseSensitive = true)
	{
		if ($caseSensitive)
		{
			return (UTF8::strpos($this->scalarString, $needle, 0, $this->encoding) !== false);
		}
		else
		{
			return (UTF8::stripos($this->scalarString, $needle, 0, $this->encoding) !== false);
		}
	}

	/**
	 * Returns true if the string contains all $needles, false otherwise.
	 *
	 * By default the comparison is case-sensitive, but can be made
	 * insensitive by setting $caseSensitive to false.
	 *
	 * @param  array $needles       SubStrings to look for.
	 *
	 * @param  bool  $caseSensitive Whether or not to enforce case-sensitivity.
	 *
	 * @return bool                 Whether or not $str contains $needle.
	 */
	public function containsAll($needles, $caseSensitive = true)
	{
		if (empty($needles)) return false;

		foreach ($needles as $needle)
		{
			if (!$this->contains($needle, $caseSensitive)) return false;
		}

		return true;
	}

	/**
	 * Returns true if the string contains any $needles, false otherwise.
	 *
	 * By default the comparison is case-sensitive, but can be made
	 * insensitive by setting $caseSensitive to false.
	 *
	 * @param  array $needles       SubStrings to look for.
	 *
	 * @param  bool  $caseSensitive Whether or not to enforce case-sensitivity.
	 *
	 * @return bool                 Whether or not $str contains $needle.
	 */
	public function containsAny($needles, $caseSensitive = true)
	{
		if (empty($needles)) return false;

		foreach ($needles as $needle)
		{
			if ($this->contains($needle, $caseSensitive)) return true;
		}

		return false;
	}

	/**
	 * Returns the number of occurrences of $substring in the given string.
	 *
	 * By default, the comparison is case-sensitive, but can be made
	 * insensitive by setting $caseSensitive to false.
	 *
	 * @param  string $substring     The substring to search for.
	 * 
	 * @param  bool   $caseSensitive Whether or not to enforce case-sensitivity.
	 *
	 * @return int                   The number of $substring occurrences
	 */
	public function countSubstr($substring, $caseSensitive = true)
	{
		if ($caseSensitive)
		{
			return UTF8::substr_count
			(
				$this->scalarString,
				$substring,
				$this->encoding
			);
		}

		$str = UTF8::strtoupper($this->scalarString, $this->encoding);
		$substring = UTF8::strtoupper($substring, $this->encoding);

		return UTF8::substr_count($str, $substring, $this->encoding);
	}
}
