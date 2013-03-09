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
 * @version 	$Id: util.js 5082 2010-08-29 12:07:45Z mehrab $
 * @since		2.0.7
 */

'Aman.Util'.namespace();

Aman.Util = function() {};

/**
 * Generate slug for given string
 * 
 * @param string str
 * @return string
 */
Aman.Util.generateSlug = function(str) {
	str = str.replace(/^\s+|\s+$/g, '');
  	var from = "Ãƒï¿½Ãƒâ‚¬Ã¡ÂºÂ Ã¡ÂºÂ¢ÃƒÆ’Ã„â€šÃ¡ÂºÂ®Ã¡ÂºÂ°Ã¡ÂºÂ¶Ã¡ÂºÂ²Ã¡ÂºÂ´Ãƒâ€šÃ¡ÂºÂ¤Ã¡ÂºÂ¦Ã¡ÂºÂ¬Ã¡ÂºÂ¨Ã¡ÂºÂªÃƒÂ¡ÃƒÂ Ã¡ÂºÂ¡Ã¡ÂºÂ£ÃƒÂ£Ã„Æ’Ã¡ÂºÂ¯Ã¡ÂºÂ±Ã¡ÂºÂ·Ã¡ÂºÂ³Ã¡ÂºÂµÃƒÂ¢Ã¡ÂºÂ¥Ã¡ÂºÂ§Ã¡ÂºÂ­Ã¡ÂºÂ©Ã¡ÂºÂ«ÃƒÂ³ÃƒÂ²Ã¡Â»ï¿½Ã¡Â»ï¿½ÃƒÂµÃƒâ€œÃƒâ€™Ã¡Â»Å’Ã¡Â»Å½Ãƒâ€¢ÃƒÂ´Ã¡Â»â€˜Ã¡Â»â€œÃ¡Â»â„¢Ã¡Â»â€¢Ã¡Â»â€”Ãƒâ€�Ã¡Â»ï¿½Ã¡Â»â€™Ã¡Â»ËœÃ¡Â»â€�Ã¡Â»â€“Ã†Â¡Ã¡Â»â€ºÃ¡Â»ï¿½Ã¡Â»Â£Ã¡Â»Å¸Ã¡Â»Â¡Ã†Â Ã¡Â»Å¡Ã¡Â»Å“Ã¡Â»Â¢Ã¡Â»Å¾Ã¡Â»Â ÃƒÂ©ÃƒÂ¨Ã¡ÂºÂ¹Ã¡ÂºÂ»Ã¡ÂºÂ½Ãƒâ€°ÃƒË†Ã¡ÂºÂ¸Ã¡ÂºÂºÃ¡ÂºÂ¼ÃƒÂªÃ¡ÂºÂ¿Ã¡Â»ï¿½Ã¡Â»â€¡Ã¡Â»Æ’Ã¡Â»â€¦ÃƒÅ Ã¡ÂºÂ¾Ã¡Â»â‚¬Ã¡Â»â€ Ã¡Â»â€šÃ¡Â»â€žÃƒÂºÃƒÂ¹Ã¡Â»Â¥Ã¡Â»Â§Ã…Â©ÃƒÅ¡Ãƒâ„¢Ã¡Â»Â¤Ã¡Â»Â¦Ã…Â¨Ã†Â°Ã¡Â»Â©Ã¡Â»Â«Ã¡Â»Â±Ã¡Â»Â­Ã¡Â»Â¯Ã†Â¯Ã¡Â»Â¨Ã¡Â»ÂªÃ¡Â»Â°Ã¡Â»Â¬Ã¡Â»Â®ÃƒÂ­ÃƒÂ¬Ã¡Â»â€¹Ã¡Â»â€°Ã„Â©Ãƒï¿½ÃƒÅ’Ã¡Â»Å Ã¡Â»Ë†Ã„Â¨ÃƒÂ½Ã¡Â»Â³Ã¡Â»ÂµÃ¡Â»Â·Ã¡Â»Â¹Ãƒï¿½Ã¡Â»Â²Ã¡Â»Â´Ã¡Â»Â¶Ã¡Â»Â¸Ã„ï¿½Ã„â€˜Ãƒâ€˜ÃƒÂ±Ãƒâ€¡ÃƒÂ§Ã‚Â·/_,:;";
  	var to   = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaooooooooooooooooooooooooooooooooooeeeeeeeeeeeeeeeeeeeeeeuuuuuuuuuuuuuuuuuuuuuuiiiiiiiiiiyyyyyyyyyyddnncc------";
  	
  	for (var i = 0, l = from.length ; i < l; i++) {
    	str = str.replace(new RegExp(from[i], "g"), to[i]);
  	}
  	str = str.replace(/[^a-zA-Z0-9 -]/g, '').replace(/\s+/g, '-').toLowerCase();
  	return str;
};
