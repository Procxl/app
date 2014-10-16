<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_purchase_orders extends Migration
{
	/**
	 * The name of the database table
	 *
	 * @var String
	 */
	private $table_name = 'purchase_orders';

	/**
	 * The table's fields
	 *
	 * @var Array
	 */
	private $fields = array(
		'id' => array(
			'type' => 'INT',
			'constraint' => 11,
			'auto_increment' => TRUE,
		),
		'po_num' => array(
			'type' => 'VARCHAR',
			'constraint' => 255,
			'null' => FALSE,
		),
		'po_date' => array(
			'type' => 'DATE',
			'null' => FALSE,
			'default' => '0000-00-00',
		),
		'po_ref' => array(
			'type' => 'VARCHAR',
			'constraint' => 255,
			'null' => FALSE,
		),
		'product_id' => array(
			'type' => 'INT',
			'null' => FALSE,
		),
		'quantity' => array(
			'type' => 'DECIMAL',
			'constraint' => '18,3',
			'null' => FALSE,
		),
		'uom_id' => array(
			'type' => 'INT',
			'null' => FALSE,
		),
		'reqd_by' => array(
			'type' => 'DATE',
			'null' => FALSE,
			'default' => '0000-00-00',
		),
		'status' => array(
			'type' => 'VARCHAR',
			'constraint' => 25,
			'null' => FALSE,
		),
		'customer_id'=> array(
			'type' => 'INT',
			'null' => FALSE,
		),
		'deleted' => array(
			'type' => 'TINYINT',
			'constraint' => 1,
			'default' => '0',
		),
		'created_on' => array(
			'type' => 'datetime',
			'default' => '0000-00-00 00:00:00',
		),
		'modified_on' => array(
			'type' => 'datetime',
			'default' => '0000-00-00 00:00:00',
		),
	);

	/**
	 * Install this migration
	 *
	 * @return void
	 */
	public function up()
	{
		$this->dbforge->add_field($this->fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table($this->table_name);
	}

	//--------------------------------------------------------------------

	/**
	 * Uninstall this migration
	 *
	 * @return void
	 */
	public function down()
	{
		$this->dbforge->drop_table($this->table_name);
	}

	//--------------------------------------------------------------------

}