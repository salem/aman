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
 * @version 	$Id: Widget.php 5248 2010-08-31 08:29:04Z mehrab $
 * @since		1.0.0
 */

class News_Widgets_Newer_Widget extends Aman_Widget 
{
	protected function _prepareShow() 
	{
		$articleId 	= $this->_request->getParam('article_id');
		$categoryId = $this->_request->getParam('category_id');
		$limit 		= $this->_request->getParam('limit', 15);
		
		$conn = Aman_Db_Connection::factory()->getSlaveConnection();
		$articleDao = Aman_Model_Dao_Factory::getInstance()->setModule('news')->getArticleDao();
		$articleDao->setDbConnection($conn);
		$article = $articleDao->getById($articleId);
		
		$dao = Aman_Model_Dao_Factory::getInstance()->setWidget($this)->getArticleDao();
		$dao->setDbConnection($conn);
		/**
		 * @since 2.0.8
		 */
		$dao->setLang($this->_request->getParam('lang'));
		
		$articles = $dao->getNewerArticles($limit, $article, $categoryId);
		
		$this->_view->assign('articles', $articles);
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
