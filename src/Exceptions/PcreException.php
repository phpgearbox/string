<?php namespace Gears\String\Exceptions;
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

class PcreException extends \RuntimeException
{
    public function __construct()
    {
        $errorCode = preg_last_error();
        $categorisedConstants = get_defined_constants(true);
        $pcreConstants = array_flip($categorisedConstants['pcre']);
        $errorMessage = $pcreConstants[$errorCode];
        parent::__construct($errorMessage, $errorCode);
    }
}
