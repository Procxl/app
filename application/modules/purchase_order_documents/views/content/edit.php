<?php

$validation_errors = validation_errors();

if ($validation_errors) :
?>
<div class="alert alert-block alert-error fade in">
	<a class="close" data-dismiss="alert">&times;</a>
	<h4 class="alert-heading">Please fix the following errors:</h4>
	<?php echo $validation_errors; ?>
</div>
<?php
endif;

if (isset($purchase_order_documents))
{
	$purchase_order_documents = (array) $purchase_order_documents;
}
$id = isset($purchase_order_documents['id']) ? $purchase_order_documents['id'] : '';

?>
<div class="admin-box">
	<h3>Purchase Order Documents</h3>
	<?php echo form_open_multipart($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<?php // Change the values in this array to populate your dropdown as required
				if (is_array($doc_types_select) && count($doc_types_select)) :		
					echo form_dropdown('purchase_order_documents_doc_type', $doc_types_select, set_value('purchase_order_documents_doc_type', isset($purchase_order_documents['doc_type']) ? $purchase_order_documents['doc_type'] : ''), 'Document Type'. lang('bf_form_label_required'));
				endif;	
			?>

			<?php // Change the values in this array to populate your dropdown as required
				if (is_array($containers_select) && count($containers_select)) :		
					echo form_dropdown('purchase_order_documents_container', $containers_select, set_value('purchase_order_documents_container', isset($purchase_order_documents['container']) ? $purchase_order_documents['container'] : ''), 'Container'. lang('bf_form_label_required'));
				endif;
			?>

			<?php // Change the values in this array to populate your dropdown as required
				if (is_array($po_refs_select) && count($po_refs_select)) :
					echo form_dropdown('purchase_order_documents_po_ref', $po_refs_select, set_value('purchase_order_documents_po_ref', isset($purchase_order_documents['po_ref']) ? $purchase_order_documents['po_ref'] : ''), 'PO Ref'. lang('bf_form_label_required'));
				endif;
			?>

			<!-- Current Image -->
			<?php if(isset($purchase_order_documents) && isset($purchase_order_documents['attachments']) && !empty($purchase_order_documents['attachments'])) :
				$attachments = unserialize($purchase_order_documents['attachments']);
			?>

			<!-- Current Image Display -->
			<div class="control-group">
				<label class="control-label">Attachments</label>
				<div class="controls">
					<ul class="thumbnails">
						<li class="span6">
							<a class="lightbox" href="<?php echo base_url() . '/uploads/' . $attachments['file_name'] ?>" target="_blank" >
								<?php echo $attachments['file_name']; ?>
							</a>
							<p><?php echo anchor(SITE_AREA.'/content/purchase_order_documents/remove_attachment/'.$purchase_order_documents['id'],'Remove', 'class="btn btn-small btn-danger"'); ?></p>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<?php endif; ?>


			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('purchase_order_documents_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/content/purchase_order_documents', lang('purchase_order_documents_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Purchase_Order_Documents.Content.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('purchase_order_documents_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('purchase_order_documents_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>