<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;

/**
 * Renders a print screen button
 *
 * @package     Service
 * @subpackage  com_service
 * @since       2.5
 */

class JButtonPrint extends JButton
{
	/**
	 * Button type
	 *
	 * @var    string
	 */
	protected $_name = 'Print';

	/**
	 * Fetch the HTML for the button
	 *
	 * @param   string  $type     Unused string.
	 * @param   string  $name     Name to be used as apart of the id
	 * @param   string  $text     Button text
	 * @param   string  $task     The task associated with the button.
	 * @param   integer $width    Width of popup
	 * @param   integer $height   Height of popup
	 * @param   string  $onClose  JavaScript for the onClose event.
	 *
	 * @return  string  HTML string for the button
	 *
	 * @since   2.5
	 */
	public function fetchButton($type = 'Print', $name = 'printlist', $text = '', $task = '', $width = 640, $height = 480, $onClose = '')
	{
		JHtml::_('behavior.modal');
		$text = JText::_($text);
		$class = $this->fetchIconClass($name);
		$doTask = $this->_getCommand($name, $task);

		$html = "<a href=\"#\" id=\"print\"onclick=\"$doTask\" class=\"toolbar modal\" rel=\"{handler: 'iframe', size: {x: $width, y: $height}, onClose: function() {" . $onClose
			. "}}\">\n";
		$html .= "<span class=\"$class\">\n";
		$html .= "</span>\n";
		$html .= "$text\n";
		$html .= "</a>\n";

		return $html;
	}

	/**
	 * Get the button CSS Id
	 *
	 * @param   string  $type  The button type.
	 * @param   string  $name  The name of the button.
	 *
	 * @return  string  Button CSS Id
	 *
	 * @since   2.5
	 */
	public function fetchId($type = 'Print', $name = '', $text = '', $task = '', $hideMenu = false)
	{
		return $this->_parent->getName() . '-' . $name;
	}

	/**
	 * Get the JavaScript command for the button
	 *
	 * @param   string   $name  The task name as seen by the user
	 * @param   string   $task  The task associated with the button.
	 *
	 * @return  string   JavaScript command string
	 *
	 * @since   2.5
	 */
	protected function _getCommand($name, $task)
	{
		JHtml::_('behavior.framework');

		$message = JText::_('JLIB_HTML_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST');
		$message = addslashes($message);

		$cmd = "if (document.adminForm.boxchecked.value==0){alert('$message')} else{Joomla.submitbutton('$task');}";

		return $cmd;
	}
}