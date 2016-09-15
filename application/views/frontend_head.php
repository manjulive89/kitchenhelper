<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 /*
 * @file frontend_head.php
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
	footer p{
				color:#BFBFBF;
				margin:15px;
		}
	.nav-pills li{
		background:#E5E5E5!important;
		}
	.text-bold a,
	.text-bold{
		font-weight:bold!important;
		}
	#addDiets, #EditDiets{
		padding-top:15px;
		}
	.btn-lg{
		font-size:25px;
		padding:20px;
		}
	li *, table * {
		font-size:20px;
		}
	.popover{
		width:300px;
		}
	#update{
		margin:15px;
		}
	.meal {
		 line-height: 40px;
		}
	.addMealstoMealtime{
		background:red!important;
		height:250px;
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
		<li><a href="<?php echo $base_url->content;?>"><span class="glyphicon glyphicon-home"></span> Dashboard</a></li>
        <li><a href="<?php echo $base_url->content;?>sheet"><span class="glyphicon glyphicon-th-list"></span> Sign Off Sheet </a></li>
        <li><a href="<?php echo $base_url->content;?>mealplan"><span class="glyphicon glyphicon-calendar"></span>Meal planner</a></li>
        <li><a href="<?php echo $base_url->content;?>messages"><span class="glyphicon glyphicon-envelope"></span> Messages to the kitchen</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

	<!-- end navbar -->
