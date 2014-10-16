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

		$this->auth->restrict('Inquiries.Developer.View');
		$this->load->model('inquiries_model', null, true);
		$this->lang->load('inquiries');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'developer/_sub_nav');

		Assets::add_module_js('inquiries', 'inquiries.js');
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
					$result = $this->inquiries_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('inquiries_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('inquiries_delete_failure') . $this->inquiries_model->error, 'error');
				}
			}
		}

		$records = $this->inquiries_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Inquiries');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Inquiries object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Inquiries.Developer.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_inquiries())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('inquiries_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'inquiries');

				Template::set_message(lang('inquiries_create_success'), 'success');
				redirect(SITE_AREA .'/developer/inquiries');
			}
			else
			{
				Template::set_message(lang('inquiries_create_failure') . $this->inquiries_model->error, 'error');
			}
		}
		Assets::add_module_js('inquiries', 'inquiries.js');

		Template::set('toolbar_title', lang('inquiries_create') . ' Inquiries');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Inquiries data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('inquiries_invalid_id'), 'error');
			redirect(SITE_AREA .'/developer/inquiries');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Inquiries.Developer.Edit');

			if ($this->save_inquiries('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('inquiries_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'inquiries');

				Template::set_message(lang('inquiries_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('inquiries_edit_failure') . $this->inquiries_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Inquiries.Developer.Delete');

			if ($this->inquiries_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('inquiries_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'inquiries');

				Template::set_message(lang('inquiries_delete_success'), 'success');

				redirect(SITE_AREA .'/developer/inquiries');
			}
			else
			{
				Template::set_message(lang('inquiries_delete_failure') . $this->inquiries_model->error, 'error');
			}
		}
		Template::set('inquiries', $this->inquiries_model->find($id));
		Template::set('toolbar_title', lang('inquiries_edit') .' Inquiries');
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
	private function save_inquiries($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['product']        = $this->input->post('inquiries_product');
		$data['quantity']        = $this->input->post('inquiries_quantity');
		$data['uom_id']        = $this->input->post('inquiries_uom_id');
		$data['required_by']        = $this->input->post('inquiries_required_by') ? $this->input->post('inquiries_required_by') : '0000-00-00';
		$data['prod_spec']        = $this->input->post('inquiries_prod_spec');
		$data['quality_spec']        = $this->input->post('inquiries_quality_spec');
		$data['packaging_spec']        = $this->input->post('inquiries_packaging_spec');
		$data['priority']        = $this->input->post('inquiries_priority');
		$data['status']        = $this->input->post('inquiries_status');
		$data['comments']        = $this->input->post('inquiries_comments');

		if ($type == 'insert')
		{
			$id = $this->inquiries_model->insert($data);

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
			$return = $this->inquiries_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}