<?php
/**
 * @file Update.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 07.06.2016 08:48:21 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Updates
 * 
 * This class provied all the api (POST) update methodes.
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
class Updates extends CI_Model{
	    /**
	     * 
	     * Call the CI_Model constructor
	     * 
	     * **/
		public function __construct(){
			parent::__construct();
			$this->load->library('container');
		}
	/**
	 * ###################
	 * 	Messages Methodes
	 * ###################
	 **/
	 
	 /**
	  * Updated the seen parameter in db of a message object!
	  * @return mixed
	  * Returns an array with data OR an Object OR an empty array.
	  **/
	  public function seen(){
		 $this->load->model("login");
		 if(Login::checkUser()->getRole() == 0){
			 return false;//if not return false
			 }
		  //get Object:
		  $data = $this->input->post("data");
		  //create messages Object:
		  $msg = $this->container->getMessageClass()->createObjectByArray($data);
		  if($msg != null){
			  $msg->setSeen(true);
			  $msg->save();
			  return $msg->getJsonObject();
			}else{
				return null;
				}
		  }
	/**
	 * order changes 
	 * 
	 * changes the meal order for mealplans in db
	 * @history: fixed the update bug that if you update the order that randomly (because of the async of AJAX) two database enrtys have the same sort. Hope its fixed.
	 * @return mixed
	 **/
	 public function order(){
		 $this->load->model("login");
		 if(Login::checkUser()->getRole() == 0){
			 return false;//if not return false
			 }
		  //get Object:
		  $data = $this->input->post("data");
		  if(is_array($data) AND isset($data["id"])){
			  $this->load->database();
			  $this->db->where("id",$data["id"]);
			  $this->db->set("sort",$data["sort"]);
			  $this->db->update("mealplanner");
			  //change order of all if set sort == 0
			 if($data["sort"] == 0){
				  $this->db->where("id !=",$data["id"]);
				  $this->db->set("activationtime",0);
			      $this->db->update("mealplanner");
				  $this->db->where("id",$data["id"]);
				  $this->db->set("activationtime",date("W"));
			      $this->db->update("mealplanner");
			      
				  }
			  }else{
				  return false;
				  }
		 }
	/**
	 * update objects
	 * @return mixed
	 **/
	 public function update(){
		 //check if user has the right to change stuff:
		 $this->load->model("login");
		 if(Login::checkUser()->getRole() == 0){
			 return false;//if not return false
			 }
		//load database
		 $this->load->database();
		 //get input from post
		 $data = $this->input->post("data");//data contains the object we need
		 $class = ucfirst($this->input->post("type"));//the class name
		 //check if user is manager and trys to update something else then user,group,diets
		 if($class != "User" AND $class != "Group" AND $class != "Diet" AND Login::checkUser()->getRole() != 2){
			 return false;
			 }
		//@added: 2016/12/28
		//exception
		if($data == "update_mealplaner" AND $class == "Mealplanner"){
		   $this->load->model("cronj");
		   $this->cronj->checkMealplan();
		   return ["status"=>"done"];
			}
		//create the class ini methode
		 $method = "get".$class."Class";//<< get[classname]Class() @see Container.php
		 if(method_exists($this->container,$method)){//check if this class exists
			 /**
			  * creates object based on a array
			  * @see ContainerObject.php
			  **/
			 $obj = $this->container->$method()->createObjectByArray($data);//get a object
			 /**
			  * ##################
			  * USER UPDATE EXTRAS
			  * ##################
			  **/
			 if($class == "User"){
				 if(Login::checkUser()->getRole() >= $obj->getRole()){
				 //user must be unique:
				 if($obj->getID() == null){
				 $check = $this->db->where("email",$data["email"])->get("user")->result();
				 $checkPassword = array();
				}else{
					$checkPassword = $this->db->where("id",$obj->getID())->get("user")->result();
					$check = $this->db->where(array("email"=>$data["email"],"id"=>"!= ".$obj->getID()))->get("user")->result();
					}
				if(count($checkPassword) == 1){
				if(strlen($checkPassword[0]->password) == 0){
					if($obj->getRole() == 1){
						return false;
						}
					}
				}
				 if(count($check) >= 1){
					 return false;
					 }
				 }else{
					 return false;
					 }
			 }
			 /*
			  * Mealplanner exception
			  * fixes the fact that if there is NO active mealplan that there will be no active mealplan.
			  **/
			 if($class == "Mealplanner"){
				if(count($this->container->getActiveMealPlans()) == 0 && $obj->isActive()){
				 $obj->setActivationTime();
				 }
			 }
			 /**
			  * ##############
			  *  Save Process
			  * ##############
			  **/
			 if($obj != null){
				if($obj->save() == true){
					//user Addon (ADMIN):
					if($class == "User" AND array_key_exists("password",$data)){
							if($data["password"] != null){
							$password =  password_hash($data["password"], PASSWORD_DEFAULT);
							$this->db->set("password",$password)->where("id",$obj->getID())->update("user");
							}
						}
					return true;
					}
					return false;
				 }
			 
			 }else{
				 return array("error"=>false);
				 }
		 }
	/**
	 * update_frontend
	 **/
	 public function update_frontend(){
		 $this->load->database();
		 $data = $this->input->post("data");//object
		 $class = ucfirst($this->input->post("type"));//which class
		 $method = "get".$class."Class";
		 if(method_exists($this->container,$method)){
			 switch($class){
				 case "User":
				 /**
				  * The only things which they can change is:
				  * dietaries
				  **/
				  $uID = (isset($data["id"]))? $data["id"]:null;
				  if(array_key_exists("dietaries",$data)){
						$diets = $data["dietaries"];
					}else{
						$diets = array();
						}
				  if(is_numeric($uID)){
				  $user = $this->container->$method()->create($uID);
				  }else{
					  $user = null;
					  }
				  
				  if(!is_null($user)){
					  $user->setDietaries(array());
					  foreach($diets as $k => $diet){
					  $adiet = $this->container->getDietClass()->createClassbyArray("Diet",$diet);
					  $user->addDiet($adiet);
					}
				  if($user->save() == true){
					  return true;
					  }
				  }else if($data["group"]["name"] == "Guests" OR $data["group"]["name"] == "Casuals"){
					  $data["role"] = 0;
					  $data["removed"] = false;
					  $user = $this->container->getUserClass()->createObjectByArray($data);
					  $user->save();
					  return true;
					  }
				  return false;
				 break;
				 case "Meal":
				 $meal = $this->container->getMealClass();
				 $meal->create($data["id"]);
				 $meal->vote(1);
				 $meal->save();
				 break;
				 case "Signoffsheet":
				 /**
				  * @fixed: bug if there was no other tick that it did not save by adding the check if ticks exists.
				  **/
				 if(isset($data["ticks"])){
						$ticks = $data["ticks"];
					}else{
						$ticks = 0;
						}
				 if(count($ticks) != 0){
					$sheet = $this->container->getSignOffSheetClass()->createObjectByArray($data);
					$sheet->save();
					return true;
				}else{
					return false;
				}
				 break;
				 case "Diet":
					$diet = $this->container->getDietClass()->createObjectByArray($data);
					$diet->save();
					return true;
				 break;
				 case "Groups":
					$group = $this->container->getGroupsClass()->createObjectByArray($data);
					$group->save();
					return true;
				 break;
				 default:
				 return array("error","unknown command");
				 break;
				 }
			 }
		 }
	/**
	 * sends a message
	 * @return mixed
	 **/	
	public function sendMessages(){
			$mesg = $this->container->getMessageClass();
			$mesg->setMessage($this->input->post("text",true));
			$mesg->setTitle($this->input->post("title",true));
			$mesg->setSeen(false);
			$mesg->setDate();
			//check sender:
			$user = $this->db->where("email",$this->input->post("email",true))->get("user")->result();
			if(count($user) > 0){
				
				$mesg->setSender($this->container->getUserClass()->create($user[0]->id));
				}else{
					$sender = $this->container->getUserClass()->create(0);
					$mesg->setSender($sender);
					$mesg->setMessage("############################################################\nE-Mail: ".$this->input->post("email",true)."\nName:".$this->input->post("name",true)."\n############################################################\n\n".$this->input->post("text",true));
					}
			$mesg->save();
		} 
	public function delete_frontend(){
		 $data = $this->input->post("data");
		 $class = ucfirst($this->input->post("type"));
		 if($class == "Groups" OR $class == "Diet"){
		 $method = "get".$class."Class";
		 if(method_exists($this->container,$method)){
			 $obj = $this->container->$method()->createObjectByArray($data);
			 if($obj != null){
				 //exceptions:
				if($class == "Group"){
					$this->load->database();
					$this->db->set("group",1)->where("group",$obj->getID())->update("user");
					}
				if($obj->delete() == true){
					return true;
					}
					return false;
				 }
			 
			 }else{
				 return array("error"=>false);
				 }
			 }else{
				 return array("error"=>false);
				 }
		}
	/**
	 * delete object
	 * @return mixed
	 **/
	 public function delete(){
		  $this->load->model("login");
		 if(Login::checkUser()->getRole() == 0){
			 return false;
			 }
		 $data = $this->input->post("data");
		 $class = ucfirst($this->input->post("type"));
			//Only Admins can have access to everything
		 if(($class != "User" AND $class != "Group" AND $class !="Diet") AND Login::checkUser()->getRole() == 1){
			 return false;
			 }
		 if($class == "Group" AND $data["id"] == 1){
			 return false;
			 }
		 if($class == "User"){
			 return false;
			 }
		 //create object:
		 $method = "get".$class."Class";
		 if(method_exists($this->container,$method)){
			 $obj = $this->container->$method()->createObjectByArray($data);
			 if($obj != null){
				 //exceptions:
				if($class == "Group"){
					$this->load->database();
					$this->db->set("group",1)->where("group",$obj->getID())->update("user");
					}
				if($obj->delete() == true){
					return true;
					}
					return false;
				 }
			 
			 }else{
				 return array("error"=>false);
				 }
		 }
	}
?>
