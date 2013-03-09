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
 * @version 	$Id: Hook.php 4688 2010-08-16 09:32:47Z mehrab $
 * @since		2.0.7
 */

class Page_Hooks_PageLinks_Hook extends Aman_Hook
{
	/**
	 * @param array $links
	 * @param string $lang (since 1.0.1)
	 * @return array
	 */
	public static function filter($links, $lang)
	{
		/**
		 * Get the view instance
		 */
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
		$view = $viewRenderer->view;
		
		$conn = Aman_Db_Connection::factory()->getMasterConnection();
		$pageDao = Aman_Model_Dao_Factory::getInstance()->setModule('page')->getPageDao();
		$pageDao->setDbConnection($conn);
		$pageDao->setLang($lang);
		$pages = $pageDao->getTree();
		
		if ($pages != null) {
			foreach ($pages as $page) {
				$links['page_page_details'][] = array(
					'title' => str_repeat('---', $page->depth) . ' ' . $page->name,
					'href'  => $view->url($page->getProperties(), 'page_page_details'),
				);
			}
		}
		
		return $links;
	}
}
