<?php
require("Restful_Controller.php");


class UsersC extends Restful_Controller{
	
	private $validation_errors;
	private $validationResult = true;	
	
	public function __construct(){
		parent::__construct();
		$this->load->model("users");
		$this->load->model("genericQuery");
		$this->load->model("privilege");
		$this->load->helper("url_helper");
		$this->load->helper("form");		
		$this->load->library('form_validation');
	}
	
	public function view($page){
				
		if ( ! file_exists(APPPATH.'views\\users\\'.$page.".php") && $page != "fails" ){
			echo "$page not found";	
			echo APPPATH.'views\\users\\'.$page.".php";
		}
		else{
			$data = [];
			
			switch($page){
				case "userForm":
					$this->load->helper('url');
					$data['title'] = "New User";
					$data["privileges"] = $this->privilege->getPrivileges();
					
					$this->load->view('templates/formheader', $data);
					$this->load->view('templates/navbar', $data);
					$this->load->view('users/'.$page, $data);
					$this->load->view('templates/footer', $data);
					break;
					
				case "userAccount":
					echo $this->createAccount();
					break;

				case "user":
					//echo the process result
					$result = parent::processRequest();
					echo json_encode($result);
					break;					
					
				case "fails":
					$this->users->testToFail();
					break;
					
				case "users":					
					$data["users"] = $this->users->getUsers();
					$data["privileges"] = $this->privilege->getPrivileges();
					$this->load->view("users/users", $data);
					
					break;
					
				default:
					$this->load->helper('url');
					
					$this->load->view('templates/header', $data);
					$this->load->view('pages/'.$page, $data);
					$this->load->view('templates/footer', $data);
					break;
			}
		}
	}
	
	public function createAccount(){
		
		$result = null;
		
		if(isset($_POST['birthYear']) && isset($_POST["birthMonth"]) && isset($_POST["birthDate"])){
			$_POST["birthdate"] = $_POST['birthYear']."-".$_POST["birthMonth"]."-".$_POST["birthDate"];
		}
		
		
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
						'rules' => 'trim'
				),
				array('field' => 'gender',
						'rules' => 'trim'
				),
				array( 'field' => 'username',
						'rules' => 'trim|required'
				),
				array('field' => 'password',
						'rules' => 'trim|required'
				),
				array('field' => 'vpassword',
						'rules' => 'trim|required|matches[password]'
				),
				array('field' => 'privilege',
						'rules' => 'trim|required'
				)
		);
		
		$this->form_validation->set_rules($validationRules);
		
		if($this->form_validation->run() === FALSE){ //validation failed
			
// 			echo "Validation failed. \n";
			$result["message"] = $this->form_validation->error_array();
			$result["title"] = "Validation Error";
			$result["result"] = VALIDATION_ERROR;
			
			//var_dump($result);
			//TODO: reload the form with the corresponding errors.
		}
		else{ //validation success			
			$result = $this->users->createNewUser($_POST);
			
			//create credentials only if there is a userId
			//echo "userId ".$data["userId"];
			if(isset($result["userId"]) && $result['result'] == 1 ){
				
				//echo "creating credentials \n";
				$this->users->createUserCredentials($_POST["username"], $_POST["password"], $result["userId"]);
			}							
		}
		
		return json_encode($result);
	}
	
	public function doPost(){
		
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
						'rules' => 'trim'
				),
				array('field' => 'gender',
						'rules' => 'trim'
				),
				array( 'field' => 'username',
						'rules' => 'trim|required'
				),
				array('field' => 'password',
						'rules' => 'trim|required'
				),
				array('field' => 'vpassword',
						'rules' => 'trim|required|matches[password]'
				),
				array('field' => 'privilege',
						'rules' => 'trim|required'
				)
		);
		
		$this->form_validation->set_rules($validationRules);
		
		if($this->form_validation->run() === FALSE){ //validation failed
			
			echo "Validation failed. <br>";
			var_dump($this->form_validation->error_array() ) ;
			
			//TODO: reload the form with the corresponding errors.
		}
		else{ //validation success
			$data = $this->users->createNewUser($_POST);
		}
	}
	
	public function doDelete(){

		parent::doDelete();		
		
		//var_dump($_POST);
		if(isset($_POST["id"])){
			$res = $this->genericQuery->delete("userdetails", $_POST["id"]);
			
			if($res == FALSE){
				$result["title"] = "Failed to Delete";
				$result["result"] = FAILED;
				$result["message"] = "Deletion of record id ". $_POST['id']." failed.";				
			}
			else{
				$result["result"] = SUCCESS;
			}
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
				
		if(isset($_POST['birthYear']) && isset($_POST["birthMonth"]) && isset($_POST["birthDate"])){
			$_POST["birthdate"] = $_POST['birthYear']."-".$_POST["birthMonth"]."-".$_POST["birthDate"];
		}
		
		//for some reason the codeigniter validation 
		//returns an emtpy error array when the validation fails
		//for now doing manual validation
// 		echo "Put data";
// 		var_dump($_POST);
		
// 		$validationRules = array(
// 				array('field' => 'firstName',
// 						'rules' => 'trim|required'
// 				),
// 				array('field' => 'lastName',
// 						'rules' => 'trim|required'
// 				),
// 				array('field' => 'middleName',
// 						'rules' => 'trim|required'
// 				),
// 				array('field' => 'birthdate',
// 						'rules' => 'trim|required'
// 				),
// 				array('field' => 'email',
// 						'rules' => 'trim|required|valid_email'
// 				),
// 				array('field' => 'address',
// 						'rules' => 'trim|required'
// 				),
// 				array('field' => 'phone',
// 						'rules' => 'trim|required'
// 				),
// 				array('field' => 'gender',
// 						'rules' => 'trim|required'
// 				),
// 				array('field' => 'privilege',
// 						'rules' => 'trim|required'
// 				)
// 		);
		
// 		$this->form_validation->set_rules($validationRules);
		
// 		if($this->form_validation->run() === FALSE){ //validation failed
								
// 			//var_dump( $this->form_validation->validation_errors() );
// 			$result["message"] = $this->form_validation->error_array();
// 			$result["title"] = "Validation Error";
// 			$result["result"] = VALIDATION_ERROR;
// 		}
		
		$this->validation_errors = array();
		
		$_POST["firstName"] = ($this->basicValidation($_POST["firstName"], "First Name") == true ) ? 
			$_POST["firstName"] : "";
		$_POST["lastName"] = ($this->basicValidation($_POST["lastName"], "Last Name") == true ) ? 
			$_POST["lastName"] : "";
		$_POST["middleName"] = ($this->basicValidation($_POST["middleName"], "") == true ) ? 
			$_POST["middleName"] : "";
		$_POST["birthdate"] = ($this->basicValidation($_POST["birthdate"], "") == true ) ? 
			$_POST["birthdate"] : "";
		$_POST["email"] = ($this->basicValidation($_POST["email"], "") == true ) ? 
			$_POST["email"] : "";
		$_POST["address"] = ($this->basicValidation($_POST["address"], "") == true ) ? 
			$_POST["address"] : "";
		$_POST["phone"] = ($this->basicValidation($_POST["phone"], "") == true ) ? 
			$_POST["phone"] : "";
		$_POST["gender"] = ($this->basicValidation($_POST["gender"], "") == true ) ? 
			$_POST["gender"] : "";
		$_POST["privilege"] = ($this->basicValidation($_POST["privilege"], "") == true ) ? 
			$_POST["privilege"] : "";
				
		if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
			$this->validationResult = false;
			array($this->validation_errors,"Invalid email format");
		}
		
		if($this->validationResult == false){
			$result["message"] = $this->validation_errors;
			$result["title"] = "Validation Error";
			$result["result"] = VALIDATION_ERROR;
		}		
		else{ //validation success
			$result= $this->users->updateUserDetails($_POST);				
		}
		
		return $result;
	}
	
	private function basicValidation($field, $fieldName){
		
		$this->validationResult = true;
		
		if( isset($field)) {
			$field = trim($field);
			array_push($this->validation_errors, "Missing element $fieldName.");
		}
		else{
			$this->validationResult= false;
		}
		
		return $this->validationResult;
	}
	
	public function doGet(){
		
		$res = null;
		if(isset($_GET["id"])){
			$res["user"] = $this->genericQuery->get("userDetails", $_GET["id"]);
			$res["result"] = 1;
		}
		
		return $res;
	}	
	
}