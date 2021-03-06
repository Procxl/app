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

if (isset($inquiries))
{
	$inquiries = (array) $inquiries;
}
$id = isset($inquiries['id']) ? $inquiries['id'] : '';

?>
<div class="admin-box">
	<h3>Inquiries</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('product') ? 'error' : ''; ?>">
				<?php echo form_label('Product'. lang('bf_form_label_required'), 'inquiries_product', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='inquiries_product' type='text' name='inquiries_product' maxlength="255" value="<?php echo set_value('inquiries_product', isset($inquiries['product']) ? $inquiries['product'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('product'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('quantity') ? 'error' : ''; ?>">
				<?php echo form_label('Quantity'. lang('bf_form_label_required'), 'inquiries_quantity', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='inquiries_quantity' type='text' name='inquiries_quantity' maxlength="19" value="<?php echo set_value('inquiries_quantity', isset($inquiries['quantity']) ? $inquiries['quantity'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('quantity'); ?></span>
				</div>
			</div>

			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
				);

				echo form_dropdown('inquiries_uom_id', $options, set_value('inquiries_uom_id', isset($inquiries['uom_id']) ? $inquiries['uom_id'] : ''), 'UOM'. lang('bf_form_label_required'));
			?>

			<div class="control-group <?php echo form_error('required_by') ? 'error' : ''; ?>">
				<?php echo form_label('Required By', 'inquiries_required_by', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='inquiries_required_by' type='text' name='inquiries_required_by'  value="<?php echo set_value('inquiries_required_by', isset($inquiries['required_by']) ? $inquiries['required_by'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('required_by'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('prod_spec') ? 'error' : ''; ?>">
				<?php echo form_label('Product Specifications', 'inquiries_prod_spec', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'inquiries_prod_spec', 'id' => 'inquiries_prod_spec', 'rows' => '5', 'cols' => '80', 'value' => set_value('inquiries_prod_spec', isset($inquiries['prod_spec']) ? $inquiries['prod_spec'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('prod_spec'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('quality_spec') ? 'error' : ''; ?>">
				<?php echo form_label('Quality Specifications', 'inquiries_quality_spec', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'inquiries_quality_spec', 'id' => 'inquiries_quality_spec', 'rows' => '5', 'cols' => '80', 'value' => set_value('inquiries_quality_spec', isset($inquiries['quality_spec']) ? $inquiries['quality_spec'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('quality_spec'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('packaging_spec') ? 'error' : ''; ?>">
				<?php echo form_label('Packaging Specifications', 'inquiries_packaging_spec', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'inquiries_packaging_spec', 'id' => 'inquiries_packaging_spec', 'rows' => '5', 'cols' => '80', 'value' => set_value('inquiries_packaging_spec', isset($inquiries['packaging_spec']) ? $inquiries['packaging_spec'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('packaging_spec'); ?></span>
				</div>
			</div>

			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
					50 => 50,
				);

				echo form_dropdown('inquiries_priority', $options, set_value('inquiries_priority', isset($inquiries['priority']) ? $inquiries['priority'] : ''), 'Priority'. lang('bf_form_label_required'));
			?>

			<?php // Change the values in this array to populate your dropdown as required
				$options = array(
					50 => 50,
				);

				echo form_dropdown('inquiries_status', $options, set_value('inquiries_status', isset($inquiries['status']) ? $inquiries['status'] : ''), 'Status');
			?>

			<div class="control-group <?php echo form_error('comments') ? 'error' : ''; ?>">
				<?php echo form_label('Comments', 'inquiries_comments', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<?php echo form_textarea( array( 'name' => 'inquiries_comments', 'id' => 'inquiries_comments', 'rows' => '5', 'cols' => '80', 'value' => set_value('inquiries_comments', isset($inquiries['comments']) ? $inquiries['comments'] : '') ) ); ?>
					<span class='help-inline'><?php echo form_error('comments'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('inquiries_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/settings/inquiries', lang('inquiries_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Inquiries.Settings.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('inquiries_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('inquiries_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>