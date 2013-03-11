<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Include dependancies
require_once JPATH_COMPONENT . '/helpers/route.php';
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');

// Execute the task.
$controller = JControllerLegacy::getInstance('Service');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();