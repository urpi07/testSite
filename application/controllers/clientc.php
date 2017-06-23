<?php

require("Restful_Controller.php");

class ClientC extends Restful_Controller{
	
	public function __construct(){		
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper("url_helper");
		$this->load->helper('form');
		$this->load->helper("lendebug");
		$this->load->model("client");
		
	}
	
	public function view($page){
		
		if ( ! file_exists(APPPATH.'views\\client\\'.$page.".php") ){
			echo "$page not found";
			echo APPPATH.'views\\client\\'.$page.".php";
		}
		else{
			$data = [];
			
			switch($page){
				case "clientForm":
					$data["title"] = "Client";
					$this->load->view('templates/formheader', $data);
					$this->load->view('templates/navbar', $data);
					$this->load->view('client/'.$page, $data);
					$this->load->view('templates/footer', $data);
					break;
					
				case "client":									
					$result = parent::processRequest();
					echo json_encode($result);
					break;
					
				case "clients": //retrieve all clients
					
					$start = (isset($_GET["start"]) ) ? $_GET["start"] : 0;
					$limit = (isset($_GET["limit"]) ) ? $_GET["limit"] : 10;										
					
					$result = $this->client->getAllClients($start, $limit);
					
					if( isset($result["data"]) ){
						$data["clients"] = $result["data"];
					}
					
					$data["title"] = "Clients";
					
					$this->load->view('templates/header', $data);
					$this->load->view("pages/mainPanel");
					$this->load->view('client/'.$page, $data);
					$this->load->view('templates/footer', $data);
					break;
					
				default:
					break;
			}
		}
	}
	
	public function doPost(){
		parent::doPost();
		
		//some backend validation
		$result = array();
		$validationRules = array(
				array('field' => 'firstName',
						'rules' => 'trim|required'
				),
				array('field' => 'lastName',
						'rules' => 'trim|required'
				),
				array('field' => 'middleName',
						'rules' => 'trim|required'
				),
				array('field' => 'birthdate',
						'rules' => 'trim|required'
				),
				array('field' => 'email',
						'rules' => 'trim|required|valid_email'
				),
				array('field' => 'address',
						'rules' => 'trim|required'
				),
				array('field' => 'phone',
						'rules' => 'trim|required'
				),
				array('field' => 'gender',
						'rules' => 'trim|required'
				),
				array('field' => 'comment',
						'rules' => 'trim'
				),
				array('field' => 'picurl',
						'rules' => 'trim'
				)
		);
		
		$this->form_validation->set_rules($validationRules);
		
		if($this->form_validation->run() === FALSE){ //validation failed
			
			$result["result"] = VALIDATION_ERROR;
			$result["message"] = $this->form_validation->error_array() ;
			$result["title"] = "Validation Error";			
		}
		else{ //validation success		
			$result= $this->client->add($_POST);								
		}
		
		return $result;
	}
	
	public function doDelete(){
		parent::doDelete();
		
		$result = array();
		//var_dump($_POST);
		if(isset($_POST["id"])){
			$result= $this->client->delete($_POST["id"]);
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
		$validationErrors = array();
		
		if(isset($_POST["firstName"])){
			$_POST["firstName"] = trim($_POST["firstName"]);
		}
		else{
			array_push($validationErrors, "Firstname is missing.");
		}
		
		if(isset($_POST["lastName"])){
			$_POST["lastName"] = trim($_POST["lastName"]);
		}
		else{
			array_push($validationErrors, "Last Name is missing.");
		}
		
		if(isset($_POST["middleName"])){
			$_POST["middleName"] = trim($_POST["middleName"]);
		}
		else{
			array_push($validationErrors, "Middle Name is missing.");
		}
		
		if(isset($_POST["email"])){
			$_POST["email"] = trim($_POST["email"]);
			
			if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
				array_push($validationErrors, "Invalid email.");
			}
		}
		else{
			array_push($validationErrors, "Email is missing.");
		}
		
		if(isset($_POST["address"])){
			$_POST["address"] = trim($_POST["address"]);
		}
		else{
			array_push($validationErrors, "Address is missing.");
		}
		
		if(isset($_POST["phone"])){
			$_POST["phone"] = trim($_POST["phone"]);
		}
		else{
			array_push($validationErrors, "Phone is missing.");
		}
		
		if(isset($_POST["birthdate"])){
			$_POST["birthdate"] = trim($_POST["birthdate"]);
		}
		else{
			array_push($validationErrors, "Birthdate is missing.");
		}
		
		if(isset($_POST["gender"])){
			$_POST["gender"] = trim($_POST["gender"]);
		}
		else{
			array_push($validationErrors, "Gender is missing.");
		}
									
		if( count($validationErrors) > 0 ){ //validation failed
			
			$result["result"] = VALIDATION_ERROR;
			$result["message"] = $validationErrors;
			$result["title"] = "";
		}
		else{ //validation success
			$result= $this->client->edit($_POST);
		}
		
		return $result;
	}
	
	public function doGet(){
		
		$result = array();
		if(isset($_GET["id"])){
			$result = $this->client->get($_GET["id"]);			
		}
		else{
			$result["title"] = "Failed";
			$result["result"] = FAILED;
			$result["message"] = "Missing record id.";
		}
		
		return $result;
	}
	
}