<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Service controller class.
 *
 * @package     Service
 * @subpackage  com_service
 * @since       2.5
 */
class ServiceControllerService extends JControllerForm
{
	/**
	 * @var    string  The prefix to use with controller messages.
	 * @since  2.5
	 */
	protected $text_prefix = 'COM_SERVICE_SERVICE';

	public function print_popup($key = null)
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app = JFactory::getApplication();
		$model = $this->getModel();
		$table = $model->getTable();

		if (empty($key))
		{
			$key = $table->getKeyName();
		}

		$recordId = JRequest::getInt($key);

		$this->setRedirect(JRoute::_('index.php?option=com_service&view=service&layout=preview&tmpl=component&id=' . $recordId, false));
	}
}