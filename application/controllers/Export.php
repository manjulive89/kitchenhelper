<?php
/**
 * @file export.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 08.06.2016 22:27:39 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
    if(!defined("USER_LIBS")){
		define("USER_LIBS",APPPATH."libraries/");
	}
 require_once USER_LIBS."Excel.php";
/**
 * Export of files to excel/pdf/print
 * 
 * @task: complete new structure!
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
 class Export extends CI_Controller{
	 public function monthexcel($id){
		 $this->load->library('container');
		 self::mexcel($id,$this->container)->send();
		 }
	 static public function mexcel($id,$container){
		 $excel = new Excel("sheet_$id.xls");
		 $excel->label("Meals for National Base Staff for FBT Calculation");
		 $excel->down();
		 $excel->home();
		 $objects = $container->getSignOffSheets();
		if($id < 12 AND $id >= 1){
			//get Weeks:
			$d = new DateTime(date("Y",time()).'-'.$id.'-1');
			$d->modify('first day of this month');
			$start = date("W",$d->getTimeStamp());//start of this caclulation
			$firstdayW = date("w",$d->getTimeStamp());
			$firstday = date("d",$d->getTimeStamp());
			$d->modify('last day of this month');
			$end = date("W",$d->getTimeStamp());//end of this calculation
			$lastdayW = date("w",$d->getTimeStamp());
			$lastday = date("d",$d->getTimeStamp());
			//head
			 $excel->home();
			 $excel->label("Mealtime");
			 $excel->right();
			 $total = 0;
			 $dayContainer = null;
			while($start <= $end){
				$header = array();
				$fbtinGeneral = array();
				$ticks = array();
				if(array_key_exists($start,$objects)){
						foreach($objects[$start] as $key => $sheet){
							$mealtime = $container->getMealtimesClass()->create($sheet->getMealTime())->getName();
							$fbtinGeneral[$key][] = $mealtime;
							$count = 0;
								for($x = 1;$x < 8;$x++){
									$dayIndex = ($x == 7)? 0:$x;
								$count +=  $sheet->count("type",1,"day",$dayIndex); 
								$total += $sheet->count("type",1,"day",$dayIndex);
								$fbtinGeneral[$key][] = $sheet->count("type",1,"day",$dayIndex); ;
								}
								$fbtinGeneral[$key][] =$count; 
						}
					}
				//header:
				$day = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
				$header[] = "Mealtime";
				for($i = 1;$i < 8;$i++){
					$dayIndex = ($i == 7)? 0:$i;
					if($dayContainer == null){
						if($dayIndex == $firstdayW){
							$header[] = $day[$dayIndex]." ".$firstday;
							$dayContainer  = 1;
							}
						}else{
							if($dayContainer == null){
							$header[] = $day[$dayIndex]; 
							}else{
								$dayContainer++;
								if($dayContainer <= $lastday){
									$d = new DateTime(date("Y",time()).'-'.$id.'-'.$dayContainer.'');
									$header[] = $day[$dayIndex]." ".$d->format("d");
								}
								}
						}
					}
				$header[] = "Total";
				foreach($header as $head){
				 $excel->label($head);
				 $excel->right();
				 }
				$excel->home();
				$excel->down();	
				if(count($fbtinGeneral) == 0){
					$excel->label("None");
					$excel->right();
					for($i = 1;$i < count($header);$i++){
						$excel->number(0);
						$excel->right();
					}
				$excel->home();
				$excel->down();	
				}			
				foreach($fbtinGeneral as $data){
					foreach($data as $entry){
					if(is_numeric($entry)){
						$excel->number($entry);
						}else if(!is_array($entry)){
							$excel->label($entry);
							}
						$excel->right();
					}
				$excel->home();
				$excel->down();
				}
				$start++;
			}
			return $excel;
		}else{
			echo "error";
			}
		 
	}
	/**
	 * monthpdf creates a PDF
	 * 
	 * This methode creates a PDF file based on the data of 1 month and gives there
	 * @param int $month
	 * Has to be a month in the form 1-12 NOT 01-12
	 * @return void
	 **/
	public function monthpdf($month){
		$this->load->library('container');
		$this->load->library('pdf');//load pdf class
		$this->load->model("einstellungen");
		$this->einstellungen->load();
		$pdf = $this->pdf;
		$pdf->setImageUrl($this->einstellungen->get("LogoUrl")->content);
		self::mpdf($month,self::mpdf($month,$pdf,$this->container,1,"Number of participants with FTB at mealtimes:"),$this->container,0,"Number of all participants who ate:")->Output();
		}
	/**
	 * mpdf
	 * 
	 * this methode exsist only because of the Framework.... I needed it for providing data for the achive
	 * otheriese everything would have been in self->monthpdf()
	 * @param int $id
	 * which stands here for identifyer like month
	 * @param FPDF $pdf
	 * Must be a FPDF object
	 * @param Container $container
	 * must be a container object
	 * @return FPDF
	 * Retuns the data for a pdf file based on the class FPDF
	 **/
	 static function mpdf($id,$pdf,$container,$type = 1,$title = ""){
		if($id < 12 AND $id >= 1){
			//load
			$objects = $container->getSignOffSheets();
			//get Weeks:
			$d = new DateTime(date("Y",time()).'-'.$id.'-1');
			$d->modify('first day of this month');
			$start = date("W",$d->getTimeStamp());//start of this caclulation
			$firstdayW = date("w",$d->getTimeStamp());
			$firstday = date("d",$d->getTimeStamp());
			$d->modify('last day of this month');
			$end = date("W",$d->getTimeStamp());//end of this calculation
			$lastdayW = date("w",$d->getTimeStamp());
			$lastday = date("d",$d->getTimeStamp());
			$pdf->AddPage();
			$dayContainer = null;
			$total = 0;
			//create header
			//run through data
			$pdf->ChapterTitle("Export of the Month: ".date("M",$d->getTimeStamp())." ".date("Y",$d->getTimeStamp()));
			$pdf->SetFont('Times','B',10);
			$pdf->Cell(0,10,$title);
			$pdf->ln();
			$pdf->SetFont('Times','',10);
			while($start <= $end){
				$header = array();
				$fbtinGeneral = array();
				$ticks = array();
				if(array_key_exists($start,$objects)){
						foreach($objects[$start] as $key => $sheet){
							$mealtime = $container->getMealtimesClass()->create($sheet->getMealTime())->getName();
							$fbtinGeneral[$key][8] = $mealtime;
							$count = 0;
								$week = $sheet->getWeekCount("type",$type);
								$count += array_sum($week);
								$total += array_sum($week);
								$fbtinGeneral[$key]= array_merge($fbtinGeneral[$key],$week);
								$fbtinGeneral[$key][] =$count; 
						}
					}
				//header:
				$day = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
				$header[] = "Mealtime";
				for($i = 1;$i < 8;$i++){
					$dayIndex = ($i == 7)? 0:$i;
					if($dayContainer == null){
						if($dayIndex == $firstdayW){
							$header[] = $day[$dayIndex]." ".$firstday;
							$dayContainer  = 1;
							}
						}else{
							if($dayContainer == null){
							$header[] = $day[$dayIndex]; 
							}else{
								$dayContainer++;
								if($dayContainer <= $lastday){
									$d = new DateTime(date("Y",time()).'-'.$id.'-'.$dayContainer.'');
									$header[] = $day[$dayIndex]." ".$d->format("d");
								}
								}
						}
					}
				$header[] = "Total";
				if(count($fbtinGeneral) == 0){
				$fbtinGeneral["No Entry"]=array();
				}
				$pdf->ImprovedTable($header,$fbtinGeneral);
				$pdf->ln(3);
				$start++;
			}
			}
				$header = array();
				$header[] = "Total";
				$header[] = $total;
				$pdf->ImprovedTable($header,array());
				return $pdf;

		 }
	/**
	 * Gens a weekly PDF
	 * 
	 * gens a PDF which data for a week
	 * 
	 **/
	 public function weekpdf($id){
		 //load container
		$this->load->library('container');
		$this->load->library('pdf');//load pdf class
		$pdf = $this->pdf;//ini pdf class
		$this->load->model("einstellungen");
		$this->einstellungen->load();
		$pdf->setImageUrl($this->einstellungen->get("LogoUrl")->content);
		$object = $this->container->getSignOffSheets($id);
		if(!is_null($object) AND count($object) != 0){
				//getting all information which are needed:
				/**
				 * Container for the important information for the boxes:
				 **/
				$normal = array();
				$tax = array();
				$who = array();//user overview
				$whoFBT = array();//user overview ONLY FBT
				foreach($object[$id] as $key => $sheet){
					//get mealtime based on the SSheet ID of mealtime
					$mealtime = $this->container->getMealtimesClass()->create($sheet->getMealTime())->getName();
					foreach($sheet->getTicksBy("user") as $ticksArray){
						//create user name
						$username = $ticksArray[0]->getUser()->getName()." ".$ticksArray[0]->getUser()->getSurname();
						$uID = $ticksArray[0]->getUser()->getID();
						$group = $ticksArray[0]->getUser()->getGroup()->getName();
						//echo $mealtime." - ".$group." -".$sheet->count("group",$ticksArray[0]->getUser()->getGroup()->getID())."\n";
						/**
						 * count ticks by group
						 **/
						if(array_key_exists($group,$normal)){
						foreach($normal[$group] as $norm){
								if(!in_array($mealtime,$norm)){
									$normal[$group][] = array($mealtime,array($sheet->count("group",$ticksArray[0]->getUser()->getGroup()->getID()),"style"=>"R"));
									break;
									}
							}
						}else{
							$normal[$group][] = array($mealtime,array($sheet->count("group",$ticksArray[0]->getUser()->getGroup()->getID()),"style"=>"R"));
						}
						//tax
						if(array_key_exists($group,$tax)){
						foreach($tax[$group] as $t){
								if(!in_array($mealtime,$t)){
									$tax[$group][] = array($mealtime,array($sheet->count("group",$ticksArray[0]->getUser()->getGroup()->getID(),"type",1),"style"=>"R"));
									break;
									}
							}
						}else{
							$tax[$group][] = array($mealtime,array($sheet->count("group",$ticksArray[0]->getUser()->getGroup()->getID(),"type",1),"style"=>"R"));
						}
						//per user:
						$who[$mealtime][$group][$uID][] = $username;
						$whoFBT[$mealtime][$group][$uID][] = $username;
						//going through the ticks
						foreach($ticksArray as $tick){
								if($tick->getType() == 0){
									$tickType = "X";
									$tickTypeFTB = "-";
									}else if($tick->getType() == 1){
										$tickType = "XX";
										$tickTypeFTB = "XX";
										}else{
											$tickType = "P";
											$tickTypeFTB = "-";
											}
								$index = ($tick->getDay() == 0)? 7:$tick->getDay();
								$who[$mealtime][$group][$uID][$index] = array($tickType,"style"=>"C");
								$whoFBT[$mealtime][$group][$uID][$index] = array($tickTypeFTB,"style"=>"C");
							}
							for($x = 1;$x < 8;$x++){
								$dayIndex = ($x == 7)? 0:$x;
							if(!array_key_exists(($x),$who[$mealtime][$group][$uID])){
								$who[$mealtime][$group][$uID][$x] = array("-","style"=>"C");
								$whoFBT[$mealtime][$group][$uID][$x] = array("-","style"=>"C");
								}
							}
							ksort($who[$mealtime][$group][$uID]);
							ksort($whoFBT[$mealtime][$group][$uID]);
							}
							//adding the result:
							for($i = 1;$i < 9;$i++){
								$dayIndex = ($i == 8)? 0:$i;
								if($dayIndex == 1){
									$total = "Total";
									$totalFBT = $total;
									}else{
										$dayIndex = ($dayIndex == 0)? 1:$dayIndex;
										$total = $sheet->count("day",($dayIndex-1));
										$totalFBT = $sheet->count("day",($dayIndex-1),"type",1);
										}
								$in = ($i == 1)? 0:$i;
								$who[$mealtime]["Result"][10000000000000000000000][$in] = array($total,"style"=>"C");
								$whoFBT[$mealtime]["Result"][10000000000000000000000][$in] = array($totalFBT,"style"=>"C");
							}
					}
				/**
				 * ##################################
				 * After this box we generate the PDF
				 * ##################################
				 **/
				$pdf->AliasNbPages();
				$pdf->AddPage();
				$pdf->SetFont('Arial','B',20);
				$pdf->Cell(0,20,"Sign off Sheet");
				$pdf->ln(15);
				//calc date:
				$time = $this->parseTime($id);
				$mon = $time["sun"];
				$sat = $time["sat"];
				$pdf->ChapterTitle("Export of the week: $id ($mon - $sat)");
				$pdf->SetFont('Times','B',10);
				$pdf->Cell(0,10,"Number of participants with FBT at mealtimes:");
				$pdf->ln(10);
				$pdf->SetFont('Times','',10);
				$pdf->ImprovedTable(array("Mealtimes","Participants"),$tax);
				$pdf->SetFont('Times','B',10);
				$pdf->Cell(0,10,"Number of participants in total:");
				$pdf->ln(10);
				$pdf->SetFont('Times','',10);
				$pdf->ImprovedTable(array("Mealtimes","Participants"),$normal);
				$pdf->AddPage();
				$pdf->SetFont('Arial','B',20);
				$pdf->Cell(0,20,"Sign off Sheet");
				$pdf->ln(15);
				$pdf->ChapterTitle("Export of the week: $id ($mon - $sat)");
				$this->printTabel($pdf,$who,"Total overview over people who ate [key]");
				$pdf->AddPage();
				$pdf->SetFont('Arial','B',20);
				$pdf->Cell(0,20,"Sign off Sheet");
				$pdf->ln(15);
				$pdf->ChapterTitle("Export of the week: $id ($mon - $sat)");
				$this->printTabel($pdf,$whoFBT,"Total overview over people who ate [key] with FTB");
				}else{
				$pdf->AliasNbPages();
				$pdf->AddPage();
				$pdf->ChapterTitle("404 Error could not found document");
				$pdf->SetFont('Times','',12);
				$pdf->Cell(100,12,"System could not find requested document.");			
				}
				//insert groups
				$pdf = self::insertGroups($this->container,$pdf,$id,$this->parseTime($id));
			$pdf->Output();	
		 }
		 
		 private function parseTime($time){
				$secounds = $time*7*24*60*60;
				$sun  =	$secounds - (60*60*24*4);
				$sat =	$secounds + (60*60*24*2);
				$son = date("D d. M ",mktime(0,0,0,1,1,date("Y"))+$sun);
				$sat = date("D d. M Y",mktime(0,0,0,1,1,date("Y"))+$sat);
				return array("sun"=>$son,"sat"=>$sat);
			 }
		private function printTabel($pdf,$who,$title = null,$caption = "X stands for normal, XX stands for tax benefits and P stands for packed food"){
				foreach($who as $key => $block){
					$pdf->SetFont('Times','B',10);
					$pdf->Cell(0,3,str_replace("[key]",$key,$title));
					$pdf->ln(5);
					$pdf->SetFont('Times','',10);
					$header = array(array("Name",60));
					for($x = 1;$x < 8;$x++){
						$t = ($x == 7)? 0:$x;
					$header[] = date("D",mktime(0,0,0,12,(28+$t),1969));
					}
					$pdf->ImprovedTable($header,$block);
					$pdf->ln(3);
					$pdf->SetFont('Times','I',10);
					$pdf->Cell(0,3,$caption);
					$pdf->ln(10);
					
				}			
			}
		static private function insertGroups($container,$pdf,$week,$time){
				$groups = $container->getGroups();
				if(count($groups) != null){
					$pdf->AddPage();
					$pdf->SetFont('Arial','B',20);
					$pdf->Cell(0,20,"Sign off Sheet");
					$pdf->ln(15);
					$pdf->ChapterTitle("Export of the week: $week (".$time["sat"]." - ".$time["sun"].")");
					//get ticks of groups:
					$dataCollector = array();
					foreach($groups as $group){
						foreach($group->getTicks($week) as $tick){
								$mealtime = $container->getMealTimes($tick["mID"]);
								if(!is_null($mealtime)){
									$dataCollector[$group->getName()][$tick["mID"]][] =$group->getNumber();
									$dataCollector[$group->getName()][$tick["mID"]][] = $mealtime->getName();
									$dataCollector[$group->getName()][$tick["mID"]] = array_merge($dataCollector[$group->getName()][$tick["mID"]],$tick["tick"]);
									}
							}
						}
						$pdf->ImprovedTable(array("Number","Mealtimes","Mon","Tue","Wed","Thu","Fri","Sat","Sun"),$dataCollector);
						$pdf->ln(3);
						$pdf->SetFont('Times','I',10);
						$pdf->Cell(0,3,"1 stands for this group ate and a 0 stands for no the group did not eat");
				}
			return $pdf;
			}
	 }

?>
