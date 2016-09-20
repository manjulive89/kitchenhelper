<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @file Container.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 31.05.2016 14:08:58 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 *
 * Workaround:
 * Codeigniter do not like Namespaces
 **/
    if(!defined("USER_LIBS")){
		define("USER_LIBS",APPPATH."libraries/");
	}
 require_once USER_LIBS."Containerobject.php";
 require_once USER_LIBS."Meal.php";
 require_once USER_LIBS."Mealtimes.php";
 require_once USER_LIBS."Mealplanner.php";
 require_once USER_LIBS."Message.php";
 require_once USER_LIBS."Notifications.php";
 require_once USER_LIBS."Signoffsheet.php";
 require_once USER_LIBS."Tick.php";
 require_once USER_LIBS."User.php";
 require_once USER_LIBS."Diet.php";
 require_once USER_LIBS."Group.php";
 require_once USER_LIBS."Groups.php";
/**
 * Container class
 * 
 * this is the class which creates out of database requests the objects. This class require to work the following classes: Meal, Mealtimes, Mealplanner, Message, Notifications,User,Signofsheet,Tick
 * 
 * This Class has 2 types of methodes:
 * 
 * 1) Class getter:
 * This methodes are the first methodes in the class, their job is it to get and ini. all Classes @see requiere block.
 * 2) Logic methodes:
 * This methodes are to divide into sub categories:
 * 2.1) Creator Methodes:
 * This methodes creating based on Database information Objecs and return them in an Array or as an Single Object.
 * 2.2) Modification Methodes:
 * This methodes modifiicate the Database based on the Objects given.
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 **/
 class Container{
	 private $CI;
	 public function __construct(){
			$this->CI =& get_instance();
		 }
		/**
		 * Class getter: Meal Class
		 * @return Container\Meal
		 **/
	 public function getMealClass(){
		 return new Container\Meal();
		 }
		/**
		 * Class getter: Mealtime Class
		 * @return Container\Mealtimes
		 **/
	 public function getMealtimesClass(){
		 return new Container\Mealtimes();
		 }
		/**
		 * Class getter: Mealplanner Class
		 * @return Container\Mealplanner
		 **/
	 public function getMealplannerClass(){
		 return new Container\Mealplanner();
		 }
		/**
		 * Class getter: Message Class
		 * @return Container\Message
		 **/
	public function getMessageClass(){
		return new Container\Message();
		}
		/**
		 * Class getter: Notifications Class
		 * @return Container\Notifications
		 **/
	public function getNotificationClass(){
		return new Container\Notifications();
		}
		/**
		 * Class getter: Signoffsheet Class
		 * @return Container\Signoffsheet
		 **/
	public function getSignOffSheetClass(){
		return new Container\Signoffsheet();
		}
		/**
		 * Class getter: Tick Class
		 * @return Container\Tick
		 **/
	public function getTickClass(){
		return new Container\Tick();
		}
		/**
		 * Class getter: Diet Class
		 * @return Container\Diet
		 **/
	public function getDietClass(){
		return new Container\Diet();
		}
		/**
		 * Class getter: Group Class
		 * @return Container\Group
		 **/
	public function getGroupClass(){
		return new Container\Group();
		}
		/**
		 * Class getter: Groups Class
		 * @return Container\Groups
		 **/
	public function getGroupsClass(){
		return new Container\Groups();
		}
		/**
		 * Class getter: User
		 * @return Container\User
		 **/
	public function getUserClass(){
		return new Container\User();
		}
		/**
		 * Class getter: Modifications
		 * @return Container\Modifications
		 **/
	public function getModificationsClass(){
		return new Container\Modifications();
		}
	/**
	 * ####################################
	 * Logic Methodes::Creator Methodes
	 * @see class discription
	 * ####################################
	 **/ 
	/**
	 * getMealTimes (Creator Methode)
	 * 
	 * returns all MealTime like: breakfast,Lunch etc. as an array of objects
	 * (see return)
	 * If no parameter is set the method will return all mealtimes. If only $mtID is set the method will return only one Object of this particular ID. (Important: without meals!)
	 * If $mpID is set then you get all Meals of that Mealplan and that Mealtime.
	 * @param int $mtID
	 * MealTime ID Default: null
	 * @param int $mpID
	 * MealPlan ID Default null.
	 * @return mixed
	 * If there are no mealtimes which are match the $mID or in general it will return no Object of MealTime no it will return null
	 **/
	public function getMealTimes($mtID = null,$mpID = null){
		//if $mpID is set
		if(is_null($mpID) AND is_null($mtID)){
			//return ONLY all mealtimes:
			return $this->createObjects("mealtimes",null,"id",null,array("start","ASC"));
		}else if(is_null($mpID) AND !is_null($mtID)){
			//return a mealtime of a special ID
		return $this->getMealtimesClass()->create($mtID);
		}else if( !is_null($mpID) AND !is_null($mtID)){
			//return a mealtime form a special mealplanner:
			$mealtimeObject = $this->createObjects("mealtimes",$mpID,"mpID",null,array("start","ASC"));
			foreach($mealtimeObject as $mealtime){
				if($mealtime->getID() == $mtID){
					return $mealtimeObject;
					}
				}
			}
				return null;
	}
	/**
	 * getMealPlanner (Creator Methode)
	 * 
	 * retuns an array of mealPlans (Mealplanner Objects)
	 * @param int $mpID
	 * Default: null
	 * @return mixed
	 * If no mealplans can be found it will send null otherwiese it sends an array constis of Container\Mealplanner Objects.
	 **/
	 public function getMealPlans($mpID = null){
		 $mealplans = $this->createObjects("mealplanner",$mpID);
		 $sortedArray = array();
		 foreach($mealplans as $mealplan){
			 if($mealplan->isActive() == true){
			 $sortedArray[$mealplan->getSort()] = $mealplan;
			 ksort($sortedArray);
				}else{
					$sortedArray[] = $mealplan;
					}
			 }
		 return $sortedArray;
		 }
	/**
	 * getActiveMealPlans (Creator Methode)
	 * 
	 * retuns an array of all active mealPlans (Mealplanner Objects)
	 * @return mixed
	 * If no mealplans can be found it will send null otherwiese it sends an array constis of Container\Mealplanner Objects.
	 **/
	 public function getActiveMealPlans(){
		 $mealplans = $this->createObjects("mealplanner",null);
		 $sortedArray = array();
		 foreach($mealplans as $mealplan){
			 if($mealplan->isActive() == true){
			 $sortedArray[$mealplan->getSort()] = $mealplan;
			 ksort($sortedArray);
				}
			 }
		 return $sortedArray;
		 }
	/**
	 * getMeals (Creator Methode)
	 * 
	 * @param int $id
	 * Default null
	 * @return mixed
	 **/
	 public function getMeals($id = null){
		 return $this->createObjects("meal",$id,"id",null,array("name","ASC"));
		 }
	/**
	 * getNotifications (Creator Methode)
	 * 
	 * returns an array with container\notifications or an Container\Notifications Object
	 * 
	 * @see Notification Class
	 * @param int $nID
	 * Notification ID default: null
	 * @return mixed
	 * If $nID is NOT set it will return ALL Notifcations like array("fixed"=>Notifications,"other"=>Notifications) but if $nID is set it will return an Container\Notification Object. If there is not match it will return null.
	 **/
	 public function getNotifications($nID = null){
		 $notif = $this->createObjects("notifications",$nID,"id",null,array("date","DESC"));
		 $return = array("fixed"=>array(),"other"=>array());
		 if(is_array($notif)){
		 foreach($notif as $n){
			 if($n->isFixed() == true){
					$return["fixed"][] = $n;
				 }else{
					 $return["other"][] = $n;
					 }
			 }
		 }else if(is_object($notif)){
			 $index = ($notif->isFixed() == true)? "fixed":"other";
			 $return[$index] = $notif;
			 
			 }
		 return $return;
		 }
	/**
	 * getGroups (Creator Methode)
	 * 
	 * creates one or more Group Objects see User class for more information
	 * 
	 * @param int $gID
	 * Default: null
	 * @return mixed
	 * It can be an array or an Diet Object depends how much dietries the database has and if $uID was set. If nothing could be found it will return null.
	 **/
	 public function getGroup($gID = null){
		 return $this->getGroups($gID);
		 }
	/**
	 * getUsers (Creator Methode)
	 * 
	 * creates one or more User Objects see User class for more information
	 * 
	 * @param int $uID
	 * Default: null
	 * @return mixed
	 * It can be an array or an Diet Object depends how much dietries the database has and if $uID was set. If nothing could be found it will return null.
	 **/
	public function getUsers($uID = null){
		if ($uID != null)
		{
			return $this->getUser($uID);
		}
		
		 $users = $this->createObjects("user",null,"id",null,array("name","ASC"));
		 if($uID == null){
			 $group = array();
				 foreach($users as $user){
					 $group[$user->getGroup()->getID()][] = $user;
					 }
					return $group;
			}else{
				return $users;
				}
		}
	/**
	 * getDiet (Creator Methode)
	 * 
	 * creates one or more Diet Objects. See Diet Class for more information.
	 * 
	 * @param int $dID
	 * Default: null
	 * @return mixed
	 * It can be an array or an Diet Object depends how much dietries the database has and if $dID was set. If nothing could be found it will return null.
	 **/
	public function getDiets($dID = null){
		 return $this->createObjects("dietaries",$dID,"id",null,array("name","ASC"));
		}
	/**
	 * Alias methode to self::getDiets($dID = null)
	 * @param int $dID
	 * Default null
	 * @return mixed
	 * see self::getDiets
	 **/
	public function getDietaries($dID = null){
		return $this->getDiets($dID);
		}
	/**
	 * getUserDiets (Creator Methode)
	 * 
	 * will return all diets of one User.
	 * 
	 * @param int $uID
	 * @return array
	 * Its an array of Container\Diet Objects. If nothing could be found it will return an empty array.
	 **/
	public function getUserDiets($uID){
		$user = $this->getUser($uID);
		return $user->getDietaries();
		}
	/**
	 * 
	 * getGroups (Creator Methode)
	 * 
	 * gives you an Array of Container\Groups objects or an Container\Groups object
	 * 
	 * @param int $gID
	 * Default: null
	 * @return mixed
	 * It can be an array or an Container\Groups Object depends how much groups the database has and if $gID was set. If nothing could be found it will return null.
	 **/
	 public function getGroups($gID = null){
		 return $this->createObjects("groups",$gID,"id",null,array("date","ASC"));
	}
	/**
	 * 
	 * getallGroupsToDay (Creator Methode)
	 * 
	 * gives you an Array of Container\Groups objects or an Container\Groups object
	 * 
	 * @param int $gID
	 * Default: null
	 * @return mixed
	 * It can be an array or an Container\Groups Object depends how much groups the database has and if $gID was set. If nothing could be found it will return null.
	 **/
	 public function getAllGroupsWeek($week = null){
		$week = ($week == null)? date("W"):$week;
		$groups = $this->createObjects("groups",null,"id",null,array("date","ASC"));
		$groupsArray = array();
		foreach($groups as $group){
			if(count($group->getTicks($week)) != 0){
				$groupsArray[] = array("id"=>$group->getID(),"name"=>$group->getName(),"ticks"=>$group->getTicks($week),"number"=>$group->getNumber(),"diets"=>$group->getDiets());
				}
			}
		return $groupsArray;
	}
	/**
	 * 
	 * getUserGroups (Creator Methode)
	 * 
	 * gives you an Array of Container\Group objects or an Container\Group object
	 * 
	 * @param int $gID
	 * Default: null
	 * @return mixed
	 * It can be an array or an Container\Group Object depends how much groups the database has and if $gID was set. If nothing could be found it will return null.
	 **/
	 public function getUserGroups($gID = null){
		 return $this->createObjects("usergroups",$gID,"id",null,array("name","ASC"));
	}	 
	/**
	 * getUser (Creator Methode)
	 * 
	 * creates one or more User objects. see User Class for more information.
	 * 
	 * @param int $userID
	 * Default: null
	 * @return mixed
	 * will return an array of User Objects OR only one User based on ID. If nothing could be found it will return null.
	 **/
	public function getUser($userID = null){
		return $this->createObjects("user",$userID);
		}
	/**
	 * 
	 * getAllMessages (Creator Methode)
	 * 
	 * creates an Array filled with Messages Objects. For more information see Message Class
	 * @param int $mID
	 * Default: null
	 * @return array
	 * This array will be structured like this: [Message,Message,Message] or a single Object. 
	 * If no messages could be found it will return a Null;
	 **/
	 public function getMessages($mID = null){
	  return $this->createObjects("messages",$mID,null,null,array("date","DESC"));
	 }
	 
	 public function getSignOffSheets($week = null,$mtID = null){
		 $signoffsheets = array();
		 $this->CI->load->database();//load in database
		 			 $db = $this->CI->db;
		 if($week == null AND $mtID == null){
			 //in this case we get all signoffsheets based on mtID and Week
			 $db->distinct();
			 $db->select("week");
			 $db->select("mtID");
			}else if($week != null AND $mtID == null){
			 $db->distinct();
			 $db->select("week");
			 $db->select("mtID");
			 $db->where("week",$week);
				}else if($week != null AND $mtID != null){
					 $db->distinct();
					 $db->select("week");
					 $db->select("mtID");
					 $db->where(array("week"=>$week,"mtID"=>$mtID));
					}
			 foreach($db->get("ticked")->result() as $sheet){
				 $signoffsheets[$sheet->week][$sheet->mtID] = $this->getSignOffSheetClass()->create($sheet->week,null,$sheet->mtID);
				 }
			return $signoffsheets;
		}
	 
	 public function createObjects($table,$id = null,$field = "id",$options = null,$order = null){
		 //data
		 $data = array();
		 if(!isset($this->CI->db)){
			 $this->CI->load->database();
			 }
		 $db = $this->CI->db;
		 $this->CI->load->database();
		 if(is_null($id)){
			 $query = $db->select("id");
			 }else{
				 if($options != null){
					 $query = $db->select("id")->where($options);
					 //bug fix:$field == null
					}else if($field != null){
						$query = $db->select("id")->where($field,$id);
					}else{
						$query = $db->select("id");
						}
				 }
			if(is_array($order)){
				$query->order_by($order[0],$order[1]);
				}
			$query = $query->get($table)->result();
		if(count($query) > 0){
			$tables = array(
				"dietaries" => "Container\Diet",
				"usergroups" => "Container\Group",
				"groups" => "Container\Groups",
				"meal" => "Container\Meal",
				"mealplanner" => "Container\Mealplanner",
				"mealtimes" => "Container\Mealtimes",
				"messages" => "Container\Message",
				"notifications" => "Container\Notifications",
				"user" => "Container\User",
				"ticked" => "Container\Tick"
				);
			if(array_key_exists($table,$tables)){
				foreach($query as $res){
					$class = new $tables[$table]();
					$data[] = $class->create($res->id);
					}
				return $data;
			}else{
				return array();
				}
			}else{
				return array();
				}
			
		 }
}
?>
