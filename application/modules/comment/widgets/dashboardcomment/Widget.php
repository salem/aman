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
 * @version 	$Id: Widget.php 4530 2010-08-12 09:44:52Z mehrab $
 * @since		2.0.7
 */

class Comment_Widgets_DashboardComment_Widget extends Aman_Widget_Dashboard 
{
	protected function _prepareShow()
	{
		$limit = $this->_request->getParam('limit', 5);
		
		$conn = Aman_Db_Connection::factory()->getMasterConnection();
		$commentDao = Aman_Model_Dao_Factory::getInstance()->setModule('comment')->getCommentDao();
		$commentDao->setDbConnection($conn);
		$comments = $commentDao->getLatest(0, $limit, false);
		
		$this->_view->assign('comments', $comments);
	}
}
