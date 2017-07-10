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
					
				default:
					break;
			}
		}
	}
	
	public function doPost(){
		parent::doPost();
	}
	public function doDelete(){
		parent::doDelete();
	}
	public function doPut(){
		parent::doPut();
	}
	public function doGet(){
		parent::doGet();
	}
}
