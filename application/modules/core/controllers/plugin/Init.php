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
 * @version 	$Id: Init.php 5023 2010-08-28 09:36:48Z mehrab $
 * @since		1.0.0
 */

class Core_Controllers_Plugin_Init extends Zend_Controller_Plugin_Abstract 
{
	public function preDispatch(Zend_Controller_Request_Abstract $request) 
	{
		$config = Aman_Config::getConfig();
		
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
		if (null === $viewRenderer->view) {
			$viewRenderer->initView();
		}
		$view = $viewRenderer->view;
		
		/**
		 * TODO: set template path here
		 */
		/**
		 * Set theme for site
		 * User can change skin at real time
		 * Check whether user set skin cookie or not
		 */
		//$skin = (isset($_COOKIE['APP_SKIN'])) ? $_COOKIE['APP_SKIN'] : $config->web->skin;
		$skin = $config->web->skin;
		
		
		/**
		 * get template from config
		 */
		
		$template = $config->web->template;
		
		/**
		 * check front end or admin
		*/
		$uri = $request->getRequestUri();
		$uri = rtrim($uri, '/');
		
		$design = '';
		$currentemplate = '';
		
		if (strpos(strtolower($uri) . '/', '/admin/') === false) {
			Zend_Registry::set(Aman_GlobalKey::APP_TEMPLATE, $template->frontend);
			Zend_Registry::set(Aman_GlobalKey::APP_DESIGN, 'frontend');
			$view->assign('APP_TEMPLATE', $template->frontend);
			$view->assign('APP_SKIN', $skin->frontend);
			$view->assign('APP_DESIGN', 'frontend');
			$design = 'frontend';
			$currentemplate = $template->frontend;
		}
		else{
			Zend_Registry::set(Aman_GlobalKey::APP_TEMPLATE, $template->admin);
			Zend_Registry::set(Aman_GlobalKey::APP_DESIGN, 'admin');
			$view->assign('APP_TEMPLATE', $template->admin);
			$view->assign('APP_SKIN', $skin->admin);
			$view->assign('APP_DESIGN', 'admin');
			$design = 'admin';
			$currentemplate = $template->admin;
		}
		
		$module = $request->getModuleName();
		$controller = $request->getControllerName();
		$action = $request->getActionName();
		
		$view->doctype('XHTML1_STRICT');
		/**
		 * Set Helpers path
		 * By default application will search for helpers in the Aman/view/helper and design/admin/base/helpers/core/view/helpers directory
		 * we will also add to search for helper in the 
		 * design/admin/current-template/helpers/current-module/views/helpers directory 
		 */
		
		$view->addHelperPath(AMAN_LIB_DIR . DS . 'Aman' . DS . 'View' . DS . 'Helper', 'Aman_View_Helper');
		$view->addHelperPath(AMAN_APP_DIR . DS . 'design' . DS . 'admin' . DS. 'base' . DS . 'helpers' . DS . 'core' . DS. 'views' . DS . 'helpers', 'Core_View_Helper');
		if($template->admin != 'base')
		    $view->addHelperPath(AMAN_APP_DIR . 'design' . DS . 'admin' . DS . $template->admin . DS . 'helpers' . DS . 'views' . DS . 'helpers', ucfirst($template->admin).'_'.ucfirst($module).'_View_Helper' );
		if($module != 'core'){		
		//add module helper path
			$view->addHelperPath(AMAN_APP_DIR . DS . 'design' . DS. 'admin' . DS . 'base' . DS . 'helpers' . DS . $module . 'views' . DS . 'helpers', ucfirst($module).'_View_Helper');
		}
		
		//add script path
		$view->addScriptPath(AMAN_APP_DIR . DS . 'design' . DS . $design . DS . $currentemplate . DS . 'views' . DS . $module . DS . 'scripts' );
		$view->addScriptPath(AMAN_APP_DIR . DS . 'design' . DS . $design . DS . $currentemplate . DS . 'views' . DS . 'core' . DS . 'scripts' );
		$view->addScriptPath(AMAN_APP_DIR . DS . 'design' . DS . $design . DS . 'base' . DS . 'views' . DS . 'core' . DS . 'scripts');
		$view->addScriptPath(AMAN_APP_DIR . DS . 'design' . DS . $design . DS . 'base');
		
		/**
		 * Set base URL
		 */
		
		$view->getHelper('BaseUrl')->setBaseUrl($config->web->url->base);
		
		/**
		 * Append meta tags
		 */
		$view->headMeta()->appendName('description', $config->web->meta->description);
		$view->headMeta()->appendName('keywords', $config->web->meta->keyword);

		/** 
		 * Set timezone
		 */
		date_default_timezone_set($config->web->datetime->timezone);
		
		
		$view->assign('APP_URL', $config->web->url->base);
		$view->assign('APP_STATIC_SERVER', $config->web->url->static);
		$view->assign('SITE_NAME', $config->web->name);
		
		/**
		 * Get charset from configuration file
		 * @since 2.0.6
		 */
		$charset = $config->web->charset;
		if (null == $charset) {
			$charset = 'utf-8';
		}
		$view->assign('CHARSET', $charset);
		
		/**
		 * Support RTL language
		 * @since 2.0.3
		 */ 
		$langDir = isset($config->web->language->direction) ? $config->web->language->direction : 'ltr';
		$view->assign('APP_LANG_RTL', ($langDir == 'rtl'));
		
		/**
		 * @since 1.0.1
		 */
		$view->assign('APP_DEFAULT_LANG', $config->localization->languages->default);

		/**
		 * Set layout
		 * first find layout in the module folder in the current template
		 * then in the current templat layout directory
		 * then in the base template in the current module
		 * teh in the base layout directory
		 */
		$layoutPath = array(
		    'curent_template_current_module_layout'=> AMAN_DESIGN_DIR . DS . $design . DS . $currentemplate . 'views'. DS . $module . DS . 'layouts',
		    'current_template_layout' =>AMAN_DESIGN_DIR . DS . $design . DS . $currentemplate . DS . 'layouts',
		    'base_current_module_layout'=>AMAN_DESIGN_DIR . DS . $design . DS . 'base' . 'views'. DS . $module . DS . 'layouts',
		    'base_layout'=>AMAN_DESIGN_DIR . DS . $design . DS . 'base' . DS . 'layouts'
		);
		
		foreach ($layoutPath as $lpath){
		    if(file_exists($lpath . DS . 'layout.phtml')){
		    	Zend_Layout::startMvc(array('layoutPath' => $lpath));
		    	Zend_Layout::getMvcInstance()->setLayout('layout');
		    	break;
		    }
		}
		
				
		/** 
		 * Cache language data if user configured to use cache
		 */
		$cache = Aman_Cache::getInstance();
		if ($cache) {
			 Zend_Translate::setCache($cache);
		}
	}
}
