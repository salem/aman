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
 * @version 	$Id: Connection.php 4834 2010-08-24 08:29:37Z mehrab $
 * @since		2.0.5
 */

class Aman_Db_Connection_Pdo_Mysql_Connection extends Aman_Db_Connection_Abstract 
{
	protected function _connect($config)
	{
		$db = Zend_Db::factory('Pdo_Mysql', $config);
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$db->query("SET CHARACTER SET 'utf8'");
		return $db;
	}
	
	public function getVersion()
	{
		$conn = $this->getSlaveConnection();
		$row  = $conn->query('SELECT VERSION() AS ver')->fetch();
		return 'MySQL v' . $row->ver;
	}
	
	public function query($sql)
	{
		$conn = $this->getMasterConnection();
		$conn->query($sql);
	}
}
