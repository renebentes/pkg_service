<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Service Component HTML Helper
 *
 * @static
 * @package     Service
 * @subpackage  com_service
 */

abstract class ServiceToolBarHelper extends JToolBarHelper
{
	public static function printList($task = 'printList', $alt = 'COM_SERVICE_TOOLBAR_PRINT')
	{
		$bar = JToolbar::getInstance('toolbar');
		$bar->appendButton('Standard', 'print', $alt, $task);
	}
}