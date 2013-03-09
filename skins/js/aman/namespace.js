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
 * @author salem
 * @copyright	Copyright (c) 2010-2012 KhanSoft Limited (http://www.khansoft.com)
 * @license		http://www.gnu.org/licenses/gpl-2.0.txt GNU GENERAL PUBLIC LICENSE Version 2
 * @version 	$Id: namespace.js 5496 2010-09-21 17:02:25Z mehrab $
 * @since		1.0.0
 */

/**
 * 
 * The AMAN Global object which should be present in every js file that use namespace
 * Example
 * <code>
 * AMAN.namesapce('x.y.z');
 * </code>
 * 
 */

var AMAN = new Object();

/**
 * Allow namespace
 * @param name
 * @param separator
 * @param container
 * @returns {Boolean}
 */
AMAN.namespace = function(name, separator, container){
  var ns = name.split(separator || '.'),
    o = container || window,
    i,
    len;
  for(i = 0, len = ns.length; i < len; i++){
    o = o[ns[i]] = o[ns[i]] || {};
  }
  return o;
};

/**
 * Check if the class exists or not
 * Usage:
 * 
 * 	AMAN.namespace('x.y.z');
 * 	if (!AMAN.isClassExist('x.y.z')) {
 * 		x.y.z = function(...) { ... };
 * 		
 * 		// Declare more prototypes of class here ...
 * 	}
 *
 */
AMAN.isClassExist = function(namesapce) {
	return eval('typeof ' + this) == 'function';
};