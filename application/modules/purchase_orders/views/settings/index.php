<?php

$num_columns	= 12;
$can_delete	= $this->auth->has_permission('Purchase_Orders.Settings.Delete');
$can_edit		= $this->auth->has_permission('Purchase_Orders.Settings.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<h3>Purchase Orders</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th>Number</th>
					<th>Date</th>
					<th>PO Reference</th>
					<th>Product</th>
					<th>Quantity</th>
					<th>UOM</th>
					<th>Required By</th>
					<th>Status</th>
					<th><?php echo lang("purchase_orders_column_deleted"); ?></th>
					<th><?php echo lang("purchase_orders_column_created"); ?></th>
					<th><?php echo lang("purchase_orders_column_modified"); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('purchase_orders_delete_confirm'))); ?>')" />
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class="column-check"><input type="checkbox" name="checked[]" value="<?php echo $record->id; ?>" /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/settings/purchase_orders/edit/' . $record->id, '<span class="icon-pencil"></span>' .  $record->po_num); ?></td>
				<?php else : ?>
					<td><?php e($record->po_num); ?></td>
				<?php endif; ?>
					<td><?php e($record->po_date) ?></td>
					<td><?php e($record->po_ref) ?></td>
					<td><?php e($record->product) ?></td>
					<td><?php e($record->quantity) ?></td>
					<td><?php e($record->uom) ?></td>
					<td><?php e($record->reqd_by) ?></td>
					<td><?php e($record->status) ?></td>
					<td><?php echo $record->deleted > 0 ? lang('purchase_orders_true') : lang('purchase_orders_false')?></td>
					<td><?php e($record->created_on) ?></td>
					<td><?php e($record->modified_on) ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">No records found that match your selection.</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php echo form_close(); ?>
</div>