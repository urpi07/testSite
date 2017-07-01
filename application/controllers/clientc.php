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
		$this->load->model("loan");
		
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
					
				case "clientDetails":
					
					if(isset($_GET) && isset($_GET["id"]) ){
						$data["title"] = "Client Details";
						$data["clientInfo"] = $this->client->get($_GET["id"]);
						$data["result"]= $this->loan->getLoansByClient($_GET["id"]);											
						
						$this->load->view('templates/header', $data);
						$this->load->view("pages/mainPanel", $data);
						$this->load->view('client/'.$page, $data);
						$this->load->view('templates/footer', $data);
					}
					else{
						$this->load->view('templates/header', $data);
						$this->load->view("pages/mainPanel", $data);
						$this->load->view('client/clientDetailError', $data);
						$this->load->view('templates/footer', $data);
					}
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
						'rules' => 'trim|required'),
				array('field' => 'lastName',
						'rules' => 'trim|required'),
				array('field' => 'middleName',
						'rules' => 'trim|required'),
				array('field' => 'birthdate',
						'rules' => 'trim|required'),
				array('field' => 'email',
						'rules' => 'trim|required|valid_email'),
				array('field' => 'address',
						'rules' => 'trim|required'),
				array('field' => 'phone',
						'rules' => 'trim|required'),
				array('field' => 'gender',
						'rules' => 'trim|required'),
				array('field' => 'comment',
						'rules' => 'trim'),
				array('field' => 'picurl',
						'rules' => 'trim')
		);
		
		$this->form_validation->set_data($_POST);
		$this->form_validation->set_rules($validationRules);
		
		if($this->form_validation->run() === FALSE){ //validation failed
			
			$result["result"] = VALIDATION_ERROR;
			$result["message"] = $this->form_validation->error_array() ;
			$result["title"] = "Validation Error...";			
		}
		else{ //validation success		
			$result= $this->client->add($_POST);								
		}
		
		return $result;
	}
	
	public function doDelete(){
		parent::doDelete();
		
		$result = array();
		
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
		
		$validationRules = array(
				array('field' => 'firstName',
						'rules' => 'trim|required'),
				array('field' => 'lastName',
						'rules' => 'trim|required'),
				array('field' => 'middleName',
						'rules' => 'trim|required'),
				array('field' => 'birthdate',
						'rules' => 'trim|required'),
				array('field' => 'email',
						'rules' => 'trim|required|valid_email'),
				array('field' => 'address',
						'rules' => 'trim|required'),
				array('field' => 'phone',
						'rules' => 'trim|required'),
				array('field' => 'gender',
						'rules' => 'trim|required'),
				array('field' => 'comment',
						'rules' => 'trim'),
				array('field' => 'picurl',
						'rules' => 'trim')
		);
		
		$this->form_validation->set_data($_POST);
		$this->form_validation->set_rules($validationRules);		
		
		if($this->form_validation->run() === FALSE){ //validation failed
			$result["result"] = VALIDATION_ERROR;
			$result["message"] = $this->form_validation->error_array() ;
			$result["title"] = "Validation Error";
		}
		else{
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