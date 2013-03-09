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
 * @version 	$Id: Cache.php 0001 2011-02-7 12:00:40Z mehrab $
 * @since		1.0.0
 */

class Aman_Cache 
{
	/**
	 * Get global cache instance
	 * 
	 * @return Zend_Cache_Core
	 */
	public static function getInstance() 
	{
		$config = Aman_Config::getConfig();
		if (!isset($config->cache->frontend) || !isset($config->cache->backend)) {
			return null;
		}
		$frontendOptions = $config->cache->frontend->options->toArray();
		$backendOptions  = $config->cache->backend->options->toArray();
		$frontendOptions = self::_replaceConst($frontendOptions);
		$backendOptions  = self::_replaceConst($backendOptions);
		
		return Zend_Cache::factory($config->cache->frontend->name, $config->cache->backend->name,
			$frontendOptions, $backendOptions);
	}
	
	private static function _replaceConst($options) 
	{
		$search 	= array('{DS}', '{AMAN_TEMP_DIR}');
		$replace 	= array(DS, AMAN_TEMP_DIR);
		$newOptions = array();
		foreach ($options as $key => $value) {
			$newOptions[$key] = str_replace($search, $replace, $value);
		}
		return $newOptions;
	}
}
