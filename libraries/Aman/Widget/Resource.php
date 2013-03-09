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
 * @version 	$Id: Resource.php 0001 2011-02-7 12:00:40Z mehrab $
 * @since		1.0.0
 */

class Aman_Widget_Resource 
{
	public static function getResources($module, $widget) 
	{
		$ret  = array('javascript' => array(), 'css' => array());
		$file = AMAN_APP_DIR . DS . 'modules' . DS . $module . DS . 'widgets' . DS . $widget . DS . 'about.xml';
		if (!file_exists($file)) {
			return $ret;
		}
		$config = simplexml_load_file($file);
		if (($resources = $config->resources)) {
			if ($resources = $resources->resource) {
				foreach ($resources as $res) {
					$attr = $res->attributes();
					$ret[(string)$attr['type']][] = (string)$attr['src'];
				}
			}
		}
		return $ret;
	}
}
