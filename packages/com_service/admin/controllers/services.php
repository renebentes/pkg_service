<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Services list controller class.
 *
 * @package     Service
 * @subpackage  com_service
 * @since       2.5
 */

class ServiceControllerServices extends JControllerAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	2.5
	 */
	protected $text_prefix = 'COM_SERVICE_SERVICES';

	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
     *
	 * @see     JController
	 * @since   2.5
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);
	}

	/**
	 * Proxy for getModel.
     *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
     *
	 * @return  object  The model.
     *
	 * @since	2.5
	 */
	public function getModel($name = 'Service', $prefix = 'ServiceModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}

	/**
	 * Method to print a list of items
	 *
	 * @return  void
	 *
	 * @since   2.5
	 */
	public function printList()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));

		// Get items to print from the request.
		$cid = JRequest::getVar('cid', array(), '', 'array');
		if (empty($cid))
		{
			JError::raiseWarning(500, JText::_($this->text_prefix . '_NO_ITEM_SELECTED'));
		}
		else
		{
			// Make sure the item ids are integers
			JArrayHelper::toInteger($cid);
			$cid = implode(',', $cid);

			// Create a new query object.
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			// Select the required fields from the table.
			$query->select('a.*');
			$query->from($db->quoteName('#__service') . ' AS a');
			$query->where('a.id IN (' . $cid . ')');
			$db->setQuery($query);

			$this->items = $db->loadObjectList();
		}

		$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list . '&layout=print', false));
	}
}