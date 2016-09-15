<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @file mealplanner.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 10.06.2016 12:01:50 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
<!-- webpage content --->
<div class="container" id="mealplanner">
	<div class="row">
		<div class="page-header">
			<h1><span class="glyphicon glyphicon-apple"></span> Mealplanner <small>Overview</small> </h1>
		</div>
	</div>
	<!-- tabs -->
	<div class="row">

	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#mealplansoverview" aria-controls="mealplansoverview" role="tab" data-toggle="tab">Mealplans</a></li>
		<li role="presentation"><a href="#mealtimesoverview" aria-controls="mealtimesoverview" role="tab" data-toggle="tab">Mealtimes</a></li>
		<li role="presentation"><a href="#mealsoverview" aria-controls="mealsoverview" role="tab" data-toggle="tab">Meals</a></li>
	  </ul>

	  <!-- Tab panes -->
	  <div class="tab-content">
		<div role="tabpanel" class="tab-pane active container" id="mealplansoverview">
<div class="panel panel-info">
		  <div class="panel-heading">
			<button type="button" class="toggle pull-right" data-toggle=".help-body">
			  <span class="glyphicon glyphicon-menu-up"></span>
			</button>
			<h3 class="panel-title">Help</h3>
		  </div>
		  <div class="panel-body help-body hidden">
			<p class="text-info"><span class="glyphicon glyphicon-info-sign"></span> <span class="helptext_mpgeneral"></span></p>
		  </div>
		</div>
			
			<hr>
			<div class="row">
				<div class="col-md-6">
					<div id="updated" class="pull-right"></div><p class="helptext_ovallplansak"></p>
					<ul class="list-group mps" id="mealplansList">
					</ul>
					<p class="text-info"><span class="glyphicon glyphicon-info-sign"></span> <span class="helptext_draganddropmp"></span></p>
					<p class="helptext_ovallplansinak"></p>
					<ul class="list-group mps" id="mealplansListInactive">
					</ul>
				</div>
				<div class="col-md-6">
				<strong><span class="glyphicon glyphicon-list-alt"></span> Add new mealtime</strong>
					<div class="panel panel-default">
					  <div class="panel-body">
							<div class="input-group">
								<span class="input-group-addon" id="mpaddon">Mealplan name</span>
							  <input type="text" class="form-control" id="mealplanname" placeholder="e.g Winter Plan #1">
							</div><!-- /input-group -->
							<hr>
							<!-- meal times -->
							<div class="btn-group">
							  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Add Mealtime <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" id="mealtimesAddMealplan">
							  </ul>
							</div>
						</div>
					</div>
					<strong><span class="glyphicon glyphicon-th-large"></span> Added Mealtimes</strong>
					<div class="panel panel-default">
					  <div class="panel-body" id="added_mealtimes">
						  <p class='text-info text-center helptext_emptymealtime'></p>
						  </div>
					</div>
					<hr>
					<p class='text-info text-left'><span class="glyphicon glyphicon-info-sign"></span> <span class="helptext_repeat"></span></p>
					<button class="btn btn-info" id="cleanMealplans" type="button">Cancel</button>
					<button class="btn btn-success" id="mealplansave">Save</button>
<!-- end -->
				</div>
			</div>		
		</div>
		<div role="tabpanel" class="tab-pane container" id="mealtimesoverview">
			<div class="row">
				<div class="col-md-6">
					<p>Overview over all mealstimes:</p>
					<ul class="list-group" id="mealtimesList">
					</ul>
					<p class="text-warning"><span class="glyphicon glyphicon-warning-sign"></span> <span class="helptext_delinfomt"></span></p>
				</div>
				<div class="col-md-6">
					<strong id="editMealTimeHeader"><span class="glyphicon glyphicon glyphicon-list-alt"></span> Add new mealtime</strong>
					<div class="panel panel-default">
					  <div class="panel-body">
							<div class="input-group">
							  <input type="text" class="form-control" id="mealtimename" placeholder="e.g Lunch">
							  <span class="input-group-addon"><input type="checkbox" class="form-controll" id="isTax"> Has FTB</span>
							  <span class="input-group-addon"><input type="checkbox" class="form-controll" id="isPackable"> Packable</span>
							</div><!-- /input-group -->
							<p class="text-info helptext_msoption"></p>
							<hr>
							<strong>Times:</strong>
								<p class="text-info helptext_use24h"></p>
								<div class="input-group">
								  <span class="input-group-addon" id="addon1">Start time</span>
								  <input type="time" class="form-control" placeholder="12:00" id="startTime" aria-describedby="addon2">
								  <span class="input-group-addon" id="addon2">Finish time</span>
								  <input type="time" class="form-control" placeholder="13:00" id="finishTime" aria-describedby="addon2">
								</div>
							<!-- end time -->
							<br>
							<button class="btn btn-info" id="cleanMealtime" type="button">Cancel</button>
							<button type="button" class="btn btn-success" id="saveMealtime"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
					  </div>
					</div>

				</div>
			</div>	<!-- cold md-->	
		</div>
		<div role="tabpanel" class="tab-pane   container" id="mealsoverview">
			<div class="row">
				<div class="col-md-6">
					<p>Overview over all meals:</p>
					<ul class="list-group" id="mealList">
					</ul>
					<p class="text-info"><span class="glyphicon glyphicon-heart"></span> <span class="helptext_star"></span></p>
				</div>
				<div class="col-md-6">
					<strong><span class="glyphicon glyphicon-apple"></span> Add new Meal</strong>
					<div class="panel panel-default">
					  <div class="panel-body">
							<div class="input-group">
							  <input type="text" class="form-control" id="mealname" placeholder="e.g Pizza">
							  <span class="input-group-btn">
								<button class="btn btn-info" id="cleanMeal" type="button">Cancel</button>
								<button class="btn btn-default" id="mealsave" type="button"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
							  </span>
							</div><!-- /input-group -->
					  </div>
					</div>
				</div>
			</div>
		</div>
	  </div>

	</div>

	<!-- end of tabs-->
</div>
