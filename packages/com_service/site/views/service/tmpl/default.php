<?php
/**
 * @package     Service
 * @subpackage  com_service
 * @copyright   Copyright (C) 2013 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

?>
<section class="service<?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->params->get('show_page_heading')): ?>
	<div class="page-header">
		<h1>
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		</h1>
	</div>
	<?php endif; ?>

	<h2>
		<?php echo $this->escape($this->item->title); ?>
	</h2>

	<?php var_dump($this->item); ?>
</section>