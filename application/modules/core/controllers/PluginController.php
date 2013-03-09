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
 * @version 	$Id: PluginController.php 4535 2010-08-12 09:51:49Z mehrab $
 * @since		1.0.0
 */

class Core_PluginController extends Zend_Controller_Action 
{
	/* ========== Backend actions =========================================== */

	/**
	 * Configure plugin
	 * 
	 * @return void
	 */
	public function configAction() 
	{
		$this->_helper->getHelper('viewRenderer')->setNoRender();
		$this->_helper->getHelper('layout')->disableLayout();
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$plugin = $request->getPost('plugin');
			$params = $request->getPost('params');
			$params = Zend_Json::decode($params);
			Aman_Plugin_Config::saveParams($plugin, $params);
			
			$data = array('success'=>true, 'message'=>sprintf($this->view->translator('plugin_list_save_config_success'), $plugin));
			
			
			$this->getResponse()->setBody(Zend_Json::encode($data));
		}
	}
	
	/**
	 * Install plugin
	 * 
	 * @return void
	 */
	public function installAction() 
	{
		$this->_helper->getHelper('viewRenderer')->setNoRender();
		$this->_helper->getHelper('layout')->disableLayout();
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$name = $request->getPost('name');
			$info = Aman_Plugin_Config::getPluginInfo($name);
			if ($info) {
				$conn = Aman_Db_Connection::factory()->getMasterConnection();
				$pluginDao = Aman_Model_Dao_Factory::getInstance()->setModule('core')->getPluginDao();
				$pluginDao->setDbConnection($conn);
				$id = $pluginDao->add(new Core_Models_Plugin($info));
				
				/**
				 * Perform the action when plugin is activated
				 */
				$pluginClass = 'Plugins_' . $name . '_Plugin';
				if (class_exists($pluginClass)) {
					$plugin = new $pluginClass();
					$plugin->activate();
				}
				$data = array(
				            'success'=>true, 
				            'message'=>sprintf($this->view->translator('plugin_list_install_success'), $name),
				            'name'=>$name,'id'=>$id);
				$this->getResponse()->setBody(Zend_Json::encode($data));
			} else {
			    $data = array(
			    		'success'=>false,
			    		'message'=>sprintf($this->view->translator('Can not install plugin %s'), $name),
			    		);
				$this->getResponse()->setBody(Zend_Json::encode($data));
			}
		}
	}
	
	/**
	 * List plugins
	 * 
	 * @return void
	 */
	public function listAction() 
	{
		$plugins = array();
		$subDirs = Aman_Utility_File::getSubDir(AMAN_APP_DIR . DS . 'plugins');
		foreach ($subDirs as $pluginName) {
			$info = Aman_Plugin_Config::getPluginInfo($pluginName);
			if (null == $info) {
				continue;
			}
			$plugin = new Core_Models_Plugin($info);
			$plugin->params = Aman_Plugin_Config::getParams($pluginName); 
			$plugins[] = $plugin;
			
		}
		
		/**
		 * Get the list of plugins from database
		 */
		$dbPlugins = array();
		
		$conn = Aman_Db_Connection::factory()->getMasterConnection();
		$pluginDao = Aman_Model_Dao_Factory::getInstance()->setModule('core')->getPluginDao();
		$pluginDao->setDbConnection($conn);
		$rs = $pluginDao->getOrdered();
		if ($rs) {
			foreach ($rs as $row) {
				$key = strtolower($row->name); 
				$dbPlugins[$key] = $key . ':' . $row->plugin_id;
			}
		}
		
		$this->view->assign('plugins', $plugins);
		$this->view->assign('dbPlugins', $dbPlugins);
	}
	
	/**
	 * Uninstall plugin
	 * 
	 * @return void
	 */
	public function uninstallAction() 
	{
		$this->_helper->getHelper('viewRenderer')->setNoRender();
		$this->_helper->getHelper('layout')->disableLayout();
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$name = $request->getPost('name');
			$id   = $request->getPost('id');
			
			$conn = Aman_Db_Connection::factory()->getMasterConnection();
			$pluginDao = Aman_Model_Dao_Factory::getInstance()->setModule('core')->getPluginDao();
			$pluginDao->setDbConnection($conn);
			$pluginDao->delete($id);
			
			/**
			 * Perform the action when plugin is deactivated
			 */
			$pluginClass = 'Plugins_' . $name . '_Plugin';
			if (class_exists($pluginClass)) {
				$plugin = new $pluginClass();
				$plugin->deactivate();
				
				
			}
			
			$data = array(
					'success'=>true,
					'message'=>sprintf($this->view->translator('plugin_list_uninstall_success'), $name),
					'name'=>$name);
			$this->getResponse()->setBody(Zend_Json::encode($data));
		}
	}
	
	/**
	 * Upload new plugin
	 * 
	 * @return void
	 */
	public function uploadAction() 
	{
		$this->_helper->getHelper('viewRenderer')->setNoRender();
		$this->_helper->getHelper('layout')->disableLayout();
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$file 	 = $_FILES['file'];
			$prefix  = 'plugin_' . time();
			$zipFile = AMAN_TEMP_DIR . DS . $prefix . $file['name'];
			move_uploaded_file($file['tmp_name'], $zipFile);
			
			/**
			 * Process uploaded file
			 */
			$zip = Aman_Zip::factory($zipFile);
			$res = $zip->open();
			if ($res === true) {
				$tempDir = AMAN_TEMP_DIR . DS . $prefix;
				if (!file_exists($tempDir)) {
					mkdir($tempDir);
				}
				$zip->extract($tempDir);
				
				/**
				 * Get the first (and only) sub-forder 
				 */
				$subDirs = Aman_Utility_File::getSubDir($tempDir);
				$xml 	 = $tempDir . DS . $subDirs[0] . DS . 'about.xml';
				$info 	 = Aman_Plugin_Config::getPluginInfoFromXml($xml);
				if ($info) {
					$plugin = new Core_Models_Plugin($info);
					
					/**
					 * TODO: Check whether the plugin was already installed
					 */					
					$conn = Aman_Db_Connection::factory()->getMasterConnection();
					$pluginDao = Aman_Model_Dao_Factory::getInstance()->setModule('core')->getPluginDao();
					$pluginDao->setDbConnection($conn);
					$id = $pluginDao->add($plugin);
					
					/**
					 * Copy to the plugins directory
					 */
					$pluginDir = AMAN_APP_DIR . DS . 'plugins' . DS . $plugin->name;
					Aman_Utility_File::copyRescursiveDir($tempDir . DS . $subDirs[0], $pluginDir);
				} else {
					/**
					 * TODO: Still add the plugin information to database without its about file
					 */
				}
				
				/**
				 * Remove all the temp files
				 */
				$zip->close();
				
				Aman_Utility_File::deleteRescursiveDir($tempDir);
				unlink($zipFile);
			}
			
			$this->_redirect($this->view->serverUrl() . $this->view->url(array(), 'core_plugin_list'));
		}
	}
}
