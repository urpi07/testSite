<?php
class Tester extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function getTables(){
		return $this->db->list_tables();
	}
	
	public function getTableFields($tableName){
		return $this->db->list_fields($tableName);
	}
	
	public function getTableFieldsData($tableName){
		return $this->db->field_data($tableName);
	}
}