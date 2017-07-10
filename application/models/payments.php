<?php
class Payments extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper("lendebug");
	}
	
	public function add($data){		
		$result = array();
		
		if(isset($data)){
			
			$args = array(
				"amount" => $data["amount"],
				"loanId" => $data["loanId"],
				"comments" => $data["comments"],
				"receiver" => $data["receiver"]
			);
			
			$this->db->trans_start();
			$this->db->insert("payment", $args);
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
					"amount" => $data["amount"],
					"loanId" => $data["loanId"],
					"comments" => $data["comments"],
					"receiver" => $data["receiver"]
			);
			
			$this->db->trans_start();
			$this->db->set($args);
			$this->db->where("id", $data["id"]);
			$this->db->update("payment");
			$this->db->trans_complete();
			
			if($this->db->trans_status() === FALSE){
				$this->result = setResult("Query Error", QUERY_ERROR, $this->db->last_query());
			}
			else{
				$this->result = setResult("SUCCESS", SUCCESS, "Payment was updated");				
			}
		}
		else{
			$result = setQueryError();
		}
		
		return $result;
	}
	
	public function delete(){
		$result = array();
		
		if(isset($id)){
			$this->db->trans_start();
			$this->db->delete("payment", array("id"=>$id));
			$this->db->trans_complete();
			
			if($this->db->trans_status() === FALSE){
				$result = setResult("Query Error", QUERY_ERROR, $this->db->last_query());
			}
			else{
				$result = setResult("SUCCESS", SUCCESS, "Payment was deleted");
			}
		}
		
		return $result;
	}
	
	public function get($id){
		
		$this->result = array();
		
		if(isset($clientId)){
			$this->db->trans_start();
			$query = $this->db->get_where("payment", array("id" => $id));
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
			$this->result = setQueryError();
		}
		
		return $this->result;
	}
	
	//this divides the loan amount into chunks of payments
	public function generatePaymentsBasesOnLoan($loanId){
		
	}
}