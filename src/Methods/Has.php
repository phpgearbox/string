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

trait Has
{
    /**
     * Does the string have at least one lower case character?
     *
     * @return bool Whether or not the string contains a lower case character.
     */
    public function hasLowerCase()
    {
        return $this->regexMatch('.*[[:lower:]]');
    }

    /**
     * Does the string have at least one upper case character?
     *
     * @return bool Whether or not the string contains an upper case character.
     */
    public function hasUpperCase()
    {
        return $this->regexMatch('.*[[:upper:]]');
    }
}
