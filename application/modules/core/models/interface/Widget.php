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
 * @version 	$Id: Widget.php 3352 2010-06-28 06:16:48Z mehrab $
 * @since		2.0.5
 */

interface Core_Models_Interface_Widget
{
	/**
	 * Add new widget
	 * 
	 * @param Core_Models_Widget $widget
	 * @return int
	 */
	public function add($widget);

	/**
	 * Delete widget by given Id
	 * 
	 * @param int $id Id of widget
	 * @return int
	 */
	public function delete($id);
	
	/**
	 * List widgets
	 * 
	 * @param int $offset
	 * @param int $count
	 * @param string $module Name of module
	 * @return Aman_Model_RecordSet
	 */
	public function getWidgets($offset = null, $count = null, $module = null);
	
	/**
	 * Count number of widget in given module
	 * 
	 * @param string $module Name of module
	 * @return int
	 */
	public function count($module = null);
}
