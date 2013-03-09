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
 * @version 	$Id: Config.php 0001 2011-02-7 12:00:40Z mehrab $
 * @since		1.0.0
 */

class Aman_Config 
{
	const KEY = 'Aman_Config_';
	
	/**
	 * Get application config object
	 * 
	 * @return Zend_Config
	 */
	public static function getConfig() 
	{
		$host = $_SERVER['SERVER_NAME'];
		$host = (substr($host, 0, 3) == 'www') ? substr($host, 4) : $host;

		$key = self::KEY.$host;
		if (!Zend_Registry::isRegistered($key)) {
			$defaultConfig = AMAN_APP_DIR . DS . 'config' . DS . 'application.ini';
			$hostConfig    = AMAN_APP_DIR . DS . 'config' . DS . $host . '.ini';
			
			$file 	= file_exists($hostConfig) ? $hostConfig : $defaultConfig;
			$config = new Zend_Config_Ini($file);
			Zend_Registry::set($key, $config);
		}
		
		return Zend_Registry::get($key);
	}
}
