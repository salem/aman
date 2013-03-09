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
 * @version 	$Id: Connection.php 0001 2011-02-7 12:00:40Z mehrab $
 * @since		1.0.0
 */

class Aman_Db_Connection
{
	/**
	 * @return Aman_Db_Connection_Abstract
	 */
	public static function factory()
	{
		$config  = Aman_Config::getConfig();
		$adapter = $config->db->adapter;
        $adapter = str_replace(' ', '_', ucwords(str_replace('_', ' ', strtolower($adapter))));
		$class 	 = 'Aman_Db_Connection_' . $adapter . '_Connection';
		if (!class_exists($class)) {
			throw new Exception('Does not support ' . $adapter . ' connection');
		}
		$instance = new $class($adapter);
		return $instance;
	}
}
