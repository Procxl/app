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

		$this->auth->restrict('Containers.Developer.View');
		$this->load->model('containers_model', null, true);
		$this->lang->load('containers');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'developer/_sub_nav');

		Assets::add_module_js('containers', 'containers.js');
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
					$result = $this->containers_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('containers_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('containers_delete_failure') . $this->containers_model->error, 'error');
				}
			}
		}

		$records = $this->containers_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Containers');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Containers object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Containers.Developer.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_containers())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('containers_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'containers');

				Template::set_message(lang('containers_create_success'), 'success');
				redirect(SITE_AREA .'/developer/containers');
			}
			else
			{
				Template::set_message(lang('containers_create_failure') . $this->containers_model->error, 'error');
			}
		}
		Assets::add_module_js('containers', 'containers.js');

		Template::set('toolbar_title', lang('containers_create') . ' Containers');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Containers data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('containers_invalid_id'), 'error');
			redirect(SITE_AREA .'/developer/containers');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Containers.Developer.Edit');

			if ($this->save_containers('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('containers_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'containers');

				Template::set_message(lang('containers_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('containers_edit_failure') . $this->containers_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Containers.Developer.Delete');

			if ($this->containers_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('containers_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'containers');

				Template::set_message(lang('containers_delete_success'), 'success');

				redirect(SITE_AREA .'/developer/containers');
			}
			else
			{
				Template::set_message(lang('containers_delete_failure') . $this->containers_model->error, 'error');
			}
		}
		Template::set('containers', $this->containers_model->find($id));
		Template::set('toolbar_title', lang('containers_edit') .' Containers');
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
	private function save_containers($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['po_ref']        = $this->input->post('containers_po_ref');
		$data['container_no']        = $this->input->post('containers_container_no');
		$data['seal']        = $this->input->post('containers_seal');
		$data['origin']        = $this->input->post('containers_origin');
		$data['batch_nos']        = $this->input->post('containers_batch_nos');
		$data['product']        = $this->input->post('containers_product');
		$data['status']        = $this->input->post('containers_status');
		$data['started_on']        = $this->input->post('containers_started_on') ? $this->input->post('containers_started_on') : '0000-00-00';
		$data['arrived_on']        = $this->input->post('containers_arrived_on') ? $this->input->post('containers_arrived_on') : '0000-00-00';

		if ($type == 'insert')
		{
			$id = $this->containers_model->insert($data);

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
			$return = $this->containers_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}