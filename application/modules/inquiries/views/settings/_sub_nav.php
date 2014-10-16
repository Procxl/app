<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/settings/inquiries') ?>" id="list"><?php echo lang('inquiries_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Inquiries.Settings.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/settings/inquiries/create') ?>" id="create_new"><?php echo lang('inquiries_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>