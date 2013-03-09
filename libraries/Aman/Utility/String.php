<?php
/**
 * AmanCMS
 * 
 * LICENSE
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE Version 2 
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-2.0.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@amancms.com so we can send you a copy immediately.
 * 
 * @copyright	Copyright (c) 2010-2012 KhanSoft Limited (http://www.khansoft.com)
 * @license		http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @version 	$Id: String.php 4032 2010-07-27 01:44:26Z leha $
 * @since		1.0.0
 */

class Aman_Utility_String 
{
	public static function normalizeUri($uri) 
	{
		if ($uri == null) {
			return null;
		}
		$uri = ltrim($uri, '/');
		return rtrim($uri, '/');
	}
	
	public static function removeSign($string, $seperator = '-', $allowANSIOnly = false) 
	{
		$pattern = array(
						"a" => "ÃƒÂ¡|ÃƒÂ |Ã¡ÂºÂ¡|Ã¡ÂºÂ£|ÃƒÂ£|Ãƒï¿½|Ãƒâ‚¬|Ã¡ÂºÂ |Ã¡ÂºÂ¢|ÃƒÆ’|Ã„Æ’|Ã¡ÂºÂ¯|Ã¡ÂºÂ±|Ã¡ÂºÂ·|Ã¡ÂºÂ³|Ã¡ÂºÂµ|Ã„â€š|Ã¡ÂºÂ®|Ã¡ÂºÂ°|Ã¡ÂºÂ¶|Ã¡ÂºÂ²|Ã¡ÂºÂ´|ÃƒÂ¢|Ã¡ÂºÂ¥|Ã¡ÂºÂ§|Ã¡ÂºÂ­|Ã¡ÂºÂ©|Ã¡ÂºÂ«|Ãƒâ€š|Ã¡ÂºÂ¤|Ã¡ÂºÂ¦|Ã¡ÂºÂ¬|Ã¡ÂºÂ¨|Ã¡ÂºÂª",
						"o" => "ÃƒÂ³|ÃƒÂ²|Ã¡Â»ï¿½|Ã¡Â»ï¿½|ÃƒÂµ|Ãƒâ€œ|Ãƒâ€™|Ã¡Â»Å’|Ã¡Â»Å½|Ãƒâ€¢|ÃƒÂ´|Ã¡Â»â€˜|Ã¡Â»â€œ|Ã¡Â»â„¢|Ã¡Â»â€¢|Ã¡Â»â€”|Ãƒâ€�|Ã¡Â»ï¿½|Ã¡Â»â€™|Ã¡Â»Ëœ|Ã¡Â»â€�|Ã¡Â»â€“|Ã†Â¡|Ã¡Â»â€º|Ã¡Â»ï¿½|Ã¡Â»Â£|Ã¡Â»Å¸|Ã¡Â»Â¡|Ã†Â |Ã¡Â»Å¡|Ã¡Â»Å“|Ã¡Â»Â¢|Ã¡Â»Å¾|Ã¡Â»Â ",
						"e" => "ÃƒÂ©|ÃƒÂ¨|Ã¡ÂºÂ¹|Ã¡ÂºÂ»|Ã¡ÂºÂ½|Ãƒâ€°|ÃƒË†|Ã¡ÂºÂ¸|Ã¡ÂºÂº|Ã¡ÂºÂ¼|ÃƒÂª|Ã¡ÂºÂ¿|Ã¡Â»ï¿½|Ã¡Â»â€¡|Ã¡Â»Æ’|Ã¡Â»â€¦|ÃƒÅ |Ã¡ÂºÂ¾|Ã¡Â»â‚¬|Ã¡Â»â€ |Ã¡Â»â€š|Ã¡Â»â€ž",
						"u" => "ÃƒÂº|ÃƒÂ¹|Ã¡Â»Â¥|Ã¡Â»Â§|Ã…Â©|ÃƒÅ¡|Ãƒâ„¢|Ã¡Â»Â¤|Ã¡Â»Â¦|Ã…Â¨|Ã†Â°|Ã¡Â»Â©|Ã¡Â»Â«|Ã¡Â»Â±|Ã¡Â»Â­|Ã¡Â»Â¯|Ã†Â¯|Ã¡Â»Â¨|Ã¡Â»Âª|Ã¡Â»Â°|Ã¡Â»Â¬|Ã¡Â»Â®",
						"i" => "ÃƒÂ­|ÃƒÂ¬|Ã¡Â»â€¹|Ã¡Â»â€°|Ã„Â©|Ãƒï¿½|ÃƒÅ’|Ã¡Â»Å |Ã¡Â»Ë†|Ã„Â¨",
						"y" => "ÃƒÂ½|Ã¡Â»Â³|Ã¡Â»Âµ|Ã¡Â»Â·|Ã¡Â»Â¹|Ãƒï¿½|Ã¡Â»Â²|Ã¡Â»Â´|Ã¡Â»Â¶|Ã¡Â»Â¸",
						"d" => "Ã„â€˜|Ã„ï¿½",
						"c" => "ÃƒÂ§",
					);
		while ((list($key, $value) = each($pattern)) != false) {
			$string = preg_replace('/' . $value . '/i', $key, $string);	
		}
		if ($allowANSIOnly) {
			$string = strtolower($string);
			$string = preg_replace('/(\w*)(\W+)/i', "$1".$seperator, $string);
		}
		return $string;
	}
}
