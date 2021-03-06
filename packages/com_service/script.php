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
     * Extension name
     *
     * @var string
     */
    private $_extension = 'com_service';

    /**
     * Array of obsoletes files
     *
     * @var array
     */
    private $_obsoletes = array(
        'files' => array(
            'administrator/components/com_service/views/services/tmpl/print.php',
            'administrator/components/com_service/views/service/tmpl/preview.php',
            'administrator/components/com_service/helpers/html/button/print.php',
            'administrator/components/com_service/helpers/html/button/index.html',
            'components/com_service/language/pt-BR.com_service.ini'
            ),
        'folders' => array(
            'administrator/components/com_service/helpers/html/button'
            )
        );

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

    }

    /**
     * Method to run before an install/update/uninstall method
     *
	 * @param string 		$type Installation type (install, update, discover_install)
	 * @param JInstaller 	$parent Parent object
     */
    function preflight($type, $parent)
    {
        $this->_checkCompatible();

        // Workaround for JInstaller bugs
        if(in_array($type, array('install','discover_install')))
        {
            $this->_bugfixDBFunctionReturnedNoError();
        }
        else
        {
            $this->_bugfixCantBuildAdminMenus();
        }

        return true;
    }

    /**
     * Method to run after an install/update/uninstall method
     *
     * @param string 		$type install, update or discover_update
	 * @param JInstaller 	$parent
     */
    function postflight($type, $parent)
    {
        $this->_removeObsoletes($this->_obsoletes);
    }

    /**
     * Method for checking compatibility installation environment
     *
     * @return bool True if the installation environment is compatible
     */
    private function _checkCompatible()
    {
        // Only allow to install on Joomla! 2.5.0 or later with PHP 5.3.0 or later
        if(defined('PHP_VERSION'))
        {
            $version = PHP_VERSION;
        }
        elseif(function_exists('phpversion'))
        {
            $version = phpversion();
        }
        else
        {
            $version = '5.0.0'; // all bets are off!
        }

        if(!version_compare(JVERSION, '2.5.6', 'ge'))
        {
            $msg = '<p>' . JText::_('NO_SUPPORTED_JOOMLA') . '</p>';
            JError::raiseWarning(100, $msg);
            return false;
        }

        if(!version_compare($version, '5.3.1', 'ge'))
        {
            $msg = '<p>' . JText::_('NO_SUPPORTED_PHP') . '</p>';
            if(version_compare(JVERSION, '3.0', 'gt'))
            {
                JLog::add($msg, JLog::WARNING, 'jerror');
            }
            else
            {
                JError::raiseWarning(100, $msg);
            }
            return false;
        }

        return true;
    }

    /**
     * Method for bugfix for "DB function returned no error"
     */
    private function _bugfixDBFunctionReturnedNoError()
    {
        $db = JFactory::getDbo();

        // Fix broken #__assets records
        $query = $db->getQuery(true);
        $query->select('id')
            ->from('#__assets')
            ->where($db->qn('name') . ' = ' . $db->q($this->_extension));
        $db->setQuery($query);
        if(version_compare(JVERSION, '3.0', 'ge'))
        {
            $ids = $db->loadColumn();
        }
        else
        {
            $ids = $db->loadResultArray();
        }

        if(!empty($ids))
        {
            foreach($ids as $id)
            {
                $query = $db->getQuery(true);
                $query->delete('#__assets')
                    ->where($db->qn('id') . ' = ' . $db->q($id));
                $db->setQuery($query);
                $db->execute();
            }
        }

        // Fix broken #__extensions records
        $query = $db->getQuery(true);
        $query->select('extension_id')
            ->from('#__extensions')
            ->where($db->qn('element') . ' = ' . $db->q($this->_extension));
        $db->setQuery($query);
        if(version_compare(JVERSION, '3.0', 'ge'))
        {
            $ids = $db->loadColumn();
        }
        else
        {
            $ids = $db->loadResultArray();
        }

        if(!empty($ids))
        {
            foreach($ids as $id)
            {
                $query = $db->getQuery(true);
                $query->delete('#__extensions')
                    ->where($db->qn('extension_id') . ' = ' . $db->q($id));
                $db->setQuery($query);
                $db->execute();
            }
        }

        // Fix broken #__menu records
        $query = $db->getQuery(true);
        $query->select('id')
            ->from('#__menu')
            ->where($db->qn('type') . ' = ' . $db->q('component'))
            ->where($db->qn('menutype') . ' = ' . $db->q('main'))
            ->where($db->qn('link'). ' LIKE ' . $db->q('index.php?option='.$this->_extension));
        $db->setQuery($query);
        if(version_compare(JVERSION, '3.0', 'ge'))
        {
            $ids = $db->loadColumn();
        }
        else
        {
            $ids = $db->loadResultArray();
        }

        if(!empty($ids))
        {
            foreach($ids as $id)
            {
                $query = $db->getQuery(true);
                $query->delete('#__menu')
                    ->where($db->qn('id') . ' = ' . $db->q($id));
                $db->setQuery($query);
                $db->execute();
            }
        }
    }

    /**
     * Method for bugfix for "Can not build admin menus"
     */
    private function _bugfixCantBuildAdminMenus()
    {
        $db = JFactory::getDbo();

        // If there are multiple #__extensions record, keep one of them
        $query = $db->getQuery(true);
        $query->select('extension_id')
            ->from('#__extensions')
            ->where($db->qn('element') . ' = ' . $db->q($this->_extension));
        $db->setQuery($query);

        if(version_compare(JVERSION, '3.0', 'ge'))
        {
            $ids = $db->loadColumn();
        }
        else
        {
            $ids = $db->loadResultArray();
        }

        if(count($ids) > 1)
        {
            asort($ids);
            $extension_id = array_shift($ids); // Keep the oldest id

            foreach($ids as $id)
            {
                $query = $db->getQuery(true);
                $query->delete('#__extensions')
                    ->where($db->qn('extension_id') . ' = ' . $db->q($id));
                $db->setQuery($query);
                $db->execute();
            }
        }

        // If there are multiple assets records, delete all except the oldest one
        $query = $db->getQuery(true);
        $query->select('id')
            ->from('#__assets')
            ->where($db->qn('name') . ' = ' . $db->q($this->_extension));
        $db->setQuery($query);
        $ids = $db->loadObjectList();
        if(count($ids) > 1)
        {
            asort($ids);
            $asset_id = array_shift($ids); // Keep the oldest id

            foreach($ids as $id)
            {
                $query = $db->getQuery(true);
                $query->delete('#__assets')
                    ->where($db->qn('id') . ' = ' . $db->q($id));
                $db->setQuery($query);
                $db->execute();
            }
        }

        // Remove #__menu records for good measure!
        $query = $db->getQuery(true);
        $query->select('id')
            ->from('#__menu')
            ->where($db->qn('type') . ' = ' . $db->q('component'))
            ->where($db->qn('menutype') . ' = ' . $db->q('main'))
            ->where($db->qn('link') . ' LIKE ' . $db->q('index.php?option='.$this->_extension));
        $db->setQuery($query);

        if(version_compare(JVERSION, '3.0', 'ge'))
        {
            $ids1 = $db->loadColumn();
        }
        else
        {
            $ids1 = $db->loadResultArray();
        }

        if(empty($ids1))
        {
            $ids1 = array();
        }

        $query = $db->getQuery(true);
        $query->select('id')
            ->from('#__menu')
            ->where($db->qn('type') . ' = ' . $db->q('component'))
            ->where($db->qn('menutype'). ' = ' . $db->q('main'))
            ->where($db->qn('link') . ' LIKE ' . $db->q('index.php?option='.$this->_extension . '&%'));
        $db->setQuery($query);

        if(version_compare(JVERSION, '3.0', 'ge'))
        {
            $ids2 = $db->loadColumn();
        }
        else
        {
            $ids2 = $db->loadResultArray();
        }

        if(empty($ids2))
        {
            $ids2 = array();
        }
        $ids = array_merge($ids1, $ids2);

        if(!empty($ids))
        {
            foreach($ids as $id)
            {
                $query = $db->getQuery(true);
                $query->delete('#__menu')
                    ->where($db->qn('id') . ' = ' . $db->q($id));
                $db->setQuery($query);
                $db->execute();
            }
        }
    }

    /**
     * Removes obsolete files and folders
     *
     * @param array $obsoletes
     */
    private function _removeObsoletes($obsoletes = array())
    {
        // Remove files
         if(!empty($obsoletes['files']))
        {
            foreach($obsoletes['files'] as $file)
            {
                $f = JPATH_ROOT . '/' . $file;
                if(!JFile::exists($f))
                {
                    continue;
                }
                JFile::delete($f);
            }
        }

        // Remove folders
        if(!empty($obsoletes['folders']))
        {
            foreach($obsoletes['folders'] as $folder)
            {
                $f = JPATH_ROOT . '/' . $folder;
                if(!JFolder::exists($f))
                {
                    continue;
                }
                JFolder::delete($f);
            }
        }
    }
}