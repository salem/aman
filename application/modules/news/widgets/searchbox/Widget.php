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
 * @version 	$Id: Widget.php 4296 2010-08-03 18:00:57Z mehrab $
 * @since		1.0.0
 */

class News_Widgets_SearchBox_Widget extends Aman_Widget 
{
	protected function _prepareShow() 
	{
		$limit = $this->_request->getParam('limit', 10);
		
		$this->_view->assign('limit', $limit);
		$this->_view->assign('unid', uniqid());
	}
}
