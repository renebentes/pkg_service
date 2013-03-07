<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Service Component Controller
 *
 * @package     Service
 * @subpackage  com_service
 * @since       2.5
 */
class ServiceController extends JController
{
	/**
	 * @var		string	The default view.
	 * @since	2.5
	 */
	protected $default_view = 'cpanel';

	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached.
	 * @param   array    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController  This object to support chaining.
     *
	 * @since   2.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT . '/helpers/service.php';

		// Load the submenu.
		ServiceHelper::addSubmenu(JRequest::getCmd('view', 'cpanel'));

		$view   = JRequest::getCmd('view', 'cpanel');
		$layout = JRequest::getCmd('layout', 'default');
		$id     = JRequest::getInt('id');

		parent::display();

		return $this;
	}
}