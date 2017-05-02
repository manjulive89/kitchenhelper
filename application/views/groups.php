<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @file groups.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 15.06.2016 10:28:37 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
<div class="container" id="groups">
	<div class="row">
		<div class="page-header">
		  <h1>Groups <small> Overview over Group of Participants</h1>
		</div>
	</div>
	<div class="row">
		<div class="panel panel-info">
		  <div class="panel-heading">
			<button type="button" class="toggle pull-right" data-toggle=".help-body">
			  <span class="glyphicon glyphicon-menu-up"></span>
			</button>
			<h3 class="panel-title">Help</h3>
		  </div><!-- end head -->
		  <div class="panel-body help-body hidden">
			 <p>This page displays all Group of Participants which have been created. You can manage them. Which means you can delete or edit them.</p>
			 <p class="text-warning"><span class="glyphicon glyphicon-warning-sign"></span> If you delete a group you will erase the stats of this group from the Statistics. (Seen under the menu point signoff sheet.)</p>
		  </div><!-- end body -->
		</div><!-- end panel -->
	</div><!-- end row -->
	<div class="row">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#groupmanagment" aria-controls="groupmanagment" role="tab" data-toggle="tab">Group managment</a></li>
    <li role="presentation"><a href="#dietmanagment" aria-controls="dietmanagment" role="tab" data-toggle="tab">Add new Dietaries</a></li>
  </ul>
  <div class="tab-content">
	  <div role="tabpanel" class="tab-pane active" id="groupmanagment">
		<button class="btn pull-right hidden" id="addGroups"><span class="glyphicon glyphicon-plus"></span> Add Group</button>
		<div id="tickOverviewGroups">
		</div>
	</div>
    <div role="tabpanel" class="tab-pane" id="dietmanagment">
		<div class="row">
			<div class="col-md-6">
				<br><p class="text-info">List of all Dietaries:</p>
				<ul id="dietslist" class='list-group'></ul>
			</div>
			<div class="col-md-6">
				<h3 id="createDietsHeader"><span class="glyphicon glyphicon-plus"></span> Create new Diet</h3>
				<div class="panel panel-default">
				  <div class="panel-body">
					<div class="input-group">
					  <input type="text" class="form-control" id="newDietName" placeholder="e.g Lactose Free">
					  <span class="input-group-addon">
						<input type="checkbox" id="isDanger"> Life threatened 
					  </span>
					</div><!-- /input-group -->
					<br>
					<p class="text-info"><span class="glyphicon glyphicon-info-sign"></span> <span class="helptext_what_means_lifeth"></span></p>
					<strong>Description</strong>
					<textarea id="desc" class="form-control" style="height:150px"></textarea>
					<button class="btn btn-info" id="newDietClean"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
					<button class="btn btn-success" id="newDietSave"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
				  </div>
				</div>
			</div>
		</div><!-- /row -->    
    </div>
	</div>
	</div>
</div>
