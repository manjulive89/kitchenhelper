<?php
/**
 * @file Settings.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 11.06.2016 19:09:51 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Settings Controller
 * 
 * Settings controller because of the reason I used the word Settings in this context I needed a new name for my model I called it einstellungen which is the german word.
 * sorry in advance
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
class Settings extends CI_Controller{
	/**
	 * generates page
	 * @returns void
	 **/
	public function index(){
		$this->load->model("login");
		if(Login::checkUser()->getRole() != 2){
			show_404();
			}
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
		//load settings model:
		$this->load->model("einstellungen");
                if ($this->input->post("submit") != null){
			//success
			$this->einstellungen->load();
			$this->einstellungen->getForm("normal");
			$this->einstellungen->getForm("helptexts");
			$this->einstellungen->save();
			}
		//data for the views
		$data = $this->einstellungen->load();//load actual settings
		//load views
		$this->load->view("backend_head",$data);
		$this->load->view("settings",$data);
		$this->load->view("backend_bottom",$data);
		}
	}
?>
