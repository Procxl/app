<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * content controller
 */
class content extends Admin_Controller
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

		$this->auth->restrict('Purchase_Order_Documents.Content.View');
		$this->load->model('purchase_order_documents_model', null, true);
		$this->load->model(array('containers/containers_model', 'purchase_orders/purchase_orders_model', 'document_types/document_types_model'));
		$this->lang->load('purchase_order_documents');
		
		Template::set_block('sub_nav', 'content/_sub_nav');

		Assets::add_module_js('purchase_order_documents', 'purchase_order_documents.js');

		$doc_types_select = $this->document_types_model->get_doc_types_select();
		Template::set('doc_types_select', $doc_types_select);

		$doc_types = $this->document_types_model->get_doc_types();
		Template::set('doc_types', $doc_types);

		$po_refs_select = $this->purchase_orders_model->get_po_ref_select();
		Template::set('po_refs_select', $po_refs_select);

		$po_refs = $this->purchase_orders_model->get_po_refs();
		Template::set('po_refs', $po_refs);

		$containers_select = $this->containers_model->get_containers_select();
		Template::set('containers_select', $containers_select);

		$containers = $this->containers_model->get_containers();
		Template::set('containers', $containers);

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
		$this->auth->restrict('Purchase_Order_Documents.Content.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_purchase_order_documents())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('purchase_order_documents_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'purchase_order_documents');

				Template::set_message(lang('purchase_order_documents_create_success'), 'success');
				redirect(SITE_AREA .'/content/purchase_order_documents');
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
			redirect(SITE_AREA .'/content/purchase_order_documents');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Purchase_Order_Documents.Content.Edit');

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
			$this->auth->restrict('Purchase_Order_Documents.Content.Delete');

			if ($this->purchase_order_documents_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('purchase_order_documents_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'purchase_order_documents');

				Template::set_message(lang('purchase_order_documents_delete_success'), 'success');

				redirect(SITE_AREA .'/content/purchase_order_documents');
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

		if (isset($_FILES['attachments']) && is_array($_FILES['attachments']) && $_FILES['attachments']['error'] != 4)
        {
			// make sure we only pass in the fields we want
			$file_path = '/var/www/crm/public/uploads';

			$config['upload_path']		= $file_path;
			$config['allowed_types']	= 'pdf';

			$this->load->library('upload', $config);
			echo "hree";
			if ( ! $this->upload->do_upload('attachments'))
			{
				return array('error'=>$this->upload->display_errors());
			}else{
				$data['attachments'] = serialize($this->upload->data());			
			}		

		}

		$data['doc_type']        = $this->input->post('purchase_order_documents_doc_type');
		$data['po_ref']        = $this->input->post('purchase_order_documents_po_ref');
		$data['container']        = $this->input->post('purchase_order_documents_container');

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