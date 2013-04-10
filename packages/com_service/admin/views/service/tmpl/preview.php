<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Get document
$doc = JFactory::getDocument();
$doc->addStyleSheet(JURI::root() . 'media/com_service/css/backend.css');

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
?>

<div class="width-70">
	<h1><?php echo JText::_('COM_SERVICE_SERVICE_LAYOUT_HEADER') ?></h1>
</div>
<?php var_dump($this->item); ?>