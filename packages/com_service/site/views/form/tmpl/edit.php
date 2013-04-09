<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Define style
jimport('joomla.filesystem.file');

$template = JFactory::getApplication()->getTemplate(true)->template;
if(!JFile::exists(JPATH_SITE . '/templates/' . $template . '/css/bootstrap.min.css'))
{
	$doc = JFactory::getDocument();
	$doc->addStyleSheet(JURI::root() . 'media/com_service/css/bootstrap.min.css');
}

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
<section class="edit<?php echo $this->pageclass_sfx; ?>">
	<?php if ($params->get('show_page_heading', 1)) : ?>
	<div class="page-header">
		<h1> <?php echo $this->escape($params->get('page_heading')); ?> </h1>
	</div>
	<?php endif; ?>
	<div class="row-fluid">
		<form action="<?php echo JRoute::_('index.php?option=com_service&s_id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-horizontal">
			<fieldset>
				<legend><?php echo empty($this->item->id) ? JText::_('COM_SERVICE_FORM_ADD') : JText::_('COM_SERVICE_FORM_EDIT'); ?></legend>
				<div class="control-group">
					<?php echo $this->form->getLabel('title'); ?>
					<?php echo $this->form->getInput('title'); ?>
				</div>
				<div class="control-group">
					<?php echo $this->form->getLabel('alias'); ?>
					<?php echo $this->form->getInput('alias'); ?>
				</div>
				<div class="control-group">
					<?php echo $this->form->getLabel('catid'); ?>
					<?php echo $this->form->getInput('catid'); ?>
				</div>
				<div class="control-group">
					<?php echo $this->form->getLabel('requestor'); ?>
					<?php echo $this->form->getInput('requestor'); ?>
				</div>
				<div class="control-group">
					<?php echo $this->form->getLabel('place'); ?>
					<?php echo $this->form->getInput('place'); ?>
				</div>

				<?php if ($this->user->authorise('core.edit.state', 'com_service.service')): ?>
				<div class="control-group">
					<?php echo $this->form->getLabel('published'); ?>
					<?php echo $this->form->getInput('published'); ?>
				</div>
				<?php endif; ?>

				<div class="control-group">
					<?php echo $this->form->getLabel('description'); ?>
					<?php echo $this->form->getInput('description'); ?>
				</div>

				<input type="hidden" name="return" value="<?php echo $this->return_page; ?>" />
				<input type="hidden" name="task" value="" />
				<?php if($this->params->get('enable_category', 0) == 1) :?>
				<input type="hidden" name="jform[catid]" value="<?php echo $this->params->get('catid', 1);?>"/>
				<?php endif;?>
				<?php echo JHtml::_('form.token'); ?>

				<div class="form-actions">
					<button class="btn btn-primary" type="button" onclick="Joomla.submitbutton('service.save')"><?php echo JText::_('JSAVE') ?></button>
					<button class="btn" type="button" onclick="Joomla.submitbutton('service.cancel')"><?php echo JText::_('JCANCEL') ?></button>
				</div>
			</fieldset>
		</form>
	</div>
</section>