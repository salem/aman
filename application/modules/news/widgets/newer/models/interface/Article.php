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
 * @version 	$Id: Article.php 3351 2010-06-28 06:15:32Z mehrab $
 * @since		2.0.5
 */

interface News_Widgets_Newer_Models_Interface_Article
{
	/**
	 * Get list of articles which are newer than given article
	 * 
	 * @param int $limit
	 * @param News_Models_Article $article
	 * @param int $categoryId Id of category
	 * @return Aman_Model_RecordSet
	 */
	public function getNewerArticles($limit, $article = null, $categoryId = null);
}
