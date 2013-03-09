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
 * @version 	$Id: Toolkit.php 3526 2010-07-10 16:37:07Z mehrab $
 * @since		2.0.7
 */

class Aman_Seo_Toolkit
{
	/**
	 * Get toolkit adapter
	 * 
	 * @param string $adapter
	 * @return Aman_Seo_Toolkit_Abstract
	 */
	public static function factory($adapter)
	{
		$adapter = strtolower($adapter);
		switch ($adapter)
		{
			case 'bing':
				return new Aman_Seo_Toolkit_Bing();
				break;
			case 'yahoo':
				return new Aman_Seo_Toolkit_Yahoo();
				break;
			case 'google':
			default:
				return new Aman_Seo_Toolkit_Google();
				break;
		}
	}	
}
