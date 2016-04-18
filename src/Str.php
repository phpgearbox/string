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
 * Str Class
 *
 * One of the motivations behind this project was that the original "Stringy"
 * class was just so ridiculously long @ 1800+ lines and 85 odd methods.
 *
 * I wanted to see if it could be built using traits to provide some sort of
 * organisation to the methods. This class simply lists all the traits that
 * now provide the functionality that the old "Stringy" used to.
 *
 * Naturally I have added some of my own methods and made other modifications...
 *
 * @package Gears\String
 */
class Str extends Base
{
    use Methods\To;
    use Methods\Is;
    use Methods\Pad;
    use Methods\Has;
    use Methods\Misc;
    use Methods\Html;
    use Methods\Regx;
    use Methods\Trim;
    use Methods\Remove;
    use Methods\Ensure;
    use Methods\Between;
    use Methods\IndexOf;
    use Methods\Replace;
    use Methods\Truncate;
    use Methods\Contains;
    use Methods\FirstLast;
    use Methods\StartEndWith;
    use Methods\LongestCommon;
    use Methods\CaseManipulators;
}
