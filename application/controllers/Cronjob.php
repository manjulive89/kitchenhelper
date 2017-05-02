<?php
/**
 * @file Cronjob.php 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 13.06.2016 23:46:16 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Cron job
 * 
 * provied the background jobs which should run as cronjob or service .
 * 
 * cou call it like the following way:
 * Terminal:
 * <code>php <i>index.php</i> cronjob [methode]</code>
 * index.php musst be the main index.php 
 * @todo: add log saver
 * @version 1.0
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
 class Cronjob extends CI_Controller {

       public function checkMealplan(){
		   $this->load->model("cronj");
		   $this->cronj->checkMealplan();
		   }
       public function cleanDB(){
		   $this->load->model("cronj");
		   $this->cronj->cleanDB();
		   }
       public function genArchive(){
		   $this->load->model("cronj");
		   $this->cronj->genArchive();
		   }
	  public function dojob($job){
		  //double checking!
		  $this->load->model("login");
		  if(Login::checkUser()->getRole() == 0){
			  echo "No Access";
			 return false;
			 }
		  switch($job){
			  case "archive":
			  $this->genArchive();
			  break;
			  case "updatemealplan":
			  $this->checkMealplan();
			  break;
			  case "cleanDB":
			  $this->cleanDB();
			  break;
			  }
		  }

}

?>
