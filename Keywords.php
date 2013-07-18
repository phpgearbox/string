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

class Keywords
{
	private $string;
	
	private $maxWords;
	
	private $commonWords = array
	(
		'able', 'about', 'after', 'again', 'all', 'also', 'and', 'any','are',
		'bad', 'been', 'before', 'being', 'between', 'but', 'came', 'can',
		'cause', 'change', 'come', 'could', 'did', 'differ', 'different',
		'does', 'don', 'down', 'each', 'end', 'even', 'every', 'far', 'few',
		'for', 'form', 'found', 'four', 'from', 'get', 'good', 'great', 'had',
		'has', 'have', 'her', 'here', 'him', 'his', 'how', 'into', 'its', 
		'just', 'keep', 'let', 'many', 'may', 'might', 'more', 'most', 'much',
		'must', 'near', 'need', 'never', 'new', 'next', 'not', 'now', 'off',
		'one', 'only', 'other', 'our', 'out', 'over', 'part', 'put', 'said',
		'same', 'say', 'seem', 'set', 'should', 'side', 'some', 'still', 'such',
		'take', 'than', 'that', 'the', 'their', 'them', 'then', 'there',
		'these', 'they', 'thing', 'this', 'three', 'through', 'too', 'two',
		'upon', 'use', 'very', 'was', 'way', 'went', 'were', 'what', 'when',
		'where', 'which', 'while', 'who', 'will', 'with', 'would', 'you',
		'your'
	);
	
	public function __construct($string, $maxWords = false)
	{
		$this->string = $string;
		$this->maxWords = $maxWords;
	}
	
	public function generate()
	{
		// Convert all text to lower case
		$text = strtolower($this->string);
		
		// Remove the HTML Tags that strip_tags doesn't
		$text = preg_replace
		(
			array
			(
				// Remove invisible content
				'@<head[^>]*?>.*?</head>@siu',
				'@<style[^>]*?>.*?</style>@siu',
				'@<script[^>]*?.*?</script>@siu',
				'@<object[^>]*?.*?</object>@siu',
				'@<embed[^>]*?.*?</embed>@siu',
				'@<applet[^>]*?.*?</applet>@siu',
				'@<noframes[^>]*?.*?</noframes>@siu',
				'@<noscript[^>]*?.*?</noscript>@siu',
				'@<noembed[^>]*?.*?</noembed>@siu',
				
				// Add line breaks before and after blocks
				'@</?((address)|(blockquote)|(center)|(del))@iu',
				'@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
				'@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
				'@</?((table)|(th)|(td)|(caption))@iu',
				'@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
				'@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
				'@</?((frameset)|(frame)|(iframe))@iu'
			),
			array
			(
				' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
				"\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
				"\n\$0", "\n\$0"
			),
			$text
		);
		
		// Remove HTML Tags
		$text = strip_tags($text);
		
		// Remove un-needed charcters
		$text = str_replace
		(
			array
			(
				'1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
				',', ')', '(', '.', '"', "'", '`', '-', '*', '...',
				'+', ';', ':', '/', '\\', '_', '?', '&amp;', '&nbsp;',
				'&rsquo;', '&reg;', '&ndash;', '&trade;'
			),
			'',
			$text
		);
		
		// Remove un-needed whitespace
		$text = BTB_String::init($text)->trim();
		
		// Create words array
		$words = array();
		foreach (split(" ", $text) as $possible_word)
		{
			$keyword = trim($possible_word);
			if (strlen($keyword) > 4)
			{
				$found = false;
				foreach ($this->commonWords as $commonword)
				{
					if ($keyword == $commonword) $found = true;
				}
				if (!$found) $words[] = $keyword;
			}
		}
		
		// Create Frequencey Array
		$freqarray = array();
		foreach ($words as $word)
		{
			if ($word != '')
			{
				if (ISSET($freqarray[$word])) $freqarray[$word] += 1;
				else $freqarray[$word] = 1;
			}
		} arsort($freqarray);
		
		// Create keywords csv string
		$keywords = ''; $i = 0;
		foreach ($freqarray as $word => $freq)
		{
			if ($this->maxWords)
			{
				if ($i < $maxWords) $keywords .= $word . ',';
			}
			else
			{
				$keywords .= $word . ',';
			}
			$i++;
		} $keywords = substr($keywords, 0, -1);
		
		return $keywords;
	}
}
