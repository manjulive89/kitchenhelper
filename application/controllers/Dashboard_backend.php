<?php
/**
 * @file Dashboard_backend.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 30.05.2016 12:11:59 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
 * Alle Rechte vorbehalten.
 * Durch diese Lizenz ist der nachfolgende Quelltext in all seinen Erscheinungsformen [Beispiele: Kompiliert, Unkompiliert, Script Code] geschützt.
 * Im nachfolgenden Text werden die Worte Werk, Script und Quelltext genutzt Diese drei Wörter sind gleichzusetzen und zu schützen.
 * Der Autor dieses Werkes kann für keinerlei Schaden die durch das Werk enstanden sein könnten, entstehen werden verantwortlich gemacht werden.
 * 
 * Rechte und Pflichten des Nutzers dieses Werkes:
 * Der Nutzer dieses Werkes verpflichtet sich, diesen Lizenztext und die Autoren-Referenz auszuweisen und in seiner originalen Erscheinungsform zu belassen.
 * Sollte dieses Werk kommerziell genutzt werden, muss der Autor per E-Mail informiert werden, wenn eine E-Mail Adresse angegeben/bekannt ist.
 * Das Werk darf solange angepasst, verändert und zu verändertem Zwecke genutzt werden, wie dieser Lizenztext und die Autor(en)-Referenz ausgewiesen wird und
 * nicht gegen die Lizenzvereinbarungen verstößt.
 * Das Werk darf nicht für illigale Zwecke eingesetzt werden.
 **/
 /**
 * Dashboard_backend class is the main Backend Controller
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
class Dashboard_backend extends CI_Controller{
	/**
	 * Methode index of Dashboad_backend checks if user is logged in or not if not loads the needed view
	 * 
	 * @return void
	 **/
	public function index(){
		//load settings model:
		$this->load->model("einstellungen");
		//data for the views
		$data = $this->einstellungen->load();//load actual settings
		//check if login if not --> login
		if(isset($_SESSION['logged_in']) == true){
					$this->load->model("login");
						if(Login::checkUser()->getRole() == 2){
						$this->load->view("backend_head",$data);
						$this->load->view("dashboard_backend",$data);
						$this->load->view("backend_bottom",$data);
						}else{
						$this->load->view("backend_head_user",$data);
						$this->load->view("user",$data);
						$this->load->view("backend_bottom_user",$data);
							}
			}else{
			//ini form:
                $this->load->helper(array('form'));
                $this->load->library('form_validation');
                //set rules for form validation:
                $this->form_validation->set_rules("username","Username","required");
                $this->form_validation->set_rules("password","Password","required");
                if ($this->form_validation->run() == FALSE)
                {       
				//load login form
						$this->load->view("login_backend",$data);
				}else{
					//check Login modul
					$this->load->model("login");
					$this->login->go();
					if($this->login->getError() == null AND isset($_SESSION['logged_in'])){
						if(Login::checkUser()->getRole() == 2){
						$this->load->view("backend_head",$data);
						$this->load->view("dashboard_backend",$data);
						$this->load->view("backend_bottom",$data);
						}else{
						$this->load->view("backend_head_user",$data);
						$this->load->view("user",$data);
						$this->load->view("backend_bottom_user",$data);
							}
						}else{
							//set error in settings data:
							$this->einstellungen->set("error",$this->login->getError());
							$this->load->view("login_backend",$this->einstellungen->load());
							}
					}
				}
		}
		/**
		 * log out process
		 * */
		public function logout(){
			$this->load->model("login");
			session_unset ();
			$this->index();
		}
		/**
		 * displays the archive
		 * only in backend... uses Login::checkUser()
		 * @see Login
		 **/
		public function archive(){
		$this->load->model("login");
		if(Login::checkUser()->getRole() != 2){
			show_404();
			}
			$this->load->model("einstellungen");
			$data = $this->einstellungen->load();
			$this->load->view("backend_head",$data);
			$this->load->view("archive",$data);
			$this->load->view("backend_bottom",$data);
			
			}
	
	}
?>
