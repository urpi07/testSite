<?php
	class Users extends CI_Model{
		
		private $isDebugMode = false;
		
		public function __construct($debugMode = false){
			$this->isDebugMode = $debugMode;
			$this->load->database();
			$this->load->helper("lendebug");
		}
		
		public function getUsers($start = 0, $limit=10){
			
			$this->db->select("*");
			$this->db->from("userdetails");
			$this->db->limit($limit, $start);					
			$query = $this->db->get();
// 			echoLog($this->db->last_query(), true);
			
			return $query->result();
		}
		
		public function createUserCredentials($username, $password, $detailId){

			$error = null;
			
			if(isset($username) && isset($password)){
				
				$args = array(
						"username" => $this->db->escape($username),
						"password" => password_hash($password, CRYPT_BLOWFISH ),
						"detailid" => intval($detailId)
				);
				
				if( !$this->db->insert("usercredentials", $args) ){
					$error = $this->db->error();
				}
				
				//$sql = "INSERT INTO usercredentials (username, password) VALUES (".$username.
				//", '".$password."')";
				
				echoLog($this->db->last_query(), $this->isDebugMode);															
			}
		}
		
		public function createNewUser($data){
			if(isset($data)){
				
				//TODO: checking if the account is already existing based on email.							
				$mydata = array();
				
				if($this->isAccountExisting(trim($data['email'])) ){
					$mydata["message"] = "Account/email is alreay in use";
					$mydata["title"] ="Account Existing";
					$mydata["result"] = 2; 
				}
				else{
					$bday = strtotime($data['birthdate']);
					$formattedBday = date('Y-m-d',$bday);
					
					$args = array(
							"firstName"=>$data['firstName'],
							"lastName"=>$data['lastName'],
							"middleName"=>$data['middleName'],
							"email"=>$data['email'],
							"phone"=>$data['phoneNumber'],
							"birthdate"=>$formattedBday,
							"privilege"=>intval($data["privilege"]),
							"gender"=>$data["gender"],
							"address"=>$data["address"]
					);
					
					// 	$sql = "INSERT INTO userdetails(firstName, lastName, middleName, ".
					// 		"email, phone, gender, birthdate, credentialId, privilege) ".
					// 		"VALUES($firstName, $lastName, $middleName, $email, $phone, ".
					// 		"$gender, $birthdate, $credentialId, $privilege)" ;
					
					$this->db->insert("userdetails", $args);
					echoLog($this->db->last_query(), $this->isDebugMode);
					
					$mydata["result"] = 1;
					$mydata["userId"] = $this->db->insert_id();					
					$mydata["message"]= "Account was created";
					$mydata["title"] = "Success";
				}
							
				return $mydata;
			}
		} 	
		
		public function isAccountExisting($email){
			
			if(isset($email)){
				$result = $this->db->get_where("userdetails", array("email" => $email));											
				echoLog($this->db->last_query(), $this->isDebugMode);
				
				echoLog("isAccountExisting ". count($result->result()), $this->isDebugMode);
				return ( count($result->result()) > 0 );
			}
		}
		
		public function updateUserDetails($data){
						
			if(isset($data)){
				$res = arrya();
				$args = array(
						"firstName"=>$data['firstName'],
						"lastName"=>$data['lastName'],
						"middleName"=>$data['middleName'],
						"email"=>$data['email'],
						"phone"=>$data['phoneNumber'],
						"birthdate"=> $data['birthdate'],
						"privilege"=>$data["privilege"],
						"gender"=>$data["gender"]
				);
				
				$id = $data["id"];
				
				$this->db->trans_start();
				$this->db->set($args);
				$this->db->where("id", $id);
				$this->db->update("userdetails");
				$this->db->trans_complete();
				
				if($this->db->trans_status()=== FALSE){
					$res["result"] = QUERY_ERROR;
					$res["title"] = "Error";
					$res["message"] = "There was an error with the transaction.";
				}
				else{
					$res["result"] = SUCCESS;
					$res["title"] = "Update Complete";
					$res["message"] = "Account was updated";
				}
				
				echoLog($this->db->last_query(), $this->isDebugMode);
			}
		}
		
		public function login($username, $password){
			
			//TODO: encrypt the password	
			$password = md5($password);
			
			$sql = "Select * from usercredentials where username='".$username."' and ".
					"password='".$password."'";
			
			$result = $this->db->query($sql);
			
			if($query->num_rows() > 0){
				$_SESSION["ml_userLoggedIn"] = true;			
			}
			else{
				$_SESSION["ml_userLoggedIn"] = false;
			}
			
			return $_SESSION["ml_userLoggedIn"];
		}
		
		public function logout(){
			unset($_SESSION["ml_userLoggedIn"]);
		}
		
		public function deleteUserCredentials($userID){
			
			if(isset($userID)){
				$this->db->delete("userdetails", array("id" => $userID));
				echoLog($this->db->last_query(), $this->isDebugMode);
			}
		}
		
		public function resetUserCredentials($userID){
			
		}
		
		//for testing purpose
		public function testToFail(){
			
			if(!$this->db->get("non_existent_table")){
				echo "this is the error ". $this->db->error();
			}
		}
	}
