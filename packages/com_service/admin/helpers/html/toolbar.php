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
	/**
	 * Writes a preview button for a given option (opens a popup window).
	 *
	 * @param  string  $item    The item associated with the button.
	 * @param  string  $alt     Button text
	 * @param  integer $width   Width of popup
	 * @param  integer $height  Height of popup
	 * @param  bool    $print 	Enables printing to load page
	 *
	 * @since  2.5
	 */
	public static function printItem($item = '', $alt = 'COM_SERVICE_TOOLBAR_PRINT', $width = 640, $height = 480, $print = true)
	{
		$print = $print ? '&print=1' : '';
		$bar = JToolbar::getInstance('toolbar');
		$bar->appendButton('Popup', 'print', $alt, 'index.php?option=com_service&view=service&layout=modal&tmpl=component' . $print . '&id=' . $item, $width, $height);
	}

	/**
	 * Writes a preview button for a given option (opens a popup window).
	 *
	 * @param  string  $task    The task associated with the button.
	 * @param  string  $alt     Button text
	 * @param  integer $width   Width of popup
	 * @param  integer $height  Height of popup
	 * @param  bool    $print 	Enables printing to load page
	 *
	 * @since  2.5
	 */
	public static function printList($task = '', $alt = 'COM_SERVICE_TOOLBAR_PRINT', $width = 640, $height = 480, $print = true)
	{
		require_once (JPATH_COMPONENT_ADMINISTRATOR . DS . 'helpers/html/toolbar/button/print.php');
		$bar = JToolbar::getInstance('toolbar');
		$bar->appendButton('Print', 'print', $alt, $task, $width, $height, $print);
	}
}