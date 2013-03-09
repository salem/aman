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
 * @version 	$Id: Bootstrap.php 5497 2010-09-22 01:41:08Z mehrab $
 * @since		2.0.3
 */

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	/**
	 * Register auto loader
	 * 
	 * @return void
	 */
	protected function _initAutoload()
	{
		$autoloader = Zend_Loader_Autoloader::getInstance();
		/**
		 * FIXME: The following loader do not work
		 * <code>
		 * $namespaces = array('Hooks_', 'Plugins_');
		 * foreach ($modules as $module) {
		 * 		$namespaces[] = ucfirst($module) . '_';
		 * }
		 * $autoloader->unshiftAutoloader(new Aman_Autoloader(), $namespaces);
		 * </code>
		 */		
		
		$modules = Aman_Module_Loader::getInstance()->getModuleNames();
		new Aman_Autoloader(array(
    			'basePath'  => AMAN_APP_DIR,
    			'namespace' => 'Hooks_',
			));
		new Aman_Autoloader(array(
    			'basePath'  => AMAN_APP_DIR,
    			'namespace' => 'Plugins_',
			));
		foreach ($modules as $module) {
			new Aman_Autoloader(array(
    			'basePath'  => AMAN_APP_DIR . DS . 'modules' . DS . $module,
    			'namespace' => ucfirst($module) . '_',
			));
		}

		require_once 'htmlpurifier/HTMLPurifier/Bootstrap.php';
		HTMLPurifier_Bootstrap::registerAutoload();
		
		return $autoloader;
	}

	/**
	 * Redirect to the install page if user have not installed yet
	 * 
	 * @since 2.0.3
	 * @return void
	 */
	protected function _initInstallChecker()
	{
		$config = Aman_Config::getConfig();
		if (null == $config->install || null == $config->install->date) {
			header('Location: install.php');
			exit;
		}
	}
	
	/**
	 * Init routes
	 * 
	 * @return void
	 */
	protected function _initRoutes()
	{
		$this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        
		$routes = Aman_Module_Loader::getInstance()->getRoutes();
		$front->setRouter($routes);
		
		/**
		 * Don't use default route
		 */
		$front->getRouter()->removeDefaultRoutes();
	}
	
	/**
	 * Init session
	 * 
	 * @return void
	 */
	protected function _initSession()
	{
		/** 
		 * Registry session handler 
		 */
		Zend_Session::setSaveHandler(Core_Services_SessionHandler::getInstance());
		
		/**
		 * Allow user to set more session settings in application.ini
		 * For example:
		 * session.cookie_lifetime = "3600"
		 * session.cookie_domain   = ".domain.ext"
		 * @since 2.0.9
		 */
		Zend_Session::setOptions(Aman_Config::getConfig()->web->session->toArray());
		
		if (isset($_GET['PHPSESSID'])) {
			session_id($_GET['PHPSESSID']);
		} else if (isset($_POST['PHPSESSID'])) {
			session_id($_POST['PHPSESSID']);
		}
	}
	
	/**
	 * Add action helpers
	 * 
	 * @since 2.0.7
	 * @return void
	 */
	protected function _initActionHelpers()
	{
		/**
		 * Protect forms/pages from CSRF attacks
		 */
		Zend_Controller_Action_HelperBroker::addHelper(new Aman_Controller_Action_Helper_Csrf());
		Zend_Controller_Action_HelperBroker::addPath(AMAN_LIB_DIR . DS . 'Aman' . DS . 'Controller' . DS . 'Action' . DS . 'Helper',
													 'Aman_Controller_Action_Helper');
	}
	
	/**
	 * Register plugins
	 * 
	 * @return void
	 */
	protected function _initPlugins()
	{
		$this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        
		/** 
		 * Register plugins
		 * The alternative way is that put plugin to /application/config/application.ini:
		 * resources.frontController.plugins.pluginName = "Plugin_Class"
		 */
        
        //->registerPlugin(new Aman_Controller_Plugin_Admin())
		$front->registerPlugin(new Core_Controllers_Plugin_Init())				
		 		->registerPlugin(new Aman_Controller_Plugin_Template())
		 		->registerPlugin(new Core_Controllers_Plugin_HookLoader())
		 		->registerPlugin(new Core_Controllers_Plugin_Auth())
		 		
		 		/**
		 		 * @since 2.0.7
		 		 */
		 		->registerPlugin(new Core_Controllers_Plugin_Permalink())
		 		
		 		/**
		 		 * @since 1.0.1
		 		 */
		 		->registerPlugin(new Aman_Controller_Plugin_LocalizationRoute());
		//TODO: Add difrent context for out put
		 		//->registerPlugin(new REST_Controller_Plugin_RESTHandler());
		/**
		 * Error handler
		 */
		$front->registerPlugin(new Zend_Controller_Plugin_ErrorHandler(array(
								    'module' 	 => 'core',
								    'controller' => 'message',
								    'action'     => 'error',
								)));
		$conn = Aman_Db_Connection::factory()->getSlaveConnection();
		$pluginDao = Aman_Model_Dao_Factory::getInstance()->setModule('core')->getPluginDao();
		$pluginDao->setDbConnection($conn);
		$plugins = $pluginDao->getOrdered();
		
		foreach ($plugins as $plugin) {
			$pluginClass = 'Plugins_'.$plugin->name.'_Plugin';
			if (class_exists($pluginClass)) {
				$pluginInstance = new $pluginClass();
				if ($pluginInstance instanceof Aman_Controller_Plugin) {
					$front->registerPlugin($pluginInstance);
				}
			} else {
//				throw new Aman_Plugin_Exception('Plugin '.$plugin->name.' not found');
			}
		}
	}
}
