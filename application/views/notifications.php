<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @file notifications.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 09.06.2016 16:51:51 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Notification View
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */

?>
<!-- webpage content --->
<div class="container" id="notifications-page">
	<div class="row">
		<div class="page-header">
			<h1><span class="glyphicon glyphicon-exclamation-sign"></span> Notifications <small>Overview </h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<ul class="list-group" id="notifications"> 
			</ul>		
		</div><!--list-->
		<div class="col-md-6">
			<div class="well">
			<strong>New Notification:</strong>
			</div>
			<div class="input-group">
			  <span class="input-group-addon" id="addon1">Title</span>
			  <input type="text" class="form-control" placeholder="Title" id="title" aria-describedby="addon1">
			<span class="input-group-addon">
				Important
				<input type="checkbox" id="important">
			</span>
			<span class="input-group-addon">
				Fixed
				<input type="checkbox" id="fixed">
			</span>
			</div>
			<br>
			<textarea id="input-text-notif" class="form-control" style="height:150px;"></textarea>
			<br>
			<p class="text-info">
			<span class="glyphicon glyphicon-info-sign"></span> <span class="helptext_important"></span> <span class="helptext_fixed"></span>
			</p>
			<button class="btn btn-success" id="save-notif" type="button">Save</button>
		
		</div><!-- editor -->
	</div>
</div>
