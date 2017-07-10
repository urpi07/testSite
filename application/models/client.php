<?php
class Client extends CI_Model{

	private $isDebugMode = false;
	private $result = null;
	
	public function __construct(){
		parent::__construct();
		
		$this->load->database();
		$this->load->helper("lendebug");
	}
	
	public function add($data){
		
		if(isset($data)){
			$bday = strtotime($data['birthdate']);
			$formattedBday = date('Y-m-d',$bday);
			$result;
			
			$args = array(
					"firstName"=>$data['firstName'],
					"lastName"=>$data['lastName'],
					"middleName"=>$data['middleName'],
					"email"=>$data['email'],
					"phoneNumber"=>$data['phone'],
					"birthdate"=>$formattedBday,
					"gender"=>$data["gender"],
					"address"=>$data["address"],
					"comment"=>$data["comments"]
			);
			
			$this->db->trans_start();
			$this->db->insert("client", $args);
			$this->db->trans_complete();
			//echoLog($this->db->last_query(), $this->isDebugMode);
			
			if($this->db->trans_status() === FALSE){
				$this->result = setResult("Query Error", QUERY_ERROR, $this->db->last_query());
			}
			else{
				$this->result = setResult("SUCCESS", SUCCESS, "Account was created");				
				$result["userId"] = $this->db->insert_id();
			}
		}
		else{
			$this->result = setQueryError();
		}
		
		return $this->result;				
	}
	
	public function edit($data){
		
		if( isset($data) ){
			$args = array(
					"firstName"=>$data['firstName'],
					"lastName"=>$data['lastName'],
					"middleName"=>$data['middleName'],
					"email"=>$data['email'],
					"phoneNumber"=>$data['phone'],
					"birthdate"=>$data["birthdate"],
					"gender"=>$data["gender"],
					"address"=>$data["address"],
					"comment"=>$data["comments"]
			);
			
			$this->db->trans_start();
			$this->db->set($args);
			$this->db->where("id", $data["id"]);
			$this->db->update("client");
			$this->db->trans_complete();
			
			if($this->db->trans_status() === FALSE){
				$this->result = setResult("Query Error", QUERY_ERROR, $this->db->last_query());
			}
			else{
				$this->result = setResult("SUCCESS", SUCCESS, "Account was updated");
			}			
		}
		else{
			$this->result=setQueryError();
		}

		return $this->result;
	}
	
	public function get($id){
				
		if(isset($id)){
			
			$this->db->trans_start();
			$query = $this->db->get_where("client", array("id"=>$id));
			$this->db->trans_complete();
			
			if($this->db->trans_status() === FALSE){
				$this->result = setResult("Query Error", QUERY_ERROR, $this->db->last_query());				
			}
			else{
				$this->result = setResult("SUCCESS", SUCCESS, "Got the account");
				$this->result["data"] = $query->result();
			}								
		}
		else{
			$this->result = setQueryError();
		}
		return $this->result;
	}
	
	public function delete($id){
		
		if(isset($id)){
			$this->db->trans_start();
			$this->db->delete("client", array("id"=>$id));
			$this->db->trans_complete();
			
			if($this->db->trans_status() === FALSE){
				$this->result = setResult("Query Error", QUERY_ERROR, $this->db->last_query());				
			}
			else{
				$this->result = setResult("SUCCESS", SUCCESS, "Account was deleted");				
			}	
		}
		
		return $this->result;
	}
	
	public function getAllClients($start=0, $limit=10){
		
		$this->db->trans_start();
		$this->db->select("*");
		$this->db->limit($limit, $start );
		$query = $this->db->get("client");
		$this->db->trans_complete();
		
		//echoLog($this->db->last_query(), false);
		
		if($this->db->trans_status() === FALSE){
			$this->result = setResult("Query Error", QUERY_ERROR, $this->db->last_query());			
		}
		else{
			$this->result = setResult("SUCCESS", SUCCESS, "Account was deleted");
			$this->result["data"] = $query->result();
		}
	
		return $this->result;
	}
}