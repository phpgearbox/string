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
 * Function: Between
 * =============================================================================
 * A very simple function that will extract the information between a start and
 * an end string. This function only acts once on the given string. I find it
 * helpful for parsing fetched HTML pages by getting to the part of the HTML
 * I am intrested in. ie: A Table, I would then run BetweenPreg over the table.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $string - The string haystack to perform the manipulation to.
 * $start - A string that defines the start point
 * $end - A string that defines the end point
 * $include - If set to true we will include the start and end in the output.
 * 
 * Returns:
 * -----------------------------------------------------------------------------
 * The string between a start and end string.
 */
function Between($string, $start, $end, $include = false)
{
	// This is what we will return
	$result = '';
	
	// Add a little buffer
	$string = ' '.$string;
	
	// Can we find the start?
	$ini = strpos($string, $start);
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
		$len = strpos($string, $end, $ini) - $ini;
		
		// Grab the middle
		$result = substr($string, $ini, $len);
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
 * Function: BetweenPreg
 * =============================================================================
 * This does more or less the same thing as above except that it does it using
 * a regular expression. It also matches multiple start and end strings.
 * This function is great or parsing HTML/XML type data.
 * 
 * Parameters:
 * -----------------------------------------------------------------------------
 * $string - The string haystack to perform the manipulation to.
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
function BetweenPreg($string, $start, $end)
{
	// Create the regular expression
	$find = '/'.preg_quote($start, '/').'(.*?)'.preg_quote($end, '/').'/s';
	
	// Run the regular expression
	if (preg_match_all($find, $string, $matches))
	{
		return $matches;
	}
	else
	{
		return false;
	}
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
function GenRand($length = 8, $possible = "0123456789bcdfghjkmnpqrstvwxyz")
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
