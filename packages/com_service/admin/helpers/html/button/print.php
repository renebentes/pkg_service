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
	 *
	 * @return  string  HTML string for the button
	 *
	 * @since   2.5
	 */
	public function fetchButton($type = 'Print', $name = 'printlist', $text = '', $task = '', $width = 640, $height = 480)
	{
		$doc = JFactory::getDocument();
		$doc->addScript('http://code.jquery.com/jquery-1.9.1.min.js');

		JHtml::_('script', 'system/modal.js', true, true);
		JHtml::_('stylesheet', 'system/modal.css', array(), true);

		$script = array();
		$script[] = "	if(jQuery && jQuery.noConflict){";
		$script[] = "		jQuery.noConflict();";
		$script[] = "	};";
		$script[] = "	if(typeof Joomla === 'undefined'){";
		$script[] = "		var Joomla = {};";
		$script[] = "	}";
		$script[] = "	Joomla.modal = function(url, width, height){";
		$script[] = "		var opt = {'size': {x: width, y: height}};";
		$script[] = "		SqueezeBox.initialize(opt);";
		$script[] = "		SqueezeBox.setContent('iframe', url);";
		$script[] = "	}";
		$script[] = "	Joomla.submitbutton = function(task){";
		$script[] = "		if(task == 'services.printlist'){";
		$script[] = "			var url = 'index.php?option=com_service&view=services&layout=modal&tmpl=component&print=1&filter_search=id:';";
		$script[] = "			arrID = jQuery('[id*=cb]:checked');";
		$script[] = "			if(arrID.length != 0){";
		$script[] = "				cid = new Array();";
		$script[] = "				jQuery.each(arrID, function(){";
		$script[] = "					cid.push(this.value);";
		$script[] = "				});";
		$script[] = "				Joomla.modal(url + cid, $width, $height);";
		$script[] = "			}";
		$script[] = "		}";
		$script[] = "		else";
		$script[] = "			submitform(task);";
		$script[] = "	}";

		$doc->addScriptDeclaration(implode("\n", $script));

		$text   = JText::_($text);
		$class  = $this->fetchIconClass($name);
		$doTask = $this->_getCommand($name, $task);

		$html = "<a href=\"#\" onclick=\"$doTask\" class=\"toolbar\">\n";
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

		$cmd = "if (document.adminForm.boxchecked.value==0){alert('$message'); return false;} else{Joomla.submitbutton('$task');}";

		return $cmd;
	}
}