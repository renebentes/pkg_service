<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Component Helper
jimport('joomla.application.component.helper');
jimport('joomla.application.categories');

/**
 * Service Component Category Tree
 *
 * @static
 * @package     Service
 * @subpackage  com_service
 *
 * @since       2.5
 */
class ServiceCategories extends JCategories
{
	/**
	 * Class constructor
	 *
	 * @param   array  $options  Array of options
	 *
	 * @since   2.5
	 */
	public function __construct($options = array())
	{
		$options['table'] = '#__service';
		$options['extension'] = 'com_service';
		$options['statefield'] = 'published';
		$options['countItems'] = 1;

		parent::__construct($options);
	}
}