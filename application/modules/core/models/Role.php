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
 * @version 	$Id: Role.php 5477 2010-09-20 09:59:00Z mehrab $
 * @since		1.0.0
 */

/**
 * Represents an user role
 */
class Core_Models_Role extends Aman_Model_Entity 
{
	protected $_properties = array(
		'role_id' 	  => null,		/** Id of role */
		'name' 		  => null,		/** Name of role */
		'description' => null,		/** Description of role */
	
		/**
		 * Lock status.
		 * Can not set the role permissions if the it is locked. 
		 */
		'locked' 	  => null,	
	);
}
