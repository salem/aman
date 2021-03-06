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
 * @version 	$Id: Widget.php 3971 2010-07-25 10:26:42Z mehrab $
 * @since		1.0.0
 */

class Core_Widgets_SkinSelector_Widget extends Aman_Widget 
{
	protected function _prepareShow() 
	{
		$config   = Aman_Config::getConfig();
		$template = $config->web->template;
		$this->_view->assign('currSkin', $config->web->skin);
		
		$file = AMAN_APP_DIR . DS . 'templates' . DS . $template . DS . 'about.xml';
		if (file_exists($file)) {
			$xml   = new Zend_Config_Xml($file);
			$skins = $xml->skins;
			$this->_view->assign('skins', $skins);
		}
	}
}
