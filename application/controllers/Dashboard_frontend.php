<?php
/**
 * @file Dashboard_Frontend.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 30.05.2016 11:23:59 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * The Dashboard controller for the frontend
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
class Dashboard_frontend extends CI_Controller{
	/**
	 * Methode index of Dashboad_frontend
	 * @methode index
	 **/
	public function index(){
		//load settings model:
		$this->load->model("einstellungen");
		//data for the views
		$data = $this->einstellungen->load();//load actual settings
		$this->load->view("frontend_head",$data);
		$this->load->view("dashboard_frontend",$data);
		$this->load->view("frontend_bottom",$data);
		}
	/**
	 * Sheet displays the signoff sheet
	 * @return void
	 **/
	 public function sheet(){
		//load settings model:
		$this->load->model("einstellungen");
		//data for the views
		$data = $this->einstellungen->load();//load actual settings
		$this->load->view("frontend_head",$data);
		$this->load->view("sheet",$data);
		$this->load->view("frontend_bottom",$data);	 
		 }
	/**
	 * Diesplays meal planner
	 * @return void
	 **/
	 public function mealplan(){
		 //load mealplan
		  $this->load->library("container");
		  $this->load->model("einstellungen");
		  $data = $this->einstellungen->load();
		  $data["mealplan"] = $this->container->getMealplannerClass()->create(null,null,array("active"=>true,"activationtime"=>date("W")));
		$this->load->view("frontend_head",$data);
		$this->load->view("mealplanner_frontend",$data);
		$this->load->view("frontend_bottom",$data);	 
	 }
	/**
	 * displays the messages
	 * @return void
	 **/
	 public function messages(){
		 //load form
		 
		 $this->load->helper(array('form', 'url'));
		 $this->load->library('form_validation');
		 $this->load->library("container");
		 //set valid rules
		 $this->form_validation->set_rules('name', 'Username', 'required');
		 $this->form_validation->set_rules('title', 'Title', 'required');
		 $this->form_validation->set_rules('email', 'Email', 'required');
		 $this->form_validation->set_rules('text', 'Message', 'required');
		//load settings model:
		$this->load->model("einstellungen");
		//data for the views
				if ($this->form_validation->run() == FALSE)
                {
					$this->einstellungen->set("error",validation_errors());
				}else{
					$this->load->model("update");
					$this->update->sendMessages();
					$this->einstellungen->set("error",true);
					}
		$data = $this->einstellungen->load();//load actual settings
		$this->load->view("frontend_head",$data);
		$this->load->view("messagebox",$data);
		$this->load->view("frontend_bottom",$data);	 
		 }
	
	}
?>
