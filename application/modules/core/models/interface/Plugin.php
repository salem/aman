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
 * @version 	$Id: Plugin.php 4535 2010-08-12 09:51:49Z mehrab $
 * @since		2.0.5
 */

interface Core_Models_Interface_Plugin
{
	/**
	 * Get all plugins in order
	 * 
	 * @return Aman_Model_RecordSet
	 */
	public function getOrdered();
	
	/**
	 * Add new plugin
	 * 
	 * @param Core_Models_Plugin $plugin
	 * @return int
	 */
	public function add($plugin);
	
	/**
	 * Delete plugin by Id
	 * 
	 * @param int $id Id of plugin
	 * @return int
	 */
	public function delete($id);
}
