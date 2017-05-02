<?php
/**
 * @file ajax.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 30.05.2016 16:10:22 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * This controller is the connection between the PHP Layer and the JavaScrip layer. For more information about this
 * 
 * 
 * <img src = "../imgs/api.png">
 * <hr>
 * <img src="../imgs/ajax.png">
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
class Ajax extends CI_Controller{
	/**
	 * 
	 * This methode deals with the request set in the config file route.
	 * @see application/config/routes.php
	 * 1) check if methode exists in file and then it will ini this methode
	 * 2) it will parse the return into JSON and will display them
	 * 
	 * @param String $action
	 * The methode name
	 * @param String $what
	 * What type of methode we have to call in the Request/Update Class
	 * @return void
	 **/
	public function action($action,$what,$arg = null){
		if(method_exists($this,$action)){
			echo json_encode($this->$action($what,$arg));
			}else{
				echo json_encode(array("error"=>"empty request"));
				}
		}
	/**
	 * Request method only for the Frontend
	 * limited access to the API
	 * @param string $methode
	 * must be a valid methode of the Model Update!
	 * @param mixed $arg
	 * can be a sting or int
	 * @return array
	 **/
	private function front_request($methode,$arg = null){
		$this->load->model("request");
		if(method_exists($this->request,$methode)){
			if($methode == "getallusers"){
				return $this->request->getAllUserWithoutRemoved($arg);
				}else if($methode != "getmessage" AND $methode != "getallmessages"){
				return $this->request->$methode($arg);
				}else{
					return array("error"=>"iligal request");
					}
		}else{
			return array("error"=>"iligal request");
			}
		}
	/**
	 * Request Methode for the Backend
	 * has full access
	 * @access private
	 * @param string $methode
	 * must be a valid methode of the Model Update!
	 * @param mixed $arg
	 * can be a sting or int
	 * @return array
	 **/
	private function request($methode,$arg = null){
		$this->load->model("login");
		if(Login::checkUser()->getRole() == 0){
			show_404();
			}
		$this->load->model("request");
		if(method_exists($this->request,$methode)){
			return $this->request->$methode($arg);
		}else{
			return array("error"=>"iligal request");
			}
		}
	/**
	 * Update Methode for the Backend
	 * has full access
	 * @param string $methode
	 * must be a valid methode of the Model Update!
	 * @param mixed $arg
	 * can be a sting or int
	 * @return mixed
	 **/
	private function update($methode,$arg = null){
		$this->load->model("login");
		if(Login::checkUser()->getRole() == 0){
			show_404();
			}
		$this->load->model("updates");
		if(method_exists($this->updates,$methode)){
			return $this->updates->$methode($arg);
		}else{
			return array("error"=>"iligal request");
			}
		}
	/**
	 * Update method only for the Frontend
	 * limited access to the API
	 * @param string $methode
	 * must be a valid methode of the Model Update!
	 * @param mixed $arg
	 * can be a sting or int
	 * @return mixed
	 **/
	private function update_frontend($methode,$arg = null){
		$this->load->model("updates");
		if(method_exists($this->updates,$methode)){
			if($methode == "update"){
				$methode = "update_frontend";
			}
			if($methode == "delete"){
				$methode = "delete_frontend";
				}
			return $this->updates->$methode($arg);
		}else{
			return array("error"=>"iligal request");
			}
		}
	/**
	 * Returns at the moment only the JSON of the helptexts ...
	 * @todo:change name and function to settings...
	 * @returns StdClass
	 * @since 08.02.2017
	 **/
	private function settings(){
		$this->load->model("einstellungen");
		$this->einstellungen->load();
		$settings = array(
		"base_url" => $this->einstellungen->getContent("base_url"),
		"pagename" => $this->einstellungen->getContent("pagename"),
		"pagetitle" => $this->einstellungen->getContent("pagetitle"),
		"logourl" => $this->einstellungen->getContent("LogoUrl"),
		"mail" => $this->einstellungen->getContent("EMailAddress")
		);
		return array("helptexts"=>$this->einstellungen->getContent("helptexts"),"settings"=>$settings);
		}
	}

?>
