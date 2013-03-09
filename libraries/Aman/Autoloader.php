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
 * @version 	$Id: Autoloader.php 0001 2011-02-7 12:00:40Z mehrab $
 * @since		1.0.0
 */

class Aman_Autoloader extends Zend_Loader_Autoloader_Resource
{
    public function __construct($options)
    {
        parent::__construct($options);
    }
    
	public function autoload($class)
    {
    	$prefix = AMAN_APP_DIR . DS;
    	$paths  = explode('_', $class);
    	switch (strtolower($paths[0])) {
    		case 'plugins':
    		case 'hooks':
    			$prefix .= '';
    			break;
    		default:
    			$prefix .= 'modules' . DS;
    			break;
    	}
    	    	
		$className = $paths[count($paths) - 1];
		$classFile = substr($class, 0, -strlen($className));
		$classFile = $prefix . strtolower(str_replace('_', DS, $classFile)) . $className . '.php';
		
		if (file_exists($classFile)) {
			return require_once $classFile;
		}
    	
        return false;
    }
}
