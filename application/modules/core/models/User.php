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
 * @version 	$Id: User.php 5478 2010-09-20 09:59:05Z mehrab $
 * @since		1.0.0
 */

/**
 * Represents an user
 */
class Core_Models_User extends Aman_Model_Entity 
{
	protected $_properties = array(
		'user_id' 		 => null,	/** Id of user */
		'name' 	 		 => null,	/** name of user */
		'password' 		 => null,	/** Password of user */
		'email' 		 => null,	/** Email address of user */
		'office'		 => null,	/** office phone of user */
		'home'			 => null,	/** home phone of user */
		'mobile'		 => null,	/** mobile phone of user */
	  	'address'		 => null,	/** address of user */
  		'language'		 => null,	/** language of user */
  		'customer_id'	 => null,	/** customer of user */
		'client_id'		 => null,	/** client of of user */
		'self_id'		 => null,	/** user belong to user */
		'group'		 	 => null,	/** group of user */
		'is_active' 	 => null,	/** Defines user's activation status. Can be 0 (not activated) or 1 (activated) */
		'created_date' 	 => null,	/** User's creation date */
		'logged_in_date' => null,	/** The last logged in date */
		'is_online' 	 => null,	/** Online status. Can be 0 (offline) or 1 (online) */
		'role_id' 		 => null,	/** Id of role that user belong to */
	);
}
