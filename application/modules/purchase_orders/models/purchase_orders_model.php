<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Purchase_orders_model extends BF_Model {

	protected $table_name	= "purchase_orders";
	protected $key			= "id";
	protected $soft_deletes	= true;
	protected $date_format	= "datetime";

	protected $log_user 	= FALSE;

	protected $set_created	= true;
	protected $set_modified = true;
	protected $created_field = "created_on";
	protected $modified_field = "modified_on";

	/*
		Customize the operations of the model without recreating the insert, update,
		etc methods by adding the method names to act as callbacks here.
	 */
	protected $before_insert 	= array();
	protected $after_insert 	= array();
	protected $before_update 	= array();
	protected $after_update 	= array();
	protected $before_find 		= array();
	protected $after_find 		= array();
	protected $before_delete 	= array();
	protected $after_delete 	= array();

	/*
		For performance reasons, you may require your model to NOT return the
		id of the last inserted row as it is a bit of a slow method. This is
		primarily helpful when running big loops over data.
	 */
	protected $return_insert_id 	= TRUE;

	// The default type of element data is returned as.
	protected $return_type 			= "object";

	// Items that are always removed from data arrays prior to
	// any inserts or updates.
	protected $protected_attributes = array();

	/*
		You may need to move certain rules (like required) into the
		$insert_validation_rules array and out of the standard validation array.
		That way it is only required during inserts, not updates which may only
		be updating a portion of the data.
	 */
	protected $validation_rules 		= array(
		array(
			"field"		=> "purchase_orders_po_num",
			"label"		=> "Number",
			"rules"		=> "required|max_length[255]"
		),
		array(
			"field"		=> "purchase_orders_po_date",
			"label"		=> "Date",
			"rules"		=> "required"
		),
		array(
			"field"		=> "purchase_orders_po_ref",
			"label"		=> "PO Reference",
			"rules"		=> "required|min_length[3]|max_length[255]"
		),
		array(
			"field"		=> "purchase_orders_customer_id",
			"label"		=> "Customer",
			"rules"		=> "required|is_natural_no_zero"
		),
		array(
			"field"		=> "purchase_orders_product_id",
			"label"		=> "Product",
			"rules"		=> "required|is_natural_no_zero"
		),
		array(
			"field"		=> "purchase_orders_quantity",
			"label"		=> "Quantity",
			"rules"		=> "required|max_length[19]"
		),
		array(
			"field"		=> "purchase_orders_uom_id",
			"label"		=> "UOM",
			"rules"		=> "required|is_natural_no_zero"
		),
		array(
			"field"		=> "purchase_orders_reqd_by",
			"label"		=> "Required By",
			"rules"		=> ""
		),
		array(
			"field"		=> "purchase_orders_status",
			"label"		=> "Status",
			"rules"		=> "required|min_length[3]|max_length[25]"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------

	public function get_po_ref_select ( )
	{
		$query = $this->db->select('po_ref')->get('purchase_orders');

		if ( $query->num_rows() <= 0 )
			return '';

		$option = array();
		$option['-1'] = 'Select one';
		foreach ($query->result() as $row)
		{
			$option[$row->po_ref] = $row->po_ref;
		}

		$query->free_result();

		return $option;
	}

	//--------------------------------------------------------------------

	public function get_po_refs()
	{
		$query = $this->db->select('po_ref')->get('purchase_orders');

		if ($query->num_rows() > 0)
		{
			return $query->result();
		} else {
			return null;
		}
	}

	//--------------------------------------------------------------------
}
