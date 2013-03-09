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
 * @version 	$Id: ArticleIcons.php 3060 2010-05-26 07:56:08Z mehrab $
 * @since		2.0.3
 */

/**
 * This helper show image and/or clip icons of article 
 */
class News_View_Helper_ArticleIcons extends Zend_View_Helper_Abstract 
{
	/**
	 * @param string $icons
	 * @return string
	 */
	public function articleIcons($icons) 
	{
		if (null === $icons) {
			return '';
		}
		$this->view->assign('icons', $icons);
		$this->view->addScriptPath(AMAN_APP_DIR . DS . 'modules' . DS . 'news' . DS . 'views' . DS . 'scripts');
		return $this->view->render('_partial/_icons.phtml');
	}
}
