<?php

require("Restful_Controller.php");

class ClientC extends Restful_Controller{
	
	public function __construct(){		
		parent::__construct();
		$this->load->helper("url_helper");
		$this->load->helper("form");
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
					parent::processRequest();					
					break;
					
				case "clients": //retrieve all clients
					
					$start = (isset($_GET["start"]) ) ? $_GET["start"] : 0;
					$limit = (isset($_GET["limit"]) ) ? $_GET["limit"] : 10;										
					
					$data["clients"] = $this->client->getAllClients($start, $limit);
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
		
		//some backend validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		
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
				array('field' => 'phoneNumber',
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
			
			echo "Validation failed. <br>";
			var_dump($this->form_validation->error_array() ) ;
			
			//TODO: reload the form with the corresponding errors.
		}
		else{ //validation success\
			echo "Creating a new client.";
			$data = $this->client->add($_POST);
					
			$data["title"] = "User Created";
		}
	}
	
	public function doDelete(){
		
	}
	
	public function doPut(){
		
	}
	
	public function doGet(){
		
	}
	
}