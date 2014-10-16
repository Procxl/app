<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/developer/samples') ?>" id="list"><?php echo lang('samples_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Samples.Developer.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/developer/samples/create') ?>" id="create_new"><?php echo lang('samples_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>