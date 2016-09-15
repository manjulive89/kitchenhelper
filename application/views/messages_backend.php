<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @file Signoffsheet_backend.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 31.05.2016 13:44:47 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Messages Backend View
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
?>
<!-- webpage content --->
<div class="container" id="messanger">
	<div class="row">
		<div class="page-header">
			<h1><span class="glyphicon glyphicon-envelope"></span> Messages <small>Kitchen feedback book</small> </h1>
		</div>
	</div> 
<div class="row">
	<div class="col-md-6"><!-- messages listed-->
		<div class="list-group" id="messages">
		</div>
	</div><!-- ende messages list -->
	<div class="col-md-6" id="messages-preview">
		<div class="alert alert-info">
		<p class="helptext_nomesageselc"></p>
		</div>
	</div>
</div>
</div>
