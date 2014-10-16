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
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
				);

				echo form_dropdown('purchase_order_documents_doc_type', $options, set_value('purchase_order_documents_doc_type', isset($purchase_order_documents['doc_type']) ? $purchase_order_documents['doc_type'] : ''), 'Document Type'. lang('bf_form_label_required'));
			?>

			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
					255 => 255,
				);

				echo form_dropdown('purchase_order_documents_po_ref', $options, set_value('purchase_order_documents_po_ref', isset($purchase_order_documents['po_ref']) ? $purchase_order_documents['po_ref'] : ''), 'PO Ref'. lang('bf_form_label_required'));
			?>

			<div class="control-group <?php echo form_error('attachments') ? 'error' : ''; ?>">
				<?php echo form_label('Attachments'. lang('bf_form_label_required'), 'purchase_order_documents_attachments', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='purchase_order_documents_attachments' type='text' name='purchase_order_documents_attachments' maxlength="255" value="<?php echo set_value('purchase_order_documents_attachments', isset($purchase_order_documents['attachments']) ? $purchase_order_documents['attachments'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('attachments'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('purchase_order_documents_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/developer/purchase_order_documents', lang('purchase_order_documents_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>