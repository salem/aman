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
 * @version 	$Id: Zip.php 0001 2011-02-7 12:00:40Z mehrab $
 * @since		2.0.4
 */

class Aman_Zip 
{
	/**
	 * @param string $file
	 * @param string $tool
	 * @return Aman_Zip_Abstract
	 */
	static public function factory($file, $adapter = null)
	{
		if (null == $adapter) {
			/**
			 * Auto detect
			 */
			if (class_exists('ZipArchive')) {
				$adapter = 'ZipArchive';
			} else {
				$adapter = 'PclZip';
			}
		}
		$className = 'Aman_Zip_Adapter_' . $adapter;
		$object    = new $className($file);
		if (!$object instanceof Aman_Zip_Abstract) {
			throw new Exception($className.' is not instance of Aman_Zip_Abstract');
		}
		return $object;
	}
}
