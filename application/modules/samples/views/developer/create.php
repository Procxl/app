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

if (isset($samples))
{
	$samples = (array) $samples;
}
$id = isset($samples['id']) ? $samples['id'] : '';

?>
<div class="admin-box">
	<h3>Samples</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
				);

				echo form_dropdown('samples_product_id', $options, set_value('samples_product_id', isset($samples['product_id']) ? $samples['product_id'] : ''), 'Product'. lang('bf_form_label_required'));
			?>

			<div class="control-group <?php echo form_error('quantity') ? 'error' : ''; ?>">
				<?php echo form_label('Quantity', 'samples_quantity', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='samples_quantity' type='text' name='samples_quantity' maxlength="19" value="<?php echo set_value('samples_quantity', isset($samples['quantity']) ? $samples['quantity'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('quantity'); ?></span>
				</div>
			</div>

			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
				);

				echo form_dropdown('samples_uom_id', $options, set_value('samples_uom_id', isset($samples['uom_id']) ? $samples['uom_id'] : ''), 'UOM');
			?>

			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
				);

				echo form_dropdown('samples_vendor_id', $options, set_value('samples_vendor_id', isset($samples['vendor_id']) ? $samples['vendor_id'] : ''), 'Vendor');
			?>

			<div class="control-group <?php echo form_error('date_received') ? 'error' : ''; ?>">
				<?php echo form_label('Date Received', 'samples_date_received', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='samples_date_received' type='text' name='samples_date_received'  value="<?php echo set_value('samples_date_received', isset($samples['date_received']) ? $samples['date_received'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('date_received'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('samples_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/developer/samples', lang('samples_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>