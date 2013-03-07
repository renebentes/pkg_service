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
$doc->setTitle(JText::_('COM_SERVICE_SERVICE_TITLE'));
$doc->addStyleSheet(JURI::root() . 'media/com_service/css/backend.css');

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

// Initialise variables.
$canDo = ServiceHelper::getActions();
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'service.cancel' || document.formvalidator.isValid(document.id('service-form'))) {
			<?php echo $this->form->getField('description')->save(); ?>
			Joomla.submitform(task, document.getElementById('service-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
		}
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_service&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="service-form" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo empty($this->item->id) ? JText::_('COM_SERVICE_SERVICE_ADD') : JText::sprintf('COM_SERVICE_SERVICE_EDIT', $this->item->id); ?></legend>
			<ul class="adminformlist">
				<li><?php echo $this->form->getLabel('title'); ?>
				<?php echo $this->form->getInput('title'); ?></li>
				<li><?php echo $this->form->getLabel('alias'); ?>
				<?php echo $this->form->getInput('alias'); ?></li>
				<li><?php echo $this->form->getLabel('catid'); ?>
				<?php echo $this->form->getInput('catid'); ?></li>

				<?php if ($canDo->get('core.edit.state')): ?>
					<li><?php echo $this->form->getLabel('published'); ?>
					<?php echo $this->form->getInput('published'); ?></li>
				<?php endif; ?>
				<li><?php echo $this->form->getLabel('requestor'); ?>
				<?php echo $this->form->getInput('requestor'); ?></li>
				<li><?php echo $this->form->getLabel('place'); ?>
				<?php echo $this->form->getInput('place'); ?></li>
				<li><?php echo $this->form->getLabel('dispatch'); ?>
				<?php echo $this->form->getInput('dispatch'); ?></li>
				<li><?php echo $this->form->getLabel('access'); ?>
				<?php echo $this->form->getInput('access'); ?></li>
				<li><?php echo $this->form->getLabel('language'); ?>
				<?php echo $this->form->getInput('language'); ?></li>
				<li><?php echo $this->form->getLabel('ordering'); ?>
				<?php echo $this->form->getInput('ordering'); ?></li>

				<?php if ($this->item->id): ?>
					<li><?php echo $this->form->getLabel('id'); ?>
					<?php echo $this->form->getInput('id'); ?></li>
				<?php endif; ?>
			</ul>
			<div>
				<?php echo $this->form->getLabel('description'); ?>
				<div class="clr"></div>
				<?php echo $this->form->getInput('description'); ?>
			</div>
		</fieldset>
	</div>
	<div class="width-40 fltrt">
		<pre>
			<?php echo empty($this->form->getFieldset('params')); ?>
			<?php echo empty($this->form->getFieldset('metadata')); ?>
			<?php var_dump($this->form->getFieldset('params')); ?>
		</pre>
		<?php echo JHtml::_('sliders.start', 'service-sliders-' . $this->item->id, array('useCookie' => 1)); ?>
		<?php
		/*if(!empty($this->form->getFieldset('publish')))
		{
			echo $this->loadTemplate('publish');
		}
		/*
		if(!empty($this->form->getFieldset('params')))
			echo $this->loadTemplate('params');
		if(!empty($this->form->getFieldset('metadata')))
			echo $this->loadTemplate('metadata');
		*/?>
		<?php echo JHtml::_('sliders.end'); ?>
	</div>
	<div>
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
	<div class="clr"></div>
</form>