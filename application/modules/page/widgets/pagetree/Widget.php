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
 * @version 	$Id: Widget.php 4711 2010-08-16 17:55:13Z mehrab $
 * @since		2.0.7
 */

class Page_Widgets_PageTree_Widget extends Aman_Widget
{
	protected function _prepareShow() 
	{
		$conn = Aman_Db_Connection::factory()->getSlaveConnection();
		$pageDao = Aman_Model_Dao_Factory::getInstance()->setModule('page')->getPageDao();
		$pageDao->setDbConnection($conn);
		
		/**
		 * @since 1.0.1
		 */
		$pageDao->setLang($this->_request->getParam('lang'));
		
		$pages = $pageDao->getTree();
		
		$this->_view->assign('pages', $pages);
	}	
}
