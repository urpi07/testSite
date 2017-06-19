<?php
class Pages extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model("tester");
		$this->load->model("genericquery");
		$this->load->helper("lendebug");
	}
	
	public function view($page = 'home')
	{				
		
		if ( ! file_exists(APPPATH.'views\\pages\\'.$page.".php") )
		{
			
			echo "$page not foundssss";		
			echo APPPATH.'views/pages/'.$page.".php";
			//show_404();
		}
		else{
			
			$this->load->helper('url');
			$data = "";
			
			switch($page){
				
				case "test":
					$data["title"] = "Tester";
					$data["tables"] = $this->tester->getTables();
					
					//var_dump($data);
					
					$this->load->view("pages/test.php", $data);
					break;
					
				case "dbForm":
					
					$data["title"] = "Tester";
					$data["table"] = $_GET['table'];
					$data["method"] = $_GET['method'];
					$data["fields"] = $this->tester->getTableFieldsData($_GET["table"]);
					
					switch($_GET['method']){
						case "PUT":
							break;
							
						case "GET":												
							$data["tableData"] = $this->genericquery->get($_GET["table"], $_GET["id"]);
							$data["method"] = "PUT";
// 							var_dump($data);
							break;
						case "DELETE":
							break;						
					}
					
					$this->load->view("pages/testForm", $data);
					break;
				
				case "login":
					
					$this->load->helper('url');					
					
					$this->load->view('templates/header', $data);
					$this->load->view('pages/'.$page, $data);
					$this->load->view('templates/footer', $data);
					break;
					
				case "mainPanel":
					$data["title"] = "Microlending";
					$this->load->helper('url');
					
					$this->load->view('templates/header', $data);
					$this->load->view('pages/'.$page, $data);
					$this->load->view('templates/footer', $data);
					break;
					
				default:	
					$data["title"] = "Microlending";
					
					$this->load->view('templates/header', $data);
					$this->load->view('templates/navbar', $data);
					$this->load->view('pages/'.$page, $data);
					$this->load->view('templates/footer', $data);
					break;
			}

		}		
	}
}