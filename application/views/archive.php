<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @file archive.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 13.06.2016 20:38:33 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
		  <h1>Archive <small> Overview over all weeks as for one year.</h1>
		</div>
	</div>
	<div class="row">
	<ul class="list-group">
	<?php
		$dir = scandir(APPPATH."archive/");
		if(count($dir) == 2){
			echo "<li class=\"list-group-item text-info text-center\">- No files -</li>";
			}
		foreach($dir as $file){
			if($file != "." AND $file != ".."){
				$re = "/([0-9]+)/"; 
				preg_match($re, $file, $matches);
				if(isset($matches[0])){
					$date = date("d.m.Y H:i:s",$matches[0]);
					};
				echo "<li class=\"list-group-item\">".APPPATH."archive/".$file." <span class=\"badge\">$date</span></li>";
			}
			}
	?>	
	</ul>
	</div>
</div>		
