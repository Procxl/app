<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/reports/purchase_order_documents') ?>" id="list"><?php echo lang('purchase_order_documents_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Purchase_Order_Documents.Reports.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/reports/purchase_order_documents/create') ?>" id="create_new"><?php echo lang('purchase_order_documents_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>