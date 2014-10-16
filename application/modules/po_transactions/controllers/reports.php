<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * reports controller
 */
class reports extends Admin_Controller
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

		$this->auth->restrict('PO_Transactions.Reports.View');
		$this->load->model('po_transactions_model', null, true);
		$this->lang->load('po_transactions');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'reports/_sub_nav');

		Assets::add_module_js('po_transactions', 'po_transactions.js');
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
					$result = $this->po_transactions_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('po_transactions_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('po_transactions_delete_failure') . $this->po_transactions_model->error, 'error');
				}
			}
		}

		$records = $this->po_transactions_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage PO Transactions');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a PO Transactions object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('PO_Transactions.Reports.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_po_transactions())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('po_transactions_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'po_transactions');

				Template::set_message(lang('po_transactions_create_success'), 'success');
				redirect(SITE_AREA .'/reports/po_transactions');
			}
			else
			{
				Template::set_message(lang('po_transactions_create_failure') . $this->po_transactions_model->error, 'error');
			}
		}
		Assets::add_module_js('po_transactions', 'po_transactions.js');

		Template::set('toolbar_title', lang('po_transactions_create') . ' PO Transactions');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of PO Transactions data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('po_transactions_invalid_id'), 'error');
			redirect(SITE_AREA .'/reports/po_transactions');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('PO_Transactions.Reports.Edit');

			if ($this->save_po_transactions('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('po_transactions_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'po_transactions');

				Template::set_message(lang('po_transactions_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('po_transactions_edit_failure') . $this->po_transactions_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('PO_Transactions.Reports.Delete');

			if ($this->po_transactions_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('po_transactions_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'po_transactions');

				Template::set_message(lang('po_transactions_delete_success'), 'success');

				redirect(SITE_AREA .'/reports/po_transactions');
			}
			else
			{
				Template::set_message(lang('po_transactions_delete_failure') . $this->po_transactions_model->error, 'error');
			}
		}
		Template::set('po_transactions', $this->po_transactions_model->find($id));
		Template::set('toolbar_title', lang('po_transactions_edit') .' PO Transactions');
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
	private function save_po_transactions($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['po_ref']        = $this->input->post('po_transactions_po_ref');
		$data['trans_type']        = $this->input->post('po_transactions_trans_type');
		$data['remit_date']        = $this->input->post('po_transactions_remit_date') ? $this->input->post('po_transactions_remit_date') : '0000-00-00';
		$data['rcvd_date']        = $this->input->post('po_transactions_rcvd_date') ? $this->input->post('po_transactions_rcvd_date') : '0000-00-00';
		$data['amount']        = $this->input->post('po_transactions_amount');
		$data['vendor_id']        = $this->input->post('po_transactions_vendor_id');

		if ($type == 'insert')
		{
			$id = $this->po_transactions_model->insert($data);

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
			$return = $this->po_transactions_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}