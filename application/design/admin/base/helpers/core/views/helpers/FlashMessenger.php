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
 * @version 	$Id: FlashMessenger.php 3971 2010-07-25 10:26:42Z mehrab $
 * @since		1.0.0
 */

class Core_View_Helper_FlashMessenger extends Zend_View_Helper_Abstract 
{
	public function flashMessenger() 
	{
		//$this->view->addScriptPath(Zend_Layout::getMvcInstance()->getLayoutPath());
		//$this->view->addScriptPath(AMAN_APP_DIR . DS . 'modules' . DS . 'core' . DS . 'views' . DS . 'scripts');
		
		$flashMsgHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
		$this->view->assign('messages', $flashMsgHelper->getMessages()); 
		//echo var_dump($this->view->getScriptPaths());die();
		return $this->view->render('_partial' . DS . '_messages.phtml', 'core');
	}
}
