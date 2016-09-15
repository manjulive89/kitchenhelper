<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @file sheet.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 12.06.2016 17:59:22 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
	  <h1>Sign Off Sheet <small> <span class=" label label-default" id="week"></span> <span id="date-ss" class="label label-default"></span></small></h1>
	</div>
	<div class="panel panel-info">
	  <div class="panel-heading">Information</div>
	  <div class="panel-body">
		<p class="text-info"><span class="glyphicon glyphicon-info-sign"></span> <span class="helptext_signoffsheet_info">[helptext_signoffsheet_info]</span></p>
		<br>
		<button class="btn btn-info" data-toggle="collapse" href="#tickExpl" aria-expanded="false" aria-controls="Tick overview"><span class="glyphicon glyphicon-info-sign"></span> <span class="helptext_sheet_tick_explenation"></span></button>
		<br>
		<ul class="list-group collapse" id="tickExpl">
		<li class="list-group-item"><button class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></button> <strong class="helptext_btndefault_sheet"></strong></li>
		<li class="list-group-item"><button class="btn btn-warning"><span class="glyphicon glyphicon-ok"></span></button> <strong class="helptext_btnnormal_sheet"></strong></li>
		<li class="list-group-item"><button class="btn btn-success"><span class="glyphicon glyphicon-ok"></span></button> <strong class="helptext_btnftb_sheet"></strong></li>		
		<li class="list-group-item"><button class="btn btn-info"><span class="glyphicon glyphicon-briefcase"></span></button> <strong class="helptext_btnpacked_sheet"></strong></li>
		</ul>
	  </div>
	</div>
	<p class="text-primary text-bold">Date: <span id="today"></span></p>
<ul class="nav nav-pills navbar-right">
  <li role="presentation" ><a href="#" id="backintimeweekFrontend"><span class="glyphicon glyphicon-chevron-left"></span> Week</a></li>
  <li role="presentation" ><a href="#" id="forwardintimeweekFrontend"><span class="glyphicon glyphicon-chevron-right"></span> Week</a></li>
  <li role="presentation"><a href="#" id="addCasual"><span class="glyphicon glyphicon-plus"></span> Casual</a></li>
  <li role="presentation"><a href="#" id="addGuest"><span class="glyphicon glyphicon-plus"></span> Guest</a></li>
  <li role="presentation"><a href="#" id="addGroup"><span class="glyphicon glyphicon-plus"></span> Group</a></li>
</ul>
	</div><!-- fin row -->
	<div id="update" class="alert alert-success hidden">
	<p><span class="glyphicon glyphicon-ok"></span> Updated</p>
	</div>
	<div class="row"><!-- overview -->
 <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist" id="mealTimes">
  </ul>	
 <!-- tab -->
 <div class="tab-content">
 
 
 </div><!-- end tabs -->	
	
	</div> <!-- /overview -->
	
</div><!-- container -->
