<?php
/**
 * @file Cronjob.php 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 13.06.2016 23:46:16 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Cron job
 * 
 * provied the background jobs which should run as cronjob or service .
 * 
 * cou call it like the following way:
 * Terminal:
 * <code>php <i>index.php</i> cronjob [methode]</code>
 * index.php musst be the main index.php 
 * @todo: add log saver
 * @version 1.0
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
 class Cronjob extends CI_Controller {
	 
	 
		/**
		 * Generates the Archive. It need a config entry in the config file 
		 * $config["acrive"] = [your path]
		 * @see application/config/config.php
		 * Displays Log messages.
		 * Saves the tables: ticked,groups in as (if $json param true) json, pdf,excel file.
		 * @param int date
		 * musst be a week number after the ISO-8601 <quote>("[..]week number of year, weeks starting on Monday (added in PHP 4.1.0)")</qoute>
		 * @see http://php.net/manual/en/function.date.php
		 * @param bool $json
		 * default true which force to save the Database as .json file.
		 * @return void
		 **/
        public function genArchive($date = null,$json = true)
        {
			$acrhivePath = $this->config->item("archive");
			$date = (is_null($date))? date("n"):$date;
			require_once APPPATH."controllers/Export.php";
           //check if its writebale:
           if(is_writable($acrhivePath)){
			   //get database datas:
			   $this->load->model("request");
			   //get all singoffsheets
			    $filename = "signofsheet_backup_".time();
				if($json == true){
					$backupFileContentGroups = json_encode($this->request->getallgroups());
					$backupFileContent = json_encode($this->request->getSignOffSheets());
			    file_put_contents($acrhivePath.$filename.".json",$backupFileContent);
			     file_put_contents($acrhivePath.$filename."_groups.json",$backupFileContentGroups);
			     echo "[".date("d.m.Y H:i:s")."] Saved: ".$acrhivePath.$filename.".json\n";
			     }
			    $this->load->library("container");
			    $excel = Export::mexcel($date,$this->container);
			    if($excel != null){
					file_put_contents($acrhivePath.$filename."_month_".$date.".xls",$excel->getData());
			    echo "[".date("d.m.Y H:i:s")."] Saved: ".$acrhivePath.$filename."_month_".$date.".xls\n";
			    }
				$this->load->library('pdf');//load pdf class
				$pdf = new Pdf();
			    file_put_contents($acrhivePath.$filename."_month_".date("n").".pdf",Export::mpdf(date("n"),$pdf,$this->container)->Output("S"));
				echo "[".date("d.m.Y H:i:s")."] Saved: ".$acrhivePath.$filename."_month_".$date.".pdf\n";
			   }else{
				   "[".date("d.m.Y H:i:s")."] Cannot write in Path: ".$acrhivePath." please change the rights\n";
				   }
        }
       /**
        * checkMealplanner
        * This creates the mealplanner loop automaticly.
        * <img src="../imgs/checkmealplanner.png">
        **/
       public function checkMealplan(){
		   $currentWeek = date("W");
		   $this->load->database();
		   $query = $this->db->where(array("activationtime"=>$currentWeek,"active"=>true))->get("mealplanner");
			   if(count($query->result()) != 1){
				   $active = $this->db->where("active",true)->order_by("sort","ASC")->get("mealplanner")->result();
				   if(count($active) != 0){
				   $days = array();
				   $plans = array();
				   $counter = 0;
				   foreach($active as $plan){
					   $plans[] = $plan;
					   if(!array_key_exists(date("W")-$plan->activationtime,$days)){
							$days[date("W")-$plan->activationtime] = $plan;
						}else{
							$counter++;
							}
					   }
					krsort($days);
					//var_dump($days);
					//get New Plan//workaround:
					$update = null;
					foreach($days as $key => $d){
						if(isset($days[$key])){

								    echo "[".date("d.m.Y H:i:s")."] counter: ".$counter."\n";
								    echo "[".date("d.m.Y H:i:s")."] days count: ".count($days)."\n";
								    echo "[".date("d.m.Y H:i:s")."] plans count: ".count($plans)."\n";
									echo "[".date("d.m.Y H:i:s")."] update #".$days[$key]->id."\n";
									//update last item:
									$this->db->where("id",$active[count($active)-1]->id)->set("activationtime",0)->update("mealplanner");
									$this->db->where("id",$days[$key]->id)->set("activationtime",date("W"))->update("mealplanner");
									$update =$days[$key]->id;
									break;
							}
					}
					if($counter == 0 AND $update != null){
						echo "[".date("d.m.Y H:i:s")."] restart loop\n";
						$this->db->where(array("active"=>1,"id !="=>$update))->set("activationtime",0)->update("mealplanner");
						}
					}
			   }else{
				   echo "[".date("d.m.Y H:i:s")."] Nothing to do\n";
				   }
		   }
		 /**
		  * CleanDB cleans the db
		  * 
		  * The job of this method is to clean the database its the yearly reset. It creates at first backup files and then it restest the database.
		  * It will reset: ticked, remove all removed = true user and it will clean up groups
		  * 
		  * The rest will only happen if in the settings table the field lastdbreset is an old year.
		  **/
		 public function cleanDB(){
				$this->load->database();
				$this->load->model("einstellungen");
				$this->einstellungen->load();
				$lastDBRest = $this->einstellungen->get("lastdbreset");
				if($lastDBRest != null){
				if(property_exists($lastDBRest,"content")){
					 echo "[".date("d.m.Y H:i:s")."] Check if db has to be cleaned\n";
					if(date("Y",$lastDBRest->content) < date("Y",time())){
						echo "[".date("d.m.Y H:i:s")."] db has to be cleaned because last clean was ".date("d/m/Y H:i",$lastDBRest->content)."\n";
						$this->cleaning();
					}else{
						echo "[".date("d.m.Y H:i:s")."] last clean was at the ".date("d/m/Y H:i",$lastDBRest->content)."\n";
						}
				}else{
					echo "[".date("d.m.Y H:i:s")."] Could not find db entry so database will be cleaned\n";
					$this->cleaning();
					}
				}else{
					 echo "[".date("d.m.Y H:i:s")."] Could not find db entry so database will be cleaned\n";
					 $this->cleaning();
					}
			 }
		/**
		 * this is the actual cleaning methode
		 * 
		 * Displays messages (logs)
		 * 
		 * @return void
		 **/
		private function cleaning(){
			 echo "[".date("d.m.Y H:i:s")."] Gen Backup\n";
				 for($x = 1;$x <= 12;$x++){
					 $json = ($x == 1)? true:false;
					$this->genArchive($x,$json);
				 }
			 $this->db->empty_table("ticked");
			 echo "[".date("d.m.Y H:i:s")."] Ticked save\n";
				$this->load->database();
				$this->load->model("einstellungen");
				$this->einstellungen->set("lastdbreset",time());
				$this->einstellungen->save();
			    $this->db->empty_table("groups");
			    $this->db->where("removed",true)->delete("user");
				echo "[".date("d.m.Y H:i:s")."] database clean see ya next year..\n";
		
		}
}

?>
