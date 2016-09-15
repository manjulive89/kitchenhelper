<?php
/**
 * @file Notifications.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 31.05.2016 12:43:18 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 namespace Container{
/**
 * Notifications
 * 
 * is the main object for the Notifications
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
 class Notifications extends ContainerObject{
	 /**
	  * @var boolean
	  ***/
	 protected  $important;
	 /**
	  * @var boolean
	  **/
	 protected  $fixed;
	 /**
	  * @var String
	  **/
	 protected  $title;
	 /**
	  * @var String
	  **/
	 protected  $message;
	 /**
	  * @var int
	  **/
	 protected  $date;
	 //methodes
	 //getter:
	 /**
	  * @return string
	  ***/
	public function getTitle(){
		return $this->title;
		}
	 /**
	  * @return string
	  ***/
	public function getMessage(){
		return $this->message;
		}
	 /**
	  * @return int
	  ***/
	public function getDate(){
		return $this->date;
		}
	 /**
	  * @return bool
	  ***/
	public function isImportant(){
		return $this->important;
		}
	 /**
	  * @return bool
	  ***/
	public function isFixed(){
		return $this->fixed;
		}
	//setter
	 /**
	  * @param string $title
	  ***/
	public function setTitle($title){
		$this->title = $title;
		}
	 /**
	  * @param string $msg
	  ***/
	public function setMessage($msg){
		$this->message = $msg;
		}
	/**
	 * setDate($date = null)
	 * 
	 * @param int $date
	 * If you do not set $date the current date will be choose
	 **/ 
	public function setDate($date = null){
		$this->date = (is_null($date))? time():$date;
		}
	/**
	 * @param bool $important
	 * can be true or false thx to MariaDB it can be 0 or 1 as well
	 **/
	public function setImportant($important){
		//mariaDB fix
		//$important = boolval($important);
		 if($important === true OR$important == 1 OR$important == "true"){
		$important = true;
		 }else{
			$important = false;
			 }
		$this->important = $important;
		}
	/**
	 * @param bool $fixed
	 * can be true or false thx to MariaDB it can be 0 or 1 as well
	 **/
	public function setFixed($fixed){
		//$important = boolval($important);
		 if($fixed === true OR$fixed == 1 OR$fixed == "true"){
		$fixed = true;
		 }else{
			$fixed = false;
			 }
		$this->fixed = $fixed;
		}
	/**
	 * creates a Notification Object based on the arguments set in the argument list of this method from the db.
	 * @param int $id
	 * @param string $field
	 * @param array $option
	 * Diffrent Where (SQL context) option
	 * @return Notifications
	 **/
	public function  create($id,$field = "id",$option = null){
		//get
		if(!is_array($option)){
			$notif = $this->get($id,$field,array("date","DESC"));
		}else{
			$notif = $this->get(null,$option,array("date","DESC"));
			}
		if(!is_null($notif) AND count($notif) == 1){
			$this->setID($notif[0]->id);
			$this->setTitle($notif[0]->title);
			$this->setMessage($notif[0]->message);
			$this->setImportant($notif[0]->important);
			$this->setFixed($notif[0]->fixed);
			$this->setDate($notif[0]->date);
			}
		return $this;
		}
	   public function save(){
		   $db = $this->CI->db;
		   // check if exists if yes update
			   $db->set("message",$this->getMessage());
			   $db->set("title",$this->getTitle());
			   $db->set("fixed",$this->isFixed());
			   $db->set("important",$this->isImportant());
		   if(is_null($this->getID()) OR !is_numeric($this->getID())){
			   //does not exists update
			   $db->set("date",$this->getDate());
			  $db->insert("notifications");
			   $this->setID($db->insert_id());
			   }else{
			   $db->set("date",time());
			   $db->where("id",$this->getID());
			   $db->update("notifications");	   
				   }
			return $this;
		   }
	 
	 }
}
?>
