<?php

$num_columns	= 8;
$can_delete	= $this->auth->has_permission('Purchase_Order_Documents.Content.Delete');
$can_edit		= $this->auth->has_permission('Purchase_Order_Documents.Content.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<h3>Purchase Order Documents</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th>Document Type</th>
					<th>PO Ref</th>
					<th>Container</th>
					<th>Attachments</th>
					<th><?php echo lang("purchase_order_documents_column_deleted"); ?></th>
					<th><?php echo lang("purchase_order_documents_column_created"); ?></th>
					<th><?php echo lang("purchase_order_documents_column_modified"); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('purchase_order_documents_delete_confirm'))); ?>')" />
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
				<?php 
					$doc_type_name = null;
					if (isset($doc_types)):
						foreach($doc_types as $doc_type){
							if($doc_type->id == $record->doc_type){
								$doc_type_name = $doc_type->name;		
							}
						}
					endif;					

				?>		
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/content/purchase_order_documents/edit/' . $record->id, '<span class="icon-pencil"></span>' .  $doc_type_name); ?></td>
				<?php else : ?>
					<td><?php e($doc_type_name);
						?></td>
				<?php endif; ?>
					<td><?php e($record->po_ref) ?></td>
					<td><?php e($record->container) ?></td>
					<td><?php if(isset($record) && isset($record->attachments) && !empty($record->attachments)) :
							$attachments = unserialize($record->attachments);
						?> 
							<a href="<?php echo base_url() . '/uploads/' . $attachments['file_name'] ?>" target="_blank" >
								<?php echo $attachments['file_name']; ?>
							</a>
						<?php endif; ?>		
                    </td>	
					<td><?php echo $record->deleted > 0 ? lang('purchase_order_documents_true') : lang('purchase_order_documents_false')?></td>
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