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
 * View class for a list of services.
 *
 * @package     Service
 * @subpackage  com_service
 * @since       2.5
 */
class ServiceViewServices extends JView
{
	protected $items;

	protected $pagination;

	protected $state;

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
		$this->items      = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state      = $this->get('State');

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

		$state = $this->get('State');
		$canDo = ServiceHelper::getActions($state->get('filter.category_id'));
		$user  = JFactory::getUser();

		JToolBarHelper::title(JText::_('COM_SERVICE_MANAGER_SERVICES'), 'services.png');

		if (count($user->getAuthorisedCategories('com_service', 'core.create')) > 0)
		{
			JToolBarHelper::addNew('service.add');
		}

		if (($canDo->get('core.edit')))
		{
			JToolBarHelper::editList('service.edit');
		}

		JToolBarHelper::custom('service.preview', 'preview', 'preview', 'Preview', true);

		if ($canDo->get('core.edit.state'))
		{
			if ($state->get('filter.published') != 2)
			{
				JToolBarHelper::divider();
				JToolBarHelper::publish('services.publish', 'JTOOLBAR_PUBLISH', true);
				JToolBarHelper::unpublish('services.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			}

			if ($state->get('filter.published') != -1)
			{
				JToolBarHelper::divider();
				if ($state->get('filter.published') != 2)
				{
					JToolBarHelper::archiveList('services.archive');
				}
				elseif ($state->get('filter.published') == 2)
				{
					JToolBarHelper::unarchiveList('services.publish');
				}
			}
		}

		if ($canDo->get('core.edit.state'))
		{
			JToolBarHelper::checkin('services.checkin');
		}

		if ($state->get('filter.published') == -2 && $canDo->get('core.delete'))
		{
			JToolBarHelper::deleteList('', 'services.delete', 'JTOOLBAR_EMPTY_TRASH');
			JToolBarHelper::divider();
		}
		elseif ($canDo->get('core.edit.state'))
		{
			JToolBarHelper::trash('services.trash');
			JToolBarHelper::divider();
		}

		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_service');
			JToolBarHelper::divider();
		}

		JToolBarHelper::help('services', $com = true);
	}
}