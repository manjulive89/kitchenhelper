<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 /*
 * @file backend_bottom.php
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
<footer>
	<hr>
	<p>Copyright by <a href="http://www.simonrenger.de">Simon Renger</a> 2016 <br> Script runs under the <a href="http://www.cyoxx.de/lizenz">Cyroxx Software Lizenz 1.0</a></p>
	<a class="pull-right" href="<?php echo $base_url->content;?>/backend"><span class="glyphicon glyphicon-lock"></span> Admin</a>
</footer>
 	<!-- end page -->
	<!-- include all the javascrip -->
	<script src="<?php echo $base_url->content;?>makeup/js/date.prototype.getweeknumber.js"></script>
	<!-- jquery -->
    <script src="<?php echo $base_url->content;?>makeup/js/jquery-2.2.0.js"></script>
    <script src="<?php echo $base_url->content;?>makeup/js/jquery-ui.min.js"></script>
    <!-- bootstrap -->
	<script src="<?php echo $base_url->content;?>makeup/js/bootstrap.min.js"></script>
	<!-- kitchenhelper scripts -->
	<script src="<?php echo $base_url->content;?>makeup/js/oba.js"></script>
    <script src="<?php echo $base_url->content;?>makeup/js/dashboard.js"></script>
    <script src="<?php echo $base_url->content;?>makeup/js/requests.js"></script>
     <script>
	var OBAClass = new OBA();
	OBAClass.time("#time",30);
	OBAClass.date("#date",1);
	OBAClass.loader("#mealTimes");
	var r = new Requests();
	r.setBaseUrl("http://localhost/outwardbound/");
	r.setType("frontend/");
	r.requestMessages();
	r.requestNotifications();
	r.requestMealPlans();
	r.requestMealTimes();
	r.requestSignOffSheets();
	r.requestTicksToday();
	r.requestTicksThisWeek();
	r.requestSheetsDiets();//ini only on Signoffsheet page
	r.requestUsers();//ini later only on User Page
	r.requestMeals();
	r.requestDiets();
	r.requestHelpTexts();

	$( "body" ).on( "loadHelptexts", function() {
		OBAdata.loadHelptexts= true;
		OBAClass.displayHelptexts();
		OBAClass.log("Display Helptexts");
		$("body").trigger("displayMps");
	});

	var d = new Dashboard();
	/**
	Mealplan
	**/
	$( "body" ).on( "loadMps", function() {
	d.displayTodaysMeal();
	OBAdata.loadMps = true;
	$( "body" ).trigger("displaySheet");
	OBAClass.log("Display Dashboard todays Meal");
	});
	$( "body" ).on( "loadUser", function() {
		OBAdata.loadUser= true;
		$( "body" ).trigger("displaySheet");
		});
	$( "body" ).on( "displaySheet", function() {
		if(OBAdata.loadMps == true && OBAdata.loadUser == true && OBAdata.loadSheets == true && OBAdata.loadDiets == true){
			d.displaySheet();
			}
		});
	$( "body" ).on( "loadSheets", function() {
		OBAdata.loadSheets = true
		$("body").trigger("displaySheet");
	});
	$( "body" ).on( "loadDiets", function() {
	OBAdata.loadDiets = true;
	$( "body" ).trigger("displaySheet");
	});
	/**
	Notifications
	**/
	$( "body" ).on( "loadNotifications", function() {
		d.displayNotificationsFrontend();
		OBAClass.log("Display Notifications");
	});
</script>
</body>
</html>
