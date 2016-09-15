<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @file User.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 09.06.2016 19:42:00 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
<div class="container" id="user">
	<div class="row">
		<div class="page-header">
			<h1><span class="glyphicon glyphicon-user"></span> User <small>Managment </h1>
		</div>
	</div>
<div class="row">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active" id="userTabNav"><a href="#users" aria-controls="users" role="tab" data-toggle="tab">Users</a></li>
    <li role="presentation"><a href="#groups" aria-controls="groups" role="tab" data-toggle="tab">Teams</a></li>
      <li role="presentation"><a href="#diets" aria-controls="diets" role="tab" data-toggle="tab">Dietaries</a></li>
    <li role="presentation" id="addNewUserTab"><a href="#newuser" aria-controls="newuser" role="tab" data-toggle="tab">New User</a></li>

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="users">
    <br><p class="helptext_listsortgroup"></p>
    <p class="text-info"><span class="glyphicon glyphicon-info-sign"></span> <span class="helptext_why_red"></span></p>
    <div id="usertable"></div>
    <br><p class="helptext_removed"></p>
    <div id="userremovetable"></div>
    </div>
    <div role="tabpanel" class="tab-pane container" id="groups">
		<div class="row">
			<div class="col-md-6">
				<br><p class="text-info">List of all Teams:</p>
				<ul id="grouplist" class='list-group'></ul>
			</div>
			<div class="col-md-6">
				<h3 id="createGroupHeader"><span class="glyphicon glyphicon-plus"></span> Create new Teams</h3>
				<div class="panel panel-default">
				  <div class="panel-body">
					<div class="input-group">
					  <input type="text" class="form-control" id="newGroupName" placeholder="Groupname">
					  <span class="input-group-btn">
						  <button class="btn btn-info" id="newGroupClean"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
						<button class="btn btn-default" type="button" id="newGroupSave"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
					  </span>
					</div><!-- /input-group -->
				  </div>
				</div>
			</div>
		</div>
    </div>
    <div role="tabpanel" class="tab-pane" id="diets">
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
      <div role="tabpanel" class="tab-pane container" id="newuser">
		 <div class="row">
		 <h3 id="userOverviewNew"><span class="glyphicon glyphicon-plus"></span> Create new User</h3>
		 <hr>
		 </div>
		<div class="row">
		<div class="alert alert-danger hidden" id="warning"></div>
		</div>
		<div class="row">
			<div class="input-group">
			  <span class="input-group-addon" id="nameAddon">Name</span>
			  <input type="text" class="form-control" id="newUserName" placeholder="Joe" aria-describedby="nameAddon">
			</div>
		</div>
		<div class="row">
			<div class="input-group">
			  <span class="input-group-addon" id="surnameAddon">Surname</span>
			  <input type="text" class="form-control" id="newUserSurname" placeholder="Doe" aria-describedby="surnameAddon">
			</div>
		</div>
		<div class="row">
			<p class="text-danger"><span class="glyphicon glyphicon-warning-sign"></span> Is required and needs a valid email adress of the following format: <i>[text]@[domain].[domain ending]</i> <u>For example: johndoe@gmail.com</u></p>
			<div class="input-group">
			  <span class="input-group-addon" id="mailAddon">E-Mail</span>
			  <input type="email" class="form-control" id="newUserEmail" placeholder="Joe.Doe@domain.tld" aria-describedby="mailAddon">
			</div>
		</div>
		<div class="row">
			<p class="text-warning"><span class="glyphicon glyphicon-question-sign"></span> Is only required for Admins or Managers</u></p>
			<div class="input-group">
			  <span class="input-group-addon" id="passwordAddon">Password</span>
			  <input type="password" class="form-control" id="Password" placeholder="Password" aria-describedby="passwordAddon">
			</div>
		</div>
		<div class="row">
			<div class="input-group">
			  <span class="input-group-addon" id="spasswordAddon">Password</span>
			  <input type="password" class="form-control" id="Password2" placeholder="Password" aria-describedby="spasswordAddon">
			</div>
		</div>
		<div class="row">
			<div class="well">Dietaries:<div id="dietListnewUser"></div></div>
			<p class="text-info"><span class="glyphicon glyphicon-question-sign"></span> Choose ad diet from the drop down. <u>If you cannot find the right diet you can add it quickly. To do this please use the text input field.</u></p>
			<div class="input-group">
			  <div class="input-group-btn">
				<button type="button" class="btn btn-default dropdown-toggle" id="addDietUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dietaries <span class="caret"></span></button>
				<ul class="dropdown-menu"  id="dropDietsItems">
				</ul>
			  </div><!-- /btn-group -->
			  <input type="text" class="form-control" id="dietNameNewUser">
			 <span class="input-group-addon">
				<input type="checkbox" id="isDangerNew">  Life threatened
			  </span>
			  <span class="input-group-btn">
				<button class="btn btn-default" id="addNewdietUser" type="button">Add new</button>
			  </span>
			</div><!-- /input-group -->		
			<p class="text-info"><span class="glyphicon glyphicon-exclamation-sign"></span><span class="helptext_what_means_lifeth"></span></p>
		</div>
		<div class="row">
		<div class="dropdown">
		  <button class="btn btn-default dropdown-toggle" type="button" id="dropGroup" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
			Choose Group
			<span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu" id="dropGroupItems" aria-labelledby="dropGroup">
		  </ul>
		</div>	
		</div>
		<div class="row">
		<label for="isAdmin">Role: Admin</label> <input name="isAdmin" id="isAdmin" type="checkbox">
		<label for="isManager">Role: Manager</label> <input name="isManager" id="isManager" type="checkbox">
		<p class="text-info helptext_role"></p>
		</div>
		<div class="row">
			<button class="btn btn-success" id="saveNewUser"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
		</div>
      </div>
  </div>

</div>
</div>
