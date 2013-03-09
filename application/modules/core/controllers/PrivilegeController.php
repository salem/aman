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
 * @version 	$Id: PrivilegeController.php 4517 2010-08-12 09:35:24Z mehrab $
 * @since		1.0.0
 */

class Core_PrivilegeController extends Zend_Controller_Action 
{
	/* ========== Backend actions =========================================== */

	/**
	 * Add new privilege
	 * 
	 * @return void
	 */
	public function addAction() 
	{
		$this->_helper->getHelper('viewRenderer')->setNoRender();
		$this->_helper->getHelper('layout')->disableLayout();
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$mca 		 = $request->getPost('mca');
			$description = $request->getPost('description');
			list($module, $controller, $action) = explode(':', $mca);
			
			$privilege = new Core_Models_Privilege(array(
				'name' 			  => $action,
				'description' 	  => $description,
				'module_name' 	  => $module,
				'controller_name' => $controller,
			));
			$conn = Aman_Db_Connection::factory()->getMasterConnection();
			$privilegeDao = Aman_Model_Dao_Factory::getInstance()->setModule('core')->getPrivilegeDao();
			$privilegeDao->setDbConnection($conn);
			$id = $privilegeDao->add($privilege);
			
			$data = array('success'=>true, 'message'=>sprintf($this->view->translator('privilege_list_add_success'), $description), 'id'=>$id);
			
			$this->getResponse()->setBody(Zend_Json::encode($data));
		}
	}
	
	/**
	 * Delete privilege
	 * 
	 * @return void
	 */
	public function deleteAction() 
	{
		$this->_helper->getHelper('viewRenderer')->setNoRender();
		$this->_helper->getHelper('layout')->disableLayout();
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$id = $request->getPost('id');
			$conn = Aman_Db_Connection::factory()->getMasterConnection();
			$privilegeDao = Aman_Model_Dao_Factory::getInstance()->setModule('core')->getPrivilegeDao();
			$ruleDao 	  = Aman_Model_Dao_Factory::getInstance()->setModule('core')->getRuleDao();
			$privilegeDao->setDbConnection($conn);
			$ruleDao->setDbConnection($conn);
			
			$privilege = $privilegeDao->getById($id);
			$data = array(
			    'success'     => true,
			    'message'     => sprintf($this->view->translator('privilege_list_delete_success'), $privilege->description),
				'mca' 		  => implode(array($privilege->module_name, $privilege->controller_name, $privilege->name), ':'), 
				'description' => $privilege->description,
			);
			$privilegeDao->delete($id);
			
			/**
			 * Remove from rule
			 */
			$ruleDao->removeRules($id);
			
			$this->getResponse()->setBody(Zend_Json::encode($data));
		}
	}
	
	/**
	 * List privileges
	 * 
	 * @return void
	 */
	public function listAction() 
	{
		$modules = Aman_Utility_File::getSubDir(AMAN_APP_DIR . DS . 'modules');
		
		$conn = Aman_Db_Connection::factory()->getMasterConnection();
		$resourceDao  = Aman_Model_Dao_Factory::getInstance()->setModule('core')->getResourceDao();
		$privilegeDao = Aman_Model_Dao_Factory::getInstance()->setModule('core')->getPrivilegeDao();
		$resourceDao->setDbConnection($conn);
		$privilegeDao->setDbConnection($conn);
		
		/**
		 * Get resources
		 */
		$rs = $resourceDao->getResources();
		$dbResources = array();
		if ($rs) {
			foreach ($rs as $row) {
				$dbResources[$row->module_name . ':' . $row->controller_name] = $row->resource_id;
			}
		}
		
		/**
		 * Get privileges
		 */
		$rs = $privilegeDao->getPrivileges();
		$dbPrivileges = array();
		if ($rs) {
			foreach ($rs as $row) {
				$dbPrivileges[$row->module_name . ':' . $row->controller_name . ':' . $row->name] = $row->privilege_id;
			}
		}
		
		$this->view->assign('modules', $modules);
		$this->view->assign('dbResources', $dbResources);
		$this->view->assign('dbPrivileges', $dbPrivileges);				
	}
}
