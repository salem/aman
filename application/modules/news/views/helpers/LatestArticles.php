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
 * @version 	$Id: LatestArticles.php 4551 2010-08-12 10:29:42Z mehrab $
 */

class News_View_Helper_LatestArticles extends Zend_View_Helper_Abstract 
{
	public function latestArticles($categoryId, $limit = 5) 
	{
		$conn = Aman_Db_Connection::factory()->getSlaveConnection();
		$articleDao = Aman_Model_Dao_Factory::getInstance()->setModule('news')->getArticleDao();
		$articleDao->setDbConnection($conn);
		return $articleDao->getByCategory($categoryId, 0, $limit);
	}
}
