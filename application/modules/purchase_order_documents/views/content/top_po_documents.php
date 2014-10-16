<?php

$num_columns	= 8;
$can_delete	= $this->auth->has_permission('Purchase_Order_Documents.Content.Delete');
$can_edit		= $this->auth->has_permission('Purchase_Order_Documents.Content.Edit');
$can_view 		= $this->auth->has_permission('Purchase_Order_Documents.Content.View');
$has_records	= isset($records) && is_array($records) && count($records);
if (!$can_view){
	exit;
}
?>
<div class="admin-box">
	<h5>Documents</h5>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-condensed table-bordered">
			<thead>
				<tr>
                    <th>PO Ref</th>    
					<th>Container</th>
					<th>Document Type</th>
					<th>Attachments</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if ($has_records) :
					$c_no = null;
					$skip_row = false;
					foreach ($records as $record) :
						if ($c_no == $record->container_no){
							$skip_row = true;	
						}else{
							$skip_row = false;
							$c_no = $record->container_no;
						}		
						echo $c_no;
						echo $skip_row;
				?>
				<tr>
					<td><?php echo $skip_row == true ? '&nbsp;' : e($record->container) ?></td>
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/content/purchase_order_documents/edit/' . $record->id, '<span class="icon-pencil"></span>' .  $record->doc_type_name); ?></td>
				<?php else : ?>
					<td><?php e($record->doc_type_name);
						?></td>
				<?php endif; ?>
			
					<td><?php if(isset($record) && isset($record->attachments) && !empty($record->attachments)) :
							$attachments = unserialize($record->attachments);
						?> 
							<a href="<?php echo base_url() . '/uploads/' . $attachments['file_name'] ?>" target="_blank" >
								<?php echo $attachments['file_name']; ?>
							</a>
						<?php endif; ?></td>		
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