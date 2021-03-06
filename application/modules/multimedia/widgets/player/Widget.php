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
 * @version 	$Id: Widget.php 5250 2010-08-31 08:49:09Z mehrab $
 * @since		1.0.0
 */

class Multimedia_Widgets_Player_Widget extends Aman_Widget 
{
	protected function _prepareShow() 
	{
		$limit 	= $this->_request->getParam('limit', 9);
		
		$conn = Aman_Db_Connection::factory()->getSlaveConnection();
		$fileDao = Aman_Model_Dao_Factory::getInstance()->setModule('multimedia')->getFileDao();
		$fileDao->setDbConnection($conn);
		$files = $fileDao->find(0, $limit, array(
									'is_active'	=> true,
									'file_type' => 'video',		
								));
    	
    	$this->_view->assign('files', $files);
	}
}
