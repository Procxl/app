<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * developer controller
 */
class developer extends Admin_Controller
{

	//--------------------------------------------------------------------


	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Purchase_Orders.Developer.View');
		$this->load->model('purchase_orders_model', null, true);
		$this->lang->load('purchase_orders');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'developer/_sub_nav');

		Assets::add_module_js('purchase_orders', 'purchase_orders.js');
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{

		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->purchase_orders_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('purchase_orders_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('purchase_orders_delete_failure') . $this->purchase_orders_model->error, 'error');
				}
			}
		}

		$records = $this->purchase_orders_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Purchase Orders');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Purchase Orders object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Purchase_Orders.Developer.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_purchase_orders())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('purchase_orders_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'purchase_orders');

				Template::set_message(lang('purchase_orders_create_success'), 'success');
				redirect(SITE_AREA .'/developer/purchase_orders');
			}
			else
			{
				Template::set_message(lang('purchase_orders_create_failure') . $this->purchase_orders_model->error, 'error');
			}
		}
		Assets::add_module_js('purchase_orders', 'purchase_orders.js');

		Template::set('toolbar_title', lang('purchase_orders_create') . ' Purchase Orders');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Purchase Orders data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('purchase_orders_invalid_id'), 'error');
			redirect(SITE_AREA .'/developer/purchase_orders');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Purchase_Orders.Developer.Edit');

			if ($this->save_purchase_orders('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('purchase_orders_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'purchase_orders');

				Template::set_message(lang('purchase_orders_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('purchase_orders_edit_failure') . $this->purchase_orders_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Purchase_Orders.Developer.Delete');

			if ($this->purchase_orders_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('purchase_orders_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'purchase_orders');

				Template::set_message(lang('purchase_orders_delete_success'), 'success');

				redirect(SITE_AREA .'/developer/purchase_orders');
			}
			else
			{
				Template::set_message(lang('purchase_orders_delete_failure') . $this->purchase_orders_model->error, 'error');
			}
		}
		Template::set('purchase_orders', $this->purchase_orders_model->find($id));
		Template::set('toolbar_title', lang('purchase_orders_edit') .' Purchase Orders');
		Template::render();
	}

	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/**
	 * Summary
	 *
	 * @param String $type Either "insert" or "update"
	 * @param Int	 $id	The ID of the record to update, ignored on inserts
	 *
	 * @return Mixed    An INT id for successful inserts, TRUE for successful updates, else FALSE
	 */
	private function save_purchase_orders($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['po_num']        = $this->input->post('purchase_orders_po_num');
		$data['po_date']        = $this->input->post('purchase_orders_po_date') ? $this->input->post('purchase_orders_po_date') : '0000-00-00';
		$data['po_ref']        = $this->input->post('purchase_orders_po_ref');
		$data['product']        = $this->input->post('purchase_orders_product');
		$data['quantity']        = $this->input->post('purchase_orders_quantity');
		$data['uom']        = $this->input->post('purchase_orders_uom');
		$data['reqd_by']        = $this->input->post('purchase_orders_reqd_by') ? $this->input->post('purchase_orders_reqd_by') : '0000-00-00';
		$data['status']        = $this->input->post('purchase_orders_status');

		if ($type == 'insert')
		{
			$id = $this->purchase_orders_model->insert($data);

			if (is_numeric($id))
			{
				$return = $id;
			}
			else
			{
				$return = FALSE;
			}
		}
		elseif ($type == 'update')
		{
			$return = $this->purchase_orders_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}