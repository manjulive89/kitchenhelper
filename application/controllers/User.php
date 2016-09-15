<?php
/**
 * @file User.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 09.06.2016 19:41:08 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * User Controller
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
class User extends CI_Controller{
	
	public function index(){
		$this->load->model("login");
		if(Login::checkUser()->getRole() != 1 AND Login::checkUser()->getRole() != 2){
			show_404();
			}
		//load settings model:
		$this->load->model("einstellungen");
		//data for the views
		$data = $this->einstellungen->load();//load actual settings
		//load views
		$this->load->view("backend_head",$data);
		$this->load->view("user",$data);
		$this->load->view("backend_bottom",$data);
		}
	/**
	 * displays the groups over view
	 * groups in thsi context means groups of paritcpants
	 * frontend
	 **/
	public function groups($type){
	$this->load->model("login");
	$this->load->model("einstellungen");
	$this->einstellungen->load();
	if($type == "frontend"){
	$password = $this->input->post("password");
	$submit = $this->input->post("login_groups");
	//bug fix: for localhost/groupmanagment
	$login = false;
	if($submit !== null){
		if( password_verify ($password, $this->einstellungen->get("password")->content)){
			$login = true;
			$this->einstellungen->set("login",$login);
			}else{
				show_error("Wrong Login 500 <a href=\"".$this->einstellungen->get("base_url")->content."\">Back</a>");
				$login = false;
				}
		}else{
			Login::checkUser();
			}
	}else{
		Login::checkUser();
		$login = false;
		}
		//load settings model:
		$this->load->model("einstellungen");
		//data for the views
		$this->einstellungen->set("login",$login);
		$data = $this->einstellungen->load();//load actual settings
		//load views		//load settings model:
		$this->load->model("einstellungen");
		//data for the views
		$data = $this->einstellungen->load();//load actual settings
		//load views
		
		if($login == false){
		$this->load->view("backend_head",$data);
		}else{
			$this->load->view("frontend_plain",$data);
			}
		$this->load->view("groups",$data);
		if($login == false){
		$this->load->view("backend_bottom",$data);
		}else{
			$this->load->view("groups_bottom",$data);
			}
		}
	}
?>
