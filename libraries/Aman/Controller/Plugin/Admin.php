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
 * @version 	$Id: Admin.php 4442 2010-08-10 17:44:43Z mehrab $
 * @since		1.0.0
 */

class Aman_Controller_Plugin_Admin extends Zend_Controller_Plugin_Abstract 
{
	public function preDispatch(Zend_Controller_Request_Abstract $request) 
	{
		$uri = $request->getRequestUri();
		$uri = rtrim($uri, '/');
		if (strpos(strtolower($uri) . '/', '/admin/') === false) {
			return;
		}
		
		/**
		 * Auto switch to admin layout
		 */
		if (Zend_Layout::getMvcInstance() != null) {
			Zend_Layout::getMvcInstance()->setLayout('admin');
		}
	}
}
