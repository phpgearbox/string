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

trait LongestCommon
{
    /**
     * Returns the longest common prefix between the string and $otherStr.
     *
     * @param  string $otherStr Second string for comparison
     *
     * @return static           String being the longest common prefix
     */
    public function longestCommonPrefix($otherStr)
    {
        $longestCommonPrefix = '';

        for ($i = 0; $i < min($this->getLength(), UTF8::strlen($otherStr, $this->encoding)); $i++)
        {
            $char = UTF8::substr($this->scalarString, $i, 1, $this->encoding);

            if ($char == UTF8::substr($otherStr, $i, 1, $this->encoding))
            {
                $longestCommonPrefix .= $char;
            }
            else
            {
                break;
            }
        }

        return $this->newSelf($longestCommonPrefix);
    }

    /**
     * Returns the longest common suffix between the string and $otherStr.
     *
     * @param  string $otherStr Second string for comparison
     *
     * @return static           String being the longest common suffix
     */
    public function longestCommonSuffix($otherStr)
    {
        $longestCommonSuffix = '';

        for ($i = 1; $i <= min($this->getLength(), UTF8::strlen($otherStr, $this->encoding)); $i++)
        {
            $char = UTF8::substr($this->scalarString, -$i, 1, $this->encoding);

            if ($char == UTF8::substr($otherStr, -$i, 1, $this->encoding))
            {
                $longestCommonSuffix = $char . $longestCommonSuffix;
            }
            else
            {
                break;
            }
        }

        return $this->newSelf($longestCommonSuffix);
    }

    /**
     * Returns the longest common substring between the string and $otherStr.
     * In the case of ties, it returns that which occurs first.
     *
     * @param  string $otherStr Second string for comparison
     *
     * @return static           String being the longest common substring
     */
    public function longestCommonSubstring($otherStr)
    {
        // Uses dynamic programming to solve
        // http://en.wikipedia.org/wiki/Longest_common_substring_problem

        $strLength = $this->getLength();
        $otherLength = UTF8::strlen($otherStr, $this->encoding);

        // Return if either string is empty
        if ($strLength == 0 || $otherLength == 0) return $this->newSelf('');

        $len = 0; $end = 0;
        $table = array_fill(0, $strLength + 1, array_fill(0, $otherLength + 1, 0));

        for ($i = 1; $i <= $strLength; $i++)
        {
            for ($j = 1; $j <= $otherLength; $j++)
            {
                $strChar = UTF8::substr($this->scalarString, $i - 1, 1, $this->encoding);
                $otherChar = UTF8::substr($otherStr, $j - 1, 1, $this->encoding);

                if ($strChar == $otherChar)
                {
                    $table[$i][$j] = $table[$i - 1][$j - 1] + 1;

                    if ($table[$i][$j] > $len)
                    {
                        $len = $table[$i][$j];
                        $end = $i;
                    }
                }
                else
                {
                    $table[$i][$j] = 0;
                }
            }
        }

        return $this->newSelf(UTF8::substr
        (
            $this->scalarString,
            $end - $len,
            $len,
            $this->encoding
        ));
    }
}
