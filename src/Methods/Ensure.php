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

trait Ensure
{
    /**
     * Ensures that the string begins with $substring.
     *
     * @param  string $substring The substring to add if not present.
     *
     * @return static            The string prefixed by the $substring.
     */
    public function ensureLeft($substring)
    {
        if ($this->startsWith($substring))
        {
            return $this;
        }
        else
        {
            return $this->newSelf($substring.$this->scalarString);
        }
    }

    /**
     * Ensures that the string ends with $substring.
     *
     * @param  string $substring The substring to add if not present.
     *
     * @return static            The string suffixed by the $substring.
     */
    public function ensureRight($substring)
    {
        if ($this->endsWith($substring))
        {
            return $this;
        }
        else
        {
            return $this->newSelf($this->scalarString.$substring);
        }
    }
}
