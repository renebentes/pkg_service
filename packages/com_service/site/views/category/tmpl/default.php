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
	<?php if ($this->params->get('show_page_heading')): ?>
	<div class="page-header page-header-main">
		<h1>
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		</h1>
	</div>
	<?php endif; ?>

	<?php if ($this->params->get('show_category_title', 1) || $this->params->get('page_subheading') || $this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)): ?>
	<div class="page-subheader">
		<h2>
			<?php echo $this->params->get('page_subheading') ? $this->escape($this->params->get('page_subheading') . ":") : null; ?>
			<?php echo $this->params->get('show_category_title') ? JHtml::_('content.prepare', $this->category->title, '', 'com_service.category') : null; ?>
		<?php if ($this->params->get('show_description') && $this->category->description): ?>
			<small>
				<?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_service.category'); ?>
			</small>
		<?php endif; ?>
		</h2>
	<?php if($this->params->get('show_description_image') && $this->category->getParams()->get('image')): ?>
		<div class="span3">
			<img src="<?php echo $this->category->getParams()->get('image'); ?>"/>
		</div>
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

<?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->get('pages.total') > 1)) : ?>
<nav class="pagination pagination-centered">
	<?php echo $this->pagination->getPagesLinks(); ?>
<?php if ($this->params->def('show_pagination_results', 1)) : ?>
	<p class="counter muted"><?php echo $this->pagination->getPagesCounter(); ?></p>
<?php endif; ?>
</nav>
<?php endif; ?>