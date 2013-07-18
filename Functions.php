<?php
////////////////////////////////////////////////////////////////////////////////
// __________ __             ________                   __________              
// \______   \  |__ ______  /  _____/  ____ _____ ______\______   \ _______  ___
//  |     ___/  |  \\____ \/   \  ____/ __ \\__  \\_  __ \    |  _//  _ \  \/  /
//  |    |   |   Y  \  |_> >    \_\  \  ___/ / __ \|  | \/    |   (  <_> >    < 
//  |____|   |___|  /   __/ \______  /\___  >____  /__|  |______  /\____/__/\_ \
//                \/|__|           \/     \/     \/             \/            \/
// =============================================================================
//         Designed and Developed by Brad Jones <bj @="gravit.com.au" />        
// =============================================================================
////////////////////////////////////////////////////////////////////////////////

namespace Gears\String;

/**
 * Function: multiByte
 * =============================================================================
 * Most of these functions are multibyte aware if the extension is loaded,
 * this will check to see if the MultiByte extension is loaded and if so it
 * will return the current encoding, if not it will return false.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * n/a
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * mixed
 */
function multiByte()
{
	static $encoding = null;
	
	if ($encoding == null)
	{
		if (extension_loaded('mbstring'))
		{
			$encoding = mb_internal_encoding();
		}
		else
		{
			$encoding = false;
		}
	}
	
	return $encoding;
}

/**
 * Function: substr
 * =============================================================================
 * A multibyte aware version of substr
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $string
 * $start
 * $length
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * string
 */
function substr ($string, $start, $length = null)
{
	if(multiByte())
	{
		return \mb_substr($string, $start, $length, multiByte());
	}
	else
	{
		return \substr($string, $start, $length);
	}
}

/**
 * Function: substring
 * =============================================================================
 * The substring() method extracts the characters from a string, between two
 * specified indices, and returns the new sub string. This method extracts the
 * characters in a string between "from" and "to", not including "to" itself.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $string
 * $start
 * $end
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * string
 */
function substring ($string, $start, $end = null)
{
	if(empty($end))
	{
		return substr($string, $start);
	}
	else
	{
		return substr($string, $start, ($end - $start));
	}
}

/**
 * Function: slice
 * =============================================================================
 * This is really just an alias for substring for completeness sake
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $string
 * $start
 * $end
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * string
 */
function slice ($string, $start, $end = null)
{
	return substring($string, $start, $end);
}

/**
 * Function: between
 * =============================================================================
 * A very simple function that will extract the information between a start and
 * an end string. This function only acts once on the given string. I find it
 * helpful for parsing fetched HTML pages by getting to the part of the HTML
 * I am intrested in. ie: A Table, I would then run BetweenPreg over the table.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $haystack - The string haystack to perform the manipulation to.
 * $start - A string that defines the start point
 * $end - A string that defines the end point
 * $include - If set to true we will include the start and end in the output.
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * The string between a start and end string.
 */
function between($haystack, $start, $end, $include = false)
{
	// This is what we will return
	$result = '';
	
	// Add a little buffer
	$haystack = ' '.$haystack;
	
	// Can we find the start?
	$ini = strpos($haystack, $start);
	if ($ini == 0)
	{
		// Nope so return nothing
		$result = '';
	}
	else
	{
		// Move our position past the start point
		$ini += strlen($start);
		
		// Get the length of the middle section
		$len = strpos($haystack, $end, $ini) - $ini;
		
		// Grab the middle
		$result = substr($haystack, $ini, $len);
	}
	
	// Do we want the start and end?
	if ($include)
	{
		$result = $start.$result.$end;
	}
	
	// Return the final result
	return $result;
}

/**
 * Function: betweenPreg
 * =============================================================================
 * This does more or less the same thing as above except that it does it using
 * a regular expression. It also matches multiple start and end strings.
 * This function is great or parsing HTML/XML type data.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $haystack - The string haystack to perform the manipulation to.
 * $start - A string that defines the start point
 * $end - A string that defines the end point
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * Returns an array of matches or false if it can't find anything. The first
 * key in the array contains an array of results including the start and end
 * strings. The second key contains an array of results that don't have the
 * start and end strings.
 */
function betweenPreg($haystack, $start, $end)
{
	// Create the regular expression
	$find = '/'.preg_quote($start, '/').'(.*?)'.preg_quote($end, '/').'/s';
	
	// Run the regular expression
	if (preg_match_all($find, $haystack, $matches))
	{
		return $matches;
	}
	else
	{
		return false;
	}
}

/**
 * Function: genRand
 * =============================================================================
 * This will generate a random string. This is certianly nothing to special.
 * If you are looking for something to use with security and encryption I
 * would look else where. But is handy for creating new random passwords,
 * api tokens, session ids, etc.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $length - How long do we want the random string to be?
 * $possible - A string of possible characters to use in the random string.
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * A random string
 */
function genRand($length = 8, $possible = "0123456789bcdfghjkmnpqrstvwxyz")
{
	// This is what we will return
	$string = '';
	
	// Start looping until we have created a string of the desired length
	$i = 0; 
	while ($i < $length)
	{
		// Select a character
		$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
		
		// Make sure that character does not already exist
		if (!strstr($string, $char))
		{
			// Add it to our new string
			$string .= $char;
			
			// Increase the loop count
			$i++;
		}
	}
	
	// Return the string
	return $string;
}

/**
 * Function: startsWith
 * =============================================================================
 * This checks to see if the haystack starts with the needle.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $needle - This is what the haystack should start with
 * $haystack - A string to test
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * boolean
 */
function startsWith($needle, $haystack)
{
	// Get the length of the needle
	$needle_len = strlen($needle);
	
	// Get the length of the haystack
	$haystack_len = strlen($haystack);
	
	// Get the start section
	$start = substr($haystack, 0, $needle_len);
	
	// Do we have a match
	if ($needle_len <= $haystack_len && $start === $needle)
	{
		return true;
	}
	else
	{
		return false;
	}
}

/**
 * Function: endsWith
 * =============================================================================
 * This checks to see if the haystack ends with the needle.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $needle - This is what the haystack should end with
 * $haystack - A string to test
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * boolean
 */
function endsWith($needle, $haystack)
{
	// Get the length of the needle
	$needle_len = strlen($needle);
	
	// Get the length of the haystack
	$haystack_len = strlen($haystack);
	
	// Get the end section
	$end = substr($haystack, -$needle_len);
	
	// Do we have a match
	if ($needle_len <= $haystack_len && $end === $needle)
	{
		return true;
	}
	else
	{
		return false;
	}
}

/**
 * Function: contains
 * =============================================================================
 * This checks to see if the haystack contains the needle
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $needle - This is what we are looking for inside the haystack
 * $haystack - A string to test
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * boolean
 */
function contains($needle, $haystack)
{
	return (strpos($haystack, $needle) !== false);
}

/**
 * Function: length
 * =============================================================================
 * This will return the length of the string
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $string - The string
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * int
 */
function length ($string)
{
	if(multiByte())
	{
		return mb_strlen($string, multiByte());
	}
	
	return strlen($string);
}

/**
 * Function: range
 * =============================================================================
 * This checks to see if the length of the haystack is between x and y
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $haystack - A string to test
 * $x - The lower value
 * $y - The higher value
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * boolean
 */
function range($haystack, $x, $y)
{
	// Get the length of the string
	$length = strlen($haystack);
	
	// Is it between x and y
	if (($length > $x) && ($length < $y))
	{
		return true;
	}
	else
	{
		return false;
	}
}

/**
 * Function: charAt
 * =============================================================================
 * The charAt() method returns the character at the specified index in a string.
 * The index of the first character is 0, the second character is 1, and so on.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $string
 * $point
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * string
 */
public function charAt ($string, $point)
{
	return substr($string, $point, 1);
}

/**
 * Function: charCodeAt
 * =============================================================================
 * The charCodeAt() method returns the Unicode of the character at the
 * specified index in a string. The index of the first character is 0,
 * the second character 1, and so on.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $string
 * $point
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * int
 */
public function charCodeAt ($string, $point)
{
	return ord(substr($string, $point, 1));
}

/**
 * Function: concat
 * =============================================================================
 * The concat() method is used to join two or more strings. This method does
 * not change the existing strings, but returns a new string containing the
 * text of the joined strings.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $string1
 * $string2
 * $string3
 * $etc
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * string
 */
function concat ()
{
	$result = '';
	foreach(func_get_args() as $arg) { $result .= (string)$arg; }
	return $result;
}

/**
 * Function: fromCharCode
 * =============================================================================
 * The fromCharCode() method converts Unicode values into characters.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $code - The ASCII Code
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * string
 */
function fromCharCode ($code)
{
	return chr($code);
}

/**
 * Function: indexOf
 * =============================================================================
 * The indexOf() method returns the position of the first occurrence of a
 * specified value in a string. This method returns -1 if the value to
 * search for never occurs.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $haystack
 * $needle
 * $offset
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * int
 */
function indexOf ($haystack, $needle, $offset = 0)
{
	if(multiByte())
	{
		return mb_strpos($haystack, $needle, $offset, multiByte());
	}
	
	return strpos($haystack, $needle, $offset);
}

/**
 * Function: lastIndexOf
 * =============================================================================
 * The lastIndexOf() method returns the position of the last occurrence of a
 * specified value in a string. Note: The string is searched from the end to
 * the beginning, but returns the index starting at the beginning, at postion 0.
 * This method returns -1 if the value to search for never occurs.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $haystack
 * $needle
 * $offset
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * int
 */
function lastIndexOf ($haystack, $needle, $offset = 0)
{
	if(multiByte())
	{
		return mb_strrpos($haystack, $needle, $offset, multiByte());
	}
	
	return strrpos($haystack, $needle, $offset);
}

/**
 * Function: match
 * =============================================================================
 * The match() method searches a string for a match against a regular
 * expression, and returns the matches, as an Array object.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $haystack
 * $regex
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * array
 */
function match ($haystack, $regex)
{
	preg_match_all($regex, $haystack, $matches, PREG_PATTERN_ORDER);
	return $matches[0];
}

/**
 * Function: replace
 * =============================================================================
 * The replace() method searches a string for a specified value,
 * or a regular expression, and returns a new string where the specified
 * values are replaced.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $haystack
 * $needle
 * $replace
 * $regex
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * string
 */
function replace ($haystack, $needle, $replace, $regex = false)
{
	if($regex)
	{
		$result = preg_replace($needle, $replace, $haystack);
	}
	else
	{
		if(multiByte())
		{
			$result = mb_str_replace($needle, $replace, $haystack);
		}
		else
		{
			$result = str_replace($needle, $replace, $haystack);
		}
	}
	
	return $result;
}

/**
 * Function: toLowerCase
 * =============================================================================
 * Converts a string to lowercase letters
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $string
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * string
 */
function toLowerCase ($string)
{
	if(multiByte())
	{
		return mb_strtolower($string, multiByte());
	}
	
	return strtolower($string);
}

/**
 * Function: toUpperCase
 * =============================================================================
 * Converts a string to uppercase letters
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $string
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * string
 */
function toUpperCase ($string)
{
	if(multiByte())
	{
		return mb_strtoupper($string, multiByte());
	}
	
	return strtoupper($string);
}

/**
 * Function: split
 * =============================================================================
 * Splits a string into an array of substrings
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $string
 * $at
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * array
 */
function split ($string, $at = '')
{
	if(empty($at))
	{
		if(multiByte())
		{
			return mb_str_split($string);
		}
		
		return str_split($string);
	}
	
	return explode($at, $string);
}
