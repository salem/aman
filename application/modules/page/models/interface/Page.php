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
 * @version 	$Id: Page.php 4685 2010-08-16 08:54:12Z mehrab $
 * @since		2.0.7
 */

interface Page_Models_Interface_Page
{
	/**
	 * Get page by given Id
	 * 
	 * @param int $id Id of page
	 * @return Page_Models_Page
	 */
	public function getById($id);
	
	/**
	 * Add new page
	 * 
	 * @param Page_Models_Page $page
	 * @return int
	 */
	public function add($page);
	
	/**
	 * Update page
	 * 
	 * @param Page_Models_Page $page
	 * @return void
	 */
	public function update($page);
	
	/**
	 * Update page order
	 * 
	 * @param Page_Models_Page $page
	 * @return int
	 */
	public function updateOrder($page);
	
	/**
	 * Delete page
	 * 
	 * @param Page_Models_Page $page
	 * @return void
	 */
	public function delete($page);
	
	/**
	 * Build pages tree with depth for each item
	 * 
	 * @return Aman_Model_RecordSet
	 */
	public function getTree();
	
	/**
	 * Get parent pages
	 * 
	 * @param int $pageId Id of page
	 * @return Aman_Model_RecordSet
	 */
	public function getParents($pageId);
	
	/**
	 * Get translable items which haven't been translated of the default language
	 * 
	 * @since 1.0.1
	 * @param string $lang
	 * @return Aman_Model_RecordSet
	 */
	public function getTranslatable($lang);
	
	/**
	 * Get translation item which was translated to given page
	 * 
	 * @since 1.0.1
	 * @param Page_Models_Page $page
	 * @return Page_Models_Page
	 */
	public function getSource($page);	
}
