
Mealplanner = function(){
	var obj = this;
	  this.requests = {
		  limit:1000, //"timeout" limit for interval
		  interval:10 //frequent
		  };
	/**
	 * ###############################
	 * 				Evenets
	 * ###############################
	 **/
	 this.editmeal = {}
	/**
	 * 
	 * #####################
	 * 			Meal
	 * #####################
	 **/
	$("#cleanMeal").click(function(){
		obj.editmeal = {};
		$("#mealname").val("");
		});
	$("#mealsave").click(function(){
			if($("#mealname").val().length >= 3){
				meal = obj.editmeal;
				meal.name = $("#mealname").val();
				$("#mealname").val("");
				$.post(r.getBaseUrl()+OBAdata.type+"api/update/update",{data:meal,type:"Meal"}).done(function(gotback){
					OBAClass.updated();
					r.requestMeals();
					});
			}else{
				new OBA().dialog("Error",OBAClass.getHelptext(1,"helptext_msletters"));
				}
		});
		$("#mealList").on("click",".mealedit",function(){
			$meal = r.getMeals($(this).attr("data-id"));
			$("#mealname").val($meal.name);
			obj.editmeal = $meal;
		});
		$("#mealList").on("click",".mealdel",function(){
			$meal = r.getMeals($(this).attr("data-id"));
			new OBA().dialog("Remove Meal",OBAClass.getHelptext(1,"helptext_mdelmsg"),function(){
			$.post(r.getBaseUrl()+OBAdata.type+"api/update/delete",{data:$meal,type:"Meal"}).done(function(gotback){
				OBAClass.updated();
					r.requestMeals();
					});
				$("#ask-dialog").modal("hide");
				});
		});
	/**
	 * 
	 * #####################
	 * 	     Mealtime
	 * #####################
	 **/
	this.mealtime = {}
	$("#cleanMealtime").click(function(){
		obj.mealtime = {};
		$("#mealtimename").val("");
		$("#startTime").val("");
		$("#finishTime").val("");
		$("#isPackable").prop("checked",false);
		$("#isTax").prop("checked",false);
		$("#editMealTimeHeader").html('<span class="glyphicon glyphicon glyphicon-list-alt"></span> Add new mealtime');
		});
	//del
	$("#mealtimesList").on("click",".mealtimedel",function(){
		obj.mealtime = r.getMealTimes($(this).attr("data-id"));
		new OBA().dialog("Remove Mealtime",OBAClass.getHelptext(1,"helptext_mtdelmsg"),function(){
			$.post(r.getBaseUrl()+OBAdata.type+"api/update/delete",{data:obj.mealtime,type:"Mealtimes"}).done(function(gotback){
					r.requestMealTimes();
					$("#ask-dialog").modal("hide");
					});
			});
		});
	/**
	 * 
	 * Edit mealtime
	 * 
	 * */
	$("#mealtimesList").on("click",".mealtimedit",function(){
		obj.mealtime = r.getMealTimes($(this).attr("data-id"));
		 $("#mealtimename").val(obj.mealtime.name);
		 $("#startTime").val(new OBA().timeMaker(obj.mealtime.start));
		 $("#finishTime").val(new OBA().timeMaker(obj.mealtime.finish));
		 $("#isPackable").prop("checked",obj.mealtime.packable);
		 $("#isTax").prop("checked",obj.mealtime.tax);
		 $("#editMealTimeHeader").html('<span class="glyphicon glyphicon glyphicon-list-alt"></span> Edit mealtime');
		});
	$("#saveMealtime").click(function(){
		var $name = $("#mealtimename").val();
		var $start = $("#startTime").val();
		var $finish = $("#finishTime").val();
		var $packable = $("#isPackable").prop("checked");
		var $tax = $("#isTax").prop("checked");
		if($name.length >= 3 && $start.length == 5 && $finish.length == 5){
			$("#isPackable").prop("checked",false);
			$("#isTax").prop("checked",false);
			$("#nameTime").val("");
			$("#mealtimename").val("");
			$("#startTime").val("");
			$("#finishTime").val("");
				obj.mealtime.name = $name;
				obj.mealtime.packable = $packable;
				obj.mealtime.tax = $tax
				//dealing with time
				$start = $start.replace(":","");		
				$finish = $finish.replace(":","");		 
				obj.mealtime.start = parseInt($start);
				obj.mealtime.finish = parseInt($finish);
			$.post(r.getBaseUrl()+OBAdata.type+"api/update/update",{data:obj.mealtime,type:"Mealtimes"}).done(function(gotback){
					OBAClass.loadMts = false;
					OBAClass.updated();
					r.requestMealTimes();
					 $("#editMealTimeHeader").html('<span class="glyphicon glyphicon glyphicon-list-alt"></span> Add new mealtime');
					});
			}else{
				new OBA().dialog("Error",OBAClass.getHelptext(1,"helptext_mtsletters"));
				}
		});
		/**
		 * #################
		 *  mealplan creator
		 * #################
		 **/
	$("#cleanMealplans").click(function(){
				$("#added_mealtimes").html("");
				$("#mealplanname").val("");
				r.requestMealPlans();
		});

			/*
			 * Change mealplanner order
			 * If you have a  new number 0 it will change the activation time to the current date.
			 **/
			$("#mealplansList").sortable({ update:function(){
				$.each($("#mealplansList li").sortable().toArray(),function(index,value){
					$mealplan = r.getMealPlans($(value).attr("data-id"));
					if($mealplan.sort != index){//only a update request if there is a change
					$mealplan.sort = index;
					if(index == 0){
						//now we have to change the span which says active to This is Active
						$("#mealplansList li").find(".badge").text("Active");
						$(this).find(".badge").text("Active this week");
						}
					$.post(r.getBaseUrl()+OBAdata.type+"api/update/order",{data:$mealplan}).done(function(gotback){
						OBAClass.updated();
						});
					}
					});
				}});
			//del mealplan
			$(".mps").on("click",".mealplandel",function(){
				$mealplan = r.getMealPlans($(this).attr("data-id"));
				OBAClass.dialog("Delete Mealplanner",OBAClass.getHelptext(1,"helptext_mpdelmsg"),function(){
				$.post(r.getBaseUrl()+OBAdata.type+"api/update/delete",{data:$mealplan,type:"Mealplanner"}).done(function(gotback){
						r.requestMealTimes();
						r.requestMealPlans();
						OBAClass.updated();
						$("#ask-dialog").modal("hide");
						});
					});//ende dialog
				});
			//mealplan inactive/active
			$(".mps").on("click",".mealplanactive",function(){
				var $id = $(this).attr("data-id");
				$mealplan = r.getMealPlans($id);
				if($mealplan.active == false){
				$mealplan.active = true;
				$mealplan.sort = r.getActiveMealPlans().length;
				}else{
					$mealplan.active = false;
					}
				$.post(r.getBaseUrl()+OBAdata.type+"api/update/update",{data:$mealplan,type:"Mealplanner"}).done(function(gotback){
						r.requestMealTimes();
						r.requestMealPlans();
						OBAClass.updated();
						if($mealplan.active == true){
							$(".list-group-item span.badge").text("Active");
							$(".list-group-item[data-id='"+$id+"'").find(".badge").text("Active this week");
						}
					});//ende dialog
				});
			/**
			 * 
			 * ####################
			 *   Save Mealplanner
			 * ####################
			 * 
			 ***/
			$("#mealplansave").click(function(){
				if(obj.mealplan.mealtimes.length >= 1 ){
				if($("#mealplanname").val().length > 2){
				obj.mealplan.name = $("#mealplanname").val();
				$("#added_mealtimes").html("");
				$("#mealplanname").val("");
				//send to api
				$.post(r.getBaseUrl()+OBAdata.type+"api/update/update",{data:obj.mealplan,type:"Mealplanner"}).done(function(gotback){
						r.requestMealTimes();
						r.requestMealPlans();
						OBAClass.updated();
						obj.mealplan = {
							mealtimes:[],
							}
						if($("#added_mealtimes").children().length == 0){
							$("#added_mealtimes").html("<p id=\"mtempty\" class='text-info text-center'>"+OBAClass.getHelptext(1,"helptext_emptymealtime")+"</p>");
							}
						});
				}else{
					new OBA().dialog("Error..",OBAClass.getHelptext(1,"helptext_mpname2l"));
					}
				}else{
					new OBA().dialog("Error..",OBAClass.getHelptext(1,"helptext_mpnomt"));
					}
				});
		/**
		 * #############################
		 *   Add Mealtime to mealplan
		 * #############################
		 **/
		$("#mealtimesAddMealplan").on("click","a",function(){
				$("#mtempty").remove();
				var $mtID = $(this).attr("data-id");
				var $mealtime = r.getMealTimes($mtID);
				$mealtime.meals = [];
				notInArray = true;
				$.each(obj.mealplan.mealtimes,function(index,mt){
						if(mt.id == $mtID){
							notInArray = false;
							return false;
							}
					});
				if(notInArray == true){
				console.log("Add new mealtime");
				obj.mealplan.mealtimes.push($mealtime);
				var mtimesIndex = obj.mealplan.mealtimes.length-1;
				obj.buildEditor($mealtime,mtimesIndex);
				}else{
					new OBA().dialog("Error..",OBAClass.getHelptext(1,"helptext_add2mt"),function(){
						$("#ask-dialog").modal("hide");
						});
					}
			});
			/**
			 * ########################
			 *     Edit Mealplanner
			 * ########################
			 **/
			$(".mps").on("click",".mealplandit",function(){
				$id = $(this).attr("data-id");
				/**
				 * Load mealplan from mealplan Object
				 **/
				var mp = r.getMealPlans($id);
				obj.mealplan = mp;
				//set basic data:
				$("#mealplanname").val(mp.name);
				//build meal select:;
				$("#added_mealtimes").html("");
				$.each(obj.mealplan.mealtimes,function(index,$mealtime){
					pack = ($mealtime.packable == true)? " <span class=\"label label-info pull-right\">Packable</span> ":"";
					obj.buildEditor($mealtime,index);
					});
				if($("#added_mealtimes").children().length == 0){
					$("#added_mealtimes").html("<p id=\"mtempty\" class='text-info text-center'>"+OBAClass.getHelptext(1,"helptext_emptymealtime")+"</p>");
					}
				});
			/*
			 * ##################################################################
			 * 						REMOVE MEALTIME
			 * 						 FROM MEALPLAN
			 * ##################################################################
			 **/
			$("#added_mealtimes").on("click",".mtdelfmp",function(){
				var mtID = $(this).attr("data-id");
				var mealtimes  = obj.mealplan.mealtimes;
				obj.mealplan.mealtimes = [];
					$.each(mealtimes,function(index,value){
						if(value.id != mtID){
							console.log(value);
							obj.mealplan.mealtimes.push(value);
							}else{
								$("#id_mt_"+mtID).remove();
								}
					});
				});
/*
 * ########################################################################################################################################################
 * 																Methodes
 * ########################################################################################################################################################
 **/
	/**
	 * @methode buildEditor
	 * @param object $mealtime
	 * @param int mtimesIndex
	 * Which is the the mealtiem index
	 **/
	this.buildEditor = function($mealtime,mtimesIndex){
			be = this;
			var $id = $mealtime.id;
				this.addMeal = function(meal,mID){
						$day = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
						$dayname = $day[$( "#added_mealtimes  #mealList_added_"+mID+" li").length];
						$( "#added_mealtimes  #mealList_added_"+mID).append("<li  class='list-group-item meal-item' data-id='"+meal.id+"'><span data-id='"+meal.id+"' class='glyphicon glyphicon glyphicon-remove pull-right'></span><strong class='dayName''>"+$dayname+"</strong> "+meal.name+" <br><input type='checkbox' class=\"repeat\" data-id='"+meal.id+"'> repeat</li>");	
						$("#added_mealtimes #mealList_added_"+$id+" .repeat[data-id='"+meal.id+"']").prop("checked",meal.repeats);	
					}					
				$meals = r.getMeals();
				pack = ($mealtime.packable == true)? " <span class=\"label label-info pull-right\">Packable</span> ":"";
				$("#added_mealtimes").append("<div class=\panel panel-default\" id='id_mt_"+$id+"'><div class='panel-heading'><button class='btn btn-default btn-sm mtdelfmp' type='button' data-id='"+$id+"'><span class='glyphicon glyphicon glyphicon-remove'></span></button> <strong>"+$mealtime.name+" <span class=\"label label-default pull-right\">"+new OBA().timeMaker($mealtime.start)+" - "+new OBA().timeMaker($mealtime.finish)+"</span> "+pack+"</strong></div><!-- /panel-heading --><div class='panel-body addMealstoMealtime'><!-- Single button --><div class=\"btn-group\"><button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">Add Meal <span class=\"caret\"></span></button><ul class=\"dropdown-menu\" id=\"mealList_"+$id+"\"></ul></div><!-- end button --><p class=\"text-info\"><span class='glyphicon glyphicon-info-sign'></span> "+OBAClass.getHelptext(1,"helptext_clickonmealtoadd")+"</p><p class=\"text-info\"><span class='glyphicon glyphicon-info-sign'></span>"+OBAClass.getHelptext(1,"helptext_clickonmealtoremove")+"</p><hr><ul id=\"mealList_added_"+$id+"\" style='height:100px;border:1px;' class=\"list-group\"></ul><hr></div><!-- panel --></div><!-- mealtime -->");
				/**
				 * Adds meal to the meal dropdown button:
				 * */
				$.each($meals,function(index,meal){
				$("#added_mealtimes #mealList_"+$id).append("<li data-id="+meal.id+"><a href=\"#id_mt_"+$id+"\">"+meal.name+"</a></li>");
				});
				/**
				 * Add Meals to the mealList which are in the selectet mealplan!
				 **/
				$.each(obj.mealplan.mealtimes[mtimesIndex].meals,function(index,meal){
						be.addMeal(meal,$mealtime.id);
					});
				/**
				 * #######################################################################################################################
				 * 													  EVENTs
				 * #######################################################################################################################
				 **/
				//add a new mealtime meal!:
				$( "#added_mealtimes  #mealList_"+$id+" li").click(function(){
					if($( "#added_mealtimes  #mealList_added_"+$id+" li").length < 7){
						var meal = r.getMeals($(this).attr("data-id"));
						console.log(obj.mealplan.mealtimes[mtimesIndex]);
						console.log(meal);
						obj.mealplan.mealtimes[mtimesIndex].meals.push(meal);
						be.addMeal(meal,$mealtime.id);
						console.log("Mealtime:"),
						console.log(obj.mealplan.mealtimes[mtimesIndex]);
						console.log("Meal:"+meal.name);
					}else{
						alert("A week has only 7 days...");
						}
					});
				//remove a meal from the meal planner:
				$("#added_mealtimes  #mealList_added_"+$id).on("click",".meal-item .glyphicon-remove",function(){
						var mid = $(this).attr("data-id");
						console.log("MEALs before:");
						var mArray = obj.mealplan.mealtimes[mtimesIndex].meals;
						console.log(mArray);
						//reset mealplanner::mealtimes::meals to make sure that it only contains the meals we want..
						obj.mealplan.mealtimes[mtimesIndex].meals = [];
						$("#added_mealtimes  #mealList_added_"+$id).html("");
						$.each(mArray,function(index,meal){
								if(meal.id != mid){
									obj.mealplan.mealtimes[mtimesIndex].meals.push(meal);
									be.addMeal(meal,$mealtime.id);
									}
							});
						console.log(obj.mealplan.mealtimes[mtimesIndex].meals);
					});
					//change order
				$( "#added_mealtimes  #mealList_added_"+$id).sortable({update:function(){
					OBAClass.log("Change order of meals");
					var $array = $("#added_mealtimes  #mealList_added_"+$id+" li").sortable().toArray();
					console.log("Old oder");
					console.log(obj.mealplan.mealtimes[mtimesIndex].meals);
					obj.mealplan.mealtimes[mtimesIndex].meals = [];
					$.each($array,function(index,value){
								//change meals
								var $meal = r.getMeals($(value).attr("data-id"));
								$meal.repeats = $(value).find(".repeat").prop("checked");
								obj.mealplan.mealtimes[mtimesIndex].meals.push($meal);
								console.log(obj.mealplan.mealtimes[mtimesIndex]);
								var $day = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
								$(value).find("strong").text($day[index]);
						});
					console.log("new order");
					console.log(obj.mealplan.mealtimes[mtimesIndex].meals);
					}});
				//change a meal to repeat!
				$("#added_mealtimes  #mealList_added_"+$id+"").on("click",".repeat",function(){
					var $mID = $(this).attr("data-id");
					$("#added_mealtimes  #mealList_added_"+$id+" .repeat").prop("checked",false);
					var $meal = r.getMeals($mID);
					if($meal.repeats == false){
					$(this).prop("checked",true);
					$meal.repeats = true;
					}else{
						$meal.repeats = false;
						}
					$.each(obj.mealplan.mealtimes[mtimesIndex].meals,function(index,val){
							if(val.id == $mID){
								obj.mealplan.mealtimes[mtimesIndex].meals[index] = $meal;
							}else{
								obj.mealplan.mealtimes[mtimesIndex].meals[index].repeats = false;
								}
						});
					});		
		}
	/**
	 * createMealList
	 * 
	 * displays the mealList
	 * 
	 * @return void
	 **/
	this.createMealList = function(){

				$("#mealList").html("");
				meals = r.getMeals();
				$.each(meals,function(index,meal){
					$points = meal.points;
					if(typeof $points != "undefined" && $points.length >= 1){
						sum = $points.length;
					}else{
						sum = 0;
					}
					$("#mealList").append('<li class="list-group-item"><div class="btn-group" role="group" ><button type="button" class="btn btn-sm btn-default mealedit" data-id="'+meal.id+'"><span class="glyphicon glyphicon-pencil"></span></button><button type="button" class="btn btn-danger mealdel btn-sm" data-id="'+meal.id+'"><span class="glyphicon glyphicon-trash"></span></button></div> '+meal.name+' <span class="badge"><span class="glyphicon glyphicon-heart"></span> '+sum+'</span></li>');
					})
	}
	/**
	 * createMealList
	 * 
	 * displays the mealList
	 * 
	 * @return void
	 **/
	this.createMealTimesList = function(){
				$("#mealtimesList").html("");
				mealtimes = r.getMealTimes();
				$.each(mealtimes,function(index,value){
					packable = (value.packable == true)? "<span class=\"label label-info\">Packable</span>":"";
					tax = (value.tax == true)? "<span class=\"label label-success\">Has FTB</span>":"";
					$("#mealtimesList").append('<li class="list-group-item"><div class="btn-group" role="group" ><button type="button" class="btn btn-sm btn-default mealtimedit" data-id="'+value.id+'"><span class="glyphicon glyphicon-pencil"></span></button><button type="button" class="btn btn-danger mealtimedel btn-sm" data-id="'+value.id+'"><span class="glyphicon glyphicon-trash"></span></button></div> '+value.name+' '+tax+' '+packable+' <span class="badge"><span class="glyphicon glyphicon-star"></span> '+new OBA().timeMaker(value.start)+' - '+new OBA().timeMaker(value.finish)+'</span></li>');
					})
	}
	/**
	 * createPlanList
	 * 
	 * displays the mealList
	 * 
	 * @return void
	 **/
	 //sortable
	this.mealplan = {mealtimes:[]}
	this.createMealPlansList = function(){
			/**
			* set an interval because of the async of AJAX Requests
			* LIMIT is with 10000 loops;
			* 
			* need 3 trigger mealplan mealtime meals
			**/
				$("#mealplansList").html("");
				$("#mealplansListInactive").html("")
				mealplans = r.getMealPlans();
				$.each(mealplans,function(index,value){
					active = (value.active == true)? "Active":"Inactive";
					$where = (value.active == true)? "#mealplansList":"#mealplansListInactive";
					activeThisWeek = (parseInt(value.activationTime) == new Date().getWeekNumber())? " this week":"";
					
					$($where).append('<li class="list-group-item"  data-id="'+value.id+'" ><div class="btn-group" role="group"><button type="button" class="btn btn-sm btn-default mealplandit" data-id="'+value.id+'"><span class="glyphicon glyphicon-pencil"></span></button><button type="button" class="btn btn-danger mealplandel btn-sm" data-id="'+value.id+'"><span class="glyphicon glyphicon-trash"></span></button><button type="button" class="btn btn-sm btn-warning mealplanactive" data-id="'+value.id+'"><span class="glyphicon glyphicon-star"></span></button></div> '+value.name+' <span class="badge">'+active+''+activeThisWeek+'</span></li>');
					});
				if($("#mealplansList").children().length == 0){
					$("#mealplansList").html("<li class=\"list-group-item\"><p class='text-info text-center'>"+OBAClass.getHelptext(1,"helptext_nompactive")+"</p></li>");
					}
				if($("#mealplansListInactive").children().length == 0){
					$("#mealplansListInactive").html("<li class=\"list-group-item\"><p class='text-info text-center'>"+OBAClass.getHelptext(1,"helptext_nompinactive")+"</p></li>");
					}
				//add Mealtimes to edit/add list:
				$("#mealtimesAddMealplan").html("");
				$.each(r.getMealTimes(),function(index,val){
					packable = (val.packable == true)? "<span class=\"label label-info\">Packable</span>":"";
					$("#mealtimesAddMealplan").append(" <li><a href=\"#id_mt_"+val.id+"\" data-id=\""+val.id+"\">"+val.name+" "+packable+" <span class=\"label label-default\">"+new OBA().timeMaker(val.start)+" - "+new OBA().timeMaker(val.finish)+"</span></a></li>");
					});
		}
}
