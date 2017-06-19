<?php

//Here we encapsulate the repetitive operations
//that are the generic add, edit and delete.
class genericQuery extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function add($table, $arg){
		
		if(isset($table) && isset($arg)){
			
		}
	}
	
	public function edit($table, $arg){
		if(isset($table) && isset($arg)){
			
		}
	}
	
	public function delete($table, $id){
		
		$res = "";
		if(isset($table) && isset($id)){
			$res = $this->db->delete($table, array("id"=>$id));
		}
		
		return $res;
	}
	
	public function get($table, $id){
		
		$res = null;
		if(isset($table) && isset($id)){
			$query = $this->db->get_where($table, array("id"=>$id));			
			$res = $query->result();
		}
		
		return $res[0];
	}
}