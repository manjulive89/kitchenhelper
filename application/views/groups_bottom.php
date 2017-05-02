<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 /*
 * @file groups_bottom.php
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
         <script src="<?php echo $base_url->content;?>makeup/js/users.js"></script>
     <script>
	var OBAClass = new OBA();
	OBAClass.debug = false;
	var r = new Requests();
	r.setBaseUrl("<?php echo $base_url->content;?>");
	r.setType("frontend/");
	r.requestSettings();
	r.requestMealTimes();
	r.requestGroups();
	r.requestDiets();
	$( "body" ).on( "loadHelptexts", function() {
		OBAdata.loadHelptexts= true;
		OBAClass.displayHelptexts();
		OBAClass.log("Display Helptexts");
	});
	$( "body" ).on( "loadGroups", function() {
	OBAdata.loadGroups = true;
	$("body").trigger("displayGroups");
	});
	u = new Users();
	$( "body" ).on( "displayGroups", function() {
		OBAClass.log("[trigger] displayGroups");
		if(OBAdata.loadGroups == true && OBAdata.loadMts == true && OBAdata.loadDiets == true){
			$("#addGroups").removeClass("hidden");
			u.createGroupList();
		}
	});
	$( "body" ).on( "loadDiets", function() {
	OBAdata.loadDiets = true;
	$( "body" ).trigger("displayDiets");
	$("body").trigger("displayGroups");
	});
	$( "body" ).on( "displayDiets", function() {
		OBAClass.log("[trigger] displayDiets");
		if(OBAdata.loadDiets == true){
			u.createDietsList();
		}
	});
	var d = new Dashboard();
	$( "body" ).on( "loadMts", function() {
		OBAdata.loadMts = true
		$("body").trigger("displayGroups");
	});
$(".toggle[data-toggle]").click(function(){
	OBAClass.toggle(this);
	});
    </script>
</body>
</html>
