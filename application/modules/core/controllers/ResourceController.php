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
 * @version 	$Id: ResourceController.php 4518 2010-08-12 09:35:54Z mehrab $
 * @since		1.0.0
 */

class Core_ResourceController extends Zend_Controller_Action 
{
	/* ========== Backend actions =========================================== */

	/**
	 * Add new resource
	 * 
	 * @return void
	 */
	public function addAction() 
	{
		$this->_helper->getHelper('viewRenderer')->setNoRender();
		$this->_helper->getHelper('layout')->disableLayout();
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$mc 		 = $request->getPost('mc');
			$description = $request->getPost('description');
			list($module, $controller) = explode(':', $mc);
			
			$resource = new Core_Models_Resource(array(
				'description' 	  => $description,
				'module_name' 	  => $module,
				'controller_name' => $controller,
			));
			$conn = Aman_Db_Connection::factory()->getMasterConnection();
			$resourceDao = Aman_Model_Dao_Factory::getInstance()->setModule('core')->getResourceDao();
			$resourceDao->setDbConnection($conn);
			$id = $resourceDao->add($resource);
			
			$data = array('success'=>true, 'message'=>sprintf($this->view->translator('privilege_list_add_resource_success'), $controller), 'id'=>$id);				
			$this->getResponse()->setBody(Zend_Json::encode($data));
		}
	}
	
	/**
	 * Delete resource
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
			$resourceDao = Aman_Model_Dao_Factory::getInstance()->setModule('core')->getResourceDao();
			$ruleDao	 = Aman_Model_Dao_Factory::getInstance()->setModule('core')->getRuleDao();
			$resourceDao->setDbConnection($conn);
			$ruleDao->setDbConnection($conn);
			
			$resource = $resourceDao->getById($id);
			$resourceName = implode(array($resource->module_name, $resource->controller_name), ':');
			$data = array(
			    'success'     => true,
			    'message'     => sprintf($this->view->translator('privilege_list_delete_resource_success'), $resource->controller_name),
				'mc' 		  => $resourceName, 
				'description' => $resource->description
			);
			$resourceDao->delete($id);
			
			/**
			 * Remove from rule
			 */ 
			$ruleDao->removeByResource($resourceName);
			
			$this->getResponse()->setBody(Zend_Json::encode($data));
		}
	}
}
