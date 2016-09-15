<?php
/**
 * @file Groups.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 15.06.2016 09:15:57 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Groups
 * 
 * This is the main container for Groups that means a group of people where the idiviual does not count for the statsticts
 * 
 * Tick json structure
 *{
 *"1":{
 *"24":[1,1,1,1,1,1,1]
 *}
 *}
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
 class Groups extends ContainerObject{
	 /**
	  * @var int
	  * Number of Participants of this group
	  **/
	 protected $number;
	 /**
	  * @var int
	  * date of the staret of programm
	  **/
	 protected $date;
	 /**
	  * @var array
	  * ticks as an Array of the form:
	  * [week][[mealtime=>1],[mealtime=>1],] ==> size of secound array can not be longer then 7 because a week has only 7 days!
	  **/
	 protected $ticks;
	 /**
	  * @var array
	  * Array of Diets
	  **/
	  protected $diets = array();
	  //setter
	  /**
	   * @param int $number
	   * Default 0
	   * */
	  public function setNumber($number = 0){
		  $this->number = $number;
		  }
	  /**
	   * @param int $date
	   * Default null which uses the current time
	   * */
	  public function setDate($date = null){
		  $date = ($date == null)? time():$date;
		  $this->date = $date;
		  }
	/**
	 * sets ticks if param is not an array sets an empty array
	 * @param array $arrayOfTicks
	 * can be a \StdClass Object as well...
	 * Default: none
	 **/
	  public function setTicks($arrayOfTicks){
			if(is_array($arrayOfTicks) OR is_object($arrayOfTicks)){
				$this->ticks = $arrayOfTicks;
				}else{
					$this->ticks = array();
					}
			}
	/**
	 * set diets
	 * @param array $diets
	 **/
	 public function setDiets($diets){
			if(is_array($diets)){
				$this->diets = $diets;
				}else{
					$this->diets = array();
					}
		 }
	//getter
	/**
	 * @return array
	 * */
	public function getDiets(){
		return $this->diets;
		}
	  /**
	   * @param int $date
	   * Default null which uses the current time
	   * */
	  public function getDate(){
		  $date = $this->date;
		  $date = ($date == null)? time():$date;
		  $this->date = $date;
		  return $date;
		  }
	/**
	 * @return int
	 * */
	public function getNumber(){
		return $this->number;
		}
	/**
	 * @param int $week
	 * Default: null Number of week whcih is the index of the self::ticks array
	 * @param int $mealtime
	 * Default null
	 * @retrun array
	 * if $week is not null AND index exists in self::ticks array if not returns an empty array
	 **/
	public function getTicks($week = null,$mealtime = null){
		if($week != null AND $mealtime != null){
		if(array_key_exists($week,$this->ticks[$mealtime])){
			return $this->ticks[$mealtime][$week];
			}else{
				return array();
				}
		}else if($week != null AND $mealtime == null){
			$returnArray = array();
				foreach($this->ticks as $key => $tick){
						if(array_key_exists($week,$tick)){
							$returnArray[] = array("mID"=>$key,"tick"=>$this->ticks[$key][$week]);
							}
					}
					return $returnArray;
			}else{
				return $this->ticks;
				}
		}
	/**
	 * Add diet to diets
	 * @param Diet $diet
	 **/
	 public function addDiet(Diet $diet){
		 $this->diets[] = $diet;
		 }
	/**
	 * add tick to ticks
	 * 
	 * based on mealtime and week
	 * @param int $mealtime
	 * @param int $week
	 **/
	public function addTick($mealtime,$week = null){
			//check if week exists if not choose current one
			$week = ($week == null)? date("W"):$week;
			if(!isset($this->ticks[$mealtime])){
				$this->ticks[$mealtime] = array();
				}
			if(!isset($this->ticks[$mealtime][$week])){
				$this->ticks[$mealtime] = array();
				}
			if(count($this->ticks[$mealtime][$week]) < 7){
				$this->ticks[$mealtime][$week][] = 1;
			}
		}
	/**
	 * checks if group is ticked on day
	 * 
	 * checks based on week if group is ticked on day
	 * 
	 * @param int $day
	 * the day of search. 0-6 @see php.net/manual/en/function.date.php Format -->"W"
	 * @param int mealtime
	 * Has to be set to get if is ticked on that day and at that mealtime
	 * @param int $week
	 * the week of search default is null which causes that the method use deafult W
	 * @return bool
	 *  true in success false in failure
	 * */
	public function isTickAtDay($day,$mealtime,$week = null){
			$week = ($week == null)? date("W"):$week;
			$ticks = $this->getTicks($mealtime,$week);
			if(count($ticks) != 0){
					//check after mealtime
					if(array_key_exists($mealtime,$ticks)){
						if(array_key_exists($ticks[$mealtime],$day))//$day 0-6; 0 == Sunday and 6 Saturday
						{
							return true;
						}else{
							return false;
						}
					}
					return false;
				}else{
					return false;//empty
					}
		}
	/**
	 * saves this object in database
	 **/
	public function save(){
		   $this->CI->load->database();
		   $db = $this->CI->db;
		   // check if exists if yes update
			   $db->set("name",$this->getName());
			   $db->set("number",$this->getNumber());
			   $db->set("ticks",json_encode($this->getTicks()));
			   $db->set("date",$this->getDate());
		   if(is_null($this->getID())){
			   //does not exists update
			   $db->insert("groups");
			   $insert = true;
			   $this->setID($db->insert_id());
			   }else{
			   $db->where("id",$this->getID());
			   $db->update("groups");	   
			   $insert = false;
				   }
			//update group diets:
			$db->where("gID",$this->getID());
			$db->delete("groupsdiets");
			$batch = array();
			$gdiets = $this->getDiets();
			//getting the numbers
			if($insert == true){
			$diets = array();
			$dietNumber = array();
			foreach($gdiets as $diet){
				if(isset($dietNumber[$diet->getID()])){
					$dietNumber[$diet->getID()]++;
					}else{
						$dietNumber[$diet->getID()] = 1;
						$diets[] = $diet;
						}
				}
			}else{
				$diets = $gdiets;
				}
			foreach($diets as $diet){
				//make sure it exists
				$diet->save();
				if($diet->getID() !== null){
					if($insert == true){
						$diet->setNumber($dietNumber[$diet->getID()]);
					}
					$batch[] = array("dID"=>$diet->getID(),"gID"=>$this->getID(),"number"=>$diet->getNumber());
					}
				}
			if(count($batch) != 0){
				$db->insert_batch("groupsdiets",$batch);
				}
			return $this;
		
		}
	/**
	 * creates a Groups Object based on the arguments from the db
	 * @param int $id
	 * @param string $field
	 * @param array $option
	 * Diffrent Where (SQL context) option
	 * @return Groups
	 **/
	public function create($id,$field = "id",$option = null){
	//get
		if(!is_array($option)){
			$group = $this->get($id,$field);
		}else{
			$group = $this->get(null,$option);
			}
		if(!is_null($group) AND count($group) == 1){
			$this->setID($group[0]->id);
			$this->setName($group[0]->name);
			$this->setNumber($group[0]->number);
			$json = json_decode($group[0]->ticks,true);
			$this->setDate($group[0]->date);
			if(json_last_error() != JSON_ERROR_NONE){
				$json = array();
				}
			$this->setTicks($json);
			//check diets:
			$this->CI->load->database();
			$diets = $this->CI->db->where("gID",$this->getID())->get("groupsdiets")->result();
			if(count($diets) != 0){
				foreach($diets as $diet){
					$d = new Diet();
					$d->create($diet->dID);
					$d->setNumber($diet->number);
					$this->addDiet($d);
					}
				}
			}
		return $this;	
	}

	
	 }
}
?>
