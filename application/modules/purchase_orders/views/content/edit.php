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

if (isset($purchase_orders))
{
	$purchase_orders = (array) $purchase_orders;
}
$id = isset($purchase_orders['id']) ? $purchase_orders['id'] : '';

?>
<div class="admin-box">
	<h3>Purchase Orders</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('po_num') ? 'error' : ''; ?>">
				<?php echo form_label('Number'. lang('bf_form_label_required'), 'purchase_orders_po_num', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='purchase_orders_po_num' type='text' name='purchase_orders_po_num' maxlength="255" value="<?php echo set_value('purchase_orders_po_num', isset($purchase_orders['po_num']) ? $purchase_orders['po_num'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('po_num'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('po_date') ? 'error' : ''; ?>">
				<?php echo form_label('Date'. lang('bf_form_label_required'), 'purchase_orders_po_date', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='purchase_orders_po_date' type='text' name='purchase_orders_po_date'  value="<?php echo set_value('purchase_orders_po_date', isset($purchase_orders['po_date']) ? $purchase_orders['po_date'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('po_date'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('po_ref') ? 'error' : ''; ?>">
				<?php echo form_label('PO Reference'. lang('bf_form_label_required'), 'purchase_orders_po_ref', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='purchase_orders_po_ref' type='text' name='purchase_orders_po_ref' maxlength="255" value="<?php echo set_value('purchase_orders_po_ref', isset($purchase_orders['po_ref']) ? $purchase_orders['po_ref'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('po_ref'); ?></span>
				</div>
			</div>

			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
				);

				echo form_dropdown('purchase_orders_product', $options, set_value('purchase_orders_product', isset($purchase_orders['product']) ? $purchase_orders['product'] : ''), 'Product'. lang('bf_form_label_required'));
			?>

			<div class="control-group <?php echo form_error('quantity') ? 'error' : ''; ?>">
				<?php echo form_label('Quantity'. lang('bf_form_label_required'), 'purchase_orders_quantity', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='purchase_orders_quantity' type='text' name='purchase_orders_quantity' maxlength="19" value="<?php echo set_value('purchase_orders_quantity', isset($purchase_orders['quantity']) ? $purchase_orders['quantity'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('quantity'); ?></span>
				</div>
			</div>

			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
				);

				echo form_dropdown('purchase_orders_uom', $options, set_value('purchase_orders_uom', isset($purchase_orders['uom']) ? $purchase_orders['uom'] : ''), 'UOM'. lang('bf_form_label_required'));
			?>

			<div class="control-group <?php echo form_error('reqd_by') ? 'error' : ''; ?>">
				<?php echo form_label('Required By', 'purchase_orders_reqd_by', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='purchase_orders_reqd_by' type='text' name='purchase_orders_reqd_by'  value="<?php echo set_value('purchase_orders_reqd_by', isset($purchase_orders['reqd_by']) ? $purchase_orders['reqd_by'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('reqd_by'); ?></span>
				</div>
			</div>

			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
					25 => 25,
				);

				echo form_dropdown('purchase_orders_status', $options, set_value('purchase_orders_status', isset($purchase_orders['status']) ? $purchase_orders['status'] : ''), 'Status'. lang('bf_form_label_required'));
			?>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('purchase_orders_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/content/purchase_orders', lang('purchase_orders_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Purchase_Orders.Content.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('purchase_orders_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('purchase_orders_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>