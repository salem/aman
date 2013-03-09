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
 * @version 	$Id: install.php 3905 2010-07-24 15:23:09Z mehrab $
 * @since		2.0.1
 */

if (version_compare(phpversion(), '5.2.0', '<') === true) {
    die('ERROR: Your PHP version is ' . phpversion() . '. AmanCMS requires PHP 5.2.0 or newer.');
}

error_reporting(E_ALL);

define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);

define('AMAN_ROOT_DIR', dirname(__FILE__));
define('AMAN_APP_DIR',  AMAN_ROOT_DIR . DS . 'application');
define('AMAN_LIB_DIR',  AMAN_ROOT_DIR . DS . 'libraries');
define('AMAN_TEMP_DIR', AMAN_ROOT_DIR . DS . 'temp');

set_include_path(PS . AMAN_LIB_DIR . PS . get_include_path());

/**
 * Run the installer
 * Use Zend_Application
 * @since 2.0.3
 */
require_once 'Zend/Application.php';
$application = new Zend_Application(
    'production',
    array(
    	'phpsettings' => array(
    		'display_startup_errors' => 1,
			'display_errors' 		 => 1,
    	),
    	'autoloadernamespaces' => array(
    		'aman' => 'Aman_',
    	),
		'bootstrap' => array(
    		'path' 	=> AMAN_APP_DIR . DS . 'Installer.php',
			'class' => 'Installer',
    	),
		'resources' => array(
			'frontController' => array(
				'controllerDirectory' => AMAN_APP_DIR . DS . 'controllers',
				'moduleDirectory' 	  => AMAN_APP_DIR . DS . 'modules',
    			'plugins' 			  => array(
    				'magicQuote' => 'Aman_Controller_Plugin_MagicQuote',
    			),
    		),
    	),
    )
);
$application->bootstrap()->run();
