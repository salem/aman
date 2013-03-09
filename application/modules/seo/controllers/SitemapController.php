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
 * @version 	$Id: SitemapController.php 3977 2010-07-25 11:32:32Z mehrab $
 * @since		2.0.7
 */

class Seo_SitemapController extends Zend_Controller_Action
{
	/* ========== Backend actions =========================================== */
	
	/**
	 * Add link to sitemap
	 * 
	 * @return void
	 */
	public function addAction()
	{
		$request = $this->getRequest();
		if ($request->isPost()) {
			$loc 		= $request->getPost('url');			
			$priority 	= $request->getPost('priority');
			$changefreq = $request->getPost('frequency');
			
			$item = new Aman_Seo_Sitemap_Item($loc, $changefreq, $priority);
			$file = AMAN_ROOT_DIR . DS . 'sitemap.xml';
			Aman_Seo_Sitemap::addToSitemap($file, $item);
			
			$this->_helper->getHelper('FlashMessenger')
					->addMessage($this->view->translator('sitemap_add_success'));
			$this->_redirect($this->view->serverUrl() . $this->view->url(array(), 'seo_sitemap_add'));
		}
	}
	
	/**
	 * Remove link from sitemap
	 * 
	 * @return void
	 */
	public function deleteAction() 
	{
		$this->_helper->getHelper('layout')->disableLayout();
		$this->_helper->getHelper('viewRenderer')->setNoRender();
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$urls = $request->getPost('urls');
			
			if (count($urls) > 0) {
				$file  = AMAN_ROOT_DIR . DS . 'sitemap.xml';
				$items = Aman_Seo_Sitemap::getItems($file);
				
				$decodedUrls = array();
				foreach ($urls as $url) {
					$decodedUrls[] = urldecode($url);
				}
				
				foreach ($items as $index => $item) {
					if (in_array($item->getLoc(), $decodedUrls)) {
						unset($items[$index]);
					}
				}
				
				Aman_Seo_Sitemap::save($file, $items);
			}
			
			$this->_helper->getHelper('FlashMessenger')
				->addMessage($this->view->translator('sitemap_delete_success'));
			$this->_redirect($this->view->serverUrl() . $this->view->url(array(), 'seo_sitemap_index'));
		}		
	}
	
	/**
	 * List all links in sitemap
	 * 
	 * @return void
	 */
	public function indexAction()
	{				
		$file = AMAN_ROOT_DIR . DS . 'sitemap.xml';
		if (!file_exists($file)) {
			$this->view->assign('notFound', true);
			return;
		}
		
		$items = Aman_Seo_Sitemap::getItems($file);
		
		$this->view->assign('items', $items);
		$this->view->assign('content', file_get_contents($file));
		$this->view->assign('lastModified', filemtime($file));
	}	
}
