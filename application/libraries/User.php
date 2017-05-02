<?php
/**
 * @file Usercontainer.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 30.05.2016 16:33:42 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Proviedes the functions of the User Object
 * 
 * With this class you can create under providig inforations for the create method a user object based on the database or 
 * you can create a new object with the normal way how you ini a Object in PHP.
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
class User extends ContainerObject{
	/** 
	 * @var string 
	 **/
	protected $surname;
	/** 
	 * @var string
	 **/
	protected $email;
	/** 
	 * @var array
	 **/
	protected $dietaries = array();
	/** 
	 * @var Group 
	 **/
	protected $group;
	/** 
	 * @var boolean 
	 **/
	protected $role;
	/** 
	 * @var boolean 
	 **/
	protected $removed;
	/**
	* Is message Anonyme or not. Default is false
	* @var boolean
	**/
	protected $anonyme = false;
	/**
	 * has the user a password!
	 * var boolean
	 **/
	 protected $hasPw;
	//setter
	/**
	 * @param string $surname
	 **/
	public function setSurname($surname){
		$this->surname =$surname;
		}
	/**
	 * @param string $email
	 **/
	public function setEmail($mail){
		$this->email = $mail;
		}
	/**
	 * @param array $diet
	 * should be an array of Container\Diet objects
	 **/
	public function setDietaries($diet){
		$this->dietaries = $diet;
		}
	/**
	 * @param Group $grp
	 **/
	public function setGroup(Group $grp){
		$this->group = $grp;
		}
	/**
	 * @return int
	 * 0 User | 1 Manager | 2 Admin
	 **/
	public function setRole($role){
		$this->role = intval($role);
		}
	public function setRemoved($remove){
		if($remove == "true" OR $remove == 1 OR $remove === true){
			$remove = true;
			}else{
				$remove = false;
				}
		$this->removed = $remove;
		}
		  /*
	   * @param boolean $condition
	   **/
	  public function setAnonyme($condition){
			 $this->anonyme = $condition;
		  }
	  public function setHasPassword($hpw = false){
		  $this->hasPw = $hpw;
		  }
	//get
	/**
	 * @return string
	 **/
	public function getSurname(){
		return $this->surname;
		}
	/**
	 * @return string
	 **/
	public function getEmail(){
		return $this->email;
		}
	/**
	 * Renturns a array with Conatiner\Diet objects.
	 * @return array
	 **/
	public function getDietaries(){
		return $this->dietaries;
		}
	/**
	 * alias methode to getDietaries()
	 * @return array
	 **/
	public function getDiet(){
		return $this->getDietaries();
		}
	/**
	 *  The integer role numbers are:
	 *  <b>0 user | 1 Manager | 2 Admin</b>
	 * @return int
	 *
	 **/
	public function getRole(){
		return $this->role;
		}
	/**
	 * Returns a Container\Group Object
	 * @see Group
	 * @return Group
	 **/
	public function getGroup(){
		return $this->group;
		}
	/**
	 * Is user in db set as removed?
	 * @return boolean
	 **/
	public function getRemoved(){
		if($this->removed == 1 OR $this->removed === true OR $this->removed == "true"){
			return  true;
			}else{
				return false;
				}
		return $this->removed;
		}
		  /**
	   * @return boolean
	   **/
	  public function isAnonyme(){
		  return $this->anonyme;
		  }
	/**
	 * @return boolean
	 **/
	 public function hasPassword(){
		 return $this->hasPw;
		 }
	//other methodes:
	/**
	 * Adds a new diet to the self::$diet array
	 * @param Diet $diet
	 **/
	public function addDiet(Diet $diet){
		$this->dietaries[] = $diet;
		}
	/**
	 * Removes a diet from self::diet array
	 * @param Diet $diet
	 **/
	public function removeDiet(Diet $diet){
			if(in_array($diet,$this->getDietaries())){
				unset($this->dietaries[array_search($diet,$this->getDietaries())]);
				return true;
				}
				return false;
		}
	/**
	 * Creates an User Object based on the database
	 * @see ContainerObject::get()
	 * @version 1.0
	 * @param int $id
	 * @param string $field
	 * @param array $option
	 * Is the optinal array for a diffrent where @see ContainerObject::get()
	 **/
	public function  create($id,$field = "id",$option = null){
		//check if isAnonyme
		if(!$this->isAnonyme()){
			//get
			if(!is_array($option)){
				$user = $this->get($id,$field);
			}else{
				$user = $this->get(null,$option);
				}
			if(!is_null($user) AND count($user) == 1){
				$this->setID($user[0]->id);
				$this->setName($user[0]->name);
				$this->setSurname($user[0]->surname);
				$this->setRole($user[0]->role);
				$this->setEmail($user[0]->email);
				$this->setRemoved($user[0]->removed);
				if(strlen($user[0]->password) == 0){
					$this->setHasPassword();
					}else{
						$this->setHasPassword(true);
						}
				$group = new Group();
				$group->create($user[0]->group);
				$this->setGroup($group);
				//dietaries:
				$this->CI->load->database();
				$db = $this->CI->db;
				foreach($db->where("uID",$this->getID())->get("userdietaries")->result() as $d){
					$diet = new Diet();
					$diet->create($d->dID);
					$this->addDiet($diet);
					}
				}
		 }else{
			 //create Anynome user:
			 $this->setID(0);
				$this->setName("Anonymous");
				$this->setSurname("Surname");
				$this->setRole(0);
				$this->setEmail("none");
				$this->setRemoved(0);
				$group = new Group();
				$group->create(1);//@Todo: default group has ID 1 @make this flexible
				$this->setGroup($group);
			 }
		return $this;
		}
		/**
		 * saves the Object in database
		 **/
	   public function save(){
		   $db = $this->CI->db;
		   // check if exists if yes update
			   //check if group exists
			   if($this->getGroup()->getID() == null){
				   $this->getGroup()->save();
			   }
			   $db->set("name",$this->getName());
			   $db->set("surname",$this->getSurname());
			   $db->set("email",$this->getEmail());
			   $db->set("role",$this->getRole());
			   $db->set("group",$this->getGroup()->getID());
			   $db->set("removed",$this->getRemoved());
		   if(is_null($this->getID())){
			   //does not exists update
			   $db->insert("user");
			   $this->setID($db->insert_id());
			   }else{
			   $db->where("id",$this->getID());
			   $db->update("user");	   
				   }
			//user dietaries:
			$diets = $this->getDietaries();
			if(is_array($diets)){
				$dbDiets = $db->where("uID",$this->getID())->get("userdietaries")->result();
				if(count($dbDiets) != count($diets)){
				$this->dietaries = array();
				$db->where("uID",$this->getID())->delete("userdietaries");
				foreach($diets as $diet){
					$diet->save();//make suer it exists
					if($diet->getID() != null){
						$db->set(array("uID"=>$this->getID(),"dID"=>$diet->getID()))->insert("userdietaries");
						$this->addDiet($diet);
						}
					}
				}
			}
			return $this;
		   }
	}
}
?>
