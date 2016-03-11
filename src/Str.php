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

class Str extends Base
{
	use Methods\To;
	use Methods\Is;
	use Methods\Pad;
	use Methods\Misc;
	use Methods\Html;
	use Methods\Regx;
	use Methods\Remove;
	use Methods\Ensure;
	use Methods\IndexOf;
	use Methods\Replace;
	use Methods\Contains;
	use Methods\FirstLast;
	use Methods\StartEndWith;
	use Methods\LongestCommon;
	use Methods\CaseManipulators;
}
