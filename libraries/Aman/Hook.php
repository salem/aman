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
 * @version 	$Id: Hook.php 0001 2011-02-7 12:00:40Z mehrab $
 * @since		1.0.0
 */

class Aman_Hook 
{
	protected $_params = null;
	
	public function __construct() 
	{
		$class = get_class($this);
		$pos   = strrpos($class, '_');
		/**
		 * 5 is length of Aman_
		 */
		$dir   = strtolower(substr($class, 5, $pos - 5));
		$file  = AMAN_APP_DIR . DS . str_replace('_', DS, $dir) . DS . 'config.xml';
		if (!file_exists($file)) {
			return;
		}
		$this->_params = simplexml_load_file($file);
	}

	/**
	 * Call when user activate the hook
	 */
	public function activate() 
	{
	}
	
	/**
	 * Call when user deactivate the hook
	 */
	public function deactivate() 
	{
	}
	
	public function getParam($paramName) 
	{
		if (null == $this->_params) {
			return null;
		}
		$xml = $this->_params->xpath("//param[@name='".addslashes($paramName)."']");
		return $xml ? $xml[0]->value : null;
	}
}
