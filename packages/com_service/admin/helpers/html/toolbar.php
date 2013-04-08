<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;


class JToolBarHelper
{
	/**
	 * Writes a preview button for a given option (opens a popup window).
	 *
	 * @param	string	$url	The name of the popup file (excluding the file extension)
	 * @param	bool	$updateEditors
	 * @since	1.0
	 */
	public static function preview($url = '', $updateEditors = false, $alt = '')
	{
		$bar = JToolBar::getInstance('toolbar');
		// Add a preview button.
		$bar->appendButton('Popup', 'preview', $alt, $url.'&task=preview');
	}
}