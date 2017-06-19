<?php
	class Privilege extends CI_Model{
		
		var $debugMode = false;
		
		public function __construct($debugMode=FALSE){
			$this->debugMode = $debugMode;
			parent::__construct();
			$this->load->database();
			$this->load->helper("lendebug");
		}
		
		public function getPrivileges(){
			
			$sql = "SELECT * FROM privileges";
			$result = $this->db->query($sql);
			
			echoLog($sql, $this->debugMode);						
			
			return $result->result_array();
			
		}
		
		public function getPrivilege($id){
			if(isset($id)){
				$result = $this->db->select("*")
					.where("id", $id)
					.get("privileges");
				
				echoLog($this->db->last_query(), $this->isDebugMode);
				
				return $result->result_array();
			}
		}
		
		public function add($data){
			
			if(isset($data)){
				
				$args = array(
						"type" => $this->db->escape($data["type"]),
						"comment" => $this->db->escape($data["comment"])
				);
				
				$this->db->insert("privileges", $args);
								
				echoLog($this->db->last_query(), $this->isDebugMode);			
				
				return $this->db->insert_id();
			}
		}
		
		public function edit($data){
			if(isset($data)){
				$args = array(
						"type" => $this->db->escape($data["type"]),
						"comment" => $this->db->escape($data["comment"])
				);
				
				$id = $data["id"];
				
				$this->db->set($args);
				$this->db->where("id", $id);
				$this->db->update("privileges");	
				
				echoLog($this->db->last_query(), $this->isDebugMode);
			}
		}
		
		public function delete($id){
			if(isset($id)){
				
				$this->db->delete("privileges", array("id" => $id));
				echoLog($this->db->last_query(), $this->isDebugMode);
			}
		}
	}