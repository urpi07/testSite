<?php
class Loan extends CI_Model{
	
	private $result = array();
	public function __construct(){
		parent::__construct();
		
		$this->load->database();
		$this->load->helper("lendebug");
	}
	
	public function add($data){				
		$this->result = array();
		
		if(isset($data)){
			
			$args = array("debtorId" => $data["debtorId"],
					"creditorId" => ( isset($data["creditorId"]) ) ? $data["creditorId"] : null,
					"loanAmount" => $data["amount"],
					"interest" => $data["interest"],
					"comments" => $data["comments"],
					"collateral" => $data["collateral"], //How to go about??
					"loanStatus" => $data["loanStatus"],
					"loanTenure" => $data["loanTenure"],
					"tenurePeriod" => $data["tenurePeriod"]					
			);						
			
			$this->db->trans_start();
			$this->db->insert("loan", $args);
			$this->db->trans_complete();
			
			if($this->db->trans_status() === FALSE){
				$this->result = setResult("Query Error", QUERY_ERROR, $this->db->last_query());
			}
			else{
				$this->result = setResult("SUCCESS", SUCCESS, "Account was created");
				$result["loanId"] = $this->db->insert_id();
			}
		}
		else{
			$this->result = setQueryError();
		}
		
		return $this->result;
	}
	
	public function edit($data){
		$this->result = array();
		
		if(isset($data)){
			
			$args = array("debtorId" => $data["debtorId"],
					"creditorId" => ( isset($data["creditorId"]) ) ? $data["creditorId"] : null,
					"loanAmount" => $data["amount"],
					"interest" => $data["interest"],
					"comments" => $data["comments"],
					"collateral" => $data["collateral"], //How to go about??
					"loanStatus" => $data["loanStatus"],
					"loanTenure" => $data["loanTenure"],
					"tenurePeriod" => $data["tenurePeriod"]
			);
			
			$this->db->trans_start();
			$this->db->set($args);
			$this->db->where("id", $data["id"]);
			$this->db->update("loan");
			$this->db->trans_complete();
			
			if($this->db->trans_status() === FALSE){
				$this->result = setResult("Query Error", QUERY_ERROR, $this->db->last_query());
			}
			else{
				$this->result = setResult("SUCCESS", SUCCESS, "The loan was updated.");			
			}
		}
		else{
			$this->result = setQueryError();
		}
		
		return $this->result;
	}
	
	public function get($id){
		$this->result = array();
		
		if(isset($_GET["id"])){
			$this->db->trans_start();
			$query = $this->db->get_where("loan", array("id"=>$_GET["id"]));
			$this->db->trans_complete();
			
			if($this->db->trans_status() === FALSE){
				$this->result = setResult("Query Error", QUERY_ERROR, $this->db->last_query());
			}
			else{
				$this->result = setResult("SUCCESS", SUCCESS, "Got the loan");
				$this->result["data"] = $query->result()[0];
			}
		}
		else{
			$this->result = setQueryError();
		}
		
		return $this->result;
	}
	
	public function delete($id){
		$this->result = array();
		
		if(isset($id)){
			$this->db->trans_start();
			$this->db->delete("loan", array("id"=>$id));
			$this->db->trans_complete();
			
			if($this->db->trans_status() === FALSE){
				$this->result = setResult("Query Error", QUERY_ERROR, $this->db->last_query());
			}
			else{
				$this->result = setResult("SUCCESS", SUCCESS, "Loan was deleted");
			}
		}
		
		return $this->result;
	}
	
	public function getLoansByClient($clientId){
		$this->result = array();
		
		if(isset($clientId)){
			$this->db->trans_start();
			$query = $this->db->get_where("loan", array("debtorId" => $clientId));
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
	
	//returns all loans not yet fully paid
	public function getAllActiveLoans(){
		$this->result = array();
		$this->db->trans_start();
		
		//TODO: create this complex challenging query...
		
		$this->db->trans_complete();
		
		if($this->db->trans_status() === FALSE){
			$this->result = setResult("Query Error", QUERY_ERROR, $this->db->last_query());
		}
		else{
			$this->result = setResult("SUCCESS", SUCCESS, "Got the account");
			$this->result["data"] = $query->result();
		}				
	}
}