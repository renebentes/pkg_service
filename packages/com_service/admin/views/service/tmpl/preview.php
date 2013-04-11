<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @dtcense     GNU General Public dtcense version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Get document
$doc = JFactory::getDocument();
$doc->setTitle(JText::_('COM_SERVICE_SERVICE_PREVIEW_TITLE'));
$doc->addStyleSheet(JURI::root() . 'media/com_service/css/backend.css');

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
?>
<h2><?php echo JText::_('COM_SERVICE_SERVICE_PREVIEW_TITLE') ?></h2>
<div class="n">
	<div class="width-70 fltlft">
		<dl class="dl-horizontal">
			<dt><?php echo JText::_('COM_SERVICE_FIELD_ID_LABEL'); ?></dt>
			<dd><?php echo $this->escape($this->item->id); ?></dd>
			<dt><?php echo JText::_('JDATE'); ?></dt>
			<dd><?php echo JHtml::_('date', $this->item->created, JText::_('DATE_FORMAT_MK')); ?></dd>
			<dt><?php echo JText::_('COM_SERVICE_FIELD_REQUESTOR_LABEL'); ?></dt>
			<dd><?php echo $this->escape($this->item->requestor); ?></dd>
			<dt><?php echo JText::_('COM_SERVICE_FIELD_PLACE_LABEL'); ?></dt>
			<dd><?php echo $this->escape($this->item->place); ?></dd>
			<dt><?php echo JText::_('COM_SERVICE_FIELD_DESCRIPTION_LABEL'); ?></dt>
		</dl>
		<?php echo $this->item->description; ?>
	</div>
	<div class="width-30 fltrt">
		<div class="pane-sliders">
			<div class="panel">
				<h3 class="title"><?php echo JText::_('COM_SERVICE_FIELD_DISPATCH_LABEL'); ?></h3>
				<div class="pane-slider content">
					<ul class="unstyled">
						<li>
							<i class="<?php echo $this->item->dispatch == 1 ? 'icon-checked' : 'icon-unchecked'; ?>"></i>
							<?php echo JText::_('COM_SERVICE_FIELD_DISPATCH_OPTION_WAIT'); ?>
						</li>
						<li>
							<i class="<?php echo $this->item->dispatch == 2 ? 'icon-checked' : 'icon-unchecked'; ?>"></i>
							<?php echo JText::_('COM_SERVICE_FIELD_DISPATCH_OPTION_ALLOW'); ?>
						</li>
						<li>
							<i class="<?php echo $this->item->dispatch == -1 ? 'icon-checked' : 'icon-unchecked'; ?>"></i>
							<?php echo JText::_('COM_SERVICE_FIELD_DISPATCH_OPTION_DENY'); ?>
						</li>
					</ul>
				</div>
			</div>
			<div class="panel">
				<div class="pane-slider content">
					<ul class="unstyled">
						<li class="divider-horizontal"></li>
						<li>CMT 8ºBEC</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="clr"></div>
</div>