<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @file mealplanner_frontend.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 13.06.2016 14:42:36 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * 
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */

?>
<div class="container">
	<div class="row">
		<div class="page-header">
		  <h1>Mealplanner <small> Overview over this week</h1>
		</div>
	</div>
	<div class="row">
	<p class="text-info"><span class="glyphicon glyphicon-info-sign"></span> <span class="helptext_mealplannerfrontent_info">[helptext_mealplannerfrontent_info]</span></p>
	<table class="table">
	<?php
	if(!is_null($mealplan)){
	foreach($mealplan->getMealtimes() as $mealtime){
		$re = "/([0-9][0-9])([0-9][0-9])/"; 
		$subst = "$1:$2"; 		 
		$start = preg_replace($re, $subst, $mealtime->getStart(), 1);
		$finish = preg_replace($re, $subst, $mealtime->getFinish(), 1);
		echo "<tr><th colspan=\"4\">".$mealtime->getName()." ".$start." - ".$finish." <button class=\"btn btn-lg btn-primary pull-right toggle-mt\" data-toggle=\".toggle_mt_by".$mealtime->getID()."\"><span class=\"glyphicon glyphicon-menu-down\"></span></button></th></tr>";
		$day = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
		$meals = $mealtime->getMeals();
		$repeat = null;
		for($x = 1;$x < 8;$x++){
			if($x == 1){
				//fix bug with sunday & repeat:
				if($meals[0]->getRepeat() == true){
					$repeat = $meals[0];
					} 
				}
			$d  = ($x == 7)? 0:$x;
			if(array_key_exists($d,$meals)){
				$meal = $meals[$d];
				$mealID = $meal->getID();
				if($meal->getRepeat() == true){
					$repeat = $meal;
					}
				$mealname = $meal->getName();
			}else if($repeat != null){
				$meal = $repeat;
				$mealID = $meal->getID();
				$mealname = $meal->getName();
				}else{
					$mealname = "- No meal -";
					$mealID = 0;
					}
					$vote = ($mealID == 0)? "<button class='disabled btn btn-default btn-lg pull-right'><span class=\"glyphicon glyphicon-heart\"></span></button>":"<button class='vote btn btn-default btn-lg pull-right' data-id='".$mealID."'><span class=\"glyphicon glyphicon-heart\"></span></button>";
			echo "<tr class=\"hidden toggle_mt_by".$mealtime->getID()."\"><td>".$day[$d]."</td><td>".$mealname."</td><td>$vote</td></tr>";
		}
		}
	}
	?>
	</table>
	</div>
</div>
