<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Content Component HTML Helper
 *
 * @static
 * @package     Service
 * @subpackage  com_service
 */
class JHtmlIcon
{
	/**
	 * Display an create icon for the item.
	 *
	 * @param	object	$category	The category for insert item
	 * @param	object	$params		The item parameters
	 * @param	array	$attribs	The attributes for HTML tag <a>
	 *
	 * @return	string	The HTML for the item edit icon.
	 * @since	2.5
	 */
	public static function create($category, $params, $attribs = array())
	{
		$uri = JURI::getInstance();

		$url = 'index.php?option=com_service&task=service.add&return='.base64_encode($uri).'&s_id=0&catid=' . $category->id;

		if ($params->get('show_icons')) {
			$text = '<i class="icon-plus icon-white"></i> ' . JText::_('JNEW');
		} else {
			$text = JText::_('JNEW');
		}

		if (empty($attribs) || isset($attribs))
		{
			$attribs['data-original-title']	= JText::_('COM_SERVICE_CREATE_SERVICE');
			$attribs['data-placement']	= 'right';
			$attribs['rel']		= 'tooltip';
			$attribs['class']	= 'btn btn-primary btn-small hasTooltip';
		}

		$button = JHtml::_('link', JRoute::_($url), $text, $attribs);
		return '<span class="pull-right">'.$button.'</span>';
	}

	/**
	 * Display a email icon for the send item
	 *
	 * @param	object	$item		The item in question.
	 * @param	object	$params		The item parameters
	 * @param	array	$attribs	The attributes for HTML tag <a>
	 *
	 * @return	string	The HTML for the item email icon.
	 * @since	2.5
	 */
	public static function email($item, $params, $attribs = array())
	{
		require_once JPATH_SITE . '/components/com_mailto/helpers/mailto.php';
		$uri	= JURI::getInstance();
		$base	= $uri->toString(array('scheme', 'host', 'port'));
		$template = JFactory::getApplication()->getTemplate();
		$link	= $base.JRoute::_(ServiceHelperRoute::getServiceRoute($item->slug, $item->catid), false);
		$url	= 'index.php?option=com_mailto&tmpl=component&template='.$template.'&link='.MailToHelper::addLink($link);

		$status = 'width=400,height=350,menubar=yes,resizable=yes';

		if ($params->get('show_icons')) {
			$text = '<i class="icon-envelope"></i> ' . JText::_('JGLOBAL_EMAIL');
		} else {
			$text = JText::_('JGLOBAL_EMAIL');
		}

		$attribs['data-original-title']	= JText::_('JGLOBAL_EMAIL');
		$attribs['rel']	= 'tooltip';
		$attribs['data-placement']	= 'right';
		$attribs['class']	= 'hasTooltip';
		$attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";

		$output = JHtml::_('link', JRoute::_($url), $text, $attribs);
		return $output;
	}

	/**
	 * Display an edit icon for the item.
	 *
	 * This icon will not display in a popup window, nor if the item is trashed.
	 * Edit access checks must be performed in the calling code.
	 *
	 * @param	object	$item		The item in question.
	 * @param	object	$params		The item parameters
	 * @param	array	$attribs	The attributes for HTML tag <a>
	 *
	 * @return	string	The HTML for the item edit icon.
	 * @since	2.5
	 */
	public static function edit($item, $params, $attribs = array())
	{
		$user	= JFactory::getUser();
		$userId	= $user->get('id');
		$uri	= JURI::getInstance();

		// Ignore if in a popup window.
		if ($params && $params->get('popup')) {
			return;
		}

		// Ignore if the published is negative (trashed).
		if ($item->published < 0) {
			return;
		}

		JHtml::_('behavior.tooltip');

		if (empty($attribs) || isset($attribs))
		{
			$attribs['rel']	= 'tooltip';
			$attribs['data-placement']	= 'right';
			$attribs['class']	= 'hasTooltip';
		}

		// Show checked_out icon if the item is checked out by a different user
		if (property_exists($item, 'checked_out') && property_exists($item, 'checked_out_time') && $item->checked_out > 0 && $item->checked_out != $user->get('id')) {
			$checkoutUser = JFactory::getUser($item->checked_out);
			$text = '<i class="icon-ban-circle"></i>';
			$date = JHtml::_('date', $item->checked_out_time);

			$attribs['data-original-title']	= JText::_('JLIB_HTML_CHECKED_OUT').' :: '.JText::sprintf('COM_SERVICE_CHECKED_OUT_BY', $checkoutUser->name).' em '.$date;

			return JHtml::_('link', JRoute::_($url), $text, $attribs);
		}

		$url = 'index.php?option=com_service&task=service.edit&a_id='.$item->id.'&return='.base64_encode($uri);

		if ($params->get('show_icons'))
		{
			$icon = $item->state ? 'edit' : 'ban-circle';
			$text = '<i class="icon-'.$icon.'"></i> ' . JText::_('JGLOBAL_EDIT');
		}
		else {
			$text = JText::_('JGLOBAL_EDIT');
		}


		$attribs['data-original-title']	= JText::_('COM_SERVICE_EDIT_ITEM');

		return JHtml::_('link', JRoute::_($url), $text, $attribs);
	}

	/**
	 * Display an icon print for the item.
	 *
	 * The icon call an popup window for the item print.
	 *
	 * @param	object	$item		The item in question.
	 * @param	object	$params		The item parameters
	 * @param	array	$attribs	The attributes for HTML tag <a>
	 *
	 * @return	string	The HTML for the item print icon.
	 * @since	2.5
	 */
	public static function print_popup($item, $params, $attribs = array())
	{
		$url  = ServiceHelperRoute::getServiceRoute($item->slug, $item->catid);
		$url .= '&tmpl=component&print=1&layout=default&page='.@ $request->limitstart;

		$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';

		// checks template image directory for image, if non found default are loaded
		if ($params->get('show_icons')) {
			$text = '<i class="icon-print"></i> ' . JText::_('JGLOBAL_PRINT');
		} else {
			$text = JText::_('JGLOBAL_PRINT');
		}

		if (empty($attribs) || isset($attribs))
		{
			$attribs['rel']	= 'tooltip';
			$attribs['data-placement']	= 'right';
			$attribs['class']	= 'hasTooltip';
		}

		$attribs['onclick'] = "window.open(this.href,'win2','".$status."'); return false;";
		$attribs['data-original-title']	= JText::_('JGLOBAL_PRINT');

		return JHtml::_('link', JRoute::_($url), $text, $attribs);
	}

	/**
	 * Display an print icon for the item.
	 *
	 * The icon call direct the print function.
	 *
	 * @param	object	$item		The item in question.
	 * @param	object	$params		The item parameters
	 * @param	array	$attribs	The attributes for HTML tag <a>
	 *
	 * @return	string	The HTML for the item print icon.
	 * @since	2.5
	 */
	public static function print_screen($item, $params, $attribs = array())
	{
		// checks template image directory for image, if non found default are loaded
		if ($params->get('show_icons')) {
			$text = '<i class="icon-print"></i> ' . JText::_('JGLOBAL_PRINT');
		} else {
			$text = JText::_('JGLOBAL_PRINT');
		}
		return '<a class="hasTooltip" rel="tooltip" data-original-title="' .JText::_('JGLOBAL_PRINT') . '" href="#" onclick="window.print();return false;">'.$text.'</a>';
	}

}