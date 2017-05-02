<?php
/**
 * @file Containerobject.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 02.06.2016 14:54:27 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Abstract Class ContainerObject
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
 abstract class ContainerObject{
	 /**
	  * @var CodeIgniter
	  * Contains the Codeigniter instance
	  **/
	 protected $CI;
	 /**
	  * @var int $id
	  **/
	 protected $id;
	 /**
	  * @var string $name
	  **/
	 protected $name;
	 /**
	  * Construcctor
	  **/
	 public function __construct(){
			//create CodeIgniter instance
			$this->CI =& get_instance();
		 }

	 /**
	  * 
	  * ###################
	  *   Setter Methodes 
	  * ###################
	  **/
	  /**
	   * @param int $id
	   **/
	   public function setID($id){
		   $this->id = $id;
		}
	   /**
	    * @param string $name
	    **/
	   public function setName($name){
		  $this->name = $name;
		  }
		/**
		 * ###################
		 *   Getter Methodes
		 * ###################
		 ***/
	   /**
	    * @return int
	    **/
	   public function getID(){
		   return $this->id;
		   }
	   /**
	    * @return string
	    **/
	   public function getName(){
		   return $this->name;
		   }
	/**
	 * Creates a clean \StdClass Object
	 * 
	 * creates a clean and nice \StdClass Object for JSON conversations
	 * 
	 * @return \StdClass
	 **/
	public function getJsonObject(){
		//create clean \StdClass object
		$object = new \StdClass();
		foreach($this as $key => $obj){
				//meal exception:
				if(get_class($this) == "Container\Meal"){
					$object->repeats = $this->getRepeat();
					}
				if(get_class($this) == "Container\Groups" AND $key == "ticks"){
							$object->ticks = $this->getTicks();
							
				}
				if($key != "CI"){
				if(is_object($obj)){
						if(method_exists($obj,"getJsonObject")){
						$object->$key = $this->$key->getJsonObject();
						}
					}else if(is_array($obj)){
							$array = array();
							//exception:
							foreach($obj as $k => $o){
								if(is_array($o) AND count($o) >= 1){
									if($key != "ticks"){
										foreach($o as $index => $value){
											$array[$k][$index] = $value->getJsonObject();
										}
									}else{
										$array[$k] = $o;
										}
									}else if(is_object($o)){
									$array[$k] = $o->getJsonObject();
									}else{
										$array[$k] = $o;
										}
								}
							$object->$key = $array;
						}else{
						$object->$key = $this->$key;
						}
					}
			}
		return $object;
		}
	protected function get($id,$flag = "id"){
		//database
		$this->CI->load->database();
		$db = $this->CI->db;
		//check if exists
		if(!is_array($flag) AND $id !== null){
			$db->where($flag,$id);
			}else if(is_array($flag)){
				$db->where($flag);
				}else{
					return null;
					}
			//database tabels:
			$tables = array(
				"Container\Diet"=>"dietaries",
				"Container\Group"=>"usergroups",
				"Container\Groups"=>"groups",
				"Container\Meal"=>"meal",
				"Container\Mealplanner"=>"mealplanner",
				"Container\Mealtimes"=>"mealtimes",
				"Container\Message"=>"messages",
				"Container\Notifications"=>"notifications",
				"Container\User"=>"user",
				"Container\Tick"=>"ticked",
				"Container\Signoffsheet"=>"ticked"
				);
			//getting class
			$class = get_class($this);
			$table =(array_key_exists($class,$tables))? $tables[$class]: null;
			if($table == null){return array();}
		 return $db->get($table)->result();
		}
	/**
	 * createObjectByArray
	 * 
	 * creates an Object based on an Array
	 * @param array $array
	 **/
	 public function createObjectByArray($array){
		 if(is_array($array)){
			 //get Methodes:
				$methodesClean = get_class_methods($this);
				//get only the setter
				foreach($methodesClean as $k=>$m){
					if(preg_match("/((set)[A-Z][a-z|A-Z]+)/", $m) == 0 AND $m != "addTick"){
						unset($methodesClean[$k]);
					}else if($m != "addTick"){
						$index = strtolower(preg_replace("/(set)([A-Z])/","$2",$m));
						$index = ($index == "activationtime")? "activationTime":$index;
						$index = ($index == "repeat")? "repeats":$index;
						
						if(array_key_exists($index,$array)){
						if(!is_array($array[$index])){
							$this->$m($array[$index]);						
							}else{
								//User Class:
								if($index == "user" OR $index == "sender"){
										$object = $this->createClassbyArray("User",$array[$index]);
										if(!is_null($object)){
												$this->$m($object);
											}
									}else if($index == "group"){
										$object = $this->createClassbyArray("Group",$array[$index]);
										if(!is_null($object)){
												$this->$m($object);
											}
										}else if($index == "mealtime" OR $index == "mealtimes"){
												$keys = array_keys($array[$index]);
													if(is_numeric($keys[0])){
														foreach($array[$index] as $arrayContent){
															$object = $this->createClassbyArray("Mealtimes",$arrayContent);
															$this->addMealTimes($object);
															}
														}	
											}else if($index == "meals"){
													$keys = array_keys($array[$index]);
													if(is_numeric($keys[0])){
														foreach($array[$index] as $arrayContent){
															$object = $this->createClassbyArray("Meal",$arrayContent);
															$this->addMeal($object);
															}
														}										
												}else if($index == "dietaries"){
													$keys = array_keys($array[$index]);
													if(is_numeric($keys[0])){
														foreach($array[$index] as $arrayContent){
															$object = $this->createClassbyArray("Diet",$arrayContent);
															$this->addDiet($object);
															}
														}
													}else if($index == "diets"){
														foreach($array[$index] as $arrayContent){
															/**
															 * Workaround
															 * @see user.js line 280 ...
															 * because when a diet is deleted from the array it creats an empty array entry (string) this causes a crash
															 * thats why the check if the array content is a array. 02/may/2017
															 **/
															if(is_array($arrayContent)){
																$object = $this->createClassbyArray("Diet",$arrayContent);
																$object->setNumber($arrayContent["number"]);
																$this->addDiet($object);
															}
															}
														}
								}
								}

						}else if($m == "addTick" AND get_class($this) != "Container\Groups"){
							if(isset($array["ticks"])){
								if(is_array($array["ticks"])){
									foreach($array["ticks"] as $tick){
										$t = $this->createClassbyArray("Tick",$tick);
										$this->addTick($t);
										}
									}
								}
							}else if($m == "addTick" AND get_class($this) == "Container\Groups"){
									if(isset($array["ticks"])){
										$this->setTicks($array["ticks"]);
									}
								}
				}
				return $this;
			 }
			 return null;
		 }
	/**
	 * creates Object by array AND name
	 * 
	 * creates based on a class name a new Object 
	 * 
	 * @param string $class
	 * Must be valid class name form the namespace Container!
	 * @param array $data
	 * must be a valid Class data to create a object based on it
	 * @return mixed
	 * Will return in case of success an object or null in case of a false
	 * */
	public function createClassbyArray($class,$data){
		$class = "Container\\".$class;
		if(class_exists($class)){
				if(is_array($data)){
					$obj = new $class();
					if(method_exists($obj,"createObjectByArray")){
						return $obj->createObjectByArray($data);
						}
						return null;
					}
					return null;
			}
			return null;
		}
		/**
		 * 
		 * delete object
		 * 
		 * This method will destroy the object AND the the database entry
		 * 
		 ***/
		 public function delete(){
				 //create super CI object:
				 $ci = $this->CI;
				 //load database
				 $ci->load->database();
				 //get class:
				 $class = get_class($this);
				 //create tables array: based on class name as keyword
				$tables = array(
					"Container\Diet"=>"dietaries",
					"Container\Group"=>"usergroups",
					"Container\Groups"=>"groups",
					"Container\Meal"=>"meal",
					"Container\Mealplanner"=>"mealplanner",
					"Container\Mealtimes"=>"mealtimes",
					"Container\Message"=>"messages",
					"Container\Notifications"=>"notifications",
					"Container\User"=>"user",
					"Container\Tick"=>"ticked",
					"Container\Signoffsheet"=>"ticked"
					);
				//check if object was saved:
				//exception signoffsheet:
				if($class != "Container\Signoffsheet"){
						if($this->getID() != null){
								//database entry
								$suc = $ci->db->where("id",$this->getID())->delete($tables[$class]);
								if($suc == true){
								unset($this);
								return true;
								}else{
									return false;
									}
							}else{
								//was not saved because object has no ID
								unset($this);
								return true;
								}
					}else{
						
						}
			 }
		 /** 
		 * Retuns methode helps with returns (Helper Methode)
		 * 
		 * This methode makes the decison if the methode gives back:
		 * 1) an array if $mixed as more then 1 Element
		 * 2) an object if $mixed has only 1 Element
		 * 3) null if $mixed is NO array nor object or has no elements
		 * @param mixed $mixed
		 * Can be a Array or a Object of mixed kinds
		 * @return mixed
		 * Can return Null , array of mixed kinds or a Object of mixed kinds
		 **/
		public function returns($mixed){
			if(is_array($mixed)){
				if(count($mixed) > 1){
					return $mixed;
					}else if(count($mixed) == 1){
						return $mixed[0];}else{
							return null;
							}
				}else if(is_object($mixed)){
					return $mixed;
					}
			return null;
			}
			/**
			 * @see http://www.codeigniter.com/user_guide/database/query_builder.html
			 * */
		abstract protected function create($id,$field = "id",$option = null);
		/**
		 * @see http://www.codeigniter.com/user_guide/database/query_builder.html
		 **/
		abstract public function save();

	 }
}
?>
