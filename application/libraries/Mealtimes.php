<?php
/**
 * @file Mealtimes.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 01.06.2016 14:04:50 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Mealtimes
 * 
 * <b>Defenition of "Mealtime"</b>
 * Undermealtime I understand everything which is a time to sit down to have a meal such as breakfast etc.
 * Therefor a mealtime is a collection of Meals and every mealtime provied only ONE meal upon the time.
 * 
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
 class Mealtimes extends ContainerObject{
	  /**
	   * @var int;
	   * formart: [HHMM] e.g. 1230 => 12:30
	   **/
	  protected   $start;
	  /**
		*@var int
		**/
	  protected   $finish;
	  /**
	   * @var array
	   **/
	  protected $meals = array();
	  /**
	   * @var bool
	   * Are the meals of this mealtime packable?
	   * Default: false
	   **/
	   protected $packable = false;
	  //setter
		/**
		 * sets the start time
		 * 
		 * @param numeric $start
		 * because of format: 0800
		 **/
	  public function setStart($start){
		  $this->start = $start;
		  }
		/**
		 * Sets the fininishing time
		 * 
		 * @param numeric $start
		 * because of format: 0800
		 **/
	 public function setFinish($fin){
		 $this->finish = $fin;
		 }
		/**
		 * Set if its possibly to pack food
		 * 
		 * This methode sets if its possible to pack your own food. Then it would generate in Container\Signoffsheet::count() 
		 * type_2: Which means: You packed your own food.
		 * 
		 * @param bool $packable
		 * Default false
		 **/
	 public function setPackable($packable = false){
		 if($packable === true OR $packable == 1 OR $packable == "true"){
		 $packable = true;
		 }else{
			 $packable = false;
			 }
		 $this->packable = $packable;
		 }
	/**
	 * if its set tax benefits make sense
	 * 
	 * later added was not in orginal plan...
	 * @todo:add in signoffsheet::count to make count accurate
	 * 
	 * @param bool $tax
	 * Default false;
	 **/
	 public function setTax($tax = false){
		 if($tax === true OR $tax == 1 OR $tax == "true"){
		 $tax = true;
		 }else{
			 $tax = false;
			 }
		 $this->tax = $tax;
		 }
	/**
	 * Adds multiple Meals to the MealTime
	 * 
	 * @param mixed $meals
	 * Can be an array of Container/Meals or a object Meal
	 **/
	 public function setMeals($meals){
		 if(is_array($meals)){
			 foreach($meals as $meal){
					if(is_object($meal)){
						$this->addMeal($meal);
					}
				 }
			 }else if(is_object($meals)){
					$this->addMeal($meal);
				 }
		 }
	//getter:
	/**
	 * @return numeric
	 * **/
	public function getStart(){
		return $this->start;
		}
	/**
	 * @return bool
	 **/
	public function isTax(){
		$tax = $this->tax;
		 if($tax === true OR $tax == 1 OR $tax == "true"){
		 $tax = true;
		 }else{
			 $tax = false;
			 }
		return $tax;
		}
	/**
	 * @return bool
	 **/
	public function isPackable(){
		$packable = $this->packable;
		 if($packable === true OR $packable == 1 OR $packable == "true"){
		 $packable = true;
		 }else{
			 $packable = false;
			 }
		return $packable;
		}
	/**
	 * @return numeric
	 **/
	public function getFinish(){
		return $this->finish;
		}
	/**
	 * getMeals() return array of Meal objects
	 * 
	 * retuns array of Meal objects. Maximum of this array is 7. Because a week has only 7 Days
	 * @return array
	 **/
	public function getMeals(){
		return $this->meals;
		}
	/**
	 * 
	 * addMeal adds meals to the meal array
	 * 
	 * because of the reason that you can add meals twice a week we do not add a check if meal is already in array. Maximum of meal is 7! because a week has only 7 Days
	 * As conculsion of the limit of 7 indexs each index stands for one day!
	 * @param Meal $meal
	 **/
	public function addMeal(Meal $meal){
			$meals = $this->getMeals();
			/**
			if(in_array($meal,$meals) == true){
				$this->meal[array_search($meal,$meals)] = $meal;
					return null;
				}
				*/
			if(count($meals) <= 7){
			$this->meals[] = $meal;
			}else{
				echo $meal->getName();
				}
	}
	/**
	 * remove meal from meal array
	 * @param Meal $meal
	 **/
	public function removeMeal(Meal $meal){
			if(in_array($meal,$this->getMeals()) == true){
				$index = array_search($meal,$this->getMeals());
					unset($this->meals[$index]);
					}
		}
		
	/**
	 * 
	 * getMeal returns a single meal based on the day
	 * 
	 * @param int $day
	 * $day must be an int and cannot be bigger then 6. In case of an error the methode gives null back
	 * @return mixed
	 * will return a Meal in case of the method had success in a case of an error it will rerurn null
	 **/
	public function getMeal($day){
		$meals = $this->getMeals();
		if(array_key_exists($day,$meals)){
			return $meals[$day];
		}else{
			return null;
			}
	}
	/**
	 * empty the  meattimes::meals array
	 **/
	public function resetMeals(){
		$this->meals = array();
		return $this;
		}
	/**
	 * creates a Mealtime Object based on the arguments from the db
	 * @param int $id
	 * @param string $field
	 * @param array $option
	 * Diffrent Where (SQL context) option
	 **/
	public function create($id,$field = "id",$option = null){
		//get mealtime from db
		$mealtime = $this->get($id);
		if($mealtime != null AND count($mealtime) == 1){
			$mealtime = $mealtime[0];
			$this->setID($mealtime->id);
			$this->setName($mealtime->name);
			$this->setStart($mealtime->start);
			$this->setFinish($mealtime->finish);
			$this->setPackable($mealtime->packable);
			$this->setTax($mealtime->tax);
			return $this;
			}else{
				return null;
			}
			return $this;
		}
	/**
	 * saves this oBject in db
	 * 
	 **/
    public function save(){
		   $db = $this->CI->db;
		   // check if exists if yes update
		   $db->set("name",$this->getName());
		   $db->set("start",$this->getStart());
		   $db->set("finish",$this->getFinish());
		   $db->set("packable",$this->isPackable());
		   $db->set("tax",$this->isTax());
		   if(is_null($this->getID())){
			   //does not exists update
			   $db->insert("mealtimes");
			   $this->setID($db->insert_id());
			   }else{
			   $db->where("id",$this->getID());
			   $db->update("mealtimes");	   
				   }
			 $db->reset_query();
			 //check meals
			 $meals =$this->getMeals();
			 $this->resetMeals();
					 foreach($meals as $key => $meal){
							$meal = $meal->save();
							$this->addMeal($meal);
						}
				return $this;
			 }
	
	
	 }
}
?>
