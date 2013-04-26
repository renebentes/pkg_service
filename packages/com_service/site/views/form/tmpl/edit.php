<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Load the tooltip behavior.
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

// Create shortcut to parameters.
$params = $this->state->get('params');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task == 'service.cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
			Joomla.submitform(task);
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>
<section class="edit<?php echo $this->pageclass_sfx; ?>">
	<?php if ($params->get('show_page_heading', 1)) : ?>
	<div class="page-header">
		<h1> <?php echo $this->escape($params->get('page_heading')); ?> </h1>
	</div>
	<?php endif; ?>
	<div class="row-fluid">
		<form action="<?php echo JRoute::_('index.php?option=com_service&s_id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-horizontal">
			<fieldset>
				<h2><?php echo empty($this->item->id) ? JText::_('COM_SERVICE_FORM_ADD') : JText::_('COM_SERVICE_FORM_EDIT'); ?></h2>
				<?php if ($this->user->authorise('core.edit.state', 'com_service.service')) : ?>
				<div class="formelm control-group">
					<?php echo $this->form->getLabel('title'); ?>
					<?php echo $this->form->getInput('title'); ?>
				</div>
				<div class="formelm control-group">
					<?php echo $this->form->getLabel('alias'); ?>
					<?php echo $this->form->getInput('alias'); ?>
				</div>
				<?php endif; ?>
				<div class="formelm control-group">
					<?php echo $this->form->getLabel('requestor'); ?>
					<?php echo $this->form->getInput('requestor'); ?>
				</div>
				<div class="formelm control-group">
					<?php echo $this->form->getLabel('place'); ?>
					<?php echo $this->form->getInput('place'); ?>
				</div>
				<div class="formelm control-group">
					<?php echo $this->form->getLabel('catid'); ?>
					<?php echo $this->form->getInput('catid'); ?>
				</div>

				<?php if ($this->user->authorise('core.edit.state', 'com_service.service')) : ?>
				<div class="formelm control-group">
					<?php echo $this->form->getLabel('published'); ?>
					<?php echo $this->form->getInput('published'); ?>
				</div>
				<?php endif; ?>

				<div class="formelm control-group">
					<?php echo $this->form->getLabel('description'); ?>
					<?php echo $this->form->getInput('description'); ?>
				</div>

				<div class="formelm control-group">
					<?php echo $this->form->getLabel('language'); ?>
					<?php echo $this->form->getInput('language'); ?>
				</div>

				<?php echo $this->form->getInput('created_by'); ?>

				<input type="hidden" name="return" value="<?php echo $this->return_page; ?>" />
				<input type="hidden" name="task" value="" />
				<?php echo JHtml::_('form.token'); ?>

				<div class="formelm-buttons form-actions">
					<button class="btn btn-inverse" type="button" onclick="Joomla.submitbutton('service.save')"><?php echo JText::_('JSAVE') ?></button>
					<button class="btn" type="button" onclick="Joomla.submitbutton('service.cancel')"><?php echo JText::_('JCANCEL') ?></button>
				</div>
			</fieldset>
		</form>
	</div>
</section>