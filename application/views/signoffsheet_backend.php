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
 * Sign off Sheet Backend View
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
?>
<!-- webpage content --->
<div class="container" id="signeoffsheet">
	<div class="row">
		<div class="page-header">
			<h1><span class="glyphicon glyphicon-th-list"></span> Sign Off Sheet <small>Overview <span id="week" class="label label-default"></span> <span class="label label-default" id="date-ss"></span></small> </h1>
		</div>
	</div>
<div class="row" id="sheetoption">
	<div class="col-md-2"><i>Date <span id="today"></span></i></div>
	<div class="col-md-10">
	<ul class="nav nav-pills navbar-right">
	  <li role="presentation"><a href="#" id="backintimeweek"><span class="glyphicon glyphicon-backward"></span> Back in time (Week)</a></li>
	  <li role="presentation"><a href="#" id="backintime"><span class="glyphicon glyphicon-chevron-left"></span> Back in time (day)</a></li>
	  <li role="presentation"><a href="#" id="forwardintime"><span class="glyphicon glyphicon-chevron-right"></span> Forward in time</a></li>
	  <li role="presentation"><a href="#" id="forwardintimeweek"><span class="glyphicon glyphicon-forward"></span> Forward in time (Week)</a></li>
	  <li role="presentation dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-floppy-save"></span> Export<span class="caret"></span></a>
          <ul class="dropdown-menu">
			<li><a class="export_excel_month" target="_blank" href="<?php echo $base_url->content;?>backend/export/sheet/excel/month/"><span class="glyphicon glyphicon-list"></span> Excel Month</a></li>
            <li><a class="export_pdf_month" target="_blank" href="<?php echo $base_url->content;?>backend/export/sheet/pdf/month/"><span class="glyphicon glyphicon-file"></span> PDF Month</a></li>
            <li><a class="export_pdf_month" target="_blank" href="<?php echo $base_url->content;?>backend/export/sheet/print/month/"><span class="glyphicon glyphicon-print"></span> Print Month</a></li>
			<li role="separator" class="divider"></li>
            <li><a class="export_pdf" target="_blank" href="<?php echo $base_url->content;?>backend/export/sheet/pdf/week/"><span class="glyphicon glyphicon-file"></span> PDF Week</a></li>
            <li><a class="export_pdf"target="_blank" href="<?php echo $base_url->content;?>backend/export/sheet/print/week/"><span class="glyphicon glyphicon-print"></span> Print Week</a></li>
          </ul></li>
	</ul>
	</div>
</div>
<!-- tabs -->
<div class="row">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#daily" aria-controls="daily" role="tab" data-toggle="tab">Daily overview</a></li>
    <li role="presentation"><a href="#weekly" aria-controls="weekly" role="tab" data-toggle="tab">Week overview</a></li>
    <li role="presentation"><a href="#groupov" aria-controls="groupov" role="tab" data-toggle="tab">Groups Overview</a></li>
  </ul>
<div class="tab-content">
<div class = "container tab-pane active"  role="tabpanel" id="daily"><!-- tab beginning -->
	<!-- over view -->
<div class="row">
	<div class="col-md-6">
		<div class ="row"><!-- in row-->
			<div class="panel panel-default">
			  <div class="panel-heading helptext_nbofpeople"></div>
			  <div class="panel-body">
			  <p class="text-info"><span class="glyphicon glyphicon-exclamation-sign"></span> <span class="helptext_nbrofpeopeeating"></span></p>
			  </div>
				 <ul class="list-group" id="mealtimes">
				  </ul>
			</div>
		</div><!-- in row -->
		<div class="row">
			<div class="panel panel-default">
			  <div class="panel-heading "><span class="helptext_nboftb"></span> <span class="badge" id="totalNumberTB"></span> <a href="#mealtimes-tb"  data-toggle="collapse" aria-expanded="false" aria-controls="mealtimes-tb"><span class="pull-right glyphicon glyphicon-chevron-down"></span></a></div>
				 <ul class="list-group collapse" id="mealtimes-tb" >
				  </ul>
			</div>		
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
		  <div class="panel-heading">Dietaries:</div>
		  <div class="panel-body">
			  <p class="text-info"><span class="glyphicon glyphicon-info-sign"></span> <span class="helptext_diets"></span></p>
			  <hr>
			  <div id="dietaries">
				  </div>
		  </div>
		</div>	
	</div>
</div>
<!-- end over view -->
	<div class="row">
			<h2>Participants</h2>
			<hr>
			<div id="user-signoff"></div>
	</div>
	</div><!-- end tab -->
	<div role="tabpanel" class="tab-pane container" id="weekly">
		<div class="row">
			<div class="panel panel-warning">
			  <div class="panel-heading"><span class="glyphicon glyphicon-th-list"></span> <span class="helptext_weekovervoewbydays"></span></div>
			  <div class="panel-body">
			  <table class="table" id="weeklyOverviewPerDay">
				  </table>
				</div>	
			</div>
		</div>

		<div class="row">
			<div class="panel panel-default">
			  <div class="panel-heading"><span class="glyphicon glyphicon-th-list"></span> <span class="helptext_howpeopleweek"></span></div>
			  <div class="panel-body">
				  <p class="text-info"><span class="glyphicon glyphicon-exclamation-sign"></span> <span class="helptext_nbrofpeopeeating"></span></p>
					<ul class="list-group" id="overview-week-mealtime">
					
					</ul>
			  </div>
			</div>
		</div>
		<div class="row">
			<div class="panel panel-info">
			  <div class="panel-heading"><span class="glyphicon glyphicon-piggy-bank"></span> <span class="helptext_fbtweek"></span></div>
			  <div class="panel-body">
					<ul class="list-group" id="overview-week-mealtime-bt">
					
					</ul>
			  </div>
			</div>
		</div>
		<div class="row">
				<h2>Participants</h2>
				<hr>
				<p><span class="glyphicon glyphicon-info-sign"></span> <span class="helptext_tickinfo"></span></p>
				<div id="user-signoff-weekly"></div>
		</div>		
	</div><!-- end weekly-->
	<div class = "container tab-pane"  role="tabpanel" id="groupov"><!-- tab beginning -->
		<br>
		<div class="row">
			<div class="col-md-6">
			<div class="panel panel-info">
			  <div class="panel-heading">
				<h3 class="panel-title">Groups todays overview</h3>
			  </div>
				 <!-- List group -->
				  <ul class="list-group" id="groupsoverview">
				  </ul>
			</div>
			<div class="panel panel-info">
			  <div class="panel-heading">
				<h3 class="panel-title">This week overview</h3>
			  </div>
				 <!-- List group -->
				  <div id="groupsoverviewdweek">
					  <table class="table">
					  <tr>
						  <th>Mealtime</th>
						  <th>Mo</th>
						  <th>Tue</th>
						  <th>Wed</th>
						  <th>Thu</th>
						  <th>Fri</th>
						  <th>Sat</th>
						  <th>Sun</th>
					  </tr>
					  </table>
				  </div>
			</div>
		</div><!-- col -->
			<div class="col-md-6">
			<div class="panel panel-info">
			  <div class="panel-heading">
				<h3 class="panel-title">Groups todays diets overview</h3>
			  </div>
				 <!-- List group -->
				  <ul class="list-group" id="groupsoverviewdiets">
				  </ul>
			</div>
		</div><!-- col-->
		</div><!-- row -->
	</div><!-- end group-->
</div><!-- end tabs -->
</div>
</div>
