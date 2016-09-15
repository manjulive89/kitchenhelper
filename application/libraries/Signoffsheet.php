<?php
/**
 * @file Signoffsheetcontainer.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 31.05.2016 08:40:08 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Sign off Sheet Container
 * 
 * This is the Main container for every "sign off sheet object".
 * A Signoffsheet Object is basicly the current Signoffsheet based on Week Number and Mealtime those both things are unique in combination.
 * 
 * @todo:Future task change property mealtime to a mealtime Object.
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
class Signoffsheet extends ContainerObject {
	/**
	 * 
	 * @var int $mealtime;
	 * contains the meal type ID z.B. Breakfast (18)
	 * **/
	protected $mealtime;
	/**
	 * 
	 * contains the week based on the year => date("W"[,time()])
	 * ISO-8601 week number of year, weeks starting on Monday (added in PHP 4.1.0)" (http://php.net/manual/en/function.date.php)
	 * @var int $week
	 **/
	protected $week;
	/**
	 * contains all ticks in a array
	 * @var array
	 **/
	protected $ticks = array();
	
	//setter
	
	/**
	 * @param int $mealtime
	 **/
	public function setMealTime($mealtime){
		$this->mealtime = $mealtime;
	}
	/**
	 * $week should be a int and <= 52 default of $week is day("W")
	 * @param int $week
	 **/
	public function setWeek($week = null){
		$week = (is_null($week))? date("W"):intval($week);
		/** 
		 * 52 = 365 / 7
		 * 365 == a year even if Feb has more days
		 **/
		if($week <= 52){
			$this->week = $week;
		}else{
			$this->week = 0;
			}
		}
	//getter
	/**
	 * @return int
	 * */
	public function getWeek(){
		return $this->week;
		}
	/**
	 * @param int $day
	 * Default null Optional!
	 * @return mixed
	 * Retuns if parameter is set an Object (Tick) or an array
	 * */
	public function getTicks($day = null){
		if($day == null){
			return $this->ticks;
		}else{
			$return = array();
			foreach($this->ticks as $tick){
				if($tick->getDay() == $day){
						$return[] = $tick;
					}
				}
			}
		}
	/**
	 * 
	 * @return Mealtimes
	 **/
	public function getMealtime(){
		return $this->mealtime;
		}
	//other methodes:
	/**
	 * Addes a tick object to the self::ticks array. 
	 * @param Tick $tick
	 * 
	 * @return
	 * in error false otherwiese null
	 ***/
	public function addTick(Tick $tick){
		if($tick->getType() == 1){
			//check if mealtime has that as well
			$mt = new Mealtimes();
			$mt->create($this->getMealtime());
			if($mt->isTax() != true){
				return false;
				}
			}
		if(in_array($tick,$this->getTicks())){
			$this->ticks[array_search($tick,$this->getTicks())] = $tick;
			}else{
				$this->ticks[] = $tick;
			}
		}
	/**
	 * untick a tick from the Ticks array.
	 * @todo: check if is redundent ... because never used...
	 * @param Tick $tick
	 **/
	public function unTick(Tick $tick){
		if(in_array($tick,$this->getTicks())){
			unset($this->ticks[array_search($tick,$this->getTicks())]);
			}
		}
	/**
	 * getTicksBy
	 * is selecting all ticks of the wished type and returns them as an array.
	 * Arguments can only be: day,type,user 
	 * @param String $arg
	 * @return array
	 * The return array will have the following structure:
	 * (based on user) Array(
	 * [1]=>Array(Container\Tick),
	 * [23]=>Array(Container\Tick)
	 * ) 
	 * 1 & 23 are IDs for users in this case. 
	 * In case of no ticks or an error the method sends back an empty array.
	 **/
	public function getTicksBy($arg){
		//return array:
		$container = array();
		//arg types:
		$args = array("day"=>"getDay","type"=>"getType","user"=>"getUser","group"=>"getUser","day"=>"getDay");
		//check if arg exist:
		if(array_key_exists($arg,$args)){
			//does methode exists?
			if(method_exists(new Tick(),$args[$arg])){
				//go through Tick array
				// $t => Container\Tick object each.
				foreach($this->getTicks() as $t){
						/**
						 * create index for return array:
						 * The return array will have the following structure:
						 * (based on user) Array(
						 * [1]=>Array(Container\Tick),
						 * [23]=>Array(Container\Tick)
						 * ) 
						 * 1 & 23 are IDs for users in this case.
						 **/
						 $meth = $args[$arg];
						$index = $t->$meth();
						if(is_object($index)){
							//sort by User::Group
							if($arg == "group"){
								$index = $t->$args[$arg]()->getGroup()->getID();
								}else{
								$index = $t->$args[$arg]()->getID();
								}
							}
						//pu Tick Object in array.
						$container[$index][] = $t;
					}
				}
				return $container;
			}else{
				return $container;
				}		
		}
	/**
	 * 
	 * get Week count as an week array(7)
	 * @param mixed $args
	 * Minimal: 0 or 2 Arguments after the above explaind shema.
	 * Maximal: 4 Arguments like the sheme above.
	 * parameter are the same like self::count() without day becaause day is standard 
	 * @return array
	 * in case of success an array with 7 elements in case of an error an empty array
	 **/
	public function getWeekCount(){
		if(func_num_args() == 2 OR func_num_args() == 4){
		$args = func_get_args();
		$counter = array();
		for($dayX = 1;$dayX < 8;$dayX++){
			$index = ($dayX == 7)? 0:$dayX;
			if(func_num_args() == 2){
				$count = $this->count($args[0],$args[1],"day",$index);
				}else if(func_num_args() == 4){
					$count = $this->count($args[0],$args[1],$args[2],$args[3],"day",$index);
					}
			$counter[$index] = $count;
			}
			ksort($counter);
			return $counter;
		}else{
			return array();
			}
		}
	/**
	 * Counts Ticks
	 * 
	 * Counts ticks after creteria set down in $args: ["creteria",mixed]. If the methode has NO arguments/creterias it will return the total number of ticks. 
	 * Which will include all 2 or 3 types of ticking.
	 * 
	 * 
	 * Types of ticking: (refreshment)
	 * type 0: I ate in the dinning hall and worked. 
	 * type 1: I ate in the dinning hall and did not work. 
	 * type 2: Is optional and only possible if the Container\Mealtimes::getPackable() returns true. This means that you packed your own food.
	 * 
	 * @param mixed $args
	 * Minimal: 0 or 2 Arguments after the above explaind shema.
	 * Maximal: 6 Arguments like the sheme above.
	 * day,type,user,group,day
	 * 
	 **/
	public function count(){
		$args = func_get_args();
		if(func_num_args() == 0){
			/**
			 * No Argument means that the methode will return the total number of ticks. This includes all 2/3 types of ticks.
			 **/
			return count($this->getTicks());
			/**
			 * check if it has 2 or 4 arguments
			 **/
		}else if(func_num_args() == 4 OR func_num_args() == 2){
				//get ticks by argument:
				/**
				 * getTicksBy can have as argument:
				 * day,type,user(needs User Object)
				 * for more information @see self::getTicksBy($arg,$arg)
				 **/
				$searchArray = $this->getTicksBy($args[0]);
				if(array_key_exists($args[1],$searchArray))
				{
					switch(func_num_args()){
						case 2:
							return count($searchArray[$args[1]]);
						break;
						case 4:
							$check = $searchArray[$args[1]];
							$counter = 0;
							$params = array("day"=>"getDay","type"=>"getType","user"=>"getUser","group"=>"getUser","day","getDay");
							if(array_key_exists($args[2],$params)){
								foreach($check as $c){
									$meth = $params[$args[2]];
									$res = $c->$meth();
									if($args[2] == "group"){
										$res = $res->getGroup()->getID();
									}
									if($res == $args[3]){
										$counter++;
										}
									}
									return $counter;
							}else{
								return 0;
								}
						break;
						}//end of switch
					}else{
						return 0;
						}
			}else if(func_num_args() == 6){
							$searchArray = $this->getTicksBy($args[0]);
							if(isset($searchArray[$args[1]])){
							$check = $searchArray[$args[1]];
							$counter = 0;
							$params = array("day"=>"getDay","type"=>"getType","user"=>"getUser","group"=>"getUser","day","getDay");
							if(array_key_exists($args[2],$params)){
								foreach($check as $c){
									$res2 = $c->$params[$args[2]]();
									$res5 = $c->$params[$args[4]]();
									if($args[2] == "group"){
										$res2 = $c->$params[$args[2]]()->getGroup()->getID();
										}else if($args[4] == "group"){
											$res5 = $c->$params[$args[4]]()->getGroup()->getID();
											}
									if($res2 == $args[3] AND $res2 == $args[5]){
										$counter++;
										}
									}
									return $counter;
								}else{
									return 0;
									}
							}else{
								return 0;
								}
				}else{
					return 0;
				}
		}
	/**
	 * saves this Object in DB it follows the Object Following rule:
	 * OFR: If there is a object in a property of this Object it makes sure that this object is the actual version ... means it saves it as well.
	 * @version 1.0
	 * @retun mixed
	 * Null in case of an error or in case of success a Signoffsheet Object
	 **/
	public function save(){
		$db = $this->CI->db;
		//get ticks
		$batch = array();
		//for untick reasons:
		$ticks = $this->getTicks();
		if(count($ticks) >=0){
		$q = $db->where(array("week"=>$this->getWeek(),"mtID"=>$this->getMealtime()))->get("ticked");
		$ids = array();
		if(count($q->result()) > count($this->getTicks())){
			foreach($q->result() as $id){
				$ids[] = $id->id;
				}
			}
		foreach($ticks as $tick){
			//check if database
			if($tick->getID() != null){
			if(in_array($tick->getID(),$ids)){
				unset($ids[array_search($tick->getID(),$ids)]);
				}
			}
			$dbTick = $db->where(array("week"=>$this->getWeek(),"user"=>$tick->getUser()->getID(),"mtID"=>$this->getMealtime(),"day"=>$tick->getDay()))->get("ticked")->result();
			if(count($dbTick) == 1)//update
			{
					$db->reset_query();
					$update = $db;
					$update->set("week",$this->getWeek());
					$update->set("mtID",$this->getMealtime());
					$update->set("day",$tick->getDay());
					$update->set("user",$tick->getUser()->getID());
					$update->set("type",$tick->getType());
					$update->where(array("week"=>$this->getWeek(),"user"=>$tick->getUser()->getID(),"mtID"=>$this->getMealtime(),"day"=>$tick->getDay()));
					$update->update("ticked");
				}else{
					//check if more
					if(count($dbTick) > 1){
						$db->where(array("week"=>$this->getWeek(),"user"=>$tick->getUser()->getID(),"mtID"=>$this->getMealtime(),"day"=>$tick->getDay()))-delete("ticked");
						}
					//insert
					$db->reset_query();
					$insert = $db;
					$insert->set("week",$this->getWeek());
					$insert->set("mtID",$this->getMealtime());
					$insert->set("day",$tick->getDay());
					$insert->set("user",$tick->getUser()->getID());
					$insert->set("type",$tick->getType());
					$insert->insert("ticked");
					}
			}
			//clean
			foreach($ids as $id){
				$db->reset_query();
				$db->where("id",$id)->delete("ticked");
				}
			}else{
				return null;
				}
			
			
			return $this;
		}
		/**
		 * creates a Signoffsheet
		 * this methode creates a signoffsheet after the rules for setting of a signoffsheet
		 * because of the database structure is the signoffsheet very diffrent from the other classes.
		 * 
		 * @param int $id
		 * @param string $field
		 * is required because of the abstract class but not neceassry
		 * @see Container\ContainerObject
		 * @param int $mtID
		 * @return Signoffsheet
		 **/
		public function create($week,$field = "id",$mtID = null){
			$this->CI->load->database();
			$this->setWeek($week);
			$this->setMealTime($mtID);
			$ticks = $this->CI->db->where(array("week"=>$week,"mtID"=>$mtID))->get("ticked")->result();
			foreach($ticks as $tick){
				$t = new Tick();
				$this->addTick($t->create($tick->id));
				}
			return $this;
		}
	/**
	 * retuns users dieataries
	 * @param string $day
	 * if $day is set and not null it will return only the diets of that day
	 * @return array
	 * Structure: Array[Day=>array(Diets)]
	 **/
	 public function getUserDiets($day = null){
		 $diets = array();
		 $ticks = $this->getTicks($day);
		 if(is_array($ticks)){
			 foreach($ticks as $tick){
				 foreach($tick->getUser()->getDiet() as $diet){
						if(!isset($diets[$tick->getDay()])){
							$diets[$tick->getDay()] = array();
							}
						if(!in_array($diet,$diets[$tick->getDay()])){
							$diets[$tick->getDay()][$diet->getName()] = array($diet);
							$diets[$tick->getDay()][$diet->getName()]["number"] = 1;
						}else{
							$diets[$tick->getDay()][$diet->getName()]["number"]++;
							}
					}
			}
		}
		return $diets;
		 }
	}
}
?>
