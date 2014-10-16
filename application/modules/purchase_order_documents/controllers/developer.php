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

		$this->auth->restrict('Purchase_Order_Documents.Developer.View');
		$this->load->model('purchase_order_documents_model', null, true);
		$this->lang->load('purchase_order_documents');
		
		Template::set_block('sub_nav', 'developer/_sub_nav');

		Assets::add_module_js('purchase_order_documents', 'purchase_order_documents.js');
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
					$result = $this->purchase_order_documents_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('purchase_order_documents_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('purchase_order_documents_delete_failure') . $this->purchase_order_documents_model->error, 'error');
				}
			}
		}

		$records = $this->purchase_order_documents_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Purchase Order Documents');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Purchase Order Documents object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Purchase_Order_Documents.Developer.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_purchase_order_documents())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('purchase_order_documents_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'purchase_order_documents');

				Template::set_message(lang('purchase_order_documents_create_success'), 'success');
				redirect(SITE_AREA .'/developer/purchase_order_documents');
			}
			else
			{
				Template::set_message(lang('purchase_order_documents_create_failure') . $this->purchase_order_documents_model->error, 'error');
			}
		}
		Assets::add_module_js('purchase_order_documents', 'purchase_order_documents.js');

		Template::set('toolbar_title', lang('purchase_order_documents_create') . ' Purchase Order Documents');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Purchase Order Documents data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('purchase_order_documents_invalid_id'), 'error');
			redirect(SITE_AREA .'/developer/purchase_order_documents');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Purchase_Order_Documents.Developer.Edit');

			if ($this->save_purchase_order_documents('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('purchase_order_documents_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'purchase_order_documents');

				Template::set_message(lang('purchase_order_documents_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('purchase_order_documents_edit_failure') . $this->purchase_order_documents_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Purchase_Order_Documents.Developer.Delete');

			if ($this->purchase_order_documents_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('purchase_order_documents_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'purchase_order_documents');

				Template::set_message(lang('purchase_order_documents_delete_success'), 'success');

				redirect(SITE_AREA .'/developer/purchase_order_documents');
			}
			else
			{
				Template::set_message(lang('purchase_order_documents_delete_failure') . $this->purchase_order_documents_model->error, 'error');
			}
		}
		Template::set('purchase_order_documents', $this->purchase_order_documents_model->find($id));
		Template::set('toolbar_title', lang('purchase_order_documents_edit') .' Purchase Order Documents');
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
	private function save_purchase_order_documents($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['doc_type']        = $this->input->post('purchase_order_documents_doc_type');
		$data['po_ref']        = $this->input->post('purchase_order_documents_po_ref');
		$data['attachments']        = $this->input->post('purchase_order_documents_attachments');

		if ($type == 'insert')
		{
			$id = $this->purchase_order_documents_model->insert($data);

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
			$return = $this->purchase_order_documents_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}