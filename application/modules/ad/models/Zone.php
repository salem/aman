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
 * @version 	$Id: Zone.php 5470 2010-09-20 08:30:02Z mehrab $
 * @since		1.0.0
 */

/**
 * Represents a zone
 */
class Ad_Models_Zone extends Aman_Model_Entity 
{
	protected $_properties = array(
		'zone_id' 	  => null,	/** Id of zone */
		'width' 	  => null,	/** Width of zone (in pixel) */
		'height' 	  => null,	/** Height of zone (in pixel) */
		'name' 		  => null,	/** Name of zone */
		'description' => null,	/** Description of zone */
	);
}
