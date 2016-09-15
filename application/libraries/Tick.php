<?php
/**
 * @file Tickcontainer.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 31.05.2016 08:58:07 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * 
 * Tickcontainer is the Tick class
 * 
 * is the tick object class provides all the functions a Tick has. What is a tick?
 * A tick is the thing which happens when you tick for a mealtime... see word explenation files.
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
class Tick extends ContainerObject{
	/**
	 * 0 (for Sunday) through 6 (for Saturday)
	 * @var int
	 **/
	protected $day;
	/**
	 * must be a Container\User Object! 
	 * @var User
	 * **/
	protected $user;
	/**
	 * 0=>dinning during work|1=>dinning in free time |2=>packed food
	 * @var int 
	 **/
	protected $type;
	/**
	 * @var int
	 * The class property $date has the function to document the exact time of the tick.
	 * @todo: ist es wirklich sinnvoll?
	 **/
	 protected $date;
	 
	//getter
	/**
	 * @return int
	 **/
	public function getDay(){
		return $this->day;
		}
	/**
	 * @return User
	 **/
	public function getUser(){
		return $this->user;
		}
	/**
	 * @return int 
	 * */
	public function getType(){
		return $this->type;
		}
	/**
	 * @return int
	 **/
	 public function getDate(){
		 return $this->date;
		 }
	
	//setter:
	/**
	 * $day = Default 0 (for Sunday) through 6 (for Saturday)
	 * @param int $day
	 * **/
	public function setDay($day){
			$this->day = ($day <= 6)? $day:0;
		}
	/**
	 * @param User $user
	 **/
	public function setUser(User $user){
			$this->user = $user;
		}
	/**
	 * @param int $date
	 * default null
	 **/
	public function setDate($date = null){
		$this->date = (is_null($date))? time():$date;
		}
	/**
	 * $type = Default 0
	 * @param $type
	 **/
	public function setType($type){
			$this->type = (is_int($type))? $type:intval($type);
		}
	/**
	 * has to be here because of the abstract class
	 * @todo: may change that in a future version
	 * */
	public function save(){}
	/**
	 * creates a Tick Object based on given information
	 * @see Container\ContainerObject::get()
	 * @param int $id
	 * @param string $field
	 * @param array $option
	 * Diffrent Where (SQL context) option
	 * @return Tick
	 **/
	public function  create($id,$field = "id",$option = null){
		//get
		if(!is_array($option)){
			$tick = $this->get($id,$field);
		}else{
			$tick = $this->get(null,$option);
			}
		if(!is_null($tick) AND count($tick) == 1){
			$this->setID($tick[0]->id);
			$this->setDate($tick[0]->date);
			$this->setDay($tick[0]->day);
			$this->setType($tick[0]->type);
			$user = new User();
			$user->create($tick[0]->user);
			$this->setUser($user);
			}
		return $this;
		}
	}
}
?>
