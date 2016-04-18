<?php namespace Gears\String;
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
use Icecave\Parity\Parity;
use Icecave\Parity\SubClassComparableInterface as Comparable;

/**
 * Base Str Class
 *
 * This class provides all the basic functionality to make the Str object
 * behave almost like a normal scalar string. Such as array access and length.
 *
 * @package Gears\String
 */
class Base implements \Countable, \ArrayAccess, \IteratorAggregate, Comparable
{
    /**
     * This stores the actual scalar string that this object represents.
     *
     * @var string
     */
    protected $scalarString;

    /**
     * This stores the actual scalar string length.
     *
     * Because Str objects are immutable, we can calculate the length at
     * construction time and reuse the same result over and over as needed,
     * instead of calling strlen() multiple times.
     *
     * @var int
     */
    protected $stringLength;

    /**
     * Returns the string length.
     *
     * @return int The number of characters in the string.
     *             A UTF-8 multi-byte character is counted as 1.
     */
    public function getLength()
    {
        return $this->stringLength;
    }

    /**
     * The stores the string's encoding.
     *
     * Which should be one of the mbstring module's supported encodings.
     * @see http://php.net/manual/en/mbstring.supported-encodings.php
     *
     * @var string
     */
    protected $encoding;

    /**
     * Returns the encoding used by the Str object.
     *
     * @return string The current value of the $encoding property.
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * Initialises a Str object.
     *
     * @param mixed       $string        Must be a scalar string or an object
     *                                   that implements the __toString() method
     *                                   or a value that is castable to a scalar
     *                                   string.
     *
     * @param string|null $encoding      The character encoding to use for this
     *                                   string. If not specified, defaults to
     *                                   the value returned from
     *                                   mb_internal_encoding().
     *
     * @throws \InvalidArgumentException If an array or object without a
     *                                   __toString method is passed as
     *                                   the first argument.
     */
    public function __construct($string = '', $encoding = null)
    {
        // Make sure we can use the provided string value as a string.
        if (is_array($string))
        {
            throw new \InvalidArgumentException
            (
                'Passed value cannot be an array'
            );
        }
        elseif (is_object($string) && !method_exists($string, '__toString'))
        {
            throw new \InvalidArgumentException
            (
                'Passed object must have a __toString method'
            );
        }

        // Store the string internally.
        $this->scalarString = (string)$string;

        // Intialise Voku's UTF8 portability layer.
        UTF8::checkForSupport();

        // Set the strings encoding.
        if ($encoding !== null)
        {
            $this->encoding = $encoding;
        }
        else
        {
            $this->encoding = mb_internal_encoding();
        }

        // Set the strings length property.
        $this->stringLength = UTF8::strlen($this->scalarString,$this->encoding);
    }

    /**
     * Magic method to automatically turn a Str back into a scalar string.
     *
     * @see http://php.net/manual/en/language.oop5.magic.php#object.tostring
     *
     * @return string
     */
    public function __toString()
    {
        return $this->scalarString;
    }

    /**
     * Factory method to create a new Gears\String\Str object.
     *
     * @param mixed       $string        Must be a scalar string or an object
     *                                   that implements the __toString() method
     *                                   or a value that is castable to a scalar
     *                                   string.
     *
     * @param string|null $encoding      The character encoding to use for this
     *                                   string. If not specified, defaults to
     *                                   the value returned from
     *                                   mb_internal_encoding().
     *
     * @return static                    A Str object.
     *
     * @throws \InvalidArgumentException If an array or object without a
     *                                   __toString method is passed as
     *                                   the first argument.
     */
    public static function s($string = '', $encoding = null)
    {
        return new static($string, $encoding);
    }

    /**
     * Helper method, used internally.
     *
     * Basically all this does is saves us a few key strokes by copying
     * the current encoding to the next Str object we are creating.
     *
     * @param  string $string
     *
     * @return static
     */
    protected function newSelf($string)
    {
        return static::s($string, $this->encoding);
    }

    /**
     * Helper method, used internally.
     *
     * Given an array of scalar strings we will convert all them to Str objects.
     *
     * > NOTE: This method is recursive.
     *
     * @param  array    $input
     *
     * @return static[]
     */
    protected function newSelfs(array $input)
    {
        $strObjects = [];

        foreach ($input as $key => $value)
        {
            if (is_string($value))
            {
                // Convert the scalar string to a Str Object
                $strObjects[$key] = $this->newSelf($value);
            }
            elseif (is_array($value))
            {
                // Recurse into the array
                $strObjects[$key] = $this->newSelfs($value);
            }
            else
            {
                // We don't know what it is do do nothing to it
                $strObjects[$key] = $value;
            }
        }

        return $strObjects;
    }

    /**
     * Countable interface method.
     *
     * @see http://php.net/manual/en/class.countable.php
     *
     * @return int
     */
    public function count()
    {
        return $this->getLength();
    }

    /**
     * IteratorAggregate interface method.
     *
     * @see http://php.net/manual/en/class.iteratoraggregate.php
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        $chars = array();

        for ($i = 0, $l = $this->getLength(); $i < $l; $i++)
        {
            $chars[] = $this[$i];
        }

        return new \ArrayIterator($chars);
    }

    /**
     * Checks to see if the character index exists.
     *
     * Implements part of the ArrayAccess interface. Offsets may be
     * negative to count from the last character in the string.
     *
     * @param  int     $index The integer of the index to check.
     *
     * @return boolean
     */
    public function offsetExists($index)
    {
        $index = (int)$index;

        if ($index >= 0) return ($this->getLength() > $index);

        return ($this->getLength() >= abs($index));
    }

    /**
     * Returns the character at the given index. Offsets may be negative to
     * count from the last character in the string. Implements part of the
     * ArrayAccess interface, and throws an OutOfBoundsException if the index
     * does not exist.
     *
     * @param  mixed  $offset        The index from which to retrieve the char.
     *
     * @return static                The character at the specified index.
     *
     * @throws \OutOfBoundsException If the positive or negative offset does
     *                               not exist.
     */
    public function offsetGet($offset)
    {
        $offset = (int)$offset;
        $length = $this->getLength();

        if (($offset >= 0 && $length <= $offset) || $length < abs($offset))
        {
            throw new \OutOfBoundsException('No character exists at the index');
        }

        return $this->newSelf(UTF8::substr
        (
            $this->scalarString,
            $offset,
            1,
            $this->encoding
        ));
    }

    /**
     * Implements part of the ArrayAccess interface, but throws an exception
     * when called. This maintains the immutability of Str objects.
     *
     * @param  mixed      $offset The index of the character.
     *
     * @param  mixed      $value  Value to set.
     *
     * @throws \Exception         When called.
     */
    public function offsetSet($offset, $value)
    {
        // Str is immutable, cannot directly set char
        throw new \Exception('Str object is immutable, cannot modify char');
    }

    /**
     * Implements part of the ArrayAccess interface, but throws an exception
     * when called. This maintains the immutability of Str objects.
     *
     * @param  mixed      $offset The index of the character.
     *
     * @throws \Exception         When called.
     */
    public function offsetUnset($offset)
    {
        // Str is immutable, cannot directly unset char
        throw new \Exception('Str object is immutable, cannot unset char');
    }

    /**
     * Implements Icecave\Parity\SubClassComparableInterface compare method.
     *
     * @see https://git.io/vVxSz
     *
     * @param  object  $value The object to compare.
     *
     * @return integer        The result of the comparison.
     */
    public function compare($value)
    {
        return strcmp((string)$value, (string)$this);
    }

    /**
     * Returns a value indicating whether this instance is equal to another.
     *
     * @param  object  $value  The object to compare.
     *
     * @return boolean
     */
    public function equals($value)
    {
        return Parity::isEqualTo($this, $value);
    }
}
