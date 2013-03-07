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
$doc->setTitle(JText::_('COM_SERVICE_CPANEL_TITLE'));
$doc->addStyleSheet(JURI::root() . 'media/com_service/css/backend.css');

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
?>

<div class="adminform">
	<div class="cpanel-left">
		<div id="cpanel">
			<?php echo ServiceHelper::button('services', 'service.png', JText::_('COM_SERVICE_QUICKICON_SERVICES')); ?>
			<?php echo ServiceHelper::button('categories', 'category.png', JText::_('COM_SERVICE_QUICKICON_CATEGORIES')); ?>
		</div>
	</div>
	<div class="cpanel-right">
		<?php echo $this->loadTemplate('stats'); ?>
	</div>
</div>