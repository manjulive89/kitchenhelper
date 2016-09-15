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
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.24.1" />
	<!-- bootstrap -->
	<link href='<?php echo $base_url->content ?>makeup/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
	<link href='<?php echo $base_url->content ?>makeup/css/bootstrap-theme.min.css' rel='stylesheet' type='text/css'>
	<style>
	.main-page .col-md-4 .list-group,
	.main-page .col-md-4 .panel{
		min-height:180px;
		}
	</style>
</head>
<body>
	<!-- page -->
	<!-- navbar -->
	<nav class="navbar navbar-default navbar-static-top">
		<div class="container-fluid">
			<div class="navbar-head">
				<a href="<?php echo $base_url->content ?>" class="navbar-brand"><?php echo $pagename->content;?></a>
			</div>
		</div>
	</nav>
	<!-- end navbar -->
	<div class="container"><!-- main container -->
		<div class="row"><!-- login form -->
		<?php 
		if(isset($error)){
		$_error = validation_errors(); 
		if($_error != "" OR $error->content != null){
			?>
			<div class="alert alert-danger">
			<?php echo $error->content;?>
			</div>
			<?php
			}
		}
		?>
		<?php echo form_open('backend'); ?>
		<div class="input-group">
		  <span class="input-group-addon" id="username">Username</span>
		  <input type="text" class="form-control" placeholder="Username" aria-describedby="username" name="username">
		  </div>
		  <br>
		  <div class="input-group">
		  <span class="input-group-addon" id="password">Password</span>
		  <input type="password" class="form-control" placeholder="Password" aria-describedby="password" name="password">
		</div>
		<br>
		<button type="submit" class="btn btn-info">Login</button>
		</form>		
		</div><!-- login end-->
		
	</div><!-- end main container-->
	<!-- end page -->
	<!-- include all the javascrip -->
	
	<!-- jquery -->
    <script src="<?php echo $base_url->content ?>makeup/js/jquery-2.2.0.js"></script
    <!-- bootstrap -->
	<script src="<?php echo $base_url->content ?>makeup/js/bootstrap.min.js"></script>
	<!-- kitchenhelper scripts -->
    <script src="<?php echo $base_url->content ?>makeup/js/dashboard.js"></script>
</body>
</html>
