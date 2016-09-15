/*
 * @file dashboard.js
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 30.05.2016 11:05:14 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Dashboard is the main JavaScript Class for the Dashboard Frontend.
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0 
 * 
 */
 
 Dashboard=function(){
	 this.request = r;
	this.log = function($msg){
		new OBA().log($msg);
		}
	//loader:
	OBAClass.loader("#todaysmeals");
	OBAClass.loader("#signoffsheetoverview");
	/**
	 * #################
	 * Display Methodes
	 * #################
	 **/
	/**
	 * This Methide displays the Group Feture under User/Groups AND in the Signoff sheet!
	 **/ 
	 //stops request after new week:
	 this.oldDate = new Date().getWeekNumber();
	 this.displayGroupsToday = function(){
		 OBAClass.loader("#groupsoverview");
		 console.log("Request:");
		 if(OBAClass.week != this.oldDate){
			 this.oldDate = OBAClass.week;
			  console.log("Request Executed:");
			 r.requestGroups(OBAClass.week);
			 return null;
			 }
		 var $groupdata = r.getGroupsWeekTick();
		 $("#groupsoverview").html("<ul class='list-group'></ul>");
		 $("#groupsoverviewdiets").html("<ul class='list-group'></ul>");
		 $("#groupsoverviewdweek .table tr td").text(0);
		$.each($groupdata,function(index,data){
					$.each(data.ticks,function(ind,group){
						var mealtime = r.getMealTimes(group.mID); 
						if(typeof group.tick[OBAClass.day] != "undefined"){
							if(group.tick[OBAClass.day] === "1"){
							$("#groupsoverview ul").append("<li class='list-group-item'><span class=\"label label-warning\">"+mealtime.name+"</span> "+data.name+" <span class='badge'>"+data.number+"</span></li>");
							/**Diets**/
							$.each(data.diets,function(i,diet){
								var danger = (diet.danger == true)? "list-group-item-danger":"";
								$("#groupsoverviewdiets ul").append("<li class='list-group-item "+danger+"' data-toggle=\"popover\" placement=\"top\"  title=\""+diet.name+"\" data-content=\""+diet.description+"\">"+diet.name+" <span class='badge'>"+diet.number+"</span></li>");
								});
							/*Displays in Signoffsheeet and user/groups*/
							}
							/**
							 * Signoffsheet
							 * calc the number per day in total
							 * */
							 for(var $x = 1;$x < 8;$x++){
								 var $dayX = ($x == 7)? 0:$x;
								 if($("#groupsoverviewdweek .table tr[data-mtid='"+mealtime.id+"']").length == 0){
									 $("#groupsoverviewdweek .table").append("<tr data-mtid='"+mealtime.id+"'><td>"+mealtime.name+"</td></tr>");
									 }
								if($("#groupsoverviewdweek .table tr[data-mtid='"+mealtime.id+"'] td[data-day='"+$dayX+"']").length == 0){
									$("#groupsoverviewdweek .table tr[data-mtid='"+mealtime.id+"']").append("<td data-day='"+$dayX+"'>0</td>");
									}
								 if(typeof group.tick[$dayX] != "undefined"){
										if(group.tick[$dayX] === "1"){
											$("#groupsoverviewdweek .table tr[data-mtid='"+mealtime.id+"'] td[data-day='"+$dayX+"']").text(parseInt(data.number)+parseInt($("#groupsoverviewdweek  .table tr[data-mtid='"+mealtime.id+"'] td[data-day='"+$dayX+"']").text()));
										}
									 }
							 }
						}
						
				});
			});
		if($("#groupsoverviewdiets ul").children().length == 0){
			$("#groupsoverviewdiets ul").append("<li class='list-group-item text-warning text-center'>No Dietraies</li>");
			}
		if($("#groupsoverview ul").children().length == 0){
			$("#groupsoverview ul").append("<li class='list-group-item text-warning text-center'>No group today</li>");
			}
		$('[data-toggle="popover"]').popover();
		 }
	 
	 
		/**
		 * @methode displayTickedToday() 
		 * request the number of people who are planning to eat.
		 * If backend is set the methode will add all data to the backend fields...@see DOM ID's
		 * @param bool $backend 
		 * need two triggers: mealime and ticks
		 **/
	this.displayTickedToday = function($backend){
				$("#signoffsheetoverview").html("");
				$total = 0;
				var obj = this;
						var $object = obj.request.getTicksToday();
						var mealtimes = obj.request.getMealTimes()
						$.each(mealtimes,function(index,value){
							if(typeof $object[value.id] != "undefined"){
								$total += $object[value.id].total;//total means in this case NOT the total number of all people who are eating only of THIS type thats why we have to add..@see php REQUEST CLASS
								}else{
									/**
									 * If object does not exists the ruslt is that no one ticked.
									 ***/
									 $object[value.id] = {total:0}
									}
								$("#signoffsheetoverview").append("<li class=\"list-group-item\">Today "+value.name+" participants <span class=\"badge\">"+$object[value.id].total+"</span></li>");
							});
								if($("#signoffsheetoverview li").length == 0){
									$("#signoffsheetoverview").append("<li class=\"list-group-item text-right\"><p class=\"text-danger text-center\">There are no Mealtimes</p></li>");
									}
						$("#signoffsheet-number-total").text($total);
						//end interval
			};
	/**
	 * @methode displayNotificationsFrontend
	 * Display Notifications
	 **/
	   this.displayNotificationsFrontend=function(){
		   var obj = this;
				$("#notifications").html("");
				var $notif = obj.request.getNotifications();
				var $limit = 0;
						$.each($notif,function(ind,val){
							if($.isArray(val)){
							$.each(val,function(index,value){
								if($limit <= 25){
									$limit++;
										obj.helper.createNotif(value,index);
									}
								});
								}else{
									obj.helper.createNotif(val,ind);
									}
							});
						if($("#notifications").children().length == 0){			
							$("#notifications").append("<li class=\"list-group-item text-warning text-center\">- No Notifications -</li>");
						}
				$("#notifications").on("click",".notif",function(){
					var notif = r.getNotifications($(this).attr("data-fixed"),$(this).attr("data-id"));
					OBAClass.dialog(notif.title,notif.message);
					});
						
		   }
	 /**
	  * @methode displayNotifications
	  * Displays the Notification titles
	  **/
	  this.displayNotifications=function(){
				var obj = this;
						//Methode:
						$("#notifications").html("");
						var $notif = obj.request.getNotifications();
						$limit = 0;
						$.each($notif,function(ind,val){
							if($.isArray(val)){
								//change limit if notifications-page exists
								if($("#notifications-page").length){
									l = val.length;
									}else{
										l = 3;
										}
							$.each(val,function(index,value){
								if($limit <= l){
									$limit++;
										obj.helper.createNotif(value,index);
									}else{
									return 0;
									}
								});
							}else{
								obj.helper.createNotif(val,ind);
								}
							});
							if($("#notifications-page").length){
									if($("#notifications").children().length == 0){
										
										$("#notifications").append("<li class=\"list-group-item text-warning text-center\">- No Notifications -</li>");
										}
								}
		  };
		this.helper = {
			obj:this
			}
		this.helper.toggle = function(element){
			OBAClass.toggle(element);
		}
		this.helper.vote = function($id){
									  OBAClass.dialog("Thanks","Thanks for your feedback");
									  var meal = r.getMeals($id);
									  if(meal != null){
										  meal.points.push(1);
										$.post(r.getBaseUrl()+OBAdata.type+"api/update/update",{data:meal,type:"Meal"});										  
										  }			
			}
		this.helper.tick = function(tickObject,thissheet,type){
			if(tickObject.id == null){
			tickObject.type = type;
			if(typeof thissheet.ticks == "undefined"){
				thissheet.ticks = [];
				}
			thissheet.ticks.push(tickObject);
			}else{
			//find
			$.each(thissheet.ticks,function(i,val){
			if(val.id == tickObject.id){
			thissheet.ticks[i].type = type;
			return false;
			}
			});
			}
			$.post(r.getBaseUrl()+OBAdata.type+"api/update/update",{data:thissheet,type:"Signoffsheet"}).done(function(gotback){
				OBAClass.loadUser = false;
				OBAdata.loadSheets = false;
				/**
				$("#mealTimes").html("");
				$(".tab-content").html("");
				r.requestSignOffSheets();
				r.requestUsers();
				*/
				$("#update").removeClass("hidden");
			});			
			}
		this.helper.hasDiet = function($userdiets,$diet){
			var has = false;
			$.each($userdiets,function(index,value){
					if(value.id == $diet.id){
						has = true;
						return false;
						}
				});
			return has;
			}
		/**
		 * isTicked
		 * 
		 * checked if user is ticked and if yes returns type
		 * @return int
		 * 0,1,2 or null
		 * */
		this.helper.isTicked = function($ticks,$day,$userID){
			var type = null;
			$.each($ticks,function(index,tick){
					if(tick.user.id == $userID && tick.day == $day){
						type = tick.type;
						return false;
						}
				});
			return type;
			}
		this.helper.createNotif = function(value,id){
						id = (typeof id != "undefined")? id:null;
						obj = this.obj;
						var $time =new Date((parseInt(value.date)*1000));
						var $date = new OBA().timeMaker(parseInt($time.getDate()))+"/"+new OBA().timeMaker(parseInt($time.getMonth())+1)+"/"+$time.getFullYear()+" "+new OBA().timeMaker(parseInt($time.getHours()))+":"+new OBA().timeMaker(parseInt($time.getMinutes()));
						if($("#frontend_dashboard").length == 0){
						var $title = value.title; 
						$fixed = (value.fixed == true)? "<span class='glyphicon glyphicon-pushpin'></span>":"";
						if($("#notifications-page").length >= 1){
							url="#";
							$class = "pull-right";
							$add = '<br><br><div class="btn-group" role="group" ><button type="button" class="btn btn-default nedit" data-fixed="'+value.fixed+'" \" data-id="'+value.id+'"><span class="glyphicon glyphicon-pencil"></span></button><button type="button" class="btn btn-default nimportant" data-fixed="'+value.fixed+'" \" data-id="'+value.id+'"><span class="glyphicon glyphicon-star"></span></button><button type="button" class="btn btn-default nfixed" \" data-id="'+value.id+'" data-fixed="'+value.fixed+'"><span class="glyphicon glyphicon-pushpin"></span></button><button type="button" class="btn btn-default ndel" data-fixed="'+value.fixed+'" \" data-id="'+value.id+'"><span class="glyphicon glyphicon-trash"></span></button></div>';
							}else{
								$add = ""
								$class = "pull-right";
								url = OBAdata.baseUrl+"backend/notifications";
								}
						$important = (value.important == true)? "<span class='glyphicon glyphicon-exclamation-sign'></span>":"";
						$("#notifications").append("<li class=\"list-group-item\ \" data-id=\""+value.id+"\">"+$fixed+" "+$important+" <a href=\""+url+"\" data-fixed='"+value.fixed+"' class='notif' \" data-id="+value.id+">"+$title+" <span class=\"badge text-right "+$class+"\">"+$date+"</span></a> "+$add+" </li>");
						}else{
							var $class;
							var $title = value.title; 
							$class = (value.important == true)? "list-group-item-info text-bold":"";
							var $add = (value.important == true)? "<span class='glyphicon glyphicon-star'></span>":"";
							$("#notifications").append("<li class=\"list-group-item "+$class+" \"> "+$add+" <a href=\"#\" class='notif' data-fixed=\""+value.fixed+"\" data-id="+value.id+">"+$title+" <span class=\"badge text-right pull-right\">"+$date+"</span></a></li>");
							}
								
			}
	this.days = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
	this.mons = ["January","Feburary","March","April","May","June","July","August","September","October","November","December"];
	this.day = new Date().getDay();
	this.week = new Date().getWeekNumber();
								 /**
								  * ##########################################################################
								  * Events:
								  *                                  Forward in Time//Backwards
								  * 								 AddCasual/Guest
								  * 								 meallike
								  * 
								  * ##########################################################################
								  * */
								  $(".vote").click(function(){
									 obj.helper.vote($(this).attr("data-id"))
									  });
								 $("#addCasual").click(function(){
									 new OBA().dialog("Add Casual","<p class='text-info'>Please fill out the following forms:</p><strong>Name</strong><input class='form-control' id='name' value='Casual'><strong>Surname</strong><input class='form-control' id='surname' value='Surname'>",function(){
										 var $name = ($("#name").val().length > 0)? $("#name").val():"Casual";
										 var $surname = ($("#surname").val().length > 0)? $("#surname").val():"Surname";
									 var user = {//create empty user
										 name:$name,
										 surname:$surname,
										 email:"casual"+Math.round((Math.random()*100000))+"@outwardbound.org.au",
										 group:{name:"Casuals"}
										 }
										$("#mealTimes").html("");
										$(".tab-content").html("");	
									OBAClass.loader("#mealTimes");
									$.post(r.getBaseUrl()+OBAdata.type+"api/update/update",{data:user,type:"User"}).done(function(gotback){
										OBAClass.loadUser = false;												
										r.requestUsers();
										r.requestSignOffSheets();
										OBAClass.updated();
									 });
									 $("#ask-dialog").modal("hide");
									 });
									 });
								$("#addGroup").click(function(){
									OBAClass.dialog("Login","<p class='text-info'>Please login with your Password</p><form action='"+OBAdata.baseUrl+"groupmanagment' method='POST'><input class=\"form-control\" type='password' name='password'><button class='btn btn-default btn-block' type='submit' name='login_groups'>Login</button></form>");
									});
								 $("#addGuest").click(function(){
									 new OBA().dialog("Add Guest","<p class='text-info'>Please fill out the following forms:</p><strong>Name</strong><input class='form-control' id='name' value='Guest'><strong>Surname</strong><input class='form-control' id='surname' value='Guest Surname'>",function(){
										 var $name = ($("#name").val().length > 0)? $("#name").val():"Guest";
										 var $surname = ($("#surname").val().length > 0)? $("#surname").val():"Guest Surname";
									 var user = {
										 name:$name,
										 surname:$surname,
										 email:"obaguest"+Math.round((Math.random()*100000))+"@outwardbound.org.au",
										 group:{name:"Guests"}
										 }
									$("#mealTimes").html("");
										$(".tab-content").html("");	
									OBAClass.loader("#mealTimes");
									$.post(r.getBaseUrl()+OBAdata.type+"api/update/update",{data:user,type:"User"}).done(function(gotback){
										OBAClass.loadUser = false;												
										r.requestUsers();
										r.requestSignOffSheets();
										OBAClass.updated();
									 });
									 $("#ask-dialog").modal("hide");
									 });
									 });
								$("#forwardintimeweekFrontend").click(function(){
									if(obj.week+1 <= 52){
									obj.week = obj.week+1;
									obj.day = 1;//set always on Monday!
									OBAClass.day = obj.day;
									OBAClass.week = obj.week;
									obj.displaySheet();
									}else{
										new OBA().dialog("Time Error","You cannot go further then a year backward in the daiely overview",function(){
										$('#ask-dialog').modal('hide');
										});
									}
									obj.displaySheet();
									});
									/**
									 * Backwards in time a week
									 **/
									$("#backintimeweekFrontend").click(function(){
										if(new Date().getWeekNumber() < obj.week){
										if(obj.week-1 > 0){
										obj.week = obj.week-1;
										obj.day = 0;//set always on Monday!
										OBAClass.day = obj.day;
										OBAClass.week = obj.week;
										obj.displaySheet();
										}else{
											new OBA().dialog("Time Error","You cannot go further then a year backward in the daiely overview",function(){
											$('#ask-dialog').modal('hide');
											});
										}
										obj.displaySheet();
										}else{
											new OBA().dialog("Time Error","You cannot go further the the actual week.",function(){
											$('#ask-dialog').modal('hide');
											});											
											}
										});
									/**
									 * #########################
									 * Toggle user groups in/out
									 * or mealtimes in mealplanner overview
									 * #########################
									 **/
									 $(".tab-content").on("click",".toggle-group",function(){
										 obj.helper.toggle(this);
										 });
									$(".toggle-mt").click(function(){
										obj.helper.toggle(this);
									 });
	this.displaySheet=function(){
		obj = this;
		var mealplan = r.getMealPlan();//get mealplan 
		var sheet = r.getSignoffSheet(this.week);//get signoffsheet
		if(typeof sheet[0] == "undefined"){
			sheet = null;
			}else{
				sheet = sheet[0];
				}
				var mealtimes = mealplan.mealtimes;
				$("#mealTimes").html("");
				$(".tab-content").html("");
				/**
				 * var counter
				 * its important for activating/inactivating tabs
				 * */
				var counter = 0;
				/**
				 * #############
				 * Mealtime each
				 * #############
				 * */
				$.each(mealtimes,function(ind,mealtime){
					var thissheet = (sheet != null && typeof sheet[mealtime.id] != "undefined")? sheet[mealtime.id]:sheet;
					/**
					 * Making sure that you can actually save
					 * */
					if(sheet == null || typeof thissheet.ticks == "undefined"){
						thissheet = {week:obj.week,mealtime:mealtime.id,ticks:[]};
						}
					/**
					 * setup the week/date
					 **/
					 OBAClass.setWeek(obj.week);
					 obj.month = OBAClass.month;
					//add tab header
					var $active;//is first tab if iyes activate it!
					if(counter == 0){
						$active = "active";
						}else{
							$active = "";
							}
					//create tab header
					$("#mealTimes").append('<li role="presentation" class="'+$active+'"><a href="#id_mt_tab_'+mealtime.id+'" aria-controls="id_mt_tab_'+mealtime.id+'" role="tab" data-toggle="tab">'+mealtime.name+'</a></li>');
					//add data:
					$(".tab-content").append('<div role="tabpanel" class="tab-pane '+$active+'" id="id_mt_tab_'+mealtime.id+'"><table class="table table-striped"><tr></tr></table></div>');
					$("#id_mt_tab_"+mealtime.id+" .table tr").append("<th>Name</th><th>Dietaries</th>");
					for($x = 1;$x < 8;$x++){
						$("#id_mt_tab_"+mealtime.id+" .table tr").append("<th>"+obj.days[(($x==7)?0:$x)]+" "+OBAClass.getDayOfWeek((($x==7)?0:$x),obj.week).getDate()+".</th>");
						}
					$("#id_mt_tab_"+mealtime.id+" .table tr").append("<th>Week</th>");
					/**
					 * 
					 * creates user + user buttons
					 * based on OBAdata.user --> getUsers()
					 *
					 ***/ 
					var $users = r.getUsers();
					$.each($users,function(index,usergroup){
						$("#id_mt_tab_"+mealtime.id+" .table").append('<tr><th  colspan="10"  scope="colgroup">'+usergroup[0].group.name+' <button class="btn btn-lg btn-primary pull-right toggle-group" data-toggle=".group-'+usergroup[0].id+'"><span class="glyphicon glyphicon-menu-down"></span></button></th><tr>');
						$.each(usergroup,function(ind,user){
							if(user.id != 0 && user.removed == false){
								var diets = "";
								if(user.dietaries.length != 0){
									diets = "<div class=\"btn-group\" role=\"group\"><button class='btn btn-default diet-show' id='mt_"+mealtime.id+"user_diet_id"+user.id+"'  data-toggle=\"popover\" title=\""+user.name+"s Dietaries\" data-content=\"\">Show Diet</button><button class='btn btn-default add-diet' data-id=\""+user.id+"\">Edit Diet</button></div>";
									}else{
										diets = 
									diets = "<div class=\"btn-group\" role=\"group\"><button class='btn btn-default disabled'>No Dietaries</button><button class='btn btn-default add-diet' data-id=\""+user.id+"\">Add Dietaries</button></div>";
										}								
								$("#id_mt_tab_"+mealtime.id+" .table").append("<tr id='id_user_id"+user.id+"_mt_"+mealtime.id+"' class=\"hidden group-"+usergroup[0].id+"\"><td>"+user.name+" "+user.surname+"</td><td>"+diets+"</td></tr>");
							/**
							 * Display users diets
							 * */
								$.each(user.dietaries,function(number,diet){
									var $content = $("#mt_"+mealtime.id+"user_diet_id"+user.id).attr("data-content");
									var cssclass = (diet.danger == true)? "text-danger":"text-info";
									$content += " <span class='"+cssclass+"'>"+diet.name+"</span>";
									$("#mt_"+mealtime.id+"user_diet_id"+user.id).attr("data-content",$content)
									});
								$('.diet-show').popover({"html":true});
								/**
								 * ########
								 * Evenets
								 * ########
								 **/
								  
								 /**
								  * ##########################################################################
								  * 
								  *                                 Dietaries
								  * 
								  * ##########################################################################
								  * */
								 $("#id_user_id"+user.id+"_mt_"+mealtime.id).on("click",".add-diet",function(){
									 var dietContainer = "";
									 var editContainer = "";
									 //get diets
									 var dietaries = r.getDiets();
									 $.each(dietaries,function(d,diet){
										 //check if user has diet already:
										 if(obj.helper.hasDiet(user.dietaries,diet) == false){
												
												var $danger = (diet.danger == true)? "btn-danger":"btn-info";
												dietContainer += "<button class=\"btn "+$danger+" addDiet text-center\" data-id='"+diet.id+"'><span class=\"glyphicon glyphicon-plus\"></span> "+diet.name+"</button> ";
											}else{
												
												editContainer += "<button class=\"btn "+$danger+" delDiet\" data-id='"+diet.id+"'><span class=\"glyphicon glyphicon-trash\"></span> "+diet.name+"</button> ";
												}
										 });
										 
										 dietContainer = (dietContainer == "")? "- No Dietaries could be found please add yours-<br>":dietContainer;
									
									var addContainer = "<p class='text-info'>List of possible dietaries:</p><div id='listDiets' style='margin-bottom:15px;'>"+dietContainer+"</div> <p class=\"text-info\"><span class='glyphicon glyphicon-info-sign'></span>Please click on the name to select. <u>If you cannot find the right diet you have to create a new one.</u></p><button id=\"showedit\" data-toggle='#dieteditor' class='btn'><span class='glyphicon glyphicon-menu-down'></span> Add a new Diet Editor</button><br><div class='hidden' id='dieteditor'><div class=\"input-group\"><input type=\"text\" class=\"form-control\" id=\"newDietName\" placeholder=\"e.g Lactose Free\"><span class=\"input-group-addon\"><input type=\"checkbox\" id=\"isDanger\"> Life threatened</span><span class='input-group-btn'><button id=\"addNewDietName\" class='btn btn-success' type='button'>Add</button></span></div><!-- /input-group --></div>";									
									var $data = "<div><ul class=\"nav nav-tabs\" role=\"tablist\"><li role=\"presentation\" class=\"active\"><a href=\"#addDiets\" aria-controls=\"addDiets\" role=\"tab\" data-toggle=\"tab\">Add Diets</a></li><li role=\"presentation\"><a href=\"#EditDiets\" aria-controls=\"EditDiets\" role=\"tab\" data-toggle=\"tab\">Manage your Dietaries</a></li></ul> <div class=\"tab-content\"><div role=\"tabpanel\" class=\"tab-pane active\" id=\"addDiets\"><br><p class='text-info'>Help: To remove a diet you have to click on the name.</p>"+addContainer+"</div><div role=\"tabpanel\" class=\"tab-pane \" id=\"EditDiets\">"+editContainer+"</div></div></div>";
									/**
									 * Add Diet Dialog:
									 * **/
									 OBAClass.dialog("Add or Edit Dietaries",$data,function(){
													$("#ask-dialog").modal("hide");
													OBAClass.loadUser = false;
													OBAClass.loadDiets = false;													
													r.requestUsers();
													r.requestDiets();
										 },"modal-lg");
										 $("#showedit").click(function(){
											 console.log(22);
											 OBAClass.toggle(this);
											 });
											/**
											 * Del diet from user
											 ***/
											$(".delDiet").click(function(){
												var $dID = $(this).attr("data-id");
												$(this).remove();
												var $diets = [];
												$.each(user.dietaries,function(index,value){
														if(value.id != $dID){
															$diets.push(value);
															}
													});
												user.dietaries = $diets;
												$.post(r.getBaseUrl()+OBAdata.type+"api/update/update",{data:user,type:"User"}).done(function(gotback){
													OBAClass.updated();
													});
												});
											//add
											/**
											 * Del diet from user
											 ***/
											$("#addNewDietName").click(function(){
												if($("#newDietName").val().length > 2){
												$name = $("#newDietName").val();
												$("#newDietName").val("");
												$isDanger = $("#isDanger").prop("checked");
												$("#isDanger").prop("checked",false);
												var diet = {name:$name,danger:$isDanger,description:"None"};
												user.dietaries.push(diet);
												$.post(r.getBaseUrl()+OBAdata.type+"api/update/update",{data:user,type:"User"}).done(function(gotback){
													OBAClass.updated();
													});
												}				
							
												});
											$(".addDiet").click(function(){
												var $dietary = r.getDiets($(this).attr("data-id"));
												//check if user has that one:
												user.dietaries.push($dietary);
												$("#EditDiets").append("<button class=\"btn delDiet\" data-id='"+$dietary.id+"'><span class=\"glyphicon glyphicon-trash\"></span> "+$dietary.name+"</button> ");
												$.post(r.getBaseUrl()+OBAdata.type+"api/update/update",{data:user,type:"User"}).done(function(gotback){
													OBAClass.loadUser = false;
													OBAClass.updated();
													});
													$(this).remove();
													//$("#ask-dialog").modal("hide");
												});	 
									 });
								 /**
								  * ##########################################################################
								  * 
								  *                                  Ticked
								  * 
								  * ##########################################################################
								  * */
								  $("#id_user_id"+user.id+"_mt_"+mealtime.id).on("click",".tick-week:not(.disabled)",function(){
									  var $uID = $(this).attr("data-id");
										//erase users ticks
										var $thissheet = {};
										$thissheet.tick = thissheet.tick;
										thissheet.tick = [];
									    $.each($thissheet.tick,function(index,$tick){
												if($tick.user.id != $uID){
													thissheet.tick.push($tick);
													}
											
											});
									    for(var $i=1;$i <=5;$i++){
												var tick = {};
												tick.id = null;
												tick.user = user;
											tick.day = $i;
											tick.type = 0;
											thissheet.ticks.push(tick);
											}
													$("#mealTimes").html("");
													$(".tab-content").html("");
													OBAClass.loader(".tab-content");
										$.post(r.getBaseUrl()+OBAdata.type+"api/update/update",{data:thissheet,type:"Signoffsheet"}).done(function(gotback){
													OBAClass.loadUser = false;
													OBAdata.loadSheets = false;
													r.requestSignOffSheets();
													r.requestUsers();
													$("#update").removeClass("hidden");
													});
										});
								  $("#id_user_id"+user.id+"_mt_"+mealtime.id).on("click",".tick:not(.disabled)",function(){
										//get type:
										var $type = $(this).attr("data-type");
										var $day = $(this).attr("data-day");
										var $uID = $(this).attr("data-id");
										//get user
										var user = r.getUsers($uID);
										  var tickObject = null;
										
										$.each(thissheet.ticks,function(id,value){
												if(value.day == $day && value.user.id == $uID){
													tickObject = value;
													tick = value
													}
											});
											if(tickObject == null){
												tickObject = {};
												tickObject.id = null;
												tickObject.day = $day;
												tickObject.type = $type;
												tickObject.user = user;
												}
												var tax = (mealtime.tax == true)? "<button type=\"button\" class=\"btn btn-success btn-lg tick-ftb\" data-mt=\""+mealtime.id+"\" data-day='"+$day+"'><span class=\"glyphicon glyphicon-ok\"></span> Tax benefits</button>":"";
												var packed = (mealtime.packable == true)? "<button type=\"button\" class=\"btn btn-info btn-lg take-away\" data-mt=\""+mealtime.id+"\" data-day='"+$day+"'><span class=\"glyphicon glyphicon-briefcase\"></span> Packed</button>":"";
												var untick = (tickObject.id == null)? "":"<button type=\"button\" class=\"btn btn-lg btn-default tick-untick\"><span class=\"glyphicon glyphicon-remove\" data-mt=\""+mealtime.id+"\" data-day='"+$day+"'></span> Untick</button>";
												$ticktypes = "<p class=\"text-info\">"+OBAClass.getHelptext(0,"helptext_tick_explain")+"</p><br><center><div class=\"btn-group\" role=\"group\">"+untick+"<button type=\"button\" class=\"btn btn-warning btn-lg tick-normal\" data-mt=\""+mealtime.id+"\" data-day='"+$day+"'><span class=\"glyphicon glyphicon-ok\"></span> Normal</button>"+tax+" "+packed+"</div></center>"
												OBAClass.dialog("Choose tick type",$ticktypes,function(){ $("#ask-dialog").modal("hide");},"modal-lg");
									  $(".tick-untick").click(function(){
											var oldTicks = thissheet.ticks;
											thissheet.ticks = [];//rest
											$.each(oldTicks,function(i,val){
												if(val.id != tickObject.id){
													thissheet.ticks.push(val);
													}
											});
										   var clicker = $(".tick[data-day='"+tickObject.day+"'][data-id='"+tickObject.user.id+"'][data-mt='"+thissheet.mealtime+"']");
										   clicker.removeClass("btn-warning");
										   clicker.removeClass("btn-success");
										   clicker.removeClass("btn-info");
										   clicker.addClass("btn-default");
										   clicker.find(".glyphicon").removeClass("glyphicon-briefcase");
										   clicker.find(".glyphicon").removeClass("glyphicon-ok");
										   clicker.find(".glyphicon").addClass("glyphicon-remove");
										$.post(r.getBaseUrl()+OBAdata.type+"api/update/update",{data:thissheet,type:"Signoffsheet"}).done(function(gotback){
													OBAClass.loadUser = false;
													OBAdata.loadSheets = false;
													r.requestSignOffSheets();
													r.requestUsers();
													$("#update").removeClass("hidden");
													});
													$("#ask-dialog").modal("hide");
									  });
									 /**
									  * ############################################
									  * 	                Tick
									  * ############################################
									  **/
									   $(".tick-normal").click(function(){
										  console.log($(this).attr("data-mt") == thissheet.mealtime);
										   var clicker = $(".tick[data-day='"+tickObject.day+"'][data-id='"+tickObject.user.id+"'][data-mt='"+thissheet.mealtime+"']");
										   clicker.removeClass("btn-default");
										   clicker.removeClass("btn-success");
										   clicker.removeClass("btn-info");
										   clicker.addClass("btn-warning");
										   clicker.find(".glyphicon").removeClass("glyphicon-briefcase");
										   clicker.find(".glyphicon").removeClass("glyphicon-remove");
										   clicker.find(".glyphicon").addClass("glyphicon-ok");
										   obj.helper.tick(tickObject,thissheet,0);
										   $("#ask-dialog").modal("hide");
										   });
									   $(".tick-ftb").click(function(){
										   var clicker = $(".tick[data-day='"+tickObject.day+"'][data-id='"+tickObject.user.id+"'][data-mt='"+thissheet.mealtime+"']");
										   clicker.removeClass("btn-default");
										   clicker.removeClass("btn-warning");
										   clicker.removeClass("btn-info");
										   clicker.addClass("btn-success");
										   clicker.find(".glyphicon").removeClass("glyphicon-briefcase");
										   clicker.find(".glyphicon").removeClass("glyphicon-remove");
										   clicker.find(".glyphicon").addClass("glyphicon-ok");
										   obj.helper.tick(tickObject,thissheet,1);
													$("#ask-dialog").modal("hide");
										   });
									   $(".take-away").click(function(){
										    var clicker = $(".tick[data-day='"+tickObject.day+"'][data-id='"+tickObject.user.id+"'][data-mt='"+thissheet.mealtime+"']");
										   clicker.removeClass("btn-default");
										   clicker.removeClass("btn-success");
										   clicker.removeClass("btn-warning");
										   clicker.addClass("btn-info");
										   clicker.find(".glyphicon").removeClass("glyphicon-ok");
										   clicker.find(".glyphicon").removeClass("glyphicon-remove");
										   clicker.find(".glyphicon").addClass("glyphicon-briefcase");
										   obj.helper.tick(tickObject,thissheet,2);
										   $("#ask-dialog").modal("hide");
										   });

								});
								/**
								 * #############################################
								 * Displays the ticks:
								 * check if ticked
								 * 
								 * #############################################
								 **/
								for(var $x = 1;$x < 8;$x++){
									var isTicked;
									var type;
									var typeDisplay;
									var btnclass = "btn-default";
									var day = ($x == 7)? 0:$x;
									if(thissheet != null){
									isTicked = obj.helper.isTicked(thissheet.ticks,day,user.id);
									}else{
										isTicked = null;
										}
									if(isTicked === null){
									 typeDisplay = "<span class=\"glyphicon glyphicon-remove\"></span>";
									 btnclass = "btn-default";
									}else if(isTicked == 0){
										btnclass = "btn-warning";
										typeDisplay = "<span class=\"glyphicon glyphicon-ok\"></span>";
										}else if(isTicked == 1){
											btnclass = "btn-success";
											typeDisplay = "<span class=\"glyphicon glyphicon-ok\"></span>";
											}else{
												btnclass = "btn-info";
												typeDisplay = "<span class=\"glyphicon glyphicon-briefcase\"></span>";
												}
											var $shouldDisable = (day == 0)?7:day;
											if($shouldDisable < obj.day && obj.week <= new Date().getWeekNumber()){
												btnclass = " disabled";
												}
											$("#id_user_id"+user.id+"_mt_"+mealtime.id).append("<td><button data-id='"+user.id+"' data-day='"+day+"' type=\"button\" data-mt='"+mealtime.id+"' data-type=\""+type+"\" class=\"tick btn btn-lg "+btnclass+"\">"+typeDisplay+"</button></td>");
									}
									//week:
									if(obj.day != 0){
										$("#id_user_id"+user.id+"_mt_"+mealtime.id).append("<td><button data-id='"+user.id+"' type=\"button\" class=\"tick-week btn btn-lg btn-default\"><span class=\"glyphicon glyphicon-ok\"></span>Week</button></td>");
									}
							}
							});
						});
						counter++;
				});//ende mealtime each
		}
	 /**
	  * @methode displayMessages
	  * Displays the Messages titles in the id #messages.
	  **/
	  this.displayMessages=function(){
				var obj = this;
						//Methode:
						$("#messages").html("");
						var $mesg = obj.request.getMessages();
						$limit = 0;
						if(typeof $mesg.length != "undefined"){
						$.each($mesg,function(index,value){
							if($limit <= 3){
								$time =new Date((parseInt(value.date)*1000));
								$date = new OBA().timeMaker(parseInt($time.getDate()))+"/"+new OBA().timeMaker(parseInt($time.getMonth())+1)+"/"+$time.getFullYear()+" "+new OBA().timeMaker(parseInt($time.getHours()))+":"+new OBA().timeMaker(parseInt($time.getMinutes()));
								$title = value.title; 
								$seen = (value.seen == 0)? "alert alert-warning":"";
								$("#messages").append("<li class=\" "+$seen+" list-group-item mail-item\" data-id=\""+index+"\"><strong><a href=\""+r.getBaseUrl()+"backend/messages/show/"+value.id+"\">"+$title+"</a></strong><p><span class=\"glyphicon glyphicon-time\"></span> "+$date+" <span class=\"glyphicon glyphicon-user\"></span> <a href=\"#\">"+value.sender.name+" "+value.sender.surname+"</a></p></li>");
							}else{
								return 0;
								}
							});
							if($("#messages").children().length == 0){
								$("#messages").html("<p class='text-warning text-center'>- No messages -</p>");
								}
						}else{
								$time =new Date((parseInt($mesg.date)*1000));
								$date = new OBA().timeMaker(parseInt($time.getDate()))+"/"+new OBA().timeMaker(parseInt($time.getMonth())+1)+"/"+$time.getFullYear()+" "+new OBA().timeMaker(parseInt($time.getHours()))+":"+new OBA().timeMaker(parseInt($time.getMinutes()));
								$title = $mesg.title; 
								$seen = (value.seen == 0)? "alert alert-warning":"";
								$("#messages").append("<li class=\" "+$seen+" list-group-item\"><strong><a href=\"#\">"+$title+"</a></strong><p><span class=\"glyphicon glyphicon-time\"></span> "+$date+" <span class=\"glyphicon glyphicon-user\"></span> "+$mesg.sender.name+" "+$mesg.sender.surname+"</p></li>");
														
							}
						//ende Methode
		  };
	 /**
	  * @methode displayMessagesNumber
	  * Checked if new messages.
	  **/
	  this.displayMessagesNumber=function(){
				var obj = this;
					$number = 0;
					$mesg = obj.request.getMessages();
					if(typeof $mesg.length != "undefined"){
					$.each($mesg,function(index,value){
						if(value.seen == 0){
							$number++;
							}
						});
					}else{
						if($mesg.seen == 0){
							$number++;
							}
						}
					$(".msgNumber").text($number);
			}
	 /**
	  * @methode displayTodaysMeal
	  * Displays the Todays meal of the Mealplanner and based on the day in the Backend/Frontend.
	  **/
		this.displayTodaysMeal = function(){
				var obj = this;
					//logic starts:
						//empy table:
						$("#todaysmeals").html("");
						/**
						 * get mealplan Object based on the current day and that it is activ!
						 * @see Dashboard::getMealPlan();
						 **/
						$mealplan = obj.request.getMealPlan(new Date().getWeekNumber(),true);
						/**
						* create a table elements with infos:
						* example:
						* <tr><th class="text-center">Lunch 12:30 - 13:30</th></tr>
						* <tr><td class="text-center">Sandwiches</td></tr>
						**/
						//add name of mealtime:
						//check if repeat or not
						$.each($mealplan.mealtimes,function(index,val){
							//print the name of mealtime
							$("#todaysmeals").append("<tr><th class=\"text-center\">"+val.name+" "+new OBA().timeMaker(val.start)+" - "+new OBA().timeMaker(val.finish)+"</th></tr>");
							/**
							 * print meals of mealtime
							 * check if current day exist in mealplan::mealtime::meals
							 **/
							if(typeof val.meals[new Date().getDay()] != "undefined"){
								$("#todaysmeals").append("<tr><td class=\"text-center\"><span class='meal'>"+val.meals[new Date().getDay()].name+"</span></td></tr>");
							}else{//repeat:
								$repeat = false;
								$setRepeat = false;
								$.each(val.meals,function(ind,value){
									if(value.repeats == true && $setRepeat == false){
										$("#todaysmeals").append("<tr><td class=\"text-center\">"+value.name+"</td></tr>");
										$repeat = true;
										$setRepeat = true;//only one time shown
										return true;
										}
									});
									if($repeat == false){
										$("#todaysmeals").append("<tr><td class=\"text-center\">- No meal planned -</td></tr>");
									}
								}
						});	   
			}
	}
