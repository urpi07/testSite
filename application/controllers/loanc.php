<?php
require("Restful_Controller.php");

class LoanC extends Restful_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');		
		$this->load->helper("url_helper");
		$this->load->helper('form');
		$this->load->helper("lendebug");
		$this->load->model("client");
		$this->load->model("loan");
	}
	
	public function view($page){
		if ( ! file_exists(APPPATH.'views\\loan\\'.$page.".php") ){
			echo "$page not found";
			echo APPPATH.'views\\loan\\'.$page.".php";
		}
		else{
			switch($page){
				case "loan":
					$result = parent::processRequest();
					echo json_encode($result);
					break;
			}
		}
	}
	
	public function doPost(){
		parent::doPost();
		$result = array();
		
		$_POST["amount"] = number_format($_POST["amount"], 2, ".", "");	
		
		$validationRules = array(
				array("field" => "amount",
						"rules" => "trim|required|decimal"),
				array("field" => "interest",
					  "rules" => "trim|required|integer"),				
				array("field" => "loanTenure",
					   "rules" =>"trim|required|integer"),
				array("field" => "loanStatus",
						"rules" => "trim|required"),
				array("field" => "tenurePeriod",
						"rules" => "trim|required"),
				array("field" => "comments",
						"rules" => "trim"),
				array("field" => "collateral",
						"rules" => "trim|required")
		);
		
		$this->form_validation->set_data($_POST);
		$this->form_validation->set_rules($validationRules);
		
		if($this->form_validation->run() === FALSE){ //validation failed
			
			$result["result"] = VALIDATION_ERROR;
			$result["message"] = $this->form_validation->error_array() ;
			$result["title"] = "Validation Error";
		}
		else{ //validation success
			$result= $this->loan->add($_POST);
		}
		
		return $result;
	}
	
	public function doDelete(){
		parent::doDelete();
		
		$result = array();

		if(isset($_POST["id"])){
			$result= $this->loan->delete($_POST["id"]);
		}
		else{
			$result["title"] = "Failed to Delete";
			$result["result"] = FAILED;
			$result["message"] = "Record id is not set";
		}
		
		return $result;
	}
	
	public function doPut(){		
		parent::doPut();
		$result = array();
		
		$_SERVER["REQUEST_METHOD"] = "PUT"; //hack since CI validation only works on post. 
		$_POST["amount"] = number_format($_POST["amount"], 2, ".", "");				
		
		$validationRules = array(
				array("field" => "amount",
						"rules" => "trim|required|decimal"),
				array("field" => "interest",
						"rules" => "trim|required|integer"),
				array("field" => "loanTenure",
						"rules" =>"trim|required|integer"),
				array("field" => "loanStatus",
						"rules" => "trim|required"),
				array("field" => "tenurePeriod",
						"rules" => "trim|required"),
				array("field" => "comments",
						"rules" => "trim"),
				array("field" => "collateral",
						"rules" => "trim|required")
		);					
		
		$this->form_validation->set_data($_POST);
		$this->form_validation->set_rules($validationRules);
		
		if($this->form_validation->run() === FALSE){ //validation failed
			
			$result["result"] = VALIDATION_ERROR;
			$result["message"] = $this->form_validation->error_array() ;
			$result["title"] = "Validation Error";
		}
		else{ //validation success
			$result= $this->loan->edit($_POST);
		}		
		
		return $result;
	}
		
	public function doGet(){	
		
		$result = array();
		if(isset($_GET["id"])){			
			$result = $this->loan->get($_GET["id"]);
		}
		else{
			$result["title"] = "Failed";
			$result["result"] = FAILED;
			$result["message"] = "Missing record id.";
		}
		
		return $result;
	}
}