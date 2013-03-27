<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Code to support edit links for service
// Create a shortcut for params.
$params = &$this->item->params;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.framework');

// Get the user object.
$user = JFactory::getUser();

// Check if user is allowed to add/edit based on service permissinos.
$canEdit = $user->authorise('core.edit', 'com_service');
$canCreate = $user->authorise('core.create', 'com_service');
$canEditState = $user->authorise('core.edit.state', 'com_service');

$n = count($this->items);
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
?>
<?php if (empty($this->items) && $this->params->get('show_no_results', 1)): ?>
<p><?php echo JText::_('COM_SERVICE_NO_RESULTS'); ?></p>
<?php else: ?>
<form action="<?php echo htmlspecialchars(JFactory::getURI()->toString()); ?>" method="post" name="adminForm" id="adminForm" class="form-inline">
	<?php if ($this->params->get('show_pagination_limit') || $this->params->get('filter_field') != 'hide') : ?>
	<fieldset class="well well-small">
		<?php if($this->params->get('filter_field') != 'hide') : ?>
			<div class="pull-left">
				<label class="control-label" for="filter_search"><?php echo JText::_('JGLOBAL_FILTER_LABEL'); ?>&nbsp;<?php echo JText::_('COM_SERVICE_'.strtoupper($this->params->get('filter_field')).'_FILTER_LABEL').'&#160;'; ?></label>
				<div class="input-append">
					<input type="text" name="filter_search" id="filter_search" class="input-small" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" title="<?php echo JText::_('COM_SERVICE_'.strtoupper($this->params->get('filter_field')).'_FILTER_DESC'); ?>" />
					<button type="submit" rel="tooltip" class="btn hasTooltip" data-original-title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>" data-placement="bottom"><i class="icon-ok"></i></button>
					<button type="button" rel="tooltip" class="btn hasTooltip" data-original-title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" data-placement="bottom" onclick="document.id('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
				</div>
			</div>
		<?php endif; ?>
		<?php if($this->params->get('show_pagination_limit')) : ?>
			<div class="pull-right">
				<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>&#160;
				<?php echo $this->pagination->getLimitBox(); ?>
			</div>
		<?php endif; ?>
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<input type="hidden" name="limitstart" value="" />
	</fieldset>
	<?php endif; ?>

	<table class="table table-bordered table-striped">
		<thead>
			<tr>
			<th id="tableOrdering">
				<?php  echo JHtml::_('grid.sort', 'COM_SERVICE_HEADING_TITLE', 'a.title', $listDirn, $listOrder) ; ?>
			</th>

			<?php if ($date = $this->params->get('list_show_date')) : ?>
			<th id="tableOrdering2">
				<?php if ($date == "created") : ?>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICE_HEADING_'.$date.'_DATE', 'a.created', $listDirn, $listOrder); ?>
				<?php elseif ($date == "modified") : ?>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICE_HEADING_'.$date.'_DATE', 'a.modified', $listDirn, $listOrder); ?>
				<?php elseif ($date == "published") : ?>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICE_HEADING_'.$date.'_DATE', 'a.publish_up', $listDirn, $listOrder); ?>
				<?php endif; ?>
			</th>
			<?php endif; ?>

			<?php if ($this->params->get('list_show_author', 1)) : ?>
			<th id="tableOrdering3">
				<?php echo JHtml::_('grid.sort', 'JAUTHOR', 'author', $listDirn, $listOrder); ?>
			</th>
			<?php endif; ?>

			<?php if ($this->params->get('list_show_hits', 1)) : ?>
			<th id="tableOrdering4">
				<?php echo JHtml::_('grid.sort', 'JGLOBAL_HITS', 'a.hits', $listDirn, $listOrder); ?>
			</th>
			<?php endif; ?>
		</tr>
		</thead>
		<tbody>
	<?php foreach ($this->items as $item): ?>
			<tr>
				<td><a href="<?php echo JRoute::_(ServiceHelperRoute::getServiceRoute($item->slug, $item->catid)); ?>"> <?php echo $this->escape($item->title); ?></a></td>
			<?php if ($this->params->get('list_show_date')) : ?>
				<td>
					<?php echo JHtml::_('date', $item->displayDate, $this->escape(
					$this->params->get('date_format', JText::_('DATE_FORMAT_MK')))); ?>
				</td>
			<?php endif; ?>

			<?php if ($this->params->get('list_show_author', 1)) : ?>
				<td><?php echo $item->author; ?></td>
			<?php endif; ?>
			<?php if ($this->params->get('list_show_hits', 1)) : ?>
				<td>
					<?php echo $item->hits; ?>
				</td>
			<?php endif; ?>
			</tr>
	<?php endforeach ?>
		</tbody>
	</table>
	<?php // Code to add a link to submit an service. ?>
	<?php if ($this->category->getParams()->get('access-create')) : ?>
	<div class="btn-group">
		<span class="btn"><?php echo JHtml::_('icon.create', $this->category, $this->category->params); ?></span>
	</div>
	<?php  endif; ?>
	<?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->get('pages.total') > 1)) : ?>
	<nav class="pagination pagination-centered">
		<?php echo $this->pagination->getPagesLinks(); ?>
		<?php if ($this->params->def('show_pagination_results', 1)) : ?>
		<p class="counter muted"><?php echo $this->pagination->getPagesCounter(); ?></p>
		<?php endif; ?>
	</nav>
	<?php endif; ?>
	<pre><?php var_dump($params); ?></pre>
</form>
<?php endif;