<?php
require("Restful_Controller.php");

class SettingsC extends Restful_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper("url_helper");
		$this->load->helper('form');
		$this->load->helper("lendebug");
		$this->load->model("settings");	
		
		$this->settings->setTable("settings");
	}
	
	public function view($page){
		
		if ( ! file_exists(APPPATH.'views\\settings\\'.$page.".php") ){
			echo "$page not found";
			echo APPPATH.'views\\settings\\'.$page.".php";
		}
		else{
			switch($page){
				case "settings":
					$result = parent::processRequest();
					echo json_encode($result);
					break;
					
				case "settingsView":
					$data["data"] = $this->settings->getAllSettings();
					
					$data["title"] = "Settings";
					$this->load->view('templates/header', $data);
					$this->load->view("pages/mainPanel", $data);
					$this->load->view('settings/'.$page, $data);
					$this->load->view('templates/footer', $data);
					break;
					
				default:
					break;
			}
		}
	}
	
	public function doPost(){
		parent::doPost();
		
		$result = array();
		$validationRules = array(
				array('field' => 'name',
						'rules' => 'trim|required'),
				array('field' => 'value',
						'rules' => 'trim|required'),
				array('field' => 'description',
						'rules' => 'trim'),
		);
		
		$this->settings->setData($_POST);
		$this->form_validation->set_data($_POST);
		$this->form_validation->set_rules($validationRules);
		
		if($this->form_validation->run() === FALSE){ //validation failed
			
			$result["result"] = VALIDATION_ERROR;
			$result["message"] = $this->form_validation->error_array() ;
			$result["title"] = "Validation Error...";
		}
		else{ //validation success
			$result= $this->settings->add();
		}
		
		return $result;
	}
	public function doPut(){
		parent::doPut();
		$result = array();
		$validationRules = array(
				array('field' => 'name',
						'rules' => 'trim|required'),
				array('field' => 'value',
						'rules' => 'trim|required'),
				array('field' => 'description',
						'rules' => 'trim'),
		);
		
		$this->settings->setData($_POST);
		$this->form_validation->set_data($_POST);
		$this->form_validation->set_rules($validationRules);
		
		if($this->form_validation->run() === FALSE){ //validation failed
			
			$result["result"] = VALIDATION_ERROR;
			$result["message"] = $this->form_validation->error_array() ;
			$result["title"] = "Validation Error...";
		}
		else{ //validation success
			$result= $this->settings->update();
		}
		
		return $result;
	}
	public function doDelete(){
		parent::doDelete();
		$result = array();
		
		if(isset($_POST["id"])){
			$result= $this->settings->delete($_POST["id"]);
		}
		else{
			$result["title"] = "Failed to Delete";
			$result["result"] = FAILED;
			$result["message"] = "Record id is not set";
		}
		
		return $result;
		
	}
	public function doGet(){
		parent::doGet();
		$result = array();
		if(isset($_GET["id"])){
			$result = $this->settings->get($_GET["id"]);
		}
		else{
			$result["title"] = "Failed";
			$result["result"] = FAILED;
			$result["message"] = "Missing record id.";
		}
		
		return $result;
	}
}
