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

/**
 * String Builder Class.
 *
 * This class is modeled off the .NET C# version.
 * @see https://goo.gl/utVtKG
 *
 * There is much debate about performance of such String Builders in PHP.
 * Most suggest PHP simply doesn't need such a class because strings are
 * mutable and for the most part I completely agree.
 * @see http://stackoverflow.com/questions/124067
 *
 * However this is not a performance thing for me, personally I just like the
 * API that the C# StringBuilder class provides. Coming back to PHP development
 * after a lengthy .NET project, it was one of many things I missed.
 *
 * Also the main Gears\String\Str class is immutable anyway.
 *
 * @package Gears\String
 */
class Builder
{
    protected $str;

    public function __construct($string = '')
    {
        if ($string instanceof Str)
        {
            $this->str = $string;
        }
        elseif (is_string((string)$string))
        {
            $this->str = new Str((string)$string);
        }
        else
        {
            throw new \InvalidArgumentException
            (
                '$string must be either a scalar string '.
                'or an instance of \\Gears\\String\\Str'
            );
        }
    }

    public function append($string)
    {
        return $this;
    }

    public function appendFormat($format, $args)
    {
        return $this;
    }

    public function appendLine($string = '', $type = "\n")
    {
        return $this;
    }

    public function clear()
    {
        return $this;
    }

    public function equals($string)
    {
        // investigate this: https://github.com/IcecaveStudios/parity
        return true;
    }

    public function insert($pos, $string)
    {
        return $this;
    }

    public function remove($start, $length)
    {
        return $this;
    }

    public function replace($old, $new)
    {
        return $this;
    }

    public function __toString()
    {
        return (string)$this->str;
    }
}
