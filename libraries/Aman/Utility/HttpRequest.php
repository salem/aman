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
 * @version 	$Id: HttpRequest.php 0001 2011-02-7 12:00:40Z mehrab $
 * @since		1.0.0
 */

class Aman_Utility_HttpRequest 
{
	public static function getResponse($url, $method = Zend_Http_Client::GET, $timeout = 300) 
	{
		try {
			$request = new Zend_Http_Client();
			$request->setConfig(array('timeout' => $timeout));
			$request->setUri($url);
			$request->setMethod($method);
			$content = $request->request()->getBody();
			return $content;
		} catch (Exception $ex) {
			/**
			 * Could not connect to $url 
			 */
			return null;
		}
	}
}
