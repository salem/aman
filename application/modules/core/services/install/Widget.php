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
 * @version 	$Id: Widget.php 3748 2010-07-17 11:48:19Z mehrab $
 * @since		2.0.3
 */

/**
 * Install all widgets belong to given module
 */
class Core_Services_Install_Widget
{
	/**
	 * @var Core_Models_Interface_Widget
	 */
	private $_widgetInterface;
	
	/**
	 * Set widget interface
	 * 
	 * @param Core_Models_Interface_Widget $dao
	 */
	public function setWidgetInterface($dao) 
	{
		$this->_widgetInterface = $dao;
	}
	
	/**
	 * Install all widgets in module
	 * 
	 * @param string $module Name of module
	 */
	public function install($module) 
	{
		/**
		 * Load all widgets from module
		 */
		$widgetDirs = Aman_Utility_File::getSubDir(AMAN_APP_DIR . DS . 'modules' . DS . $module . DS . 'widgets');
		if (0 == count($widgetDirs)) {
			return;
		}
		foreach ($widgetDirs as $widgetName) {
			$info = Aman_Widget_Config::getWidgetInfo($module, $widgetName);
			if ($info != null) { 				
				$widget = new Core_Models_Widget($info);
				$this->_widgetInterface->add($widget);
			}
		}
	}
}
