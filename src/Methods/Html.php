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

trait Html
{
	/**
	 * Escapes html
	 *
	 * @return static
	 */
	public function htmlEscape()
	{
		return $this->newSelf
		(
			UTF8::htmlspecialchars
			(
				$this->scalarString,
				ENT_QUOTES | ENT_SUBSTITUTE,
				$this->encoding
			)
		);
	}

    /**
	 * Convert all HTML entities to their applicable characters.
	 *
	 * @param  int|null $flags Optional flags
	 *
	 * @return static   String with the resulting $str after being html decoded.
	 */
	public function htmlDecode($flags = ENT_COMPAT)
	{
		return $this->newSelf
		(
			UTF8::html_entity_decode
			(
				$this->scalarString,
				$flags,
				$this->encoding
			)
		);
	}

	/**
	 * Convert all applicable characters to HTML entities.
	 *
	 * @param  int|null $flags Optional flags
	 *
	 * @return static   String with the resulting $str after being html encoded.
	 */
	public function htmlEncode($flags = ENT_COMPAT)
	{
		return $this->newSelf
		(
			UTF8::htmlentities
			(
				$this->scalarString,
				$flags,
				$this->encoding
			)
		);
	}

    /**
     * remove xss from html
     *
     * @return static
     */
    public function htmlXssClean()
    {
		static $antiXss = null;

		if ($antiXss === null)
		{
			if (class_exists('\\voku\\helper\\AntiXSS'))
			{
				$antiXss = new voku\helper\AntiXSS();
			}
			else
			{
				throw new \RuntimeException
				(
					"This method requires \voku\helper\AntiXSS. ".
					"Install with: composer require voku/anti-xss"
				);
			}
		}

		return $this->newSelf($antiXss->xss_clean($this->scalarString));
    }

    /**
     * remove html
     *
     * @param $allowableTags
     *
     * @return static
     */
    public function htmlStripTags($allowableTags = null)
    {
		return $this->newSelf
		(
			UTF8::strip_tags($this->scalarString, $allowableTags)
		);
    }
}
