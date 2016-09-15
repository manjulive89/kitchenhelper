<?php
/**
 * @file Group.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 02.06.2016 09:17:44 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Group container Class
 * 
 * This is the container class for User Groups (or with other words a TEAM)
 * @todo  rename this class or create a alias class
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
 class Group extends ContainerObject{
	 /**
	  * saves this object in db
	  * 
	  **/
	   public function save(){
		   $db = $this->CI->db;
		   // check if exists if yes update
		   //check if name is unique:
		   $group = $db->where("name",$this->getName())->get("usergroups")->result();
		   if(count($group) == 1){
			   $this->setID($group[0]->id);
			   }
			   $db->reset_query();
			   $db->set("name",$this->getName());
		   if(is_null($this->getID())){
			   //does not exists update
			   $db->insert("usergroups");
			   $this->setID($db->insert_id());
			   }else{
			   $db->where("id",$this->getID());
			   $db->update("usergroups");	   
				   }
			return $this;
		   }
	/**
	 * creates a Group Object based on the arguments from the db
	 * @param int $id
	 * @param string $field
	 * @param array $option
	 * Diffrent Where (SQL context) option
	 **/
	public function  create($id,$field = "id",$option = null){
		//get
		if(!is_array($option)){
			$group = $this->get($id,$field);
		}else{
			$group = $this->get(null,$option);
			}
		if(!is_null($group) AND count($group) == 1){
			$this->setID($group[0]->id);
			$this->setName($group[0]->name);
			}
		return $this;
		}
	 }
}
?>
