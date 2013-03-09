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

class Aman_Hook_Config 
{
	/**
	 * Get hook information
	 * 
	 * @param string $hook Hook name
	 * @param string $module Module name
	 * @return array
	 */
	public static function getHookInfo($hook, $module = null) 
	{
		$hook = strtolower($hook);
		$file = (null == $module) 
				? AMAN_APP_DIR . DS . 'hooks' . DS . $hook . DS . 'about.xml'
				: AMAN_APP_DIR . DS . 'modules' . DS . $module . DS . 'hooks' . DS . $hook . DS . 'about.xml';
		return self::getHookInfoFromXml($file);
	}
	
	/**
	 * @param string $file
	 * @return array
	 */
	public static function getHookInfoFromXml($file) 
	{
		if (!file_exists($file)) {
			return null;
		}
		$xml = simplexml_load_file($file);
		return array(
			'name' 		  => strtolower($xml->name),
			'module' 	  => $xml->module,
			'description' => $xml->description,
			'thumbnail'   => $xml->thumbnail,
			'author' 	  => $xml->author,
			'email' 	  => $xml->email,
			'version' 	  => $xml->version,
			'license' 	  => $xml->license,
		);
	}

	/**
	 * Get hook params
	 * 
	 * @param string $hook
	 * @param string $module Name of module
	 * @return array
	 */
	public static function getParams($hook, $module = null) 
	{
		$hook = strtolower($hook);
		$file = (null == $module)  
			? AMAN_APP_DIR . DS . 'hooks' . DS . $hook . DS . 'config.xml'
			: AMAN_APP_DIR . DS . 'modules' . DS . $module . DS . 'hooks' . DS . $hook . DS . 'config.xml';
		if (!file_exists($file)) {
			return null;
		}
		$xml = simplexml_load_file($file);
		if ($xml->param == null || count($xml->param) == 0) {
			return null;
		}
		$params = array();
		foreach ($xml->param as $param) {
			$attr = $param->attributes();
			$params[] = array(
				'name' 		  => $attr['name'],
				'description' => (string)$param->description,
				'value' 	  => (string)$param->value,
			);
		}
		return $params;
	}
	
	/**
	 * Save configured params
	 * 
	 * @param array $params
	 * @param string $hook Name of hook
	 * @param string $module Name of module
	 */
	public static function saveParams($params, $hook, $module = null) 
	{
		$hook = strtolower($hook);
		$file = (null == $module)  
			? AMAN_APP_DIR . DS . 'hooks' . DS . $hook . DS . 'config.xml'
			: AMAN_APP_DIR . DS . 'modules' . DS . $module . DS . 'hooks' . DS . $hook . DS . 'config.xml';
		if (!file_exists($file)) {
			return null;
		}
		$xml = simplexml_load_file($file);
		foreach ($params as $key => $value) {
			$nodes = $xml->xpath('param[@name="'.addslashes($key).'"]');
			if ($nodes && is_array($nodes)) {
				$nodes[0]->value = $value;
			}
		}
		$xml->asXML($file);
	}
	
	/**
	 * Get hook targets of given module
	 * 
	 * @param string $module Name of module
	 * @return array
	 */
	public static function getTargetInfo($module) 
	{
		$file = AMAN_APP_DIR . DS . 'modules' . DS . $module . DS . 'config' . DS . 'hook.xml';
		if (!file_exists($file)) {
			return null;
		}
		$xml = simplexml_load_file($file);
		$items = $xml->targets;
		$items = $items[0];
		
		$targets = array();
		foreach ($items as $item) {
			$attr = $item->attributes();
			$targets[] = array(
				'target_module' => $module,
				'target_name' 	=> (string)$attr['name'],
				'description' 	=> (string)$item->description,
				'hook_type' 	=> (string)$attr['type'],
			);
		}
		return $targets;
	}
}
