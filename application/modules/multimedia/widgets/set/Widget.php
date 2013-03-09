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
 * @version 	$Id: Widget.php 5143 2010-08-30 06:21:12Z mehrab $
 * @since		2.0.8
 */

class Multimedia_Widgets_Set_Widget extends Aman_Widget 
{
	protected function _prepareShow() 
	{
		$setId = $this->_request->getParam('set_id', 10);
		$limit = $this->_request->getParam('limit', 10);
		
		$conn = Aman_Db_Connection::factory()->getSlaveConnection();
		$setDao = Aman_Model_Dao_Factory::getInstance()->setModule('multimedia')->getSetDao();
		$fileDao = Aman_Model_Dao_Factory::getInstance()->setModule('multimedia')->getFileDao();
		$setDao->setDbConnection($conn);
		$fileDao->setDbConnection($conn);
		
		$set   = $setDao->getById($setId);
		$files = $fileDao->getFilesInSet($setId, null, null, true);
		
		$this->_view->assign('set', $set);
		$this->_view->assign('files', $files);
	}
	
	protected function _prepareConfig()
	{
		$conn = Aman_Db_Connection::factory()->getMasterConnection();
		$setDao = Aman_Model_Dao_Factory::getInstance()->setModule('multimedia')->getSetDao();
		$setDao->setDbConnection($conn);
		
		$user = Zend_Auth::getInstance()->getIdentity();
		$sets = $setDao->find(null, null, array('created_user_id' => $user->user_id, 'is_active' => 1));
		
		$this->_view->assign('sets', $sets);
	}
}
