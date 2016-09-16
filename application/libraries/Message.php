<?php
/**
 * @file Message.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 31.05.2016 13:03:27 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Message to the kitchen
 * 
 * Is the Class which provied all methodes for every message to the kitchen
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
 class Message extends ContainerObject{
	 /**
	  * @var User
	  **/ 
	 protected   $sender;
	 /**
	  * @var String
	  **/
	  protected   $title;
	  /**
	  * @var String
	  **/
	  protected   $message;
	 /**
	  * @var int
	  **/
	  protected   $date;
	  /**
	   * @var boolean
	   **/
	   protected $seen;
	  //methodes:
	  //setter
		 /**
		  * @param User $user
		  * $user musst be a User Object
		  **/
	  public function setSender(User $user){
		  $this->sender = $user;
		  }
		/**
		 * @param string $title
		 **/
	  public function setTitle($title){
		  $this->title = $title;
		  }
		 /**
		  * @param string $msg
		  **/
	  public function setMessage($msg){
		  $this->message = $msg;
		  }
		 /**
		  * @param int $date
		  * Default: time()
		  **/
	  public function setDate($date = null){
		  $this->date = (is_null($date))? time():$date;
		  }
	  /**
	   * @param boolean $seen
	   **/
	  public function setSeen($seen){
		  $this->seen = $seen;
		  }

	  //getter
	  /**
	   * @return User
	   **/
	  public function getSender(){
		  return $this->sender;
		  }
	  /**
	   * @return string
	   **/
	  public function getTitle(){
		  return $this->title;
		  }
	  /**
	   * @return string
	   **/
	  public function getMessage(){
		  return $this->message;
		  }
	  /**
	   * @return int
	   **/
	  public function getDate(){
		  return $this->date;
		  }
	  /**
	   * @return booleam
	   **/
	  public function isSeen(){
		  return $this->seen;
		  }
	//other Methodes:
	/**
	 * creates a Notification Object based on the arguments from the db
	 * @param int $id
	 * @param string $field
	 * @param array $option
	 * Diffrent Where (SQL context) option
	 **/
	public function  create($id,$field = "id",$option = null){
		//get
		if(!is_array($option)){
			$mesg = $this->get($id,$field);
		}else{
			$mesg = $this->get(null,$option);
			}
		if(!is_null($mesg) AND count($mesg) == 1){
			$this->setID($mesg[0]->id);
			$this->setTitle($mesg[0]->title);
			$this->setMessage($mesg[0]->message);
			$user = new User();
			//if sender is NULL its an anoyme post!
			if($mesg[0]->sender == null OR $mesg[0]->sender == 0){
				$user->setAnonyme(true);
			}
			$this->setSender($user->create($mesg[0]->sender));
			$this->setDate($mesg[0]->date);
			$this->setSeen($mesg[0]->seen);
			}
		return $this;
		}
	/**
	 * Saves the Message in the database
	 **/
	   public function save(){
		   $this->CI->load->database();
		   $db = $this->CI->db;
			   $db->set("sender",$this->getSender()->getID());
			   $db->set("title",$this->getTitle());
			   $db->set("message",$this->getMessage());
			   $db->set("seen",$this->isSeen());
		   if(is_null($this->getID())){
			   //does not exists update
			   $db->set("date",$this->getDate());
			   $db->insert("messages");
			   $this->setID($db->insert_id());
			   }else{
			   $db->set("date",time());
			   $db->where("id",$this->getID());
			   $db->update("messages");	   
				   }
			return $this;
		   }
	 }
}
?>
