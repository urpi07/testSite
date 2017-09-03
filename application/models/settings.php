<?php
require 'restful_model.php';

class Settings extends Restful_Model{
	
	public function __construct(){
		parent::__construct();		
	}	

	public function setData($data){
		if(isset($data)){
			parent::setData($data);
			$this->args = array(
				"name" => $data["name"],
				"value" => $data["value"],
				"description" => $data["description"] );
		}
	}

	public function getAllSettings(){
		$result = array();
		
		$this->db->trans_start();
		
		$this->db->select('*');			
		$query= $this->db->get("settings");
		$query=$query->result_array();
		$this->db->trans_complete();
		
		if($this->db->trans_status() === FALSE){
			$result = setResult("Query Error", QUERY_ERROR, $this->db->last_query());
		}
		else{
			$result = setResult("SUCCESS", SUCCESS, "Got the loan");
			$result["data"] = $query;
		}
		
		return $result;
	}
	
	public function getSettingsByName($name){
		$result = array();
		
		if(isset($name)){
			$this->db->trans_start();
			
			$this->db->select('*');
			$this->db->like('name',"%$name%");
			$query=$this->db->get("settings");
			$query=$query->result_array();					
			$this->db->trans_complete();
			
			if($this->db->trans_status() === FALSE){
				$result = setResult("Query Error", QUERY_ERROR, $this->db->last_query());
			}
			else{
				$result = setResult("SUCCESS", SUCCESS, "Got the loan");
				$result["data"] = $query->result();
			}
		}
		else{
			$result = setQueryError();
		}
		
		return $result;
	}
}