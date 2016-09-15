Users = function(){
	var obj = this;
	this.edit = false;
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	  switch($(e.target).attr("href")){
		  case "#groups":
		  new OBA().loader("#grouplist");
		  r.requestUserGroups();
		  break;
		  case "#users":
		  new OBA().loader("#usertable");
		  r.requestUsers();
		  obj.createUserList();
		  break;
		  case "#diets":
		  new OBA().loader("#dietslist");
		  r.requestDiets();
		  break;
		  case "#newuser":
		  r.requestDiets();
		  r.requestUserGroups();
		  obj.clean();//cleans
		  break;
		  }
	});
	/**
	 * createDietList
	 * 
	 * Displays the diets in an List <ul class='list-group'></ul>
	 * for style infos checkot bootstrap3 or the css3 files
	 * 
	 * @return void
	 **/
	 this.createDietsList = function(){
				var obj = this;
					$("#dietslist").html("");
					$("#dropDietsItems").html("");
					/**
					 * Create Diets Overview
					 * */
					diets = r.getDiets();
					$.each(diets,function(index,value){
						$class = (value.danger == true)? "list-group-item-danger": "";
						$lt = (value.danger == true)? "Life threatened: yes":"Life threatened: no";
						$("#dropDietsItems").append("<li><a href=\"#\" data-index='"+index+"'>"+value.name+" ("+$lt+")</a></li>");
						$("#dietslist").append(" <li class=\"list-group-item "+$class+"\" data-index='"+index+"'><div class=\"btn-group\" role=\"group\"><button class=\"btn btn-sm btn-default dedit\" data-index='"+index+"'><span class=\"glyphicon glyphicon-pencil\"></span></button><button class=\"btn btn-danger btn-sm ddel\" data-index='"+index+"'><span class=\"glyphicon glyphicon-trash\"></span></button><button class=\"btn btn-sm btn-info\" data-toggle=\"popover\" placement=\"top\"  title=\""+value.name+"\" data-content=\""+value.description+"\"><span class='glyphicon glyphicon-question-sign'></span></button></div> "+value.name+"</li>");
						});
		 }
	/**
	 * 
	 * ###############
	 * Diet Events
	 * ###############
	 **/
	//create new Diet
	$("#dietslist").on("click",".dedit",function(){
		$("#createDietsHeader").html("<span class=\"glyphicon glyphicon-pencil\"></span> Edit Diet");
		$diets = r.getDiets();
		$index = $(this).attr("data-index");
		$("#newDietSave").attr("data-id",$diets[$index].id);
		$("#newDietName").val($diets[$index].name);
		$("#isDanger").prop("checked",$diets[$index].danger);
		$("#desc").val($diets[$index].description);
		});
	//del old diets
	$("#dietslist").on("click",".ddel",function(){
		$diets = r.getDiets();
		$index = $(this).attr("data-index");
				new OBA().dialog("Remove Diet",OBAClass.getHelptext(4,"helptext_ddel"),function(){
					$.post(r.getBaseUrl()+r.getType()+"api/update/delete",{data:$diets[$index],type:"Diet"}).done(function(){
						r.requestDiets();
						obj.createDietsList();
						});	
						$("#ask-dialog").modal("hide");
					});
		});
	$("#newDietClean").click(function(){
		$("#newDietName").val("");
		$("#isDanger").prop("checked",false);
		$("#desc").val("");
		});
	$("#newDietSave").click(function(){
		if($("#newDietName").val().length >= 2){
		$("#createDietHeader").html("<span class=\"glyphicon glyphicon-plus\"></span>Create new Diet");
			if(typeof $(this).attr("data-id") != undefined){
			diet = {name:$("#newDietName").val(),id:$(this).attr("data-id"),description:$("#desc").val()}
			$(this).removeAttr("data-id"); 
			}else{
				diet = {name:$("#newDietName").val(),description:$("#desc").val()}
				}
			diet.danger = $("#isDanger").prop("checked");
			$("#isDanger").prop("checked",false);
			$("#newDietName").val("");
			$("#desc").val("");
			$.post(r.getBaseUrl()+r.getType()+"api/update/update",{data:diet,type:"Diet"}).done(function(){
				r.requestDiets();
				obj.createDietsList();
				});
			}else{
				new OBA().dialog("Remove Group",OBAClass.getHelptext(4,"helptext_group_2l"));
				}
		});
	/**
	 * createGroupList
	 * 
	 * creates and displays the overview over groups
	 * 
	 * @return void
	 **/
	 this.createGroupList = function(){				/**
				 * Create Group Overview 
				 * */
				$("#groups #tickOverviewGroups").html("<br>");
				var obj = this;
					var groups = r.getGroups();
					var $mons = ["January","Feburary","March","April","May","June","July","August","September","October","November","December"];
					$.each(groups,function(index,value){
						var diets = "";
						$.each(value.diets,function(index,val){
							var $class = (val.danger == true)? "label-danger":"label-info";
							diets += "<li data-id=\""+val.id+"\" class='list-group-item'><button class=\"btn minus-diet\" data-index='"+index+"' data-id=\""+value.id+"\"><span class='glyphicon glyphicon-minus'></span></button> <button data-id=\""+value.id+"\" data-index='"+index+"' class=\"btn plus-diet\"><span class='glyphicon glyphicon-plus'></span></button><button class=\"btn btn-info\" data-toggle=\"popover\" placement=\"top\"  title=\""+val.name+"\" data-content=\""+val.description+"\"><span class='glyphicon glyphicon-question-sign'></span></button>  "+val.name+" <span class=\"pull-right label "+$class+"\">"+val.number+"</span></li>";
							});
						if(diets == ""){
							diets = "<li class=\"list-group-item text-center text-warning\">-None-</li>";
							}
						/**
						 * Ticks
						 **/
						 //add overview header
						  $("#groups #tickOverviewGroups").append("<h3><button class='btn btn-default' id='btn-toggle-"+value.id+"' data-toggle=\".pgroup-"+value.id+"\"><span class='glyphicon glyphicon-menu-down'></span></button> <span class=\"label label-default\">Size: "+value.number+" "+value.name+"</span>  <span class='badge pull-right'>"+new Date(parseInt(value.date)).getDate()+". "+$mons[new Date(parseInt(value.date)).getMonth()]+" "+new Date(parseInt(value.date)).getFullYear()+"</span></h3>");
						  $("#groups #tickOverviewGroups").append('<div class=\"pgroup-'+value.id+' hidden\"><div class="panel panel-default" > <div class="panel-body"><strong>Dietaries</strong><ul class="list-group">'+diets+'</ul></div></div><div class="btn-group" role="group"><button class="btn btn-sm btn-default groupadddiet" data-id="'+value.id+'"><span class=\"glyphicon glyphicon-plus\"></span> Add dietaries</button><button class="btn btn-sm btn-default groupedit" data-id="'+value.id+'"><span class=\"glyphicon glyphicon-pencil\"></span> Edit '+value.name+'</button><button class="btn btn-danger btn-sm groupdel" data-id="'+value.id+'"><span class="glyphicon glyphicon-trash"></span> Delete '+value.name+'</button></div><br><h3>Tick Overview for '+value.name+'</h3></div>');
						 $("#groups #tickOverviewGroups").append("<div class=\"pgroup-"+value.id+" hidden\"><table class=\"table\" id='table_group_"+value.id+"'><tr><th>Mealtime</th><th>Week</th><th data-day='1'>Mon</th><th data-day='2'>Tue</th><th data-day='3'>Wed</th><th data-day='4'>Thu</th><th data-day='5'>Fri</th><th data-day='6'>Sat</th><th data-day='0'>Sun</th><th></th></tr><table></div>");
						 $.each(value.ticks,function(mtID,mealtime){
							 $.each(mealtime,function(weekNumber,week){
								 var Sun = OBAClass.getDayOfWeek(0,weekNumber);
								 var Mon = OBAClass.getDayOfWeek(1,weekNumber); 
								$("#table_group_"+value.id).append("<tr data-week='"+weekNumber+"' data-id='"+mtID+"'><td>"+r.getMealTimes(mtID).name+"</td><td>"+[weekNumber]+" "+Mon.getDate()+". "+$mons[Mon.getMonth()]+" - "+Sun.getDate()+". "+$mons[Sun.getMonth()]+"</td></tr>");
								 for(var $x = 1;$x < 8;$x++){
									 var $dayX = ($x == 7)? 0:$x;
									 if(typeof week[$dayX] != "undefined"){
											ticktype = (week[$dayX] == true)? "<button class=\"btn tick-group btn-sm\" data-week='"+weekNumber+"' data-mealtime='"+mtID+"' data-id='"+value.id+"' data-day='"+$dayX+"' data-type='0'><span class='glyphicon glyphicon-ok'></span></button>":"<button data-week='"+weekNumber+"' data-mealtime='"+mtID+"' data-day='"+$dayX+"' data-type='1' class=\"btn btn-sm  tick-group\" data-id='"+value.id+"'><span class='glyphicon glyphicon-remove'></span></button>";
											
											$("#table_group_"+value.id+" tr[data-week='"+weekNumber+"'][data-id='"+mtID+"']").append("<td>"+ticktype+"</td>");
										}else{
											$("#table_group_"+value.id+" tr[data-week='"+weekNumber+"'][data-id='"+mtID+"']").append("<td><button class=\"btn btn-sm tick-group\" data-week='"+weekNumber+"' data-id='"+value.id+"' data-mealtime='"+mtID+"' data-day='"+$dayX+"' data-type='1'><span class='glyphicon glyphicon-remove'></span></button></td>");
											}
									 }
								$("#table_group_"+value.id+" tr[data-week='"+weekNumber+"'][data-id='"+mtID+"']").append("<td><button data-week='"+weekNumber+"' data-id='"+value.id+"' data-mtid='"+mtID+"' class=\"btn removeMt btn-danger btn-sm \"><span class=\"glyphicon glyphicon-trash\"></span></button></td>")
								 });
							 //OBAClass.getDayOfWeek(
							 });
							 $("#groups #tickOverviewGroups").append("<div class=\"pgroup-"+value.id+" hidden\"><button data-id=\""+value.id+"\" class=\"addMealTimeToGroupTicks btn btn-default\"><span class='glyphicon glyphicon-plus'></span> Add Mealtime</button></div>");
							 /**
							  * Toggle Event
							  * */
								$("#btn-toggle-"+value.id).click(function(){
									OBAClass.toggle("#btn-toggle-"+value.id);
								});						
						});
						
		$('[data-toggle="popover"]').popover();
	}
		 /**
		  * 
		  * 
		  * Helper Methode for Group managment
		  * @param OBject $groupObject
		  * @return void
		  **/
		this.editorGroup = function($groupObject){
		 var diets = r.getDiets();
		 var dietHTML = "";//contains the diet HTML
		 $.each(diets,function(index,diet){
			 $danger = (diet.danger == true)? "danger":"info";
			 dietHTML += " <button class='addDietToGroup btn btn-"+$danger+"' data-id='"+diet.id+"'>"+diet.name+"</button> ";
			 });
		//the whole dialog layout:
		isNew = ($groupObject.name == "Default")? "<p class=\"text-info\">Choose from the list which diets this group has (below this text)</p><br><div id=\"dietListGroups\">"+dietHTML+"</div><ul id=\"diet-list-groups-number-add\" class=\"list-group\"></ul>":"";
		 data = "<div id=\"dia-content\"><div class=\"input-group\" id=\"nameError\"> <span class=\"input-group-addon\" id=\"name\">Group name</span> <input  type=\"text\" id='groupNewName' class=\"form-control\" placeholder=\"School Group\" aria-describedby=\"name\"></div><div style=\"margin-top:15px;\"><div class=\"input-group\" id='numberError'> <span class=\"input-group-addon\" id=\"name\">Number of Participants</span> <input type=\"number\" class=\"form-control\" id='groupsNumber' placeholder=\"18\" aria-describedby=\"name\"></div></div><div style=\"margin-top:15px;\"><div class=\"input-group\"> <span class=\"input-group-addon\" id=\"name\">Start Date of Programm</span> <input type=\"date\" class=\"form-control\" id='groupsdate' placeholder=\"18\" aria-describedby=\"date\"></div></div>"+isNew+"</div>";
		 //ini the dialog
		 OBAClass.dialog("Add Group",data,function(){
			 //if press OKAY
			 if(typeof $("#groupNewName") != "undefined"){
			 if($("#groupNewName").val().length > 2 && $("#numberError input").val().length != 0){
			 $groupObject.name = $("#groupNewName").val();
			 $("#groupNewName").val("");
			 $groupObject.number = $("#groupsNumber").val();
			 console.log($("#groupsdate").val());
			 $groupObject.date = new Date($("#groupsdate").val()).getTime();
			 $("#groupsNumber").val("");
			 $("#diet-list-groups-number-add ").html("");
						$.post(r.getBaseUrl()+r.getType()+"api/update/update",{data:$groupObject ,type:"Groups"}).done(function(){
									r.requestGroups();
									obj.createGroupList();
									OBAClass.updated();
									obj.newGroup = {diets:[],name:"",number:0}
									$("#ask-dialog").modal("hide");
					$("#nameError").removeClass("has-error");
					$("#numberError").removeClass("has-error");
						});
				}else{
					$("#nameError").addClass("has-error");
					$("#numberError").addClass("has-error");
					}
				}else{
					$("#nameError").addClass("has-error");
					$("#numberError").addClass("has-error");					
					}
			 },"modal-lg");
			/*
			 * check if its a new or end old object
			 **/
			if($groupObject.name != "Default"){
				$("#groupsNumber").val($groupObject.number);
				$("#groupNewName").val($groupObject.name);
				var $d = new Date(parseInt($groupObject.date));
				/**
				 * A string representing a date.
				 * Value: A valid full-date as defined in [RFC 3339], 
				* with the additional qualification that the year component is
				* four or more digits representing a number greater than 0.
				* YYYY-MM-DD
				* */
				var $day = (new String($d.getDate()).length == 1)? "0"+$d.getDate():$d.getDate();
				var $mon = (new String($d.getMonth()).length == 1)? "0"+($d.getMonth()+1):($d.getMonth()+1);
				console.log($d.getFullYear()+"-"+$day+"-"+$mon);
				$("#groupsdate").val($d.getFullYear()+"-"+$mon+"-"+$day);
				}
			/**
			 * Internal Events
			 * AddDiet To group
			 **/
		$(".addDietToGroup").click(function(){
			var $diet = r.getDiets($(this).attr("data-id"));
			$groupObject.diets.push($diet);
			if($("#diet-list-groups-number-add li[data-id='"+$diet.id+"']").length == 0){
				$("#diet-list-groups-number-add").append("<li data-id=\""+$diet.id+"\" class=\"list-group-item\">"+$diet.name+" <span class=\"badge\">1</span></li>");
			}else{
				$("#diet-list-groups-number-add li[data-id='"+$diet.id+"'] .badge").text((parseInt($("#diet-list-groups-number-add li[data-id='"+$diet.id+"'] .badge").text())+1));
				}
			});
					
					}

	/**
	 * ##################
	 * Group Events
	 * #################
	 * 
	 * GROUP DIETS:
	 **/
	 $(" #tickOverviewGroups").on("click",".plus-diet",function(){
			var $index = $(this).attr("data-index");
			var $group = r.getGroups($(this).attr("data-id"));
			
			$group.diets[$index].number = parseInt($group.diets[$index].number) + 1;
			console.log($group.diets[$index].number);
			$.post(r.getBaseUrl()+r.getType()+"api/update/update",{data:$group,type:"Groups"}).done(function(){
									r.requestGroups();
									obj.createGroupList();
									OBAClass.updated();
									$("#ask-dialog").modal("hide");
			});
		  });
	 $(" #tickOverviewGroups").on("click",".minus-diet",function(){
			var $index = $(this).attr("data-index");
			var $group = r.getGroups($(this).attr("data-id"));
			if((parseInt($group.diets[$index].number)-1) != 0){
			$group.diets[$index].number = parseInt($group.diets[$index].number) - 1;
			}else{
				delete $group.diets[$index];
				}
						$.post(r.getBaseUrl()+r.getType()+"api/update/update",{data:$group,type:"Groups"}).done(function(){
									r.requestGroups();
									obj.createGroupList();
									OBAClass.updated();
									$("#ask-dialog").modal("hide");
						});
		  });
		  
	$(" #tickOverviewGroups").on("click",".groupadddiet",function(){
		 var diets = r.getDiets();
		 var gID =$(this).attr("data-id");
		 var dietHTML = "";
		 $.each(diets,function(index,diet){
			 $danger = (diet.danger == true)? "danger":"info";
			 dietHTML += " <button class='addNewDietToGroup btn btn-"+$danger+"' data-group='"+gID+"' data-id='"+diet.id+"'>"+diet.name+"</button> ";
			 });
		OBAClass.dialog("Add Diet","<p class='text-info'>Choose your diet</p>"+dietHTML);
		/**
		 * SAVE DIET IN OBJECT --> IN DB
		 * */
	$(".addNewDietToGroup").click(function(){
		var group = r.getGroups($(this).attr("data-group"));
		var diet = r.getDiets($(this).attr("data-id"));
		$(this).remove();
		group.diets.push(diet);
						$.post(r.getBaseUrl()+r.getType()+"api/update/update",{data:group,type:"Groups"}).done(function(){
									r.requestGroups();
									obj.createGroupList();
									OBAClass.updated();
						});
		});			
		});
	/**
	 * ############################
	 * GROUP WORK: EDIT/DEL/ADD
	 * #############################
	 **/
	 $(" #tickOverviewGroups").on("click",".groupedit",function(){
		 var group = r.getGroups($(this).attr("data-id"));
		 obj.editorGroup(group);

		 });
	 $(" #tickOverviewGroups").on("click",".groupdel",function(){
		 var group = r.getGroups($(this).attr("data-id"));
		 OBAClass.dialog("Remove Group","Do you really want to remove this group? <p class=\"text-danger\">This has influances on the statistics!</p>",function(){
						$.post(r.getBaseUrl()+r.getType()+"api/update/delete",{data:group,type:"Groups"}).done(function(){
									r.requestGroups();
									obj.createGroupList();
									OBAClass.updated();
									$("#ask-dialog").modal("hide");
						});
			 });
		 });
	/**
	 * 
	 * Add a group to the system:
	 * 
	 * */
	 $(" #addGroups").click(function(){
		 obj.editorGroup(obj.newGroup);
		 });

	 /**
	  * ###########################
	  * Events for existing group:
	  * ###########################
	  **/
	 var groupObject = {week:0,mealtime:0};
	$("#groups #tickOverviewGroups").on("click",".addMealTimeToGroupTicks",function(){
			var group = r.getGroups($(this).attr("data-id"));
			/*
			 * #################################
			 * 		Add mealtime to Group
			 * #################################
			 * */
			OBAClass.dialog("Add new Mealtime","<p class=\"text-info\">You want to add a new Mealtime to this group ["+group.name+"]? Then choose out of this drop down a week (of year) and a mealtime.</p> <div class=\"btn-group\" role=\"group\"> <div class=\"btn-group\" role=\"group\"> <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" id=\"weekselector\"> Week of the year <span class=\"caret\"></span> </button> <ul class=\"dropdown-menu\" id=\"weekOfTheYear\"> </ul> </div><div class=\"btn-group\" role=\"group\"> <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" id=\"mealtimeselector\"> Mealtime <span class=\"caret\"></span> </button> <ul class=\"dropdown-menu\" id=\"mealTimeDropDown\"> </ul> </div></div>",function(){
					if(groupObject.week != 0 && groupObject.mealtime != 0){
						if($.isArray(group.ticks)){
							group.ticks = {};
							}
						if(typeof group.ticks[groupObject.mealtime] == "undefined"){
							group.ticks[groupObject.mealtime] = {};
							}
						if(typeof group.ticks[groupObject.mealtime][groupObject.week] == "undefined"){
							group.ticks[groupObject.mealtime][groupObject.week] = [0,0,0,0,0,0,0];
							}
						$.post(r.getBaseUrl()+r.getType()+"api/update/update",{data:group,type:"Groups"}).done(function(){
									r.requestGroups();
									obj.createGroupList();
						});
						//clean
						groupObject = {week:0,mealtime:0}
						OBAClass.updated();
						$("#ask-dialog").modal("hide");
						}else{
							$("#ask-dialog p.text-info").addClass("text-danger");
							}
				});
			/**
			 * Add mealtimes
			 **/
			 $("#mealTimeDropDown").on("click","li a",function(){
				 $("#mealtimeselector").text($(this).text());
				 groupObject.mealtime = $(this).attr("data-id");
				 });
			 $("#weekOfTheYear").on("click","li a",function(){
				 $("#weekselector").text($(this).text());
				 groupObject.week = $(this).attr("data-id");
				 });
			 var mealtimes = r.getMealTimes();
			 $.each(mealtimes,function(mindex,value){
			$("#mealTimeDropDown").append("<li><a href=\"#\"  data-id=\""+value.id+"\">"+value.name+" ("+OBAClass.timeMaker(value.start)+" - "+OBAClass.timeMaker(value.finish)+")</a></li>");
			});
			
			//add week of year:
			var $mons = ["January","Feburary","March","April","May","June","July","August","September","October","November","December"];
			for($x = new Date().getWeekNumber();$x <= 52;$x++){
				var Sun = OBAClass.getDayOfWeek(0,$x);
				Sun = Sun.getDate()+". "+$mons[Sun.getMonth()];
				var Mon = OBAClass.getDayOfWeek(1,$x);
				Mon = Mon.getDate()+". "+$mons[Mon.getMonth()];
				$("#weekOfTheYear").append("<li><a href=\"#\"  data-id=\""+$x+"\">Week "+$x+" ("+Mon+" - "+Sun+")</a></li>");
				}
		   
		}); 
	//remove mealtime
	$("#groups #tickOverviewGroups").on("click",".table .removeMt",function(){
		var $mtID = $(this).attr("data-mtid");
		var $week = $(this).attr("data-week");
		var thistick = r.getGroups($(this).attr("data-id"));
		if(typeof thistick.ticks[$mtID] != "undefined"){
			if(typeof thistick.ticks[$mtID][$week] != "undefined"){
				//now we can erase it
			OBAClass.dialog("Remove Mealtime","Do you really wish to remove this mealtime from this group?",function(){
					delete thistick.ticks[$mtID][$week];
				$.post(r.getBaseUrl()+r.getType()+"api/update/update",{data:thistick,type:"Groups"}).done(function(){
							r.requestGroups();
							obj.createGroupList();
				});	
				$("#ask-dialog").modal("hide");
				OBAClass.updated();
				});
				}
			}
		});
	/**
	 * 
	 * Ticks a Day of a Group
	 * */
	$("#groups #tickOverviewGroups").on("click",".table .tick-group",function(){
		var thistick = r.getGroups($(this).attr("data-id"));
		var week = $(this).attr("data-week");
		var mtID = $(this).attr("data-mealtime");
		var type = $(this).attr("data-type");
		var day = $(this).attr("data-day");
		/**
		 * checking if in array of the index mealtiem ID and week the day exists if not fill in type if yes change
		 *  1 => tick
		 *  0 => not ticked ^^
		 * */
			if(typeof thistick.ticks[mtID][week][day] == "undefined"){
				thistick.ticks[mtID][week][day] = type;
			}else{
				thistick.ticks[mtID][week][day] = type;
				}
			/*
			 * workaround dont have enough time to fix that 1 day left...
			 **/
			if(thistick.ticks[mtID][week].length < 7){
				for($i = thistick.ticks[mtID][week].length;$i <= 7;$i++){
					thistick.ticks[mtID][week][$i] = "0";
					}
				}
			/**
			 * cosmetic
			 * **/
			tickRemoveClassImage = (type == 1)? "glyphicon-remove":"glyphicon-ok";
			type = (type == 0)? 1:0;
			$(this).attr("data-type",type);
			tickAddClassImage = (type == 1)? "glyphicon-remove":"glyphicon-ok";
			$(this).find(".glyphicon").removeClass(tickRemoveClassImage);
			$(this).find(".glyphicon").addClass(tickAddClassImage);
			/*
			 * save
			 * */
			$.post(r.getBaseUrl()+r.getType()+"api/update/update",{data:thistick,type:"Groups"}).done(function(){
						//r.requestGroups();
						//obj.createGroupList();
			});	
		});
	/**
	 * createUserGroupList
	 * 
	 * creates and displays the overview over groups
	 * 
	 * @return void
	 **/
	 this.newGroup = {
		 name:"Default",
		 number:18,
		 diets:[]
		 }
	 this.createUserGroupList = function(){
				var obj = this;
					$("#grouplist").html("");
					$("#dropGroupItems").html("");
					groups = r.getUserGroups();
					$.each(groups,function(index,value){
						$("#dropGroupItems").append("<li><a href=\"#\" data-index='"+index+"'>"+value.name+"</a></li>");
						$("#grouplist").append(" <li class=\"list-group-item\" data-index='"+index+"'><div class=\"btn-group\" role=\"group\"><button class=\"btn btn-sm btn-default gedit\" data-index='"+index+"'><span class=\"glyphicon glyphicon-pencil\"></span></button><button class=\"btn btn-danger btn-sm gdel\" data-index='"+index+"'><span class=\"glyphicon glyphicon-trash\"></span></button></div> "+value.name+"</li>");
						});
	}

	//create new Group
	$("#grouplist").on("click",".gedit",function(){
		$("#createGroupHeader").html("<span class=\"glyphicon glyphicon-pencil\"></span> Edit Team");
		$group = r.getUserGroups();
		$index = $(this).attr("data-index");
		$("#newGroupSave").attr("data-id",$group[$index].id);
		$("#newGroupName").val($group[$index].name);
		});
	//del old group
	$("#grouplist").on("click",".gdel",function(){
		$group = r.getUserGroups();
		$index = $(this).attr("data-index");
		if($group[$index].id == 1){
			new OBA().dialog("Errer:Remove Group","You cannot delete the Default Group",function(){
				$("#ask-dialog").modal("hide");
				});
			}else{
				new OBA().dialog("Remove Group",OBAClass.getHelptext(4,"helptext_dddgel"),function(){
					$.post(r.getBaseUrl()+r.getType()+"api/update/delete",{data:$group[$index],type:"Group"}).done(function(){
						r.requestUserGroups();
						obj.createUserGroupList();
						});	
						$("#ask-dialog").modal("hide");				
					});
			}
		});
	$("#newGroupClean").click(function(){
		$("#newGroupName").val("");
		});
	$("#newGroupSave").click(function(){
		if($("#newGroupName").val().length >= 2){
		$("#createGroupHeader").html("<span class=\"glyphicon glyphicon-plus\"></span>Create new Group");
			if(typeof $(this).attr("data-id") != undefined){
			group = {name:$("#newGroupName").val(),id:$(this).attr("data-id")}
			$(this).removeAttr("data-id"); 
			}else{
				group = {name:$("#newGroupName").val()}
				}
			$("#newGroupName").val("");
			$.post(r.getBaseUrl()+r.getType()+"api/update/update",{data:group,type:"Group"}).done(function(){
				r.requestUserGroups();
				});
			}else{
				new OBA().dialog("Remove Group",OBAClass.getHelptext(4,"helptext_group_2l"));
				}
		});
	/**
	 * createUserList
	 * 
	 * creates and displays the overview over users backend
	 * 
	 * @return void
	 **/
	this.createUserList = function(){
				var obj = this;
				$users = r.getUsers();
				$("#usertable").html("");
				$("#userremovetable").html("");
				role = ["User","Manager","Admin"];
				$.each($users,function(index,value){
						html = "<h3><button id=\"usertogglebyGroup_"+value[0].group.id+"\" class='btn btn-sm btn-primary' data-toggle='#group_"+value[0].group.id+"'><span class='glyphicon glyphicon-menu-down'></span></button> "+value[0].group.name+"</h3><table class='table hidden' id='group_"+value[0].group.id+"'><tr><th>Name</th><th>Surname</th><th>E-Mail</th><th>Role</th><th>Dietaries</th><th>Option</th></tr></table>";
						htmlRemoved = "<h3><button id=\"rmusertogglebyGroup_"+value[0].group.id+"\" class='btn btn-sm btn-primary' data-toggle='#group_removed_"+value[0].group.id+"'><span class='glyphicon glyphicon-menu-down'></span></button> Removed User of Team "+value[0].group.name+"</h3><table class='table hidden' id='group_removed_"+value[0].group.id+"'><tr><th>Name</th><th>Surname</th><th>E-Mail</th><th>Role</th><th>Dietaries</th><th>Option</th></tr></table>";
						$("#usertable").append(html);
						$("#userremovetable").append(htmlRemoved)
						$.each(value,function(ind,val){
							if(val.email == ""){
								val.email = val.name+new String(val.surnamename).slice(0,1)+OBAdata.mail;
								}
								$diets = "";
							if(val.dietaries.length >= 1){
							$.each(val.dietaries,function(i,diet){
								$class = (diet.danger == true)? "label-danger":"label-info";
								$diets += " <span class=\"label "+$class+"\" data-toggle=\"popover\" title=\""+diet.name+"\" data-content=\""+diet.description+"\" >"+diet.name+" </span>";
								});
							}else{
								$diets = "<span class=\"label label-default\">None</span>";
								}
							roleDisplay = role[val.role];
							if(val.removed == false){
								$btn = (val.id != 0)? "<button class=\"btn btn-default uedit\" data-id='"+val.id+"'><span class=\"glyphicon glyphicon-pencil\"></span></button><button class=\"btn btn-danger udel\" data-id='"+val.id+"'><span class=\"glyphicon glyphicon-trash\"></span></button>":"";
							$("#usertable #group_"+value[0].group.id).append("<tr><td>"+val.name+"</td><td>"+val.surname+"</td><td>"+val.email+"</td><td>"+roleDisplay+"</td><td>"+$diets+"</td><td><div class=\"btn-group\" role=\"group\">"+$btn+"</div></td></tr>");
							}else{
								$("#userremovetable #group_removed_"+value[0].group.id).append("<tr><td>"+val.name+"</td><td>"+val.surname+"</td><td>"+val.email+"</td><td>"+roleDisplay+"</td><td>"+$diets+"</td><td><div class=\"btn-group\" role=\"group\"><button class=\"btn btn-success ure\" data-id='"+val.id+"'><span class=\"glyphicon glyphicon-repeat\"></span></button></div></td></tr>");
							}
							});
						$("#usertogglebyGroup_"+value[0].group.id).click(function(){
							OBAClass.toggle(this);
							});
							$("#rmusertogglebyGroup_"+value[0].group.id).click(function(){
							OBAClass.toggle(this);
							});
					});
				
				$('[data-toggle="popover"]').popover()
		}
	/**
	 * EVENTS:
	 * Backend User options:
	 * Edit,Remove,Re-Remove,Delete Diet from User
	 * if I had time I would have ... no
	 **/
	/* Re delete Delete*/
	$("#userremovetable ").on("click",".ure",function(){
		$user = r.getUsers($(this).attr("data-id"));
			$user.removed = false;
					$.post(r.getBaseUrl()+r.getType()+"api/update/update",{data:$user,type:"User"}).done(function(){
						r.requestUsers();
						obj.createUserList();			
					});
		});
	/* User Delete*/
	$("#usertable").on("click",".udel",function(){
		$user = r.getUsers($(this).attr("data-id"));
		new OBA().dialog("Delete User",OBAClass.getHelptext(4,"helptext_udel"),function(){
			$user.removed = true;
					$.post(r.getBaseUrl()+r.getType()+"api/update/update",{data:$user,type:"User"}).done(function(){
						r.requestUsers();
						obj.createUserList();		
					});
					$("#ask-dialog").modal("hide");		
			});
		});
	//edit diets delete
	$("#dietListnewUser").on("click",".user-diet",function(){
		var id = $(this).attr("data-id");
		var $diets = obj.newUser.dietaries;
		obj.newUser.dietaries = [];
		$.each($diets,function(index,diet){
			if(diet.id != id){
				obj.newUser.dietaries.push(diet);
				}
			});
		$(this).remove();
		});
	/**
	 * 
	 * Edit user
	 * 
	 * */
	$("#usertable").on("click",".uedit",function(){
		$("#userOverviewNew").html('<span class="glyphicon glyphicon-pencil"></span> Edit User');
		$(".tab-pane").removeClass("active");
		$("#userTabNav").removeClass("active");
		$("#addNewUserTab").addClass("active");
		$("#newuser").addClass("active");
		$("#dietListnewUser").html("");
		$("#isAdmin").prop("checked",false);
		$("#isManager").prop("checked",false);
		r.requestDiets();
		r.requestUserGroups();
		$user = r.getUsers($(this).attr("data-id"));
		obj.edit = true;
		obj.newUser = $user;
		$("#newUserName").val($user.name);
		$("#newUserSurname").val($user.surname);
		$("#newUserEmail").val($user.email);
		if($user.role == 1){
			$("#isManager").prop("checked",true);
			}else if($user.role == 2){
			$("#isAdmin").prop("checked",true);
			}
			$.each($user.dietaries,function(i,diet){
				$class = (diet.danger == true)? "label-danger":"label-info";
				$("#dietListnewUser").append(" <span data-id=\""+diet.id+"\" class=\" user-diet label "+$class+"\">"+diet.name+" <span class=\"glyphicon glyphicon-remove\"></span></span>");
			});
		$("#dropGroup").html($user.group.name+" <span class=\"caret\"></span>");
		});
	/**#####################
	 *     Add new Users
	 * #####################
	 **/
		//add new user
	this.newUser = {
		dietaries:[],
		group: null,
		name:"",
		email:"",
		password:"",
		role: false,
		}
		/**
		 * Dropdown choose group for user
		 * */
		$("#dropGroupItems").on("click"," a",function(){
			$group = r.getUserGroups();
			obj.newUser.group = $group[$(this).attr("data-index")];
		$("#dropGroup").html(obj.newUser.group.name+" <span class=\"caret\"></span>");
		});
		/**
		 * check if its admin
		 **/
		$("#isAdmin").click(function(){
			if($("#Password").val().length >= 4  && $("#Password2").val().length >= 4 && $("#Password").val() == $("#Password2").val()){
				obj.newUser.role = 	$("#isAdmin").prop("checked");
				}else{
						$("#isAdmin").prop("checked",false);
					}
		});
		/**
		 * Add diet to user diets!
		 **/	
	$("#dropDietsItems").on("click"," a",function(){
		$diet = r.getDiets();
		okay = true;
		$index = $(this).attr("data-index");
		$.each(obj.newUser.dietaries,function(index,val){
				if(val.id == $diet[$index].id)
				{	okay = false;
					return false;
				}
			});
		if(okay == true){
		obj.newUser.dietaries.push($diet[$index]);
		diet = $diet[$index];
		$class = (diet.danger == true)? "label-danger":"label-info";
		$("#dietListnewUser").append(" <span  data-id=\""+diet.id+"\" class=\"label user-diet "+$class+"\">"+diet.name+" <span class=\"glyphicon glyphicon-remove\"></span></span>");
		}
		});
	/**
	 * If diet does not exists adds new diet!
	 * */
	$("#addNewdietUser").click(function(){
		if($("#dietNameNewUser").val().langh != 0){
				$name = $("#dietNameNewUser").val();
				$isLt = $("#isDangerNew").prop("checked");
				$("#isDangerNew").prop("checked",false);
				$("dietNameNewUser").val("");
				obj.newUser.dietaries.push({name:$name,danger:$isLt});
				$class = ($isLt == true)? "label-danger":"label-info";
				$("#dietListnewUser").append(" <span class=\"label"+$class+"\">"+$name+"</span>");
			}else{
				alert("Diet must have a name!");
				}
		})
	$("#saveNewUser").click(function(){
		if(obj.newUser.group != null){
		obj.newUser.name = $("#newUserName").val();
		obj.newUser.surname = $("#newUserSurname").val();
		obj.newUser.email = $("#newUserEmail").val();
		if(obj.edit == false){
			if($("#Password").val().length >= 4  && $("#Password2").val().length >= 4 && $("#Password").val() == $("#Password2").val()){
				obj.newUser.password = $("#Password").val();
					var role = 0;
					if( $("#isAdmin").prop("checked") == true){
						role = 2;
						}else if ( $("#isManager").prop("checked") == true){
							role = 1;
							}
				 obj.newUser.role = role;
				 $("#isAdmin").prop("checked",false);
				}else if($("#isAdmin").prop("checked") == true){
					new OBA().dialog("Error",OBAClass.getHelptext(4,"helptext_password"));
						$("#isAdmin").prop("checked",false);
						return false;
					}
			}else if($("#isAdmin").prop("checked") != obj.newUser.role || $("#isManager").prop("checked") != obj.newUser.role){
					var role = 0;
					if( $("#isAdmin").prop("checked") == true){
						role = 2;
						}else if ( $("#isManager").prop("checked") == true){
							role = 1;
							}
					obj.newUser.role = role;
					//check password:
					if($("#Password").val().length >= 4  && $("#Password2").val().length >= 4 && $("#Password").val() == $("#Password2").val()){
						obj.newUser.password = $("#Password").val();
					}else{
						new OBA().dialog("Error",OBAClass.getHelptext(4,"helptext_password"));
						}
				}
		if(obj.newUser.email.length > 0 && obj.newUser.name.length > 0 && obj.newUser.surname.length > 0){
		$.post(r.getBaseUrl()+r.getType()+"api/update/update",{data:obj.newUser,type:"User"}).done(function(gotback){
				r.requestUsers();
				obj.createUserList();
				//clean page:
				gotback = $.parseJSON(gotback);
				if(gotback == true){
					obj.clean();//cleans
					new OBA().dialog("Success",OBAClass.getHelptext(4,"helptext_usersaved"))
				}else{
					$("#warning").text(OBAClass.getHelptext(4,"helptext_usererroremail"));
					$("#warning").removeClass("hidden");
					}
				});
			}else{
				new OBA().dialog("Error",OBAClass.getHelptext(4,"helptext_newusererror"));
				}
			}else{
				new OBA().dialog("Error",OBAClass.getHelptext(4,"helptext_newuser_group"));
				}
		});
	this.clean = function(){
				obj.newUser = {
				dietaries:[],
				group: null,
				name:"",
				email:"",
				password:null,
				role: false,
				}
				$("#dietNameNewUser").val("");
				$("#dietListnewUser").html("");
				$("#Password2").html("");
				$("#warning").addClass("hidden");
				$("#Password").html("");
				$("#newUserName").val("");
				$("#newUserEmail").val("");
				$("#newUserSurname").val("");
				$("#Password").val("");
				$("#Password2").val("");
				$("#isAdmin").prop("checked",false);
				$("#isManager").prop("checked",false);
								$("#dropGroup").html("Choose Team <span class=\"caret\"></span>");	
				if(this.edit == true){
					this.edit = false;
					$("#userOverviewNew").html('<span class="glyphicon glyphicon-plus"></span> Add new User');
					$(".tab-pane").removeClass("active");
					$("#users").addClass("active");
					}	
		}

	}
