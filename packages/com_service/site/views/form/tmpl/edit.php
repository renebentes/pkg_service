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
			<?php echo $this->form->getField('description')->save(); ?>
			Joomla.submitform(task);
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>
<div class="edit<?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->params->get('show_page_heading', 1)): ?>
	<h1>
		<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
	<?php endif; ?>
	<form action="<?php echo JRoute::_('index.php?option=com_service&view=form&s_id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
		<fieldset>
			<legend><?php echo JText::_('COM_SERVICE_SERVICE'); ?></legend>
			<div class="formelm">
				<?php echo $this->form->getLabel('title'); ?>
				<?php echo $this->form->getInput('title'); ?>
			</div>
			<div class="formelm">
				<?php echo $this->form->getLabel('alias'); ?>
				<?php echo $this->form->getInput('alias'); ?>
			</div>
			<div class="formelm">
				<?php echo $this->form->getLabel('catid'); ?>
				<?php echo $this->form->getInput('catid'); ?>
			</div>
			<div class="formelm">
				<?php echo $this->form->getLabel('requestor'); ?>
				<?php echo $this->form->getInput('requestor'); ?>
			</div>
			<div class="formelm">
				<?php echo $this->form->getLabel('place'); ?>
				<?php echo $this->form->getInput('place'); ?>
			</div>

			<?php if ($this->user->authorise('core.edit.state', 'com_service.service')): ?>
			<div class="formelm">
				<?php echo $this->form->getLabel('published'); ?>
				<?php echo $this->form->getInput('published'); ?>
			</div>
			<?php endif; ?>

			<div class="formelm">
				<?php echo $this->form->getLabel('language'); ?>
				<?php echo $this->form->getInput('language'); ?>
			</div>

			<div class="formelm-buttons">
				<button type="button" onclick="Joomla.submitbutton('service.save')"><?php echo JText::_('JSAVE') ?></button>
				<button type="button" onclick="Joomla.submitbutton('service.cancel')"><?php echo JText::_('JCANCEL') ?></button>
			</div>

			<div>
				<?php echo $this->form->getLabel('description'); ?>
				<?php echo $this->form->getInput('description'); ?>
			</div>
		</fieldset>
		<div>
			<input type="hidden" name="return" value="<?php echo $this->return_page; ?>" />
			<input type="hidden" name="task" value="" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</form>
</div>