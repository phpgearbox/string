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
 * Function: Contains
 * =============================================================================
 * This does a simple check to see if the haystack contains the needle.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $haystack - The string haystack to perform the test to.
 * $needle - This is what we are looking for inside the haystack.
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * boolean
 */
function Contains($haystack, $needle)
{
	return (strpos($haystack, $needle) !== false);
}

/**
 * Function: Search
 * =============================================================================
 * The search() method searches a string for a specified value,
 * or regular expression, and returns the position of the match.
 * This method returns -1 if no match is found.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $haystack - The string haystack to perform the test to.
 * $needle - This is what we are looking for inside the haystack.
 * $regx - Set to true if needle is a regular expression.
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * boolean
 */
function Search($haystack, $needle, $regx = false)
{
	if ($regx)
	{
		if (preg_match($needle, $haystack, $match) == 1)
		{
			$pos = strpos($haystack, $match[0]);
		}
		else
		{
			$pos = -1;
		}
	}
	else
	{
		$pos = strpos($haystack, $needle);
		
		if ($pos === false)
		{
			$pos = -1;
		}
	}
	
	return $pos;
}

/**
 * Function: Replace
 * =============================================================================
 * The replace() method searches a string for a specified value,
 * or a regular expression, and returns a new string where the specified
 * values are replaced.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $haystack - The string haystack to perform the manipulation to.
 * 
 * $needle - This is what we are looking for inside the haystack.
 * This can also be an array of multiple needles.
 * 
 * $replace - This is what will replace the needle. This can be an array of
 * multiple replacements. Also if using regx, you can supply an annoymous
 * function if you wish instead.
 * 
 * $regex - Set to true if needle is a regular expression.
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * string
 */
function Replace($haystack, $needle, $replace, $regex = false)
{
	if($regex)
	{
		if (is_callable($replace))
		{
			$result = preg_replace_callback($needle, $replace, $haystack);
		}
		else
		{
			$result = preg_replace($needle, $replace, $haystack);
		}
	}
	else
	{
		$result = str_replace($needle, $replace, $haystack);
	}
	
	return $result;
}

/**
 * Function: Match
 * =============================================================================
 * The match() method searches a string for a match against a regular
 * expression, and returns the matches, as an Array object.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $haystack - The string haystack to perform the test to.
 * $regex - Set to true if needle is a regular expression.
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * array
 */
function Match($haystack, $regex)
{
	preg_match_all($regex, $haystack, $matches);
	return $matches[0];
}

/**
 * Function: Between
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
function Between($haystack, $start, $end, $include = false)
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
 * Function: BetweenRegx
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
function BetweenRegx($haystack, $start, $end)
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
 * Function: StartsWith
 * =============================================================================
 * This checks to see if the haystack starts with the needle.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $haystack - The string haystack to perform the test to.
 * $needle - This is what the haystack should start with.
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * boolean
 */
function StartsWith($haystack, $needle)
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
 * Function: EndsWith
 * =============================================================================
 * This checks to see if the haystack ends with the needle.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $haystack - The string haystack to perform the test to.
 * $needle - This is what the haystack should end with.
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * boolean
 */
function EndsWith($haystack, $needle)
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
 * Function: SubString
 * =============================================================================
 * The substring() method extracts the characters from a string, between two
 * specified indices, and returns the new sub string. This method extracts the
 * characters in a string between "from" and "to", not including "to" itself.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $string - The input string. Must be one character or longer.
 * $start - The starting point of the extraction.
 * $end - The ending point of the extraction.
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * string
 */
function SubString($string, $start, $end = null)
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
 * Function: Slice
 * =============================================================================
 * This is really just an alias for substring for completeness sake
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $string - The input string. Must be one character or longer.
 * $start - The starting point of the extraction.
 * $end - The ending point of the extraction.
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * string
 */
function Slice($string, $start, $end = null)
{
	return SubString($string, $start, $end);
}

/**
 * Function: ConCat
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
function ConCat()
{
	$result = '';
	foreach(func_get_args() as $arg) { $result .= (string)$arg; }
	return $result;
}

/**
 * Function: Split
 * =============================================================================
 * Splits a string into an array of substrings
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $string - The string to split
 * 
 * $at - What character to use as the delimeter for the split,
 * if none supplied you will get an array of characters.
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * array
 */
function Split ($string, $at = '')
{
	if(empty($at))
	{
		return str_split($string);
	}
	else
	{
		return explode($at, $string);
	}
}

/**
 * Function: Length
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
function Length($string)
{
	return strlen($string);
}

/**
 * Function: Range
 * =============================================================================
 * This checks to see if the length of the haystack is between x and y
 * Calulates inclusive of x and y, I felt this was the natural assumption.
 * It was for me when I first used this function before it become part of
 * the library anyway.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $string - A string to test
 * $x - The lower value
 * $y - The higher value
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * boolean
 */
function Range($string, $x, $y)
{
	// Get the length of the string
	$length = strlen($string);
	
	// Is it between x and y
	if (($length >= $x) && ($length <= $y))
	{
		return true;
	}
	else
	{
		return false;
	}
}

/**
 * Function: CharAt
 * =============================================================================
 * The charAt() method returns the character at the specified index in a string.
 * The index of the first character is 0, the second character is 1, and so on.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $string - The string to extract the character from.
 * $point - The numerical index of the character, starting at 0.
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * string
 */
function CharAt($string, $point)
{
	return substr($string, $point, 1);
}

/**
 * Function: CharCodeAt
 * =============================================================================
 * The charCodeAt() method returns the Unicode of the character at the
 * specified index in a string. The index of the first character is 0,
 * the second character 1, and so on.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $string - The string to extract the character from.
 * $point - The numerical index of the character, starting at 0.
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * int
 */
function CharCodeAt($string, $point)
{
	return ord(substr($string, $point, 1));
}

/**
 * Function: FromCharCode
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
function FromCharCode($code)
{
	return chr($code);
}

/**
 * Function: IndexOf
 * =============================================================================
 * Just an alias for strpos
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
function IndexOf($haystack, $needle, $offset = 0)
{
	return strpos($haystack, $needle, $offset);
}

/**
 * Function: LastIndexOf
 * =============================================================================
 * Just an alias for strrpos
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
function LastIndexOf($haystack, $needle, $offset = 0)
{
	return strrpos($haystack, $needle, $offset);
}

/**
 * Function: ToLowerCase
 * =============================================================================
 * Just an alias for strtolower
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $string
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * string
 */
function ToLowerCase($string)
{
	return strtolower($string);
}

/**
 * Function: ToUpperCase
 * =============================================================================
 * Just an alias for strtoupper
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $string
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * string
 */
function ToUpperCase ($string)
{
	return strtoupper($string);
}

/**
 * Function: GenRand
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
function GenRand($length, $possible = "0123456789bcdfghjkmnpqrstvwxyz")
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
