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
 * @version 	$Id: Loader.php 0001 2011-02-7 12:00:40Z mehrab $
 * @since		1.0.0
 */

class Aman_Module_Loader 
{
	/**
	 * @var Aman_Module_Loader
	 */
	private static $_instance;
	
	/**
	 * @var array
	 */
	private $_moduleNames;
	
	/**
	 * @return Aman_Module_Loader
	 */
	public static function getInstance() 
	{
		if (null == self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;		
	}
	
	private function __construct() 
	{
		$this->_moduleNames = $this->_getModules();
	}
	
	public function getModuleNames() 
	{
		return $this->_moduleNames;
	}
	
	/**
	 * @return Zend_Controller_Router_Interface
	 */
	public function getRoutes() 
	{
		if (null == $this->_moduleNames) {
			return;
		}
		$router = new Zend_Controller_Router_Rewrite();
		
		foreach ($this->_moduleNames as $name) {
			$configFiles = $this->_loadRouteConfigs($name);
			
			foreach ($configFiles as $file) {
				$config = new Zend_Config_Ini($file, 'routes');
				$router->addConfig($config, 'routes');
			}
		}
		
		return $router;
	}
	
	/**
	 * @return array
	 */
	private function _getModules() 
	{
		return Aman_Utility_File::getSubDir(AMAN_APP_DIR . DS . 'modules');
	}
	
	/**
	 * @return array
	 */
	private function _loadRouteConfigs($moduleName) 
	{
		$dir = AMAN_APP_DIR . DS . 'modules' . DS . $moduleName . DS . 'config' . DS . 'routes';
		if (!is_dir($dir)) {
			return array();
		}
		
		$configFiles = array();
		
		$dirIterator = new DirectoryIterator($dir);
		foreach ($dirIterator as $file) {
            if ($file->isDot() || $file->isDir()) {
                continue;
            }
            $name = $file->getFilename();
            if (preg_match('/^[^a-z]/i', $name) || ('CVS' == $name) 
            		|| ('.svn' == strtolower($name))) {
                continue;
            }
            $configFiles[] = $dir . DS . $name;
        }
		
		return $configFiles;
	}	
}
