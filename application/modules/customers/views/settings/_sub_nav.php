<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/settings/customers') ?>" id="list"><?php echo lang('customers_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Customers.Settings.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/settings/customers/create') ?>" id="create_new"><?php echo lang('customers_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>