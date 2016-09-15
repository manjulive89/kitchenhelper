<?php
/**
 * @file Diet.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 02.06.2016 09:37:09 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Diet conatiner
 * 
 * this class is give you all methodes you need for modifiying and working with Diets
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
 class Diet extends ContainerObject{
	   /**
	    * @var boolean
	    **/
	   protected  $danger;
	   /**
	    * @var string
	    **/
	   protected  $description = "None";
	   /**
	    * @var number
	    * Number of people with diets is only required for Conatiner\Groups
	    **/
	   protected $number = 0;
	   //setter
	   /**
	    * @param boolean $danger
	    **/
	   public function setDanger($danger){
		   //(is_bool($danger))? $danger:boolval($danger) fixed
		   if($danger === 0 or $danger == false OR $danger == "false"){
			   $danger = false;
			   }else if($danger === 1 or $danger == true OR $danger == "true"){
				   $danger = true;
				   }
			$this->danger = $danger;
		   }
	   /**
	    * @param string $desc
	    **/
	   public function setDescription($desc){
		   $this->description = $desc;
		   }
	   /**
	    * @param int $number
	    **/
	   public function setNumber($number){
		   $this->number = $number;
		   }
	   //getter:
	   /**
	    * @return string
	    **/
	   public function getDescription(){
		   return $this->description;
		   }
	   /**
	    * @return int
	    **/
	   public function getNumber(){
		   return $this->number;
		   }
	   /**
	    * @return boolean
	    **/
	   public function isDanger(){
		   $danger = $this->danger;
		    if(is_bool($danger)){
				return $danger;
				}else if($danger == 0 OR $danger == false OR $danger == "false"){
					return $danger;
					}
		   return $danger;
		   }
	//other methodes:
	/**
	 * creates a Diet Object based on the arguments from the db
	 * @param int $id
	 * @param string $field
	 * @param array $option
	 * Diffrent Where (SQL context) option
	 **/
	public function  create($id,$field = "id",$option = null){
		//get
		if(!is_array($option)){
			$diet = $this->get($id,$field);
		}else{
			$diet = $this->get(null,$option);
			}
		if(!is_null($diet) AND count($diet) == 1){
			$this->setID($diet[0]->id);
			$this->setName($diet[0]->name);
			$this->setDanger($diet[0]->danger);
			if($diet[0]->description != ""){
				$this->setDescription($diet[0]->description);
			}
			}
		return $this;
		}
	   public function save(){
		   $db = $this->CI->db;
		   // check if exists if yes update
			   $db->set("name",$this->getName());
			   $db->set("danger",$this->isDanger());
			   $db->set("description",$this->getDescription());
		   if(is_null($this->getID())){
			   //does not exists update
			   $db->insert("dietaries");
			   $this->setID($db->insert_id());
			   }else{
			   $db->where("id",$this->getID());
			   $db->update("dietaries");	   
				   }
			return $this;
		   }
	 }
}
?>
