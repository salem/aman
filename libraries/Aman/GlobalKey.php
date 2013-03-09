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
 * @version 	$Id: GlobalKey.php 0001 2011-02-7 12:00:40Z mehrab $
 * @since		1.0.0
 */

class Aman_GlobalKey 
{
	/**
	 * If you do not want to log the HTTP request (by Core_Controllers_Plugin_RequestLogger plugin), 
	 * set this key to false in your controller action 
	 */
	const LOG_REQUEST  = 'Aman_GlobalKey_Log_Request';
	
	/**
	 * Use to set/get application template.
	 */
	const APP_TEMPLATE = 'Aman_GlobalKey_App_Template';
	
	/**
	 * Use to set/get application front end or back end 
	 */
	const APP_DESIGN = 'Aman_GlobalKey_App_Design';
	/**
	 * Use to set/get application theme.
	 */
	const APP_THEME    = 'Aman_GlobalKey_App_Theme';
}
