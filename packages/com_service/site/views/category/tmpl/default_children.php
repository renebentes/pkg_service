<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

if (count($this->children[$this->category->id]) > 0 && $this->maxLevel != 0):
?>
<ul class="unstyled">
<?php foreach($this->children[$this->category->id] as $id => $child) : ?>
	<?php
	if ($this->params->get('show_empty_categories') || $child->numitems || count($child->getChildren())): ?>
		<li>
			<?php $class = ''; ?>
			<h3><a href="<?php echo JRoute::_(ServiceHelperRoute::getCategoryRoute($child->id)); ?>">
				<?php echo $this->escape($child->title); ?></a>
			</h3>

			<?php if ($this->params->get('show_subcat_desc') == 1): ?>
				<?php if ($child->description): ?>
				<div class="row-fluid"><?php echo JHtml::_('content.prepare', $child->description, '', 'com_service.category'); ?></div>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ($this->params->get('show_cat_num_items') == 1): ?>
			<p><span class="label label-info"><?php echo JText::_('COM_SERVICE_NUM_ITEMS'); ?>&nbsp;<?php echo $child->getNumItems(true); ?></span></p>
			<?php endif; ?>
			<hr />

			<?php if (count($child->getChildren()) > 0):
				$this->children[$child->id] = $child->getChildren();
				$this->category = $child;
				$this->maxLevel--;
				if ($this->maxLevel != 0) :
					echo $this->loadTemplate('children');
				endif;
				$this->category = $child->getParent();
				$this->maxLevel++;
			endif; ?>
		</li>
	<?php endif; ?>
<?php endforeach; ?>
</ul>
<?php endif;