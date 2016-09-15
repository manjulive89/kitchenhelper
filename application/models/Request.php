<?php
/**
 * @file Request.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 30.05.2016 16:27:14 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Ajax-Request Handler
 * 
 * Answered to all request request to the api and provied the data.
 * This class never return any Objects only SdtClass Objects in Arrays so that json_encode() is able to create a nice and clean output
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 */
class Request extends CI_Model{
	    /**
	     * 
	     * Call the CI_Model constructor
	     * 
	     * **/
		public function __construct(){
				$this->load->library('container');
                parent::__construct();
		}
		/**
		 * Returns groups form groups table
		 * @return array
		 * @see Container::getAllGroups()
		 **/
		public function getallgroups(){
			return $this->getJsonObjectOfArrayOrObject($this->container->getGroups());
			}
		/**
		 * Returns groups form groups table
		 * @param int $week
		 * number of week
		 * @return array
		 * @see Container::getAllGroupsWeek()
		 **/
		public function getallgroupsweek($week = null){
			return $this->getJsonObjectOfArrayOrObject($this->container->getAllGroupsWeek($week));
			}
		/**
		 * returns user groups (usergroups table)
		 * @return array
		 * @see Container::getAllGroups()
		 **/
		public function getallusergroups(){
			return $this->getJsonObjectOfArrayOrObject($this->container->getUserGroups());
			}
		/**
		 * Provides all users from the user table (including the removed one)
		 * @return array
		 * @see Container::getAllUsers()
		 **/
		public function getallusers(){
			return $this->getJsonObjectOfArrayOrObject($this->container->getUsers());
			}
		/**
		 * Provides the removed users from database
		 * @return array
		 * @see Container::getAllUsers()
		 **/
		public function getAllUserWithoutRemoved(){
			$users = $this->container->getUsers();
			$userArray = array();
			foreach($users as $key =>$group){
					$userArray[$key] = array();
					foreach($group as $user){
					if($user->getRemoved() == false){
						$userArray[$key][] = $user;
						}
					}
				}
			return $this->getJsonObjectOfArrayOrObject($userArray);
			}
		/**
		 * Return all diets of the dietaries table
		 * @return array
		 * @see Container::getAllDiets()
		 **/
		public function getalldiets(){
			return $this->getJsonObjectOfArrayOrObject($this->container->getDiets());
			}
		/**
		 * Returns all the mealtimes from the mealtimes table
		 * @return array
		 * @see Container::getMealTimes()
		 **/
		public function getmealtimes(){
			return $this->getJsonObjectOfArrayOrObject($this->container->getMealTimes());
		}
		/**
		 * Prodiveds all meals
		 * @return array
		 * @see Container::getMeals()
		 **/
		public function getmeals(){
			return $this->getJsonObjectOfArrayOrObject($this->container->getMeals());
			}
		/**
		 * Gives back all notifications
		 * @return array
		 * @see Container::getAllNotifications()
		 **/
		public function getallnotifications(){
			$fixed = $this->container->getNotifications()["fixed"];
			$other = $this->container->getNotifications()["other"];
			return array("fixed"=>$this->getJsonObjectOfArrayOrObject($fixed),"other"=>$this->getJsonObjectOfArrayOrObject($other));
			}
		/**
		 * returns all messages
		 * @return array
		 * @see Container::getAllMessages()
		 **/
		public function getallMessages(){
			return $this->getJsonObjectOfArrayOrObject($this->container->getMessages());
			}
		/**
		 * Get messages based on $_GET["id"]
		 * @return array
		 * @see Container::getAllMessages()
		 **/
		public function getMessage(){
			return $this->getJsonObjectOfArrayOrObject($this->container->getMessages($this->input->get("id")));
			}
		/**
		 * Returns the signoffsheet of this week.
		 * @return array
		 * @see Container::getSignoffsheet
		 **/
		public function getTodaysSignoffsheet(){
			return $this->getJsonObjectOfArrayOrObject($this->container->getSignOffSheets(date("W")));
			}
		/**
		 * Returns ALL signoffsheets if $_GET['week'] is null
		 * @todo: add param so that the frameworks route system work which creates easier work
		 * @return array
		 * @see Container::getSignoffsheet
		 **/
		public function getSignoffsheets(){
			return $this->getJsonObjectOfArrayOrObject($this->container->getSignOffSheets($this->input->get("week")));
			}
		/**
		 * Givs back the user dietaries of sinoffsheets
		 * 
		 * if $_GET["week"] is set it returns only the diets of the requested sheet/sheets
		 * 
		 * @return array
		 * retuns the user dieatries of the signoffsheet
		 * structure:
		 * Array(
		 * [week]=>Array(
		 * [mealtime ID] = Array(
		 * [day] => Array(
		 * [number starts by 0] => Diet
		 * )
		 * )
		 * )
		 * */
		 public function getSheetsdiets(){
			 $sheets = $this->container->getSignOffSheets($this->input->get("week"));
			 $diets = array();
			 foreach($sheets as $sheet){
				 foreach($sheet as $msheet){
					 $diets[$msheet->getWeek()][$msheet->getMealTime()] = $this->getJsonObjectOfArrayOrObject($msheet->getUserDiets());
					 }
				 }
			/*
			 * structure:
			 * Array(
			 * [week]=>Array(
			 * [mealtime ID] = Array(
			 * [day] => Array(
			 * [number starts by 0] => Diet
			 * )
			 * )
			 * )
			 * var_dump($diets[2][2][0][0]);
			 **/
			return $diets;
			 }
		/**
		 * returns ticks sorted by user
		 * @return array
		 **/
		public function usersortedticks($when){
			$when = (is_null($when))? date("W"):intval($when); 
			//check if $wen is set and $day must set then as well
			$ticks = array();
			$result = array();
			$sheets = $this->container->getSignOffSheets($when);
			if(!is_null($sheets)){
				if(array_key_exists($when,$sheets)){
					foreach($sheets[$when] as $key => $sheet){
						$ticks[$key] = $sheet->getTicksBy("user");
						$ticks[$key]["mtID"] = $sheet->getMealTime();
						}
					}
				}
			return $this->getJsonObjectOfArrayOrObject($ticks);
			}
		//ticked:
		/**
		 * gives back the number of people who ticked as an array (today)
		 * 
		 * Structur: ["1":{"total":0,"type_0":0,"type_1":0,"type_2":0}] (JSON view)
		 * total: means total people who eat
		 * type_0: ticked and work
		 * type_1: ticked and not work
		 * type_2: packed meal
		 * 
		 * @return array
		 * Structur: ["1":{"total":0,"type_0":0,"type_1":0,"type_2":0}] (JSON view)
		 **/
		public function gettickedtoday(){
			return $this->getTicked("all_day");
		}
		/**
		 * gives back the number of people who ticked as an array (this week)
		 * 
		 * Structur: [(mealtype=>"1"):{"total":0,"type_0":0,"type_1":0,"type_2":0}] (JSON view)
		 * total: means total people who eat
		 * type_0: ticked and work
		 * type_1: ticked and not work
		 * type_2: packed meal
		 * 
		 * @return array
		 * Structur: ["1":{"total":0,"type_0":0,"type_1":0,"type_2":0}] (JSON view)
		 **/
		public function gettickedthisweek(){
			return $this->getTicked("week");
		}
		/**
		 * gives back the number of people who ticked as an array from a sepcial week
		 * 
		 * Structur: [(mealtype=>"1"):{"total":0,"type_0":0,"type_1":0,"type_2":0}] (JSON view)
		 * total: means total people who eat
		 * type_0: ticked and work
		 * type_1: ticked and not work
		 * type_2: packed meal
		 * 
		 * @return array
		 * Structur: ["1":{"total":0,"type_0":0,"type_1":0,"type_2":0}] (JSON view)
		 **/
		public function gettickedweek($data){
			if($data == null){
				return null;
				}else{
			return $this->getTicked("week",$data);
			}
		}
		/**
		 * getTicked returns all ticked sorted after a sepcial request
		 * 
		 * @param string $what
		 * this methode deals with $what: all or all_day.
		 * @param int $when
		 * is the parameter to declare which week is the base of the search. Default: date("W") @see php.net/manual/en/function.date.php
		 * @param int $day
		 * is the parameter which only works in the case that $when is set. Default: date("w") @see php.net/manuel/en/function.date.php 
		 * @return array
		 **/
		private function getTicked($what,$when = null,$day = null){
			$when = (is_null($when))? date("W"):intval($when); 
			$day = (is_null($day))? date("w"):intval($day);
			//check if $wen is set and $day must set then as well
			$result = array();
			
			$sheets = $this->container->getSignOffSheets($when);
			if(array_key_exists($when,$sheets)){
				foreach($sheets[$when] as $mtID => $sheet){
					switch($what){
					case "all":
					$result[$mtID]= array(
						"total"=>$sheet->count(),
						"type_0"=>$sheet->count("type",0),
						"type_1"=>$sheet->count("type",1),
						"type_2"=>$sheet->count("type",2)
						);
					break;
					case "week":
					for($x = 0;$x <= 6;$x++){
					$result[$mtID][$x]= array(
						"total"=>$sheet->count("day",$x),
						"type_0"=>$sheet->count("day",$x,"type",0),
						"type_1"=>$sheet->count("day",$x,"type",1),
						"type_2"=>$sheet->count("day",$x,"type",2)
						);
						}
					break;
					case "all_day":
					$result[$mtID]= array(
						"total"=>$sheet->count("day",$day),
						"type_0"=>$sheet->count("day",$day,"type",0),
						"type_1"=>$sheet->count("day",$day,"type",1),
						"type_2"=>$sheet->count("day",$day,"type",2)
						);
					break;
					}
					}
			}
			return $result;
			}
		/**
		 * getallmealplans() returns all mealplans in an array which contains all Mealplans
		 * @return array
		 **/
		public function getallmealplans(){
			return $this->getJsonObjectOfArrayOrObject($this->container->getMealPlans());
		}
	/**
	 * ###############
	 * helper methdoes
	 * ###############
	 **/
	 
	 /**
	  * getJsonObjectOfArray($array)
	  * 
	  * return a clean and nice array of \StdClass Objects based on array
	  **/
	  private function getJsonObjectOfArrayOrObject($arrayOrObject){
		  $niceCleanObjectArray = array();
		  if(is_array($arrayOrObject)){
			  foreach($arrayOrObject as $key => $object){
					if(is_object($object)){
					if(method_exists($object,"getJsonObject")){
						$niceCleanObjectArray[$key] = $object->getJsonObject();
						}
						
					}else if(is_array($object)){
						$niceCleanObjectArray[$key] = $this->getJsonObjectOfArrayOrObject($object);
						}elseif(!is_null($object)){
							$niceCleanObjectArray[$key] = $object;
							}
				  }
				  return $niceCleanObjectArray;
			  }elseif(is_object($arrayOrObject) AND method_exists($arrayOrObject,"getJsonObject")){
					return $arrayOrObject->getJsonObject();
				  }else{
					return array();
				  }
		  }
	}
?>
