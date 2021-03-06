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
 * HTML Form View class for the Service component
 *
 * @package     Service
 * @subpackage  com_service
 * @since       2.5
 */
class ServiceViewForm extends JViewLegacy
{
	protected $form;

	protected $item;

	protected $return_page;

	protected $state;

	/**
	 * Method to display the view.
	 *
	 * @param   string  $tpl  A template file to load. [optional]
	 *
	 * @return  mixed  False on error, null otherwise.
	 *
	 * @return  2.5
	 */
	public function display($tpl = null)
	{
		// Initialise variables.
		$app   = JFactory::getApplication();
		$user  = JFactory::getUser();

		// Get model data.
		$this->state       = $this->get('State');
		$this->item        = $this->get('Item');
		$this->form        = $this->get('Form');
		$this->return_page = $this->get('ReturnPage');

		if (empty($this->item->id))
		{
			$authorised = ($user->authorise('core.create', 'com_service') || (count($user->getAuthorisedCategories('com_service', 'core.create'))));
		}
		else
		{
			$authorised = $this->item->params->get('access-edit');
		}

		if ($authorised !== true)
		{
			JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			return false;
		}

		if (!empty($this->item) && isset($this->item->id))
		{
			$this->form->bind($this->item);
		}

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseWarning(500, implode("\n", $errors));
			return false;
		}

		// Create a shortcut to the parameters.
		$params	= &$this->state->params;

		// Escape strings for HTML output
		$this->pageclass_sfx = htmlspecialchars($params->get('pageclass_sfx'));

		$this->params = $params;
		$this->user   = $user;

		// Check for guest user
		if ($user->get('guest'))
		{
			$this->form->setValue('created_by', null, $params->get('created_by', 1));
		}

		// Check param for category enabled
		if ($params->get('enable_category') == 1) {
			$this->form->setFieldAttribute('catid', 'default',  $params->get('catid', 1));
			$this->form->setFieldAttribute('catid', 'readonly', 'true');
		}

		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 *
	 * @return  void
	 *
	 * @since   2.5
	 */
	protected function _prepareDocument()
	{
		$app	= JFactory::getApplication();
		$menus	= $app->getMenu();
		$pathway	= $app->getPathway();
		$title	= null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();

		if (empty($this->item->id))
		{
			$head = JText::_('COM_SERVICE_FORM_ADD');
		}
		else
		{
			$head = JText::_('COM_SERVICE_FORM_EDIT');
		}

		if ($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else
		{
			$this->params->def('page_heading', $head);
		}

		$title = $this->params->def('page_title', $head);

		if ($app->getCfg('sitename_pagetitles', 0) == 1)
		{
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2)
		{
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}

		$this->document->setTitle($title);

		$pathway = $app->getPathWay();
		$pathway->addItem($title, '');

		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}
}