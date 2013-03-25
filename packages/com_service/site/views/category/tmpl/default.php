<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
?>
<section class="service-category<?php echo $this->pageclass_sfx;?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
		</div>
	<?php endif; ?>
	<?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
		<h2> <?php echo $this->escape($this->params->get('page_subheading')); ?>
			<?php if ($this->params->get('show_category_title', 1)) : ?>
				<?php echo $this->category->title;?>
			<?php endif; ?>
		</h2>
	<?php endif; ?>
	<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
	<div>
		<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
		<p><img src="<?php echo $this->category->getParams()->get('image'); ?>"/></p>
		<?php endif; ?>
		<?php if ($this->params->get('show_description') && $this->category->description) : ?>
		<?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_service.category'); ?>
		<?php endif; ?>
	</div>
	<?php endif; ?>

	<?php echo $this->loadTemplate('items'); ?>

	<?php if (!empty($this->children[$this->category->id]) && $this->maxLevel != 0): ?>
		<h3><?php echo JText::_('JGLOBAL_SUBCATEGORIES'); ?></h3>
		<?php echo $this->loadTemplate('children'); ?>
	<?php endif; ?>
</section>