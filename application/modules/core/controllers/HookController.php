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
 * @version 	$Id: HookController.php 3971 2010-07-25 10:26:42Z mehrab $
 * @since		1.0.0
 */

class Core_HookController extends Zend_Controller_Action 
{
	/* ========== Backend actions =========================================== */
	
	/**
	 * Configure hook
	 * 
	 * @return void
	 */
	public function configAction() 
	{
		$this->_helper->getHelper('viewRenderer')->setNoRender();
		$this->_helper->getHelper('layout')->disableLayout();
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$module = $request->getPost('mod');
			
			if ('_' == $module) {
				/**
				 * We are saving config for global hook
				 */
				$module = null;
			}
			
			$hook 	= $request->getPost('name');
			$params = $request->getPost('params');
			$params = Zend_Json::decode($params);
			Aman_Hook_Config::saveParams($params, $hook, $module);
			$data = array('success'=>true, 'message'=>sprintf($this->view->translator('hook_list_save_config_success'), $hook));
			$this->getResponse()->setBody(Zend_Json::encode($data));
		}
	}
	
	/**
	 * Install hook
	 * 
	 * @return void
	 */	
	public function installAction() 
	{
		$this->_helper->getHelper('viewRenderer')->setNoRender();
		$this->_helper->getHelper('layout')->disableLayout();
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$module = $request->getPost('mod');
			$name 	= $request->getPost('name');
			
			if ('_' == $module) {
				/**
				 * We're going to install global hook
				 */
				$module = null;
			}
			
			$info = Aman_Hook_Config::getHookInfo($name, $module);
			if ($info) {
				$hook = new Core_Models_Hook($info);
				$conn = Aman_Db_Connection::factory()->getMasterConnection();
				$hookDao = Aman_Model_Dao_Factory::getInstance()->setModule('core')->getHookDao();
				$hookDao->setDbConnection($conn);
				$id = $hookDao->install($hook);
				
				$data = array('success'=>true, 'message'=>sprintf($this->view->translator('hook_list_install_success'), $name), 'hook'=>($module == null)?'_':$module . ':' . $name . ':' . $id);
				
				$this->getResponse()->setBody(Zend_Json::encode($data));
			} else {
			    $data = array('success'=>false, 'message'=>$this->view->translator('An error occure while instaling hook'));
				$this->getResponse()->setBody(Zend_Json::encode($data));
			}
		}
	}
	
	/**
	 * List hooks
	 * 
	 * @return void
	 */
	public function listAction() 
	{
		$hooks = array(
			/**
			 * Store global hooks which can be used to apply for multiple modules
			 */
			'_' => array(),
		);
		
		/**
		 * Get global hooks
		 */
		$modules = array();
		$subDirs = Aman_Utility_File::getSubDir(AMAN_APP_DIR . DS . 'hooks');
		foreach ($subDirs as $hookName) {
			$info = Aman_Hook_Config::getHookInfo($hookName);
			if (null == $info) {
				continue;
			}
			$hook 		  = new Core_Models_Hook($info);
			$hook->params = Aman_Hook_Config::getParams($hookName); 
			$hooks['_'][] = $hook;
			
			if (!in_array('_', $modules)) {
				$modules[] = '_';
			}
		}
		
		/**
		 * Get hooks from modules
		 */
		$subDirs = Aman_Utility_File::getSubDir(AMAN_APP_DIR . DS . 'modules');
		foreach ($subDirs as $module) {
			$hooks[$module] = array();
			$subDirs = Aman_Utility_File::getSubDir(AMAN_APP_DIR . DS . 'modules' . DS . $module . DS . 'hooks');
			foreach ($subDirs as $hookName) {
				$info = Aman_Hook_Config::getHookInfo($hookName, $module);
				if ($info != null) {
					$hook 			  = new Core_Models_Hook($info);
					$hook->params 	  = Aman_Hook_Config::getParams($hookName, $module); 
					$hooks[$module][] = $hook;
					$modules[]		  = $module;
				}
			}
		}
		
		$conn = Aman_Db_Connection::factory()->getMasterConnection();
		$hookDao = Aman_Model_Dao_Factory::getInstance()->setModule('core')->getHookDao();
		$hookDao->setDbConnection($conn);
		$rs = $hookDao->getHooks();
		$dbHooks = array();
		if ($rs) {
			foreach ($rs as $row) {
				$key = ((null == $row->module || '' == $row->module) ? '_' : $row->module)
						. ':' . strtolower($row->name);
				$dbHooks[$key] 	= $key . ':' . $row->hook_id;
			}
		}
		
		$this->view->assign('modules', $modules);
		$this->view->assign('hooks', $hooks);
		$this->view->assign('dbHooks', $dbHooks);
	}

	/**
	 * Uninstall hook
	 * 
	 * @return void
	 */
	public function uninstallAction() 
	{
		$this->_helper->getHelper('viewRenderer')->setNoRender();
		$this->_helper->getHelper('layout')->disableLayout();
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$module = $request->getPost('mod');
			$name 	= $request->getPost('name');
			$id 	= $request->getPost('id');
			$hook 	= new Core_Models_Hook(array(
				'hook_id' => $id,
				'module'  => ('_' == $module) ? null : $module,
				'name' 	  => $name,
			));
			
			$conn = Aman_Db_Connection::factory()->getMasterConnection();
			$hookDao = Aman_Model_Dao_Factory::getInstance()->setModule('core')->getHookDao();
			$hookDao->setDbConnection($conn);
			$hookDao->uninstall($hook);
			$data = array('success'=>true, 'message'=>sprintf($this->view->translator('hook_list_uninstall_success'), $name), 'hook'=>$module . ':' . $name);
			$this->getResponse()->setBody(Zend_Json::encode($data));
		}
	}
	
	/**
	 * Upload new hook
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
			$prefix  = 'hook_'.time();
			$zipFile = AMAN_TEMP_DIR . DS . $prefix.$file['name'];
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
				$info 	 = Aman_Hook_Config::getHookInfoFromXml($xml);
				
				if ($info) {
					$hook = new Core_Models_Hook($info);
					$conn = Aman_Db_Connection::factory()->getMasterConnection();
					$hookDao = Aman_Model_Dao_Factory::getInstance()->setModule('core')->getHookDao();
					$hookDao->setDbConnection($conn);
					
					/**
					 * Check whether the hook was already installed
					 */
					if (!$hookDao->exist($hook)) {
						$id = $hookDao->add($hook);
						
						/**
						 * Copy to the hooks directory
						 */
						$hookDir = AMAN_APP_DIR . DS . 'hooks' . DS . $hook->name;
						Aman_Utility_File::copyRescursiveDir($tempDir . DS . $subDirs[0], $hookDir);
					}
				} else {
					/**
					 * TODO: Still add the hook information to database without its about file
					 */
				}
				
				/**
				 * Remove all the temp files
				 */
				$zip->close();
				
				Aman_Utility_File::deleteRescursiveDir($tempDir);
				unlink($zipFile);
			}
			
			$this->_redirect($this->view->serverUrl() . $this->view->url(array(), 'core_hook_list'));
		}
	}	
}
