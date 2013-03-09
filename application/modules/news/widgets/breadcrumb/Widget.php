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
 * @version 	$Id: Widget.php 4716 2010-08-17 02:47:53Z mehrab $
 * @since		1.0.0
 */

class News_Widgets_Breadcrumb_Widget extends Aman_Widget 
{
	protected function _prepareShow() 
	{
		$categoryId = $this->_request->getParam('category_id');
		
		$conn = Aman_Db_Connection::factory()->getSlaveConnection();
		$categoryDao = Aman_Model_Dao_Factory::getInstance()->setModule('category')->getCategoryDao();
		$categoryDao->setDbConnection($conn);
		
		$lang = $this->_request->getParam('lang');
		$this->_view->assign('lang', ($lang == $this->_view->APP_DEFAULT_LANG) ? '' : '/' . $lang . '/');
		
		if ($categoryId != null && $categoryId != '') {
			$categories = $categoryDao->getParents($categoryId);
			$this->_view->assign('categories', $categories);
		}
	}
	
	protected function _prepareConfig() 
	{
		$conn = Aman_Db_Connection::factory()->getMasterConnection();
		$categoryDao = Aman_Model_Dao_Factory::getInstance()->setModule('category')->getCategoryDao();
		$categoryDao->setDbConnection($conn);
		$categories = $categoryDao->getTree();
		
		$this->_view->assign('categories', $categories); 
	}
}
