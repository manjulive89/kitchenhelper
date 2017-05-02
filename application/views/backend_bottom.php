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
	<script src="<?php echo $base_url->content;?>makeup/js/requests.js"></script>
    <script src="<?php echo $base_url->content;?>makeup/js/dashboard.js"></script>
     <script src="<?php echo $base_url->content;?>makeup/js/messanger.js"></script>
      <script src="<?php echo $base_url->content;?>makeup/js/signoffsheet.js"></script>
       <script src="<?php echo $base_url->content;?>makeup/js/notification.js"></script>
         <script src="<?php echo $base_url->content;?>makeup/js/users.js"></script>
         <script src="<?php echo $base_url->content;?>makeup/js/mealplanner.js"></script>
     <script>
	var OBAClass = new OBA();
	OBAClass.debug = true;
	OBAClass.time("#time",30);
	OBAClass.date("#date",1);
	var r = new Requests();
	r.setBaseUrl("<?php echo $base_url->content;?>");
	OBAdata.exportExcel = "<?php echo $base_url->content;?>backend/export/sheet/excel/";
	OBAdata.exportPDF = "<?php echo $base_url->content;?>backend/export/sheet/pdf/";
	r.requestSettings();	
	r.requestMessages();
	r.requestNotifications();
	r.requestMealPlans();
	r.requestMealTimes();
	r.requestSignOffSheets();
	r.requestTicksToday();
	r.requestTicksThisWeek();
	r.requestSheetsDiets();//ini only on Signoffsheet page
	r.requestUsers();//ini later only on User Page
	r.requestGroups();
	r.requestMeals();
	$( "body" ).on( "loadSettings", function() {
		OBAdata.loadHelptexts= true;
			console.log("LOOL");
		OBAClass.displayHelptexts();
		OBAClass.log("Display Helptexts");
		$("body").trigger("displayMps");
	});
	var mp = new Mealplanner();
	$( "body" ).on( "loadMs", function() {
		OBAdata.loadMs = true;
		mp.createMealList();
		$("body").trigger("displayMps");
	});
	//
	$( "body" ).on( "displayMps", function() {
	if(OBAdata.loadMps == true && OBAdata.loadMs == true && OBAdata.loadMts == true && OBAdata.loadHelptexts  == true){
		mp.createMealPlansList();
	}
	});
	$( "body" ).on( "loadUser", function() {
	OBAdata.loadUser = true;
	$( "body" ).trigger("displayUser");
	});
	$( "body" ).on( "loadGroups", function() {
	OBAdata.loadGroups = true;
	$( "body" ).trigger("displayGroups");
	$("body").trigger("loadTicksGroupsWeek");
	});
	$( "body" ).on( "loadUserGroups", function() {
	OBAdata.loadUserGroups = true;
	$( "body" ).trigger("displayUserGroups");
	});
	$( "body" ).on( "loadDiets", function() {
	OBAdata.loadDiets = true;
	$( "body" ).trigger("displayDiets");
	$("body").trigger("displayGroups");
	});
	var u = new Users();
	$( "body" ).on( "displayUser", function() {
		OBAClass.log("[trigger] displayUser");
		if(OBAdata.loadUser == true){
			u.createUserList();
		}
	});
	$( "body" ).on( "displayDiets", function() {
		OBAClass.log("[trigger] displayDiets");
		if(OBAdata.loadDiets == true){
			u.createDietsList();
		}
	});
	$( "body" ).on( "displayUserGroups", function() {
		OBAClass.log("[trigger] displayUserGroups");
		if(OBAdata.loadUserGroups == true){
			u.createUserGroupList();
		}
	});
	r.requestDiets();
	$( "body" ).on( "displayGroups", function() {
		OBAClass.log("[trigger] displayGroups");
		if(OBAdata.loadGroups == true && OBAdata.loadMts == true && OBAdata.loadDiets == true){
			$("#addGroups").removeClass("hidden");
			u.createGroupList();
		}
	});	
	$("body").on("loadTicksGroupsWeek",function(){
		if(OBAdata.loadGroups == true && OBAdata.loadTicksGroupsWeek ==true &&  OBAdata.loadMts == true ){
			d.displayGroupsToday();
			}
		});
	var s = new Signoffsheet();
	$( "body" ).on( "loadSheets", function() {
		OBAdata.loadSheets = true
		$("body").trigger("displayDaily");
		$("body").trigger("displayWeekly");
	});
	$( "body" ).on( "loadSheetDiets", function() {
		OBAdata.loadSheetDiets = true
		$("body").trigger("displayDaily");
		$("body").trigger("displayWeekly");
	});
	$( "body" ).on( "loadWeekTicks", function() {
		OBAdata.loadWeekTicks = true;
		$("body").trigger("displayWeekly");
	});
	$( "body" ).on( "displayDaily", function() {
		OBAClass.log("[triggered] displayDaily");
		if(OBAdata.loadSheetDiets == true && OBAdata.loadSheets == true && OBAdata.loadTodayTicks == true && OBAdata.loadMts == true){
			s.daily();
			OBAClass.log("Display Daily");
		}
	});

	$( "body" ).on( "displayWeekly", function() {
		OBAClass.log("[triggered] Weely");
		if(OBAdata.loadSheetDiets == true && OBAdata.loadSheets == true && OBAdata.loadWeekTicks == true && OBAdata.loadMts == true){
			s.weekly();
			OBAClass.log("Display Weekly");
		}
	});
	var d = new Dashboard();
	$( "body" ).on( "loadMps", function() {
	OBAdata.loadMps = true;
	d.displayTodaysMeal();
	$("body").trigger("displayMps");
	OBAClass.log("Display Dashboard todays Meal");
	});
	$( "body" ).on( "loadMts", function() {
		OBAdata.loadMts = true
		mp.createMealTimesList();
		$("body").trigger("displayTodaysTicks");
		$("body").trigger("displayDaily");
		$("body").trigger("displayWeekly");
		$("body").trigger("displayMps");
		$( "body" ).trigger("displayGroups");
		$("body").trigger("loadTicksGroupsWeek");
	});
	$( "body" ).on( "loadTodayTicks", function() {
		OBAdata.loadTodayTicks = true;
		$("body").trigger("displayTodaysTicks");
		$("body").trigger("displayDaily");
	});
	$( "body" ).on( "displayTodaysTicks", function() {
		if(OBAdata.loadTodayTicks == true && OBAdata.loadMts == true){
		d.displayTickedToday(true);
		OBAClass.log("Display TodaysTicks");
		}
	});
	/**
	Notifications
	**/
	var n = new Notification();
	$( "body" ).on( "loadNotifications", function() {
		d.displayNotifications();
		OBAClass.log("Display Notifications");
	});
	/**
	Messages:
	**/
	$( "body" ).on( "loadMessages", function() {
	var m = new Messanger();
	d.displayMessages();
	d.displayMessagesNumber();
<?php

if(isset($page) AND isset($id)){
if($page->content == "messages"){
		?>
		m.loadMessage(<?php echo $id->content;?>);
		<?php
		}
	}
    ?>
		OBAClass.log("Display Messages");
	});
$(".toggle[data-toggle]").click(function(){
	OBAClass.toggle(this);
	});
    </script>
</body>
</html>
