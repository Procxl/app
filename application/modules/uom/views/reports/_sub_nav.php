<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/reports/uom') ?>" id="list"><?php echo lang('uom_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('UOM.Reports.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/reports/uom/create') ?>" id="create_new"><?php echo lang('uom_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>