<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public license version 2 or later; see LICENSE.txt
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
<div id="content-box">
	<div id="toolbar-box">
		<div class="m">
			<div class="toolbar-list" id="toolbar">
				<ul>
					<li class="button" id="toolbar-popup-preview">
					<a class="modal" href="http://servidor.8bec.eb.mil.br/develop/administrator/index.php?option=com_service&view=service&layout=preview&tmpl=component&id=12&task=preview" rel="{handler: 'iframe', size: {x: 640, y: 480}, onClose: function() {}}">
					<span class="icon-32-preview">
					</span>
					Preview
					</a>
					</li>
				</ul>
				<div class="clr"></div>
			</div>
			<div class="pagetitle icon-48-service">
				<h2><?php echo JText::_('COM_SERVICE_SERVICE_PREVIEW_TITLE') ?></h2>
			</div>
		</div>
	</div>
	<div id="element-box">
		<div class="m">
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
					<div class="hide">
						<div></div>
					</div>
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
				</div>
			</div>
			<div class="clr"></div>

			<div class="width-100">
				<ul class="unstyled">
					<li class="divider-horizontal"></li>
					<li>CMT 8ºBEC</li>
				</ul>
			</div>
		</div>
	</div>
</div>