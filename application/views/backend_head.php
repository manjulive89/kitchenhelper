<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 /*
 * @file backend_head.php
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
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $pagetitle->content; ?></title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.24.1" />
	<!-- bootstrap -->
	<link href='<?php echo $base_url->content;?>makeup/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
	<link href='<?php echo $base_url->content;?>makeup/css/bootstrap-theme.min.css' rel='stylesheet' type='text/css'>
	<style>
	.main-page .col-md-4 .list-group,
	.main-page .col-md-4 .panel{
		min-height:130px;
		}
	#messanger .mail-item{
		cursor:pointer;
		}
	#messanger .mail-item.active,
	#messanger .mail-item.active a{
		color:#fff!important;
		}
	#messanger #messages{
		max-height:300px;
		overflow-y: auto;
		}
	footer p{
				color:#BFBFBF;
				margin:15px;
		}
#sheetoption{
	margin-top:15px;
	margin-bottom:15px;
	}
#weekly{
	padding-top:15px;
	}
#newuser .row{
	margin-top:15px;
	}
#mealplansoverview,
#mealtimesoverview,
#mealsoverview{
	padding-top:15px;
	}
#mealplansList{
	height-min:100px;
	}
	.updated{
		background:#fff;
		color:#008000;
		font-weight:bold;
		font-size:32px;
		width:200px;
		height:65px;
		position:fixed;
		padding:15px;
		padding-bottom:20px;
		top:5%;
		left:0;
		border:1px solid;
		border-left:none;
		z-index:5000;
		margin-left:-200px;
        -webkit-transition: margin 2s; /* For Safari 3.1 to 6.0 */
        transition: margin 2s;
		}
	.go{
		margin-left:0px!important;
        -webkit-transition: margin 2s; /* For Safari 3.1 to 6.0 */
        transition: margin 2s;
		}
	#dia-content{
		max-height:300px;
		overflow-y: auto;
		}
	</style>
</head>
<body>
<div class="updated"><span class="glyphicon glyphicon-floppy-disk"></span>Updated</div>
	<!-- page -->
	<!-- navbar -->
<nav class="navbar navbar-default navbar-static-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo $base_url->content;?>/backend"><?php echo $pagename->content;?></a>
    </div>
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	<ul class="nav navbar-nav navbar-right">
		<li><a href="<?php echo $base_url->content;?>/backend"><span class="glyphicon glyphicon-home"></span> Dashboard</a></li>
        <li><a href="<?php echo $base_url->content;?>/backend/signoffsheet"><span class="glyphicon glyphicon-th-list"></span> Sign Off Sheet <span class="badge" id="signoffsheet-number-total">0</span></a></li>
        <li><a href="<?php echo $base_url->content;?>backend/mealplanner"><span class="glyphicon glyphicon-apple"></span>Meal planner</a></li>
		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> User & Groups <span class="caret"></span></a>
          <ul class="dropdown-menu">
			  <li><a href="<?php echo $base_url->content;?>/backend/user/groups">Group Managment</a></li>
			 <li><a href="<?php echo $base_url->content;?>/backend/user">User Mangament</a></li>
          </ul>
        </li>
        <li><a href="<?php echo $base_url->content;?>backend/messages"><span class="glyphicon glyphicon-envelope"></span> Messages Box <span class="badge msgNumber">0</span></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-option-vertical"></span> More<span class="caret"></span></a>
          <ul class="dropdown-menu">
			  <li><a href="<?php echo $base_url->content;?>/backend/notifications"><span class="glyphicon glyphicon-info-sign"></span> Notifications</a></li>
            <li><a href="<?php echo $base_url->content;?>/backend/settings"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
             <li><a href="<?php echo $base_url->content;?>/backend/archive"><span class="glyphicon glyphicon-inbox"></span> Archive</a></li>
            <li><a href="<?php echo $base_url->content;?>/backend/user/logout"><span class="glyphicon glyphicon-lock"></span> Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

	<!-- end navbar -->
