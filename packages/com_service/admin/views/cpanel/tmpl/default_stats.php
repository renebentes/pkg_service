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
JHtml::_('behavior.tooltip');

// Initialise variables.
$user      = JFactory::getUser();
$userId    = $user->get('id');
?>
<?php echo JHtml::_('sliders.start', 'stat-pane'); ?>
<?php echo JHtml::_('sliders.panel', JText::_('COM_SERVICE_FIELDSET_SERVICES'), 'services-panel'); ?>
<form action="<?php echo JRoute::_('index.php?option=com_service&view=cpanel'); ?>" method="post" name="adminForm" id="adminForm">
	<table class="adminlist">
		<thead>
			<tr>
				<th width="1%" class="nowrap">
					<?php echo JText::_('COM_SERVICE_HEADING_ID'); ?>
				</th>
				<th class="left">
					<?php echo JText::_('COM_SERVICE_HEADING_TITLE'); ?>
				</th>
				<th width="10%">
					<?php echo JText::_('JDATE'); ?>
				</th>
				<th width="10%">
					<?php echo JText::_('JSTATUS'); ?>
				</th>
				<th width="5%">
					<?php echo JText::_('JGLOBAL_HITS'); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">&nbsp;</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
		$k = 0;
		if ($this->items):
			foreach ($this->items as $i => $item):
				$canEdit    = $user->authorise('core.edit', 'com_service.category.' . $item->catid);
				$canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
				$canChange  = $user->authorise('core.edit.state', 'com_service.category.' . $item->catid) && $canCheckin;
			?>
			<tr class="row<?php echo $k; ?>">
				<td class="center">
					<?php echo $this->escape($item->id); ?>
				</td>
				<td>
					<?php if ($item->checked_out): ?>
						<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'services.', $canCheckin); ?>
					<?php endif; ?>
					<?php if ($canEdit): ?>
						<a href="<?php echo JRoute::_('index.php?option=com_service&task=service.edit&id=' . (int) $item->id); ?>">
							<?php echo $this->escape($item->title); ?>
						</a>
					<?php else: ?>
						<?php echo $this->escape($item->title); ?>
					<?php endif; ?>
				</td>
				<td class="center">
					<?php echo JHtml::_('date', $item->created, JText::_('DATE_FORMAT_MK')); ?>
				</td>
				<td class="center">
						<?php echo JHtml::_('jgrid.published', $item->published, $i, 'services.', $canChange, 'cb', $item->publish_up, $item->publish_down); ?>
					</td>
				<td class="center">
					<?php echo $this->escape($item->hits); ?>
				</td>
			</tr>
			<?php $k = 1 - $k; ?>
			<?php endforeach; ?>
		<?php else: ?>
			<?php echo '<tr class="row' . $k . '"><td colspan="5" align="center">' . JText::_('COM_SERVICE_NO_RESULTS') . '</td></tr>'; ?>
		<?php endif; ?>
		</tbody>
	</table>
	<div>
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<?php echo JHtml::_('sliders.end'); ?>