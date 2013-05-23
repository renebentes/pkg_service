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
$doc->setTitle(JText::_('COM_SERVICE_SERVICES_PRINT_TITLE'));
$doc->addStyleSheet(JURI::root() . 'media/com_service/css/backend.css', 'text/css', 'all');

if (JRequest::getInt('print') == 1)
{
	echo '<script type="text/javascript">document.window.print();</script>';
}

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
?>
<div id="content-box" class="content-box-printed">
	<div id="toolbar-box">
		<div class="m">
			<div class="toolbar-list" id="toolbar">
				<ul>
					<li class="button" id="toolbar-popup-printer">
					<a href="#" onclick="document.window.print();">
					<span class="icon-32-print">
					</span>
					<?php echo JText::_('COM_SERVICE_TOOLBAR_PRINT'); ?>
					</a>
					</li>
				</ul>
				<div class="clr"></div>
			</div>
			<div class="pagetitle icon-48-service">
				<h2><?php echo JText::_('COM_SERVICE_SERVICES_PRINT_TITLE') ?></h2>
			</div>
		</div>
	</div>
	<div id="element-box">
		<div class="n">
			<table class="adminlist">
				<thead>
					<tr>
						<th width="1%">
							<?php echo JText::_('COM_SERVICE_HEADING_ID'); ?>
						</th>
						<th width="30%">
							<?php echo JText::_('COM_SERVICE_HEADING_DESCRIPTION'); ?>
						</th>
						<th width="10%">
							<?php echo JText::_('COM_SERVICE_HEADING_REQUESTOR'); ?>
						</th>
						<th width="10%">
							<?php echo JText::_('COM_SERVICE_HEADING_PLACE'); ?>
						</th>
						<th width="5%">
							<?php echo JText::_('COM_SERVICE_HEADING_DISPATCH'); ?>
						</th>
						<th width="30%">
							<?php echo JText::_('COM_SERVICE_HEADING_NOTES'); ?>
						</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="6">&nbsp;</td>
					</tr>
				</tfoot>
				<tbody>
				<?php foreach ($this->items as $key => $item) : ?>
					<tr>
						<td class="center"><?php echo $this->escape($item->id); ?></td>
						<td><?php echo nl2br($this->escape($item->description)); ?></td>
						<td class="center"><?php echo $this->escape($item->requestor); ?></td>
						<td class="center"><?php echo $this->escape($item->place); ?></td>
						<td class="center">
							<?php switch ($item->dispatch) {
								case 1:
									echo JText::_('COM_SERVICE_FIELD_DISPATCH_OPTION_WAIT');
									break;
								case 2:
									echo JText::_('COM_SERVICE_FIELD_DISPATCH_OPTION_ALLOW');
									break;
								case -1:
									echo JText::_('COM_SERVICE_FIELD_DISPATCH_OPTION_DENY');
									break;
								default:
									echo " ";
									break;
							} ?>
						</td>
						<td>&nbsp;</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>