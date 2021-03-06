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
 * @version 	$Id: Abstract.php 3349 2010-06-28 06:14:27Z mehrab $
 * @since		2.0.4
 */

abstract class Aman_Zip_Abstract
{
	/**
	 * @var string
	 */
	protected $_file;
	
	public function __construct($file)
	{
		$this->_file = $file;
	}
	
	abstract public function open();
	
	abstract public function close();
	
	/**
	 * Extract to destination directory
	 * @param string $destination
	 */
	abstract public function extract($destination);
}
