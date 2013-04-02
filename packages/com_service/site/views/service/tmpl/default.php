<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

?>
<section class="service<?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->params->get('show_page_heading')): ?>
	<div class="page-header">
		<h1>
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		</h1>
	</div>
	<?php endif; ?>
	<h2>
		<?php echo $this->escape($this->item->title); ?>
	</h2>
	<div class="row-fluid">
		<div class="span9">
			<dl class="dl-horizontal">
				<dt><?php echo JText::_('COM_SERVICE_FIELD_ID_LABEL'); ?></dt>
				<dd><?php echo $this->escape($this->item->id); ?></dd>
				<dt><?php echo JText::_('JGLOBAL_FIELD_CREATED_LABEL'); ?></dt>
				<dd><?php echo JHtml::_('date', $this->item->created, $this->escape($this->params->get('date_format', JText::_('DATE_FORMAT_MK')))); ?></dd>
				<dt><?php echo JText::_('COM_SERVICE_FIELD_REQUESTOR_LABEL'); ?></dt>
				<dd><?php echo $this->escape($this->item->requestor); ?></dd>
				<dt><?php echo JText::_('COM_SERVICE_FIELD_PLACE_LABEL'); ?></dt>
				<dd><?php echo $this->escape($this->item->place); ?></dd>
				<dt><?php echo JText::_('COM_SERVICE_FIELD_DESCRIPTION_LABEL'); ?></dt>
			</dl>
			<?php echo $this->item->description; ?>
		</div>
		<div class="span3">
			<h5><?php echo JText::_('COM_SERVICE_FIELD_DISPATCH_LABEL'); ?></h5>
		</div>
	</div>
	<?php var_dump($this->item); ?>
</section>