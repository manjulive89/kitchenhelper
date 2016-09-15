<?php
/**
 * @file Mealplannercontainer.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 31.05.2016 11:34:03 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Mealplanner Container
 * 
 * Mealplan is a collection of Mealtimes and gives the methodes to manipulate mealtimes etc.
 * 
 * @namespace Container
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
class Mealplanner extends ContainerObject{
	/**
	 * @var Array $mealtimes
	 **/
	protected  $mealtimes = array();
	/**
	 * @var boolean $active
	 **/
	protected  $active;
	/**
	 * @var int $sort
	 **/
	protected  $sort;
	/**
	 * @var int $activationTime
	 * Sets the week number based on ISO-8601 week number of a Year. for more information
	 * contains the activation date default is day!
	 **/
	 protected  $activationTime;
	 	 
	//methodes:
	//setter:
	/*
	 * activates or inactives a Mealplan.
	 * @param bool $active
	 **/
	public function setActive($active = true){
		if($active === true OR $active == 1 OR $active == "true"){
			$active = true;
		}else{
			$active = false;
			}
			$this->active = $active;
		}
	/**
	 * set the sort number... maybe a German word (Sortierung[snummer]) okay dict.cc says ist english as well...
	 * http://www.dict.cc/?s=Sort ...
	 * @param int $sort
	 **/
	public function setSort($sort){
		$this->sort = (is_int($sort))? $sort:intval($sort);
		}
	/**
	 * Sets the week number based on ISO-8601 week number of a Year. for more information
	 * @see http://php.net/manual/en/function.date.php
	 * @todo:change name from ...[time] to ...[week] its iritating
	 * @todo:check if its a valid weeknumber...
	 * @param int $weeknumber
	 * Default null
	 **/
	public function setActivationTime($weeknumber = null){
			$this->activationTime = (is_null($weeknumber))? date("W"): intval($weeknumber);
		}
	/**
	 * set the Mealtime to the Mealplanner
	 * @param mixed $mealtimes
	 * Its musst be an array or a Object of the Class Mealtime
	 * */
	public function setMealTimes($mealtimes){
		if(is_array($mealtimes)){
				foreach($mealtimes as $mealtime){
					$this->addMealTimes($mealtime);
					}
			}else if(is_object($mealtimes)){
				$this->addMealTimes($mealtimes);
				}
		}
	/**
	 * alias methode to self::setActivationTime
	 * @param int $weeknumber
	 * Default null
	 **/
	public function setActTime($weeknumber = null){
		$this->setActivationTime($weeknumber);
		}
	//getter
	/**
	 * @return int
	 **/
	public function getSort(){
		if($this->sort === null){
			$this->sort = 0;
			}
		return $this->sort;
		}
	/**
	 * @return boolean
	 **/
	public function isActive(){
		$active = $this->active;
		if($active === true OR $active == 1 OR $active == "true"){
			$active = true;
		}else {
				$active = false;
				}
		return $active;
		}
	/**
	 * getMealTimes() returns all MealTime
	 * @param int $mtID
	 * @return array
	 **/
	public function getMealTimes($mtID = null){
			if(is_null($mtID)){
				return $this->mealtimes;
			}else{
				foreach($this->mealtimes as $m){
					if($m->getID() == $mtID){
						return $m;
						}
					}
				}
		}
	/**
	 * getActivationTime retuns the time of activation of that mealplan
	 * @return int
	 **/
	 public function getActivationTime(){
		 return $this->activationTime;
		 }
	/**
	 * alias methode to self::getActivationTime()
	 **/
	public function getActTime(){
		return $this->getActivationTime();
		}
	//other methodes:
	/**
	 * Adds a single mealtime to the mealtime Object
	 * @param Mealtime $mealtimes
	 **/
	public function addMealTimes(Mealtimes $mealtimes){
		//check if is in object if yes overwrite:
		foreach($this->getMealTimes() as $k => $m){
				if(!is_null($this->getMealTimes($mealtimes->getID()))){
					$this->mealtimes[$k] = $mealtimes;
					return true;
					}
			}
		$this->mealtimes[$mealtimes->getStart()] = $mealtimes;
		ksort($this->mealtimes);
		$tmpArray = array();
		foreach($this->mealtimes as $mt){
			$tmpArray[] = $mt;
			}
		$this->mealtimes = $tmpArray;	
		return true;
		}
	/**
	 * creates a Mealplanner Object based on the arguments from the db
	 * @param int $id
	 * @param string $field
	 * @param array $option
	 * Diffrent Where (SQL context) option
	 * @returns Mealplanner
	 **/
	public function create($id,$field = "id",$option = null){
		//database
		$this->CI->load->database();
		$db = $this->CI->db;
		//get
		if(is_null($option)){
		$mealplan = $this->get($id,$field);
		}else{
			$mealplan = $this->get(null,$option);
			}
		//can only deal with one meal plan 
		if(count($mealplan) == 1){
			if($id == null){
				$id = $mealplan[0]->id;
				}
			$mealplan = $mealplan[0];
			$this->setID($id);
			$this->setName($mealplan->name);
			$this->setActive($mealplan->active);
			$this->setActTime($mealplan->activationtime);
			$this->setSort($mealplan->sort);
			//get meals
			$db->distinct();
			$db->select("mtID");
			$db->where("mpID",$this->getID());
			$mts = $db->get("meals")->result();//mealtimes
				foreach($mts as $mt){
					$mealtime = new Mealtimes();
					$mealtime->create($mt->mtID);
					//set meals
					foreach($db->where(array("mpID"=>$id,"mtID"=>$mealtime->getID()))->get("meals")->result() as $meal){
						$m = new Meal();
						$m->create($meal->mID);
						$m->setRepeat($meal->repeats);
						$mealtime->addMeal($m);
						}
					$this->addMealTimes($mealtime);
				}
				return $this;
			}else{
				return null;
				}
		}
    public function save(){
		   $db = $this->CI->db;
		//if its active check if week exists:
		if($this->isActive() == true){
				//add active to the next mealplanner in the oder by sort!
				//check if one mealplan has sort null:
				if(count($this->CI->db->where(array("sort"=>0,"active"=>1))->get("mealplanner")->result()) == 0){
				$prefix = $this->CI->db->dbprefix;
				$query = $this->CI->db->query("SELECT * FROM ".$prefix."mealplanner WHERE active = 1 AND sort = (SELECT MIN(NULLIF(sort, 0)) FROM `".$prefix."mealplanner` WHERE active = 1)");
				foreach($query->result() as $row){
					$this->CI->db->set("activationtime",0)->where(array("id"=>"!=".$row->id,"activationtime"=>date("W")))->update("mealplanner");
					$this->CI->db->set("activationtime",date("W"))->where("id",$row->id)->update("mealplanner");
					}
				}else{
					$this->CI->db->set("activationtime",0)->where("activationtime",date("W"))->update("mealplanner");
					$this->CI->db->where(array("sort"=>0,"active"=>1))->set("activationtime",date("W"))->update("mealplanner");
					}
			}else{
				$this->setActTime(0);
				}
		   // check if exists if yes update
		   $db->set("name",$this->getName());
		   $db->set("active",$this->isActive());
		   $db->set("sort",$this->getSort());
		   $db->set("activationtime",$this->getActivationTime());
		   if(is_null($this->getID())){
			   //does not exists update
			   $db->insert("mealplanner");
			   $this->setID($db->insert_id());
			   }else{
			   $db->where("id",$this->getID());
			   $db->update("mealplanner");	   
				   }
		 //check mealtimes:
		 if(count($this->getMealTimes()) > 0){
			 $db->reset_query();
			 $mts = $this->getMealTimes();
			 $this->mealtimes = array();
			/**
			 * To make suer that we save the mealplan right we have to delete all meals and mealtimes to fill in the in the Array self::mealtime saved meals and mealtimes.
			 **/
		    $db->where(array("mpID"=>$this->getID()))->delete("meals");
			 foreach($mts as $mt){
				 $mt = $mt->save();
				 //to make sure they have an ID:
				 if(!is_null($mt)){
					 foreach($mt->getMeals() as $meal){
							if(!is_null($meal)){
										$db->reset_query();
										$db->set("mtID",$mt->getID());
										$db->set("mpID",$this->getID());
										$db->set("mID",$meal->getID());
										$db->set("repeats",$meal->getRepeat());
										$db->insert("meals");
										}
						}
					}
				 $this->addMealTimes($mt);
				 }
			 }
			return $this;
		   }

	}
}
?>
