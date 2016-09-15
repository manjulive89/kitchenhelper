<?php
/**
 * @file mealcontainer.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 31.05.2016 09:22:13 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Mealcontainer
 * 
 * is the Meal Object which means what the name says...
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 *
 */
class Meal extends ContainerObject{
	/**
	 * @var boolean
	 * Default: false
	 **/
	private $repeat = false;
	/**
	 * contains an array with the points how people though was the meal
	 * @var array
	 **/
	protected  $points = "";
	//setter
	/**
	 * setRepeat sets if a meal repest itself every free day
	 * If the value is true and a meal Object repeats itself that means on all days where NO meal is set this meal will appear
	 * @param boolean $repeat
	 * Default: false;
	 **/
	public function setRepeat($repeat = false){
		if($repeat === true OR $repeat == 1 OR $repeat == "true"){
			$repeat = true;
		}else{
			$repeat = false;
			}
		$this->repeat = $repeat;
		}
	/**
	 * Set the points for vointing based on a JSON ARRAY (@see db structur doc).
	 * @param array
	 * Default null makes the methode to create a empty self::points array
	 **/
	public function setPoints($arrayOfPoints = null){
			if(is_null($arrayOfPoints)){
				$arrayOfPoints = array();
				}else if(!is_array($arrayOfPoints)){
				$arrayOfPoints = array();
				}
		$this->points = $arrayOfPoints;
		}
	/**
	 * alias methode to self::vote(int $point)
	 * @see self::vote(int $point)
	 **/
	public function setPoint($point){
		$this->vote($point);
		}
	//getter
	/**
	 * @return int
	 **/
	public function getPoints(){
		return $this->points;
		}
	/**
	 * @return boolean
	 **/
	public function getRepeat(){
		$repeat = $this->repeat;
		if($repeat === true OR $repeat == 1 OR $repeat == "true"){
			$repeat = true;
		}else{
			$repeat = false;
			}
		return $repeat;
		}
	/**
	 * alias methode to getRepeat
	 * @return boolean
	 **/
	 public function isRepeat(){
		 return $this->getRepeat();
		 }
	//other methodes:
	/**
	 * returns the Average of all voted points based on the simple average
	 * @return int
	 **/
	public function getAverage(){
		if(is_array($this->points) == true AND count($this->points) > 0){
			return array_sum($this->points) / count($this->points);
		}else{
			return 0;
			}
		}
	/**
	 * 
	 * emptys alll vote and cerate a new self::points array
	 **/
	public function clearVotes(){
		$this->points = array();
		}
	/**
	 * add a vote to the self:points array
	 * @param int $point
	 * Default: 10
	 **/
	public function vote($point = 10){
		$point = (is_int($point))? $point:intval($point);
		$this->points[] = $point;
		}
	/**
	 * clean vote array
	 **/
	 public function cleanVote(){
		 $this->points = array();
		 }
	/**
	 * creates a Mealt Object based on the arguments from the db
	 * @param int $id
	 * @param string $field
	 * @param array $option
	 * Diffrent Where (SQL context) option
	 * @return Meal
	 **/
	public function  create($id,$field = "id",$option = null){
		//get
		if(!is_array($option)){
			$meal = $this->get($id,$field);
		}else{
			$meal = $this->get(null,$option);
			}
		if(!is_null($meal) AND count($meal) == 1){
			$this->setID($meal[0]->id);
			$this->setName($meal[0]->name);
			$points = json_decode($meal[0]->points);
			if(json_last_error() != 0){
			$points = array();
			}
			$this->setPoints($points);	
			}
		return $this;
		}
	/**
	 * saves this object in database
	 **/
    public function save(){
		   $db = $this->CI->db;
		   // check if exists if yes update
		   $db->set("name",$this->getName());
		   $db->set("points",json_encode($this->getPoints()));
		   if(is_null($this->getID())){
			   //does not exists update
			   $db->insert("meal");
			   $this->setID($db->insert_id());
			   }else{
			   $db->where("id",$this->getID());
			   $db->update("meal");	   
				   }
			return $this;
		   }	
	
	}
}
?>
