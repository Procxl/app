<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/developer/containers') ?>" id="list"><?php echo lang('containers_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Containers.Developer.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/developer/containers/create') ?>" id="create_new"><?php echo lang('containers_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>