<?php
class Settings extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();		
	}
	
	public function add($data){
		$result = array();
		
		if(isset($data)){
			
			$args = array(
				"name" => $data["name"],
				"value" => $data["value"],
				"description" => $data["description"] );
			
			$this->db->trans_start();
			$this->db->insert("settings", $args);
			$this->db->trans_complete();
			
			if($this->db->trans_status() === FALSE){
				$this->result = setResult("Query Error", QUERY_ERROR, $this->db->last_query());
			}
			else{
				$this->result = setResult("SUCCESS", SUCCESS, "Account was created");
				$result["paymentId"] = $this->db->insert_id();
			}
		}
		else{
			$result = setQueryError();
		}
		
		return $result;
	}	

	
	public function edit($data){		
		$result = array();
		
		if(isset($data)){
			$args = array(
					"name" => $data["name"],
					"value" => $data["value"],
					"description" => $data["description"] );
			
			$this->db->trans_start();
			$this->db->set($args);
			$this->db->where("id", $data["id"]);
			$this->db->update("settings");
			$this->db->trans_complete();
			
			if($this->db->trans_status() === FALSE){
				$this->result = setResult("Query Error", QUERY_ERROR, $this->db->last_query());
			}
			else{
				$this->result = setResult("SUCCESS", SUCCESS, "The loan was updated.");
			}
		}
		else{
			$result = setQueryError();
		}
		return $result;
	}
	
	public function delete($id){
		$result = array();
		
		if(isset($id)){
			$this->db->trans_start();
			$this->db->delete("settings", array("id"=>$id));
			$this->db->trans_complete();
			
			if($this->db->trans_status() === FALSE){
				$this->result = setResult("Query Error", QUERY_ERROR, $this->db->last_query());
			}
			else{
				$this->result = setResult("SUCCESS", SUCCESS, "Loan was deleted");
			}			
		}
		else{
			$result = setQueryError();
		}
		return $result;		
	}
	
	public function get($id){
		$result = array();
		
		if(isset($id)){
			
			$this->db->trans_start();
			$query = $this->db->get_where("settings", array("id" => $id));
			$this->db->trans_complete();
			
			if($this->db->trans_status() === FALSE){
				$this->result = setResult("Query Error", QUERY_ERROR, $this->db->last_query());
			}
			else{
				$this->result = setResult("SUCCESS", SUCCESS, "Got the loan");
				$this->result["data"] = $query->result();
			}
		}
		else{
			$result = setQueryError();
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
				$this->result = setResult("Query Error", QUERY_ERROR, $this->db->last_query());
			}
			else{
				$this->result = setResult("SUCCESS", SUCCESS, "Got the loan");
				$this->result["data"] = $query->result();
			}
		}
		else{
			$result = setQueryError();
		}
		
		return $result;
	}
}