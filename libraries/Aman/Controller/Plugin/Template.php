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
 * @version 	$Id: Template.php 0001 2011-02-7 12:00:40Z mehrab $
 * @since		1.0.0
 */

class Aman_Controller_Plugin_Template extends Zend_Controller_Plugin_Abstract 
{
	public function preDispatch(Zend_Controller_Request_Abstract $request) 
	{
		$config = Aman_Config::getConfig();
		
		/** 
		 * Support template
		 */
	
		$template = Zend_Registry::get(Aman_GlobalKey::APP_TEMPLATE);
		$design = Zend_Registry::get(Aman_GlobalKey::APP_DESIGN);
		
		$module 	= $request->getModuleName();
		$controller = strtolower($request->getControllerName());
		$action 	= strtolower($request->getActionName());	
		
		/**
		 * Check if we are in modules or widgets folder
		 */
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
		if (null === $viewRenderer->view) {
			$viewRenderer->initView();
		}
		$view = $viewRenderer->view;
		
		$path  = AMAN_DESIGN_DIR . DS . $design . DS . '%s' . DS . 'views' . DS . $module . DS . 'scripts';
		
		$file1 = sprintf($path,  $template) . DS . $controller . DS . $action . '.phtml';
		
		$file2 = sprintf($path, 'base') . DS . $controller . DS . $action . '.phtml';

		/**
		 * FIXED: Try to find the script in template first
		 */
		if(file_exists($file1)){
		    $view->addScriptPath(sprintf($path, $template) . DS);
		}
		else{
		    $view->addScriptPath(sprintf($path, 'base') . DS);
		}
		
	}
}
