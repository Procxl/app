<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * settings controller
 */
class settings extends Admin_Controller
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

		$this->auth->restrict('Samples.Settings.View');
		$this->load->model('samples_model', null, true);
		$this->lang->load('samples');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'settings/_sub_nav');

		Assets::add_module_js('samples', 'samples.js');
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
					$result = $this->samples_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('samples_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('samples_delete_failure') . $this->samples_model->error, 'error');
				}
			}
		}

		$records = $this->samples_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Samples');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Samples object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Samples.Settings.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_samples())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('samples_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'samples');

				Template::set_message(lang('samples_create_success'), 'success');
				redirect(SITE_AREA .'/settings/samples');
			}
			else
			{
				Template::set_message(lang('samples_create_failure') . $this->samples_model->error, 'error');
			}
		}
		Assets::add_module_js('samples', 'samples.js');

		Template::set('toolbar_title', lang('samples_create') . ' Samples');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Samples data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('samples_invalid_id'), 'error');
			redirect(SITE_AREA .'/settings/samples');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Samples.Settings.Edit');

			if ($this->save_samples('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('samples_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'samples');

				Template::set_message(lang('samples_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('samples_edit_failure') . $this->samples_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Samples.Settings.Delete');

			if ($this->samples_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('samples_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'samples');

				Template::set_message(lang('samples_delete_success'), 'success');

				redirect(SITE_AREA .'/settings/samples');
			}
			else
			{
				Template::set_message(lang('samples_delete_failure') . $this->samples_model->error, 'error');
			}
		}
		Template::set('samples', $this->samples_model->find($id));
		Template::set('toolbar_title', lang('samples_edit') .' Samples');
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
	private function save_samples($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['product_id']        = $this->input->post('samples_product_id');
		$data['quantity']        = $this->input->post('samples_quantity');
		$data['uom_id']        = $this->input->post('samples_uom_id');
		$data['vendor_id']        = $this->input->post('samples_vendor_id');
		$data['date_received']        = $this->input->post('samples_date_received') ? $this->input->post('samples_date_received') : '0000-00-00';

		if ($type == 'insert')
		{
			$id = $this->samples_model->insert($data);

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
			$return = $this->samples_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}