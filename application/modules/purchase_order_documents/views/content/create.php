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

			<div class="control-group <?php echo form_error('attachments') ? 'error' : ''; ?>">
				<?php echo form_label('Attachments'. lang('bf_form_label_required'), 'purchase_order_documents_attachments', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='attachments' type='file' name='attachments'  />
					<span class='help-inline'><?php echo form_error('attachments'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('purchase_order_documents_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/content/purchase_order_documents', lang('purchase_order_documents_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>