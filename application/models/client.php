<?php
class Client extends CI_Model{

	private $isDebugMode = false;
	
	public function __construct(){
		parent::__construct();
		
		$this->load->database();
		$this->load->helper("lendebug");
	}
	
	public function add($data){
		
		$bday = strtotime($data['birthdate']);
		$formattedBday = date('Y-m-d',$bday);
		
		$args = array(
				"firstName"=>$data['firstName'],
				"lastName"=>$data['lastName'],
				"middleName"=>$data['middleName'],
				"email"=>$data['email'],
				"phoneNumber"=>$data['phoneNumber'],
				"birthdate"=>$formattedBday,				
				"gender"=>$data["gender"],
				"address"=>$data["address"],
				"comment"=>$data["comment"]
		);
		
		$this->db->insert("client", $args);
		echoLog($this->db->last_query(), $this->isDebugMode);
		
		$mydata["userId"] = $this->db->insert_id();
		$mydata["message"]= "Account was created";
		return $mydata;				
	}
	
	public function edit($data){
		
		$args = array(
				"firstName"=>$data['firstName'],
				"lastName"=>$data['lastName'],
				"middleName"=>$data['middleName'],
				"email"=>$data['email'],
				"phoneNumber"=>$data['phoneNumber'],
				"birthdate"=>$formattedBday,
				"gender"=>$data["gender"],
				"address"=>$data["address"],
				"comment"=>$data["comment"]
		);
						
		$this->db->set($args);
		$this->db->where("id", $data["id"]);
		$this->db->update("client");
		
		echoLog($this->db->last_query(), $this->isDebugMode);
	}
	
	public function get($id){
		
		$result = null;
		if(isset($id)){
			$query = $this->db->get_where("client", array("id"=>$id));
			$result = $query->result();
		}
		
		return $result;
	}
	
	public function delete($id){
		
		if(isset($id)){
			$this->db->delete("client", array("id"=>$id));
		}		
	}
	
	public function getAllClients($start=0, $limit=10){
		
		$this->db->select("*");
		$this->db->limit($limit, $start );
		$query = $this->db->get("client");			
		
		echoLog($this->db->last_query(), true);
		return $query->result();
	}
}