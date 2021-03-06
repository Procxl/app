<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_po_transactions extends Migration
{
	/**
	 * The name of the database table
	 *
	 * @var String
	 */
	private $table_name = 'po_transactions';

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
		'po_ref' => array(
			'type' => 'VARCHAR',
			'constraint' => 255,
			'null' => FALSE,
		),
		'trans_type' => array(
			'type' => 'VARCHAR',
			'constraint' => 255,
			'null' => FALSE,
		),
		'remit_date' => array(
			'type' => 'DATE',
			'null' => FALSE,
			'default' => '0000-00-00',
		),
		'rcvd_date' => array(
			'type' => 'DATE',
			'null' => FALSE,
			'default' => '0000-00-00',
		),
		'amount' => array(
			'type' => 'DECIMAL',
			'constraint' => '18,3',
			'null' => FALSE,
		),
		'vendor_id' => array(
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