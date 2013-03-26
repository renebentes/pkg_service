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
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
?>
<section id="service-category"<?php echo !empty($this->pageclass_sfx) ? 'class="' . $this->pageclass_sfx . '"' : null;?>>
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
		</div>
		<?php if ($this->params->get('page_subheading')) : ?>
		<h2>
			<?php echo $this->escape($this->params->get('page_subheading')); ?>
			<?php if ($this->params->get('show_category_title', 1)) : ?>
				<small><?php echo $this->escape($this->category->title); ?></small>
			<?php endif; ?>
		</h2>
		<?php else : ?>
			<?php if ($this->params->get('show_category_title', 1)) : ?>
				<h2><?php echo $this->escape($this->category->title); ?></h2>
			<?php endif; ?>
		<?php endif; ?>
	<?php else : ?>
		<?php if ($this->params->get('page_subheading')) : ?>
			<div class="page-header">
				<h1><?php echo $this->escape($this->params->get('page_subheading')); ?></h1>
			</div>
			<?php if ($this->params->get('show_category_title', 1)) : ?>
				<h2><?php echo $this->escape($this->category->title); ?></h2>
			<?php endif; ?>
		<?php else : ?>
			<?php if ($this->params->get('show_category_title', 1)) : ?>
				<div class="page-header">
					<h1><?php echo $this->escape($this->category->title); ?></h1>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>
	<?php if(($this->params->get('show_description_image') && $this->category->getParams()->get('image')) || ($this->params->get('show_description', 1) && $this->category->description)) : ?>
		<div class="row-fluid">
		<?php if($this->params->get('show_description_image') && $this->category->getParams()->get('image')): ?>
			<img src="<?php echo $this->category->getParams()->get('image'); ?>" class="span1"/>
		<?php endif; ?>
		<?php if($this->params->get('show_description', 1) && $this->category->description) : ?>
			<p class="span11 lead">
				<?php echo $this->escape(strip_tags($this->category->description)); ?>
			</p>
		<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php echo $this->loadTemplate('items'); ?>

	<?php if (!empty($this->children[$this->category->id]) && $this->maxLevel != 0): ?>
	<div class="cat-children">
		<h3><?php echo JText::_('JGLOBAL_SUBCATEGORIES'); ?></h3>
		<?php echo $this->loadTemplate('children'); ?>
	</div>
	<?php endif; ?>
</section>