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
 * @version 	$Id: FileController.php 4761 2010-08-21 18:52:33Z mehrab $
 * @since		1.0.0
 */

class Download_FileController extends Zend_Controller_Action 
{
	
	public function browseAction()
	{
	    $request = $this->getRequest();
	    $path = $request->getParam('path');
	    if($path){
	        ob_get_clean();
	        readfile($path);
	        die();
	    }		
	}
	
	/**
	 * Upload file
	 * 
	 * @return void
	 */
	public function linksAction()
	{
	    $path = $_SERVER['DOCUMENT_ROOT'];
	    $this->_helper->layout()->disableLayout();
		//$path = $this->getRequest()->getParam('path');
		//$zip = new ZipArchive();
		//$zip->open($path.'abcdefghijklmnopqrstuvwz');
	    $dirIterator = new DirectoryIterator($path);
	    $dirs  = array();
	    $files = array();
	    foreach ($dirIterator as $file) {
	    	if ($file->isDot()) {
	    		continue;
	    	}
	    	if($file->getFilename() == 'v2'){
	    	    continue;
	    	}
	    	if ($file->isDir()) {
	    		$this->_loopdir($path, $files);
	    	}
	    	 else {
	    	     $files[] = $file->getFilename();	    			
	    	} 
	    	//echo var_dump($file);
	    }
	   
	    $this->view->assign('files', $files);
	}
	
	function _loopdir($path, &$files){
	    $dirIterator = new DirectoryIterator($path);
	   
	    foreach ($dirIterator as $file) {
	    	if ($file->isDot()) {
	    		continue;
	    	}
	    	if ($file->isDir()) {
	    		$this->_loopdir($path.DS.$file->getFilename(), $files);
	    	} 
	    	else {
	    		$files[] = $path.DS.$file->getFilename();
	    	}
	    }
	}
}
