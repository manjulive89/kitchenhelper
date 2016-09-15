<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 /*
 * @file dashboard_frontend.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 30.05.2016 10:55:04 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 *
 */
 ?>
	<!-- end navbar -->
	<div class="container" id="frontend_dashboard"><!-- main container -->
		
	<div class="row main-page"> <!-- row main-page -->
		<!-- information box -->
		<div class="col-md-4">
			<div class="panel panel-default">
			  <div class="panel-body">
						<h2 id="time"><?php echo date("H:i",time());?></h2>
						<h3 id="date"><?php echo date("D d. M Y");?></h3>
			  </div>
			</div>
		</div>
		<!-- menue box -->
		<div class="col-md-4">
			<div class="panel panel-default">
			 <!-- Table -->
			 <div class="panel-body">
			 <strong>Todays Mealplan</strong>
			 <hr>
			  <table class="table" id="todaysmeals">
			  </table>
			 </div>
			</div>
		</div>
		<!--- option box -->
		<div class="col-md-4">
			<div class="panel panel-default">
			  <div class="panel-body">
				    <a href="<?php echo $base_url->content;?>sheet"  class="btn btn-default btn-lg btn-block"><span class="glyphicon glyphicon-th-list"></span> Sign off Sheet</a>
				    <a href="<?php echo $base_url->content;?>mealplan" class="btn btn-default btn-lg btn-block"><span class="glyphicon glyphicon-calendar"></span> Meal Planner</a>
				    <a href="<?php echo $base_url->content;?>messages" class="btn btn-default btn-lg btn-block"><span class="glyphicon glyphicon-envelope"></span> Message to the kitchen</a>
			  </div>
			</div>		
		</div>
	</div><!-- end row -->
	<div class="row">
		<h1 class="page-header">Notifications</h1>
		<ul class="list-group" id="notifications">
		
		</ul>
	</div>
	</div><!-- end main container-->
	<!-- end page -->
