<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * purchase_order_documents controller
 */
class purchase_order_documents extends Front_Controller
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

		$this->load->library('form_validation');
		$this->load->model('purchase_order_documents_model', null, true);
		$this->lang->load('purchase_order_documents');
		

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

		$records = $this->purchase_order_documents_model->find_all();

		Template::set('records', $records);
		Template::render();
	}

	//--------------------------------------------------------------------

	public function top_po_documents(){

		$records = $this->purchase_order_documents_model->get_top_po_documents();

		$data = array('records' => $records);

		return $this->load->view('content/top_po_documents', $data, true);

	}

}