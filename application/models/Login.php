<?php
/**
 * @file login.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 30.05.2016 12:57:25 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Login Modul: is the login modul
 * 
 * The use of php natives session is a workaround because Codeigniter build in SESSION/COOKIE
 * system did not wanted to work.
 *
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
class Login extends CI_Model{
	//@var boolean error contains the error message for the view
	private $error = null;
	public function __construct(){
                // Call the CI_Model constructor
                parent::__construct();
		}
	/**
	 * checked if user is logged in if yes returns the Object saved in $_SESSION['user_data']
	 **/
	public static function checkUser(){
			if(isset($_SESSION['user_data'])){
					$CI =& get_instance();
					$CI->load->library('container');
					return $CI->container->getUserClass()->create($_SESSION['user_data']);
			}else{
				show_404();
				die();
			}
		}
	/**
	 * The login methode
	 * Saves the user Object of the logged in user in  $_SESSION['user_data']
	 * and sets $_SESSION['login'] true
	 * */
	public function go(){
		//$this->input->post(STRING,XSS Filter)
		$username = $this->input->post("username",true);
		$password = $this->input->post("password",true);
		$this->load->database();
		//login check db:
		$query = $this->db->where("email='$username' AND ( role=1 OR role = 2)")->get("user");
		$row = $query->result();
		if(count($row) == 1){
			if(password_verify($password,$row[0]->password) == true){
				$_SESSION['logged_in'] = true;
				$this->load->library('container');
				$_SESSION['user_data'] = $row[0]->id;
				}else{
					$this->setError("The password is wrong.");
					}
		}else{		
			$this->setError("The username does not exist.");			
			}
		}
	/**
	 * @param String $error
	 ***/
	public function setError($error){
		$this->error = $error;
		}
	/**
	 * @return String  the error message
	 ***/
	public function getError(){
		return $this->error;
		}
	}
?>
