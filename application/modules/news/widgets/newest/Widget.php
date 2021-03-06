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
 * @version 	$Id: Widget.php 5345 2010-09-07 09:29:23Z mehrab $
 * @since		1.0.0
 */

class News_Widgets_Newest_Widget extends Aman_Widget 
{
	protected function _prepareShow() 
	{
		$limit      = (int) $this->_request->getParam('limit', 5);
		$categoryId = $this->_request->getParam('category_id', null);
		
		$conn = Aman_Db_Connection::factory()->getSlaveConnection();
		$articleDao = Aman_Model_Dao_Factory::getInstance()->setModule('news')->getArticleDao();
		$articleDao->setDbConnection($conn);
		
		/**
		 * @since 2.0.8
		 */
		$articleDao->setLang($this->_request->getParam('lang'));
		
		$exp = array('status' => 'active');
		if ($categoryId != null && $categoryId != '') {
			$exp['category_id'] = $categoryId;
		}
		$articles = $articleDao->find(0, $limit, $exp);
		
		$this->_view->assign('articles', $articles);
		
		/**
		 * @since 2.0.8
		 */
		$this->_view->assign('dateFormat', array(
			'DAY' 			=> $this->_view->translator()->widget('diff_day_format'),
			'DAY_HOUR'		=> $this->_view->translator()->widget('diff_day_hour_format'),
			'HOUR' 			=> $this->_view->translator()->widget('diff_hour_format'),
			'HOUR_MINUTE' 	=> $this->_view->translator()->widget('diff_hour_minute_format'),
			'MINUTE' 		=> $this->_view->translator()->widget('diff_minute_format'),
			'MINUTE_SECOND'	=> $this->_view->translator()->widget('diff_minute_second_format'),
			'SECOND'		=> $this->_view->translator()->widget('diff_second_format'),
		));
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
