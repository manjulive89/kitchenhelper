<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 /*
 * @file dashboard_backend.php
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
<!-- webpage content --->
<div class="container" id="dashboard">
	<div class="row">
		<div class="page-header">
		  <h1>Dashboard Backend</h1>
		</div>
	</div>
	<div class="row main-page">
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
			<div class="panel panel-info">
			  <div class="panel-heading">
				<h3 class="panel-title">Todays meal</h3>
			  </div>
			 <!-- Table -->
			 <div class="panel-body">
			  <table class="table" id="todaysmeals">
			  </table>
			 </div>
			<div class="panel-footer"><a href="<?php echo $base_url->content;?>backend/mealplanner">Edit</a></div>
			</div>
		</div>
		<!-- menue box -->
		<div class="col-md-4">
			<div class="panel panel-default">
			  <div class="panel-heading">
				<h3 class="panel-title">Notifications:</h3>
			  </div>
			<ul class="list-group" id="notifications">  
			</ul>
			<div class="panel-footer"><a href="<?php echo $base_url->content;?>backend/notifications" class="small"><span class="glyphicon glyphicon-cog"></span> Manage</a></div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
		<!-- sign off sheet -->
		<div class="panel panel-info">
		  <div class="panel-heading">
			<h3 class="panel-title">Sign off sheet todays overview</h3>
		  </div>
			 <!-- List group -->
			  <ul class="list-group" id="signoffsheetoverview">
			  </ul>
			 <div class="panel-footer"><a href="backend/signoffsheet">More information</a></div>
		</div>
		<!-- end sign off sheet -->
		</div>
		<div class="col-md-4">
		<!-- sign off sheet -->
		<div class="panel panel-info">
		  <div class="panel-heading">
			<h3 class="panel-title">Groups todays overview</h3>
		  </div>
			 <!-- List group -->
			  <ul class="list-group" id="groupsoverview">
			  </ul>
			 <div class="panel-footer"><a href="backend/user/groups">More information</a></div>
		</div>
		<!-- end sign off sheet -->
		</div>
		<div class="col-md-4">
		<!-- letter to the kitchen -->
		<div class="panel panel-success">
		  <div class="panel-heading">
			<h3 class="panel-title">Mail Box <span class="badge msgNumber">0</span></h3>
		  </div>
			 <!-- List group -->
			  <ul class="list-group" id="messages">
				
			</ul>
			<div class="panel-footer"><a href="<?php echo $base_url->content;?>backend/messages" class="small"><span class="glyphicon glyphicon-cog"></span> Manage</a></div>
		</div>
		<!-- end letter to the kitchen -->
		</div>
	</div> 
</div>
