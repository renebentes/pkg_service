<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Include dependencies
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.installer.installer');

/**
 * Script file of Service component
 */
class Com_ServiceInstallerScript
{
    /**
     * Method to install the component
     *
     * @param JInstaller $parent
     */
    function install($parent)
    {

    }

    /**
     * Method to uninstall the component
     *
     * @param JInstaller $parent
     */
    function uninstall($parent)
    {

    }

    /**
     * Method to update the component
     *
     * @param JInstaller $parent
     */
    function update($parent)
    {
        $folder = JPATH_ROOT . DS . 'images/birthdays';

        if(JFolder::exists($folder))
        {
            JFolder::delete($folder);
        }
    }

    /**
     * Method to run before an install/update/uninstall method
     *
	 * @param string 		$type Installation type (install, update, discover_install)
	 * @param JInstaller 	$parent Parent object
     */
    function preflight($type, $parent)
    {

    }

    /**
     * Method to run after an install/update/uninstall method
     *
     * @param string 		$type install, update or discover_update
	 * @param JInstaller 	$parent
     */
    function postflight($type, $parent)
    {

    }
}