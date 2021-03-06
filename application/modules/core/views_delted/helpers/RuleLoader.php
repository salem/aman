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
 * @version 	$Id: RuleLoader.php 4537 2010-08-12 09:53:42Z mehrab $
 * @since		1.0.0
 */

class Core_View_Helper_RuleLoader extends Zend_View_Helper_Abstract 
{
	public function ruleLoader() 
	{
		return $this;
	}
	
	public function getResources($module) 
	{
		$conn = Aman_Db_Connection::factory()->getMasterConnection();
		$resourceDao = Aman_Model_Dao_Factory::getInstance()->setModule('core')->getResourceDao();
		$resourceDao->setDbConnection($conn);
		return $resourceDao->getResources($module);
	}
	
	public function getByRole($resource, $roleId) 
	{
		$conn = Aman_Db_Connection::factory()->getMasterConnection();
		$privilegeDao = Aman_Model_Dao_Factory::getInstance()->setModule('core')->getPrivilegeDao();
		$privilegeDao->setDbConnection($conn);
		return $privilegeDao->getByRole($resource, $roleId);
	}
	
	public function getByUser($resource, $userId) 
	{
		$conn = Aman_Db_Connection::factory()->getMasterConnection();
		$privilegeDao = Aman_Model_Dao_Factory::getInstance()->setModule('core')->getPrivilegeDao();
		$privilegeDao->setDbConnection($conn);
		return $privilegeDao->getByUser($resource, $userId);		
	}
}
