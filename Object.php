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

class Object implements \ArrayAccess
{
	/**
	 * Property: $value
	 * =========================================================================
	 * This stores the actual string that this object represents.
	 */
	private $value;
	
	/**
	 * Method: __construct
	 * =========================================================================
	 * Creates a new Gears\String\Object
	 * 
	 * Parameters:
	 * -------------------------------------------------------------------------
	 * $string - A PHP string to tunr into a Gears\String\Object
	 * 
	 * Returns:
	 * -------------------------------------------------------------------------
	 * void
	 */
	public function __construct($string)
	{
		$this->value = (string)$string;
	}
	
	/**
	 * Method: __toString
	 * =========================================================================
	 * Magic method to turn Gears\String\Object back into a normal string.
	 * 
	 * Parameters:
	 * -------------------------------------------------------------------------
	 * n/a
	 * 
	 * Returns:
	 * -------------------------------------------------------------------------
	 * string
	 */
	public function __toString()
	{
		return $this->value;
	}
	
	// Alias for above
	public function toString()
	{
		return $this->__toString();
	}
	
	/**
	 * Method: offsetExists
	 * =========================================================================
	 * ArrayAccess method, checks to see if the key actually exists.
	 * 
	 * Parameters:
	 * -------------------------------------------------------------------------
	 * $index - The integer of the index to check.
	 * 
	 * Returns:
	 * -------------------------------------------------------------------------
	 * boolean
	 */
	public function offsetExists($index)
	{
		return !empty($this->value[$index]);
	}
	
	/**
	 * Method: offsetGet
	 * =========================================================================
	 * ArrayAccess method, retrieves an array value.
	 * 
	 * Parameters:
	 * -------------------------------------------------------------------------
	 * $index - The integer of the index to get.
	 * 
	 * Returns:
	 * -------------------------------------------------------------------------
	 * string
	 */
	public function offsetGet($index)
	{
		return CharAt($this->value, $index);
	}
	
	/**
	 * Method: offsetSet
	 * =========================================================================
	 * ArrayAccess method, sets an array value.
	 * 
	 * Parameters:
	 * -------------------------------------------------------------------------
	 * $index - The integer of the index to set.
	 * $val - The new value for the index.
	 * 
	 * Returns:
	 * -------------------------------------------------------------------------
	 * void
	 */
	public function offsetSet($index, $val)
	{
		// Work out the start of the string
		if ($index == 0)
		{
			$start = '';
		}
		else
		{
			$start = SubString($this->value, 0, $index);
		}
		
		// Work out the end of the string
		$end = SubString($this->value, $index+1, Length($this->value));
		
		// Recombine them with a new middle
		$this->value = $start.$val.$end;
	}
	
	/**
	 * Method: offsetUnset
	 * =========================================================================
	 * ArrayAccess method, removes an array value.
	 * 
	 * Parameters:
	 * -------------------------------------------------------------------------
	 * $index - The integer of the index to delete.
	 * 
	 * Returns:
	 * -------------------------------------------------------------------------
	 * void
	 */
	public function offsetUnset($index)
	{
		$this->value =
			substr($this->value, 0, $index).
			substr($this->value, $index+1)
		;
	}
	
	/**
	 * Method: convertArray
	 * =========================================================================
	 * This method will take an array of normal PHP strings
	 * and return an array of \Gears\String\Object strings.
	 * 
	 * Parameters:
	 * -------------------------------------------------------------------------
	 * $array - The array to convert
	 * 
	 * Returns:
	 * -------------------------------------------------------------------------
	 * void
	 */
	private function convertArray($array)
	{
		// Make sure it's an array
		if (is_array($array))
		{
			// This is what we will return
			$new_array = [];
			
			// Loop through the old array
			foreach ($array as $string)
			{
				$new_array[] = new self($string);
			}
			
			// Return the new array
			return $new_array;
		}
		else
		{
			// Do nothing to it
			return $array;
		}
	}
	
	public function Contains($needle)
	{
		return \Gears\String\Contains($this->value, $needle);
	}
	
	public function Search($needle, $regx = false)
	{
		return new self
		(
			\Gears\String\Search($this->value, $needle, $regx)
		);
	}
	
	public function Replace($needle, $replace, $regex = false)
	{
		return new self
		(
			\Gears\String\Replace($this->value, $needle, $replace, $regex)
		);
	}
	
	public function Match($regex)
	{
		return $this->convertArray
		(
			\Gears\String\Match($this->value, $regex)
		);
	}
	
	public function Between($start, $end, $include = false)
	{
		return new self
		(
			\Gears\String\Between($this->value, $start, $end, $include)
		);
	}
	
	public function BetweenRegx($start, $end)
	{
		return $this->convertArray
		(
			\Gears\String\BetweenRegx($this->value, $start, $end)
		);
	}
	
	public function StartsWith($needle)
	{
		return \Gears\String\StartsWith($this->value, $needle);
	}
	
	public function EndsWith($needle)
	{
		return \Gears\String\EndsWith($this->value, $needle);
	}
	
	public function SubStr($start, $length)
	{
		return new self
		(
			substr($this->value, $start, $length)
		);
	}
	
	public function SubString($start, $end)
	{
		return new self
		(
			\Gears\String\SubString($this->value, $start, $end)
		);
	}
	
	public function Slice($start, $end = null)
	{
		return new self
		(
			\Gears\String\Slice($this->value, $start, $end)
		);
	}
	
	public function ConCat()
	{
		return new self
		(
			call_user_func_array
			(
				'\Gears\String\ConCat',
				array_merge([$this->value], func_get_args())
			)
		);
	}
	
	public function CharAt($point)
	{
		return new self
		(
			\Gears\String\CharAt($this->value, $point)
		);
	}
	
	public function CharCodeAt($point)
	{
		return new self
		(
			\Gears\String\CharCodeAt($this->value, $point)
		);
	}
	
	public function IndexOf($needle, $offset = 0)
	{
		return new self
		(
			\Gears\String\IndexOf($this->value, $needle, $offset)
		);
	}
	
	public function LastIndexOf($needle, $offset = 0)
	{
		return new self
		(
			\Gears\String\LastIndexOf($this->value, $needle, $offset)
		);
	}
	
	public function ToLowerCase()
	{
		return new self
		(
			\Gears\String\ToLowerCase($this->value)
		);
	}
	
	public function ToUpperCase()
	{
		return new self
		(
			\Gears\String\ToUpperCase($this->value)
		);
	}
	
	public function Split($at = '')
	{
		return $this->convertArray
		(
			\Gears\String\Split($this->value, $at)
		);
	}
	
	public function Trim($charlist = null)
	{
		return new self
		(
			trim($this->value, $charlist)
		);
	}

	public function Ltrim($charlist = null)
	{
		return new self
		(
			ltrim($this->value, $charlist)
		);
	}

	public function Rtrim($charlist = null)
	{
		return new self
		(
			rtrim($this->value, $charlist)
		);
	}
}
