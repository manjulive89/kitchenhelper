/*
 * @file signoffsheet.js
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
 * 
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0 
 * 
 */
 
Signoffsheet = function(){
	    var obj = this;
		this.thisweek = new Date().getWeekNumber();
		this.week = new Date().getWeekNumber();
		this.day = new Date().getDay();
		this.month = new Date().getMonth()+1;
		this.ticks = {};
		this.userticks = null;
			OBAClass.loader("#mealtimes");
			OBAClass.loader("#dietaries");
			OBAClass.loader("#mealtimes-tb");
		this.setExportDate = function(){
			$(".export_pdf").attr("href",OBAdata.exportPDF+"week/sheet_"+this.week+".pdf");
			$(".export_pdf_month").attr("href",OBAdata.exportPDF+"month/sheet_"+this.month+".pdf");
			$(".export_excel").attr("href",OBAdata.exportExcel+"week/sheet_"+this.week+".xls");
			$(".export_excel_month").attr("href",OBAdata.exportExcel+"month/sheet_"+this.month+".xls");
		}
		//ini:
		this.setExportDate();
		this.getDay = function(){
			return OBAClass.day;
			}
		this.getWeek = function(){
			return OBAClass.week;
			}
		this.getMonth = function(){
			return OBAClass.month;
			}
		/**
		 * Backwards in time a day
		 **/
		$("#backintime").click(function(){
			if(obj.day == 0){
				//we have to use plus now:
				if( (obj.day+1) < 7){
					obj.day = 6;
					}else if(obj.week - 1 > 0){
						obj.day = 0;
						obj.week--;
						
						OBAClass.day = obj.day;
						OBAClass.week = obj.week;
						obj.weekly();
						}else{
							new OBA().dialog("Time Error","You cannot go further in time in the daiely overview");
							}
				}else if(obj.day-1 >= 1){
				obj.day = obj.day-1;
				}else{
					//go back in Week:
					if(obj.week - 1 > 0){
							obj.day = 0;
							obj.week = obj.week -1
							OBAClass.day = obj.day;
							OBAClass.week = obj.week;
							
							d.displayGroupsToday();
							obj.weekly();
						}else{
							new OBA().dialog("Time Error","You cannot go further in time in the daiely overview");
							}
					}
			d.displayGroupsToday();
			obj.daily();
			});
		/**
		 * Backwards in time a week
		 **/
		$("#backintimeweek").click(function(){
			if(obj.week-1 > 0){
			obj.week = obj.week-1;
			obj.day = 0;//set always on Monday!
			obj.weekly();
			}else{d
				new OBA().dialog("Time Error","You cannot go further then a year backward in the daiely overview",function(){
				$('#ask-dialog').modal('hide');
				});
			}
			OBAClass.day = obj.day;
			OBAClass.week = obj.week;
			obj.daily();
			obj.weekly();
			
			d.displayGroupsToday();
			});
		/**
		 * Go Forward in time day
		 **/
		$("#forwardintime").click(function(){
			if(obj.day == 0){
					if((obj.week + 1) <= 52){
						obj.day++;
						obj.week++;
						
						d.displayGroupsToday();
						obj.weekly();
					}
				}else if((obj.day +1) < 7){
					obj.day++
					}else{
							if((obj.week + 1) <= 52){
								obj.day = 0;
							}
						}
			OBAClass.day = obj.day;
			OBAClass.week = obj.week;
			d.displayGroupsToday();
			obj.daily();
			});
		/**
		 * Go Forward in time week
		 **/
		$("#forwardintimeweek").click(function(){
			if(obj.week+1 < 52){
			obj.week = obj.week+1;
			obj.day = 0;//set always on Monday!
			obj.weekly();
			}else{
				new OBA().dialog("Time Error","You cannot go further then a year backward in the daiely overview",function(){
				$('#ask-dialog').modal('hide');
				});
			}
			OBAClass.day = obj.day;
			OBAClass.week = obj.week;
			obj.daily();
			
			d.displayGroupsToday();
			obj.weekly();
			});
		/**
		 * tabs settings
		 **/
		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		  if($(e.target).attr("href") == "#weekly"){
			  $("#backintime").hide();
			  $("#forwardintime").hide();
			  }else{
			  $("#backintime").show();
			  $("#forwardintime").show();			  
				  }
		});
		this.daily = function(){
			/**
			 * signoff mealtime tickwee sheet diet
			 * 			**/
				/**
				 * HTML & CSS Look and feel changes:
				 **/
				$("#mealtimes").html("");
				$("#dietaries").html("");
				$("#mealtimes-tb").html("");
				//set week and dates:
				this.setExportDate();
				OBAClass.setWeek(obj.week);
				 obj.month = OBAClass.month;
				/**
				 * Actual work starts here:
				 * 
				 * Load Mealtimes
				 **/
				$break = false;//to break the whole function!
				mealtimes = r.getMealTimes();
				//create new Object based on the sheets:
				//displaying the current signoffsheet based on the time set in this methode:
				$number_tax_benfits = 0;
				$.each(mealtimes,function(index,value){
					day = obj.day;
					if(obj.thisweek != obj.week){
						obj.thisweek = obj.week;
						var ticks = null;
						$break = true;
						//get ticks from API for the week week current
						$.get(OBAdata.baseUrl+OBAdata.type+"api/request/gettickedweek/"+obj.week,function($data){
							OBAdata.ticksthisweek = $.parseJSON($data);//overrite the gloabl week
							}).success(function(){
								obj.daily();//reload this methode
								});
							return false;
						}else{
							ticks = r.getTicksThisWeek(value.id,day);
						}
					if(ticks != null){
						//if there are ticks:
						tick = parseInt(ticks.type_0)+parseInt(ticks.type_1);//create sum for TAX benefits and Normal
						packTick = ticks.type_2;
						tb = ticks.type_1;//only tax befits number total
						/**
						 * If something is wrong make sure the number is correct
						 * */
						if(value.tax == true){
						$number_tax_benfits += ticks.type_1;
						}
						}else{
							tick = 0;
							packTick = 0;
							tb = 0;
							}
							$("#mealtimes").append("<li class=\"list-group-item\">"+value.name+" participants <span class=\"badge\">"+tick+"</span></li>");
							// show only what is set in object
							if(value.tax == true){
								$("#mealtimes-tb").append("<li class=\"list-group-item\">"+value.name+" participants <span class=\"badge\">"+tb+"</span></li>");
							}
							if(value.packable == true){
								$("#mealtimes").append("<li class=\"list-group-item list-group-item-info\">Packed "+value.name+" participants <span class=\"badge\">"+packTick+"</span></li>");
								}
						//display Dietaries:
						obj.displayDietaries(value,obj.week,day);
				});//end each
				$("#totalNumberTB").text($number_tax_benfits);
				//check if we have to break:
				if($break == true){
					return null;
					}
				
								if($("#mealtimes li").length == 0){
									$("#mealtimes").append("<li class=\"list-group-item text-right\"><p class=\"text-danger text-center\">No data</p></li>");
									}
						obj.displayTickedUsers("#user-signoff");
						if($("#user-signoff").children().length == 0){
							$("#user-signoff").append("<li class=\"list-group-item text-right\"><p class=\"text-danger text-center\">No data</p></li>");
							}
						//$("#signoffsheet-number-total").text($total);
						$('.pop').popover();

		}
	/**
	 * displays the dietaries per mealtime
	 * @param Mealtime mealtimes (MealTime Object)
	 * @param int week
	 * @param int day
	 * 
	 * required triggers:loadMts loadSheetdiets
	 * 
	 **/
	this.displayDietaries=function(mealtime,$week,day){
		//get mealtimes
		diets = r.getSheetsDiets();
		mtID = mealtime.id;
			$("#dietaries").append("<strong>"+mealtime.name+"</strong>");//set Name
			$("#dietaries").append("<ul id=\"diet_id_"+mealtime.id+"\" class=\"list-group\"></ul>");
			$error = false;
			if(typeof diets[$week] != "undefined"){
				if(typeof diets[$week][mtID] != "undefined"){
					if(typeof diets[$week][mtID][day] != "undefined"){
						diets = diets[$week][mtID][day];
						$.each(diets,function(ind,val){
							if(val[0].danger == true){
								$class = "list-group-item-danger";
								}else{
									$class = "";
									}
							$("#diet_id_"+mealtime.id).append("<li class=\"list-group-item "+$class+"\"><a href='#' placement=\"top\" class=\"pop\" data-toggle=\"popover\" title=\""+val[0].name+"\" data-content=\""+val[0].description+"\">"+val[0].name+"</a> <span class=\"badge\">"+val["number"]+"</span></li>");
							});
						}else{
						$error = true;
						}
				}else{
				$error = true;
				}
				
			}else{
				$error = true;
				}
		if($error == true){
				$("#diet_id_"+mealtime.id).append("<li class=\"list-group-item text-right\"><p class=\"text-danger text-center\">No Dietaries.</p></li>");
			}
		}
	/**
	 * DisplayTickedUsers
	 * @param string $id
	 * DOM elemt ID/class
	 * @param bool $weekly
	 * if weekly overview or not
	 **/
	this.displayTickedUsers = function($id,$weekly){
		$weekly = (typeof $weekly == "undefined")? null:$weekly;
		if($weekly == null){
		sheets = r.getSignoffSheet(obj.week);
		sheets = (typeof sheets[0] != "undefined")? sheets[0]:null;
		}else{
			sheets = obj.userticks;
			}	
		if(sheets != null){
				$($id).html("");
				//$("#weeklyOverviewPerDay").html("");
				$.each(sheets,function(index,value){
					mtID = ($weekly != null)? value.mtID:value.mealtime;
					//weekly total number per day
					mealtimes = r.getMealTimes(mtID);
						$($id).append("<table class='table' id='tab_id_"+mealtimes.id+"'><caption><strong>"+mealtimes.name+"</strong></caption><tr class='tr_th'><th>Name</th><th>Group</th><th class='ditesTh'>Dietaries</th><th class='typeTh'>Type</th></tr></table>");
						tickToday = [];
						//seperation between $weekly and daily:
						if($weekly == null){
						$.each(value.ticks,function(index,tick){
							if(obj.day == tick.day){
								tickToday.push(tick);
							}
							});
						if(tickToday.length > 0){
						$.each(obj.sortTicks(tickToday),function(index,value){
							//gen dietaries:
							if(value.user.dietaries.length > 0){
								diets= "";
								$.each(value.user.dietaries,function(index,val){
									$class = (val.danger != true)? "label-info":"label-danger";
									diets += "<span class=\"label pop "+$class+"\" placement=\"top\"  data-toggle=\"popover\" title=\""+val.name+"\" data-content=\""+val.description+"\">"+val.name+"</span> ";
									});
								}else{
									diets = "None";
									}
							//types:
							types = OBAdata.mealtypes;
							$($id+" #tab_id_"+mealtimes.id).append("<tr><td>"+value.user.name+" "+value.user.surname+"</td><td>"+value.user.group.name+"</td><td>"+diets+"</td><td>"+types[value.type]+"</td></tr>");
							});
						}else{
							$($id+" #tab_id_"+mealtimes.id).remove();
							}
						}else{
							/** Weekly overview **/
							$day = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
							for($x = 1;$x < 8;$x++){
								var $dayX = ($x == 7)? 0:$x;
								$($id+" #tab_id_"+mealtimes.id+" .tr_th").append("<th>"+$day[$dayX]+"<th>");
								}
							$($id+" #tab_id_"+mealtimes.id+" .tr_th th:empty").remove();
							$($id+" #tab_id_"+mealtimes.id+" .tr_th .ditesTh").remove();	
							$($id+" #tab_id_"+mealtimes.id+" .tr_th .typeTh").remove();	
							console.log(11);
							$number = {}
							$.each(sheets,function(index,sheet){
								if(sheet.mtID == mealtimes.id){
								$.each(sheet,function(ind,ticks){
									if(ind != "mtID"){
									t = ticks[0];
									user = t.user;
									$($id+" #tab_id_"+mealtimes.id).append("<tr id=\"tab_id_"+mealtimes.id+"_tr_u"+ind+"\"><td>"+user.name+" "+user.surname+"</td><td>"+user.group.name+"</td></tr>");
									// days tds
									for($x = 0;$x < 7;$x++){
										var $dayX = ($x == 7)? 0:$x;
										$($id+" #tab_id_"+mealtimes.id+"_tr_u"+ind).append("<td class='time'><span class='glyphicon glyphicon-remove'></span></td>");
										if($("#table_mID_"+mealtimes.id).children().length <=7){
											$("#table_mID_"+mealtimes.id).append("<td id=\"mt_"+mealtimes.id+"_day_"+$dayX+"\">0</td>");
										}
										}
									/**
									 * Displays the ticks
									 * */
									$.each(ticks,function(key,tick){
										$class = (tick.type == 1)? "text-success":"";
										$class = (tick.type == 2)? "text-info":$class ;
										if(typeof $number[tick.day] != "undefined"){
										$number[tick.day]++;
										}else{
											$number[tick.day] = 1;
											}
										var tickTypeImage = (tick.type != 2)? "glyphicon-ok":"glyphicon-briefcase";
										$($($id+" #tab_id_"+mealtimes.id+"_tr_u"+ind+" .time").get(tick.day)).html("<span class='"+$class+" glyphicon "+tickTypeImage+"'></span>")
										
										});
									}
									});
								}
								});
								//display howmany people et this week:
								for($x = 0;$x < 7;$x++){
								var $dayX = ($x == 7)? 0:$x;
								$("#mt_"+mealtimes.id+"_day_"+$dayX).text($number[$dayX]);
									}
							}
					});
		}else{
				$($id).html("<p class='text-warning text-center'>- No one wants to eat -</p>");
				}
		}
	this.sortTicks=function($array){
		sortArray = [];
		sortIndexs = [];
		returnArray = [];
		$.each($array,function(index,value){
			sortArray.push(value.user.name);
			sortIndexs.push(value.user.name);
			});
		$.each(sortArray.sort(),function(index,value){
			returnArray.push($array[sortIndexs.findIndex(function(arg){return arg == value;})]);
			});
			return returnArray;
		}
	/**
	 * displays the weekly overview
	 * @require: trigger loadSignoffsheets,loadMts,loadWeekTicks,loadSheetDiets
	 **/
	this.weekly= function(){
		//update the Export
		this.setExportDate();
				var addTh = "<tr><th>Mealtime</th>";
				for($x =1;$x < 8;$x++){
					$day = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
					var $dayX = ($x == 7)? 0:$x;
					addTh += "<th>"+$day[$dayX]+"</th>"
					}
				addTh += "</tr>";
				$("#weeklyOverviewPerDay").html("");
				$("#weeklyOverviewPerDay").append(addTh);
				//get Mealtimes:
				mealtimes = r.getMealTimes();
				$("#overview-week-mealtime").html("");
				$("#overview-week-mealtime-bt").html("");
				$.each(mealtimes,function(index,value){
					//add mealtime to the weekly overview
					$("#weeklyOverviewPerDay").append("<tr id=\"table_mID_"+value.id+"\"><th>"+value.name+"</th></tr>");
					
					$("#overview-week-mealtime").append('<li class="list-group-item">'+value.name+' <span class="badge" id="id_week_mealTime_'+value.id+'">0</span></li>');
					if(value.tax == true){
					$("#overview-week-mealtime-bt").append('<li class="list-group-item">'+value.name+' <span class="badge" id="id_week_mealTime_bt_'+value.id+'">0</span></li>');
					}
					if(value.packable == true){
						$("#overview-week-mealtime").append('<li class="list-group-item list-group-item-info">Packed '+value.name+' <span class="badge" id="id_week_mealTime_packed_'+value.id+'">0</span></li>');
						}
					});
					$("#overview-week-mealtime").append('<li class="list-group-item"><strong>Total</strong> <span class="badge" id="totalNumber">0</span></li>');
					$("#overview-week-mealtime-bt").append('<li class="list-group-item"><strong>Total</strong> <span class="badge" id="totalNumberTb">0</span></li>');

						$.get(OBAdata.baseUrl+OBAdata.type+"api/request/gettickedweek/"+obj.week).done(function($data){
								ticks = $.parseJSON($data);//overrite the gloabl week
								if(ticks != null){
										$total_number = 0;
										$total_bt_number = 0;
										$.each(ticks,function(index,val){
												$total = 0;
												$total_pack = 0;
												$total_bt = 0;
												$.each(val,function(inex,value){
													$total += parseInt(value.type_1)+parseInt(value.type_0);
													$total_pack += parseInt(value.type_2);
													$total_number += parseInt(value.total);
													$total_bt += parseInt(value.type_1);
													});
												$total_bt_number += $total_bt;
												$("#id_week_mealTime_"+index).text($total);
												$("#id_week_mealTime_packed_"+index).text($total_pack);
												$("#id_week_mealTime_bt_"+index).text($total_bt);
											});
											$("#totalNumber").text($total_number);
											$("#totalNumberTb").text($total_bt_number);
									}else{
										$("#overview-week-mealtime").append('<li class="list-group-item">- No data -</li>');
										}
								});
								//all user list:
								$.get(OBAdata.baseUrl+OBAdata.type+"api/request/usersortedticks/"+obj.week).done(function($data){
									ticks = $.parseJSON($data);//overrite the gloabl week
									if(ticks != null){
										obj.userticks = ticks;
										obj.displayTickedUsers("#user-signoff-weekly",true);
										}
									});
		}
	}
