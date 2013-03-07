<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for Cpanel.
 *
 * @package     Service
 * @subpackage  com_service
 * @since       2.5
 */
class ServiceViewCpanel extends JView
{
	/**
	 * Method to display the view.
	 *
	 * @param   string  $tpl  A template file to load. [optional]
	 *
	 * @return  mixed  A string if successful, otherwise a JError object.
	 *
	 * @since   2.5
	 */
	public function display($tpl = null)
	{
		// Initialise variables.
		$model = JModel::getInstance('Services', 'ServiceModel', array('ignore_request' => true));
		$model->setState('list.select', 'a.*');
		$model->setState('list.limit', 5);
		$model->setState('list.ordering', 'a.created');
		$model->setState('list.direction', 'desc');

		$this->items = $model->getItems();

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   2.5
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT . '/helpers/service.php';

		$canDo = ServiceHelper::getActions();
		$user = JFactory::getUser();

		JToolBarHelper::title(JText::_('COM_SERVICE_MANAGER_CPANEL'), 'cpanel.png');

		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_service');
			JToolBarHelper::divider();
		}

		JToolBarHelper::help('cpanel', $com = true);
	}
}