/**
 * @file requests.php
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 07.06.2016 16:59:58 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 **/
 
/**
 * Request Class
 * 
 * This class deals with all AJAX Request the system has.
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
OBAdata = {
	mealtimes:{},
	meals:{},
	notification:{},
	messanges:{},
	users:{},
	signoffsheets:{},
	signoffsheet:[],//current
	tickstoday:{},
	baseUrl:"",
	exportPDF:"",
	exportExcel:"",
	mail:"@oba.com.au",
	ticksthisweek:{},
	sheetdiets:{},
	users:{},
	groups:{},
	diets:{},
	groupsweektick:{},
	helptexts: null,
	mealtypes:["Normal","Tax Benfits","Packed"],
	loadSheetDiets:false,// => requestSheetsDiets
	lodMts:false,// _> mealtimes
	loadMessages:false,
	loadTodayTicks:false,
	loadWeekTicks:false,
	loadSheets:false,
	loadMs:false,
	LoadMps:false,
	loadHelptexts:false,
	loadDiets:false,
	loadUserGroups:false,
	loadGroups:false,
	loadTicksGroups:false,
	loadTicksGroupsWeek:false,
	loadUser:false,
	loadNotifications:false,
	type: "backend/"
	}
Requests=function(){
	  /**
	   * ########################
	   * setter & getter methodes
	   * ########################
	   **/
	this.setBaseUrl = function(baseUrl){
		OBAdata.baseUrl = baseUrl;
		}
	this.getBaseUrl = function(){
		return OBAdata.baseUrl;
		}
	this.setType = function(type){
		OBAdata.type = type;
		}
	this.getType = function(){
		return OBAdata.type;
		}
	this.setTicksToday = function(ticks){
		OBAdata.tickstoday = ticks;
		};
	this.getUsers = function(uID){
		if(typeof uID != "undefined"){
			returnUser = null;
			$.each(OBAdata.users,function(index,group){
				$.each(group,function(ind,value){
					if(value.id == uID){
						returnUser = value;
						return false;
						}
					});
				});
				return returnUser;
			}else{
				return OBAdata.users;
			}
		};
	this.setUsers = function(users){
		OBAdata.users = users;
		};
	this.getUserGroups = function(gID){
		if(typeof gID != "undefined"){
			returnGroup = null;
			$.each(OBAdata.groups,function(index,value){
				if(value.id == gID){
					returnGroup = value;
					return false;
					}
				});
				return returnGroup;
			}else{
				return OBAdata.usergroups;
			}
		};
	this.setUserGroups = function(groups){
		OBAdata.usergroups = groups;
		};
	this.getGroupsWeekTick = function(gID){
		if(typeof gID != "undefined"){
			returnGroup = null;
			$.each(OBAdata.groupsweektick,function(index,value){
				if(value.id == gID){
					returnGroup = value;
					return false;
					}
				});
				return returnGroup;
			}else{
				return OBAdata.groupsweektick;
			}
		};
	this.setGroupsWeekTick = function(groups){
		OBAdata.groupsweektick = groups;
		};
	this.getGroups = function(gID){
		if(typeof gID != "undefined"){
			returnGroup = null;
			$.each(OBAdata.groups,function(index,value){
				if(value.id == gID){
					returnGroup = value;
					return false;
					}
				});
				return returnGroup;
			}else{
				return OBAdata.groups;
			}
		};
	this.setGroups = function(groups){
		OBAdata.groups = groups;
		};
	this.getDiets = function(dID){
		if(typeof dID != "undefined"){
			returnDiet = null;
			$.each(OBAdata.diets,function(index,value){
				if(value.id == dID){
					returnDiet = value;
					return false;
					}
				});
				return returnDiet;
			}else{
				return OBAdata.diets;
			}
		};
	this.setDiets = function(diets){
		OBAdata.diets = diets;
		};
	this.getTicksToday = function(){
		return OBAdata.tickstoday;
		};
	this.setTicksThisWeek = function(ticks){
		OBAdata.ticksthisweek = ticks;
		};
	this.setSheetsDiets = function(diets){
		
		OBAdata.sheetsdiets = diets;
		}
	this.getSheetsDiets = function(){
		return OBAdata.sheetsdiets;
		}
	this.getTicksThisWeek = function(mtID,day){
			if(typeof mtID == "undefined"){
				return OBAdata.ticksthisweek;
			}else if(typeof day == "undefined"){
				if(typeof OBAdata.ticksthisweek[mtID] != "undefined"){
					return OBAdata.ticksthisweek[mtID];
				}else{
					return null;
					}
			}else{
				if(typeof OBAdata.ticksthisweek[mtID] != "undefined" && typeof OBAdata.ticksthisweek[mtID][day] != "undefined"){
					return OBAdata.ticksthisweek[mtID][day];
				}else{
					return null;
					}
				}
		};
	this.setmealtimes = function(mealtimes){
		OBAdata.mealtimes = mealtimes;
		};
	this.getMealTimes = function(mtID){
		if(typeof mtID == "undefined"){
			return OBAdata.mealtimes;
		}else{
			var mt = null
			$.each(OBAdata.mealtimes,function(index,value){
				if(value.id == mtID){
					mt = value;
					}
				});
				return mt;
			}
		};
	this.setMeals = function(meal){
		OBAdata.meals = meal;
		};
	this.getMeals = function(mtID){
		if(typeof mtID == "undefined"){
			return OBAdata.meals;
		}else{
			var mt = null
			$.each(OBAdata.meals,function(index,value){
				if(value.id == mtID){
					mt = value;
					}
				});
				return mt;
			}
		};
	this.setSignoffSheets = function($signoffsheet){
		OBAdata.signoffsheets = $signoffsheet;
		}
	this.getSignoffSheets=function(){
		return OBAdata.signoffsheets;
		}
	this.getSignoffSheet=function($week){
		var object = [];
		$.each(OBAdata.signoffsheets,function(index,value){
				if(index == $week)
					object.push(value);
			});
		return object;
		}
	this.getMealPlans = function(mpID){

		if(typeof mpID == "undefined"){
			return OBAdata.mealplans;
		}else{
			var mt = null
			$.each(OBAdata.mealplans,function(index,value){
				if(value.id == mpID){
					mt = value;
					}
				});
				return mt;
			}

		}
	this.getActiveMealPlans = function(){
			var mt = [];
			$.each(OBAdata.mealplans,function(index,value){
				if(value.active == true){
					mt.push(value);
					}
				});
				return mt;
			}
	this.setMealPlans=function($plans){
		OBAdata.mealplans = $plans;
		}
	this.getNotifications = function($fixed,$id){
		if(typeof $id == "undefined" || typeof $fixed == "undefined"){
			return OBAdata.notifications;
		}else{
			var n = null
			if($fixed == "true"){ind = "fixed";}else{ind = "other";}
			$.each(OBAdata.notifications[ind],function(index,value){
				if(value.id == $id){
					n = value;
					}
				});
				return n;
			}


		}
	this.setNotifications = function($notif){
		OBAdata.notifications = $notif;
		}
	this.setMessages = function($message){
		OBAdata.messages = $message;
		}
	this.getMessages = function(){
		return OBAdata.messages;
		}
	/**
	 * getMealPlan from the globa mealplan Object
	 * @param int $activationTime
	 * Is the Number of week from a Year to idintify the current week Default: current week number
	 * @param boolean $active
	 * true we use this meal plan currently
	 * false we dont
	 * Default: null
	 * So it picks every plan you want
	 **/
	this.getMealPlan=function($activationTime,$active){
		$active = (typeof $active == "undefined")? null:$active;
		$activationTime = (typeof $activationTime == "undefined")? new Date().getWeekNumber():$activationTime;
		$mealplans = this.getMealPlans();//load global mealplan Object
		var $mealplan = {};//create container
		$.each($mealplans,function(index,val){
				if($active == null){
					if(val.activationTime == $activationTime){
						$mealplan = val;
						}
				}else if(val.activationTime == $activationTime && val.active == true){
					$mealplan = val;
				}
			});
		return $mealplan;
		};
	/**
	 * ######################
	 * Ajax Request Methodes:
	 * ######################
	 * 
	 * every methode isTriggering something.
	 * 
	 **/
	/**
	 * @methode requestSheetsDiets
	 * @see setSheetDiets()
	 * @return void
	 */
	this.requestSheetsDiets = function(){
		var obj = this;
		OBAClass.log("Request SheetDiets...");
		$.get(this.getBaseUrl()+OBAdata.type+"api/request/getsheetsdiets").success(function($data){
				$object = jQuery.parseJSON($data);
				obj.setSheetsDiets($object);
				OBAClass.log("Trigger loadSheetDiets...");
				$("body").trigger("loadSheetDiets");
				delete $object;
				});
		};
	/**
	 * @methode requestmealtimes
	 * this methode request the API for the mealtimes object and saves it in the mealtimes object of the OBAdata class
	 * @see setMealTimes()
	 * @return void
	 */
	this.requestMealTimes = function(){
		var obj = this;
		OBAClass.log("Request MealTimes...");
		$.get(this.getBaseUrl()+OBAdata.type+"api/request/getmealtimes").success(function($data){
				$object = jQuery.parseJSON($data);
				obj.setmealtimes($object);
				OBAClass.log("Trigger LoadMts...");
				$("body").trigger("loadMts");
				delete $object;
				});
		};
	/**
	 * @methode requestMessages
	 * this methode request the API for the Messages object and saves it in the Message object of the OBAdata class
	 * @return void
	 */
	this.requestMessages = function(){
		var obj = this;
		OBAClass.log("Request Messages...");
			$.get(this.getBaseUrl()+OBAdata.type+"api/request/getallmessages").success(function($data){
				//json
				$object = jQuery.parseJSON($data);
				obj.setMessages($object);
				OBAClass.log("Trigger loadMessages...");
				$("body").trigger("loadMessages");
				delete $object;
			});
		};
	/**
	 * @methode requestTicksToday
	 * this methode request the API for the Ticks object and saves it in the Signoffsheets object of the OBAdata class
	 * @see setTicksToday()
	 * @return void
	 */
	this.requestTicksToday = function(){
		var obj = this;
		OBAClass.log("Request Ticks today...");
			$.get(this.getBaseUrl()+OBAdata.type+"api/request/gettickedtoday").success(function($data){
				//json
				$object = jQuery.parseJSON($data);
				obj.setTicksToday($object);
				OBAClass.log("Trigger loadTodayTicks.");
				$("body").trigger("loadTodayTicks");
				delete $object;
			});
		};
	/**
	 * @methode requestTicksThisWeek
	 * this methode request the API for the Ticks object and saves it in the Signoffsheets object of the OBAdata class
	 * @see setTicksThisWeek()
	 * @return void
	 */
	this.requestTicksThisWeek = function(){
		var obj = this;
		OBAClass.log("Request Ticks week...");
			$.get(this.getBaseUrl()+OBAdata.type+"api/request/gettickedthisweek").success(function($data){
				//json
				$object = jQuery.parseJSON($data);
				obj.setTicksThisWeek($object);
				OBAClass.log("Trigger loadWeekTicks");
				$("body").trigger("loadWeekTicks");
				delete $object;
			});
		};
	/**
	 * @methode requestSignOffSheets
	 * this methode request the API for the SignOffSheets object and saves it in the Signoffsheets object of the OBAdata class
	 * @see setSignOffSheet()
	 * @return void
	 */
	this.requestSignOffSheets = function(){
		var obj = this;
		OBAClass.log("Request Sheets");
			$.get(this.getBaseUrl()+OBAdata.type+"api/request/getsignoffsheets").success(function($data){
				//json
				$object = jQuery.parseJSON($data);
				obj.setSignoffSheets($object);
				//set the current SignOffsheet:
				OBAClass.log("Trigger loadSheets...");
				$("body").trigger("loadSheets");
				delete $object;
			});
		};
	/**
	 * @methode requestMeals
	 * this methode request the API for the meals object and saves it in the meals object of the OBAdata class
	 * @see setMealPlans()
	 * @return void
	 */
	this.requestMeals = function(){
		var obj = this;
		OBAClass.log("Request Meals...");
			$.get(this.getBaseUrl()+OBAdata.type+"api/request/getmeals").success(function($data){
				//json
				$object = jQuery.parseJSON($data);
				obj.setMeals($object);
				OBAClass.log("Trigger loadMs.");
				$("body").trigger("loadMs");
			});
		}
	/**
	 * @methode requestMealPlans
	 * this methode request the API for the mealplan object and saves it in the mealplan object of the OBAdata class
	 * @see setMealPlans()
	 * @return void
	 */
	this.requestMealPlans = function(){
		OBAClass.log("Request Mps...");
		var obj = this;
			$.get(this.getBaseUrl()+OBAdata.type+"api/request/getallmealplans").success(function($data){
				//json
				$object = jQuery.parseJSON($data);
				obj.setMealPlans($object);
				OBAClass.log("Trigger loadMps");
				$("body").trigger("loadMps");
			});
		}
	/**
	 * @methode requestMealPlans
	 * this methode request the API for the mealplan object and saves it in the mealplan object of the OBAdata class
	 * @see setMealPlans()
	 * @return void
	 */
	this.requestHelpTexts = function(){
		OBAClass.log("Request Helptexts...");
		var obj = this;
		$.getJSON(this.getBaseUrl()+OBAdata.type+"api/json/load").success(function(data){
			OBAdata.helptexts = data;
			OBAClass.log("Trigger loadHelptexts");
			$("body").trigger("loadHelptexts");
			});
		}
	/**
	 * @methode requestDiets
	 * this methode request the API for the diet object and saves it in the diet object of the OBAdata class
	 * @see setMealPlans()
	 * @return void
	 */
	this.requestDiets = function(){
		OBAClass.log("Request Diets...");
		var obj = this;
			$.get(this.getBaseUrl()+OBAdata.type+"api/request/getalldiets").success(function($data){
				//json
				$object = jQuery.parseJSON($data);
				obj.setDiets($object);
				OBAClass.log("Trigger loadDiets.");
				$("body").trigger("loadDiets");
			});
		}
	/**
	 * @methode requestUserGroups
	 * this methode request the API for the users object and saves it in the mealplan object of the OBAdata class
	 * @see setMealPlans()
	 * @return void
	 */
	this.requestUserGroups = function(){
		OBAClass.log("Request Groups...");
		var obj = this;
			$.get(this.getBaseUrl()+OBAdata.type+"api/request/getallusergroups").success(function($data){
				//json
				$object = jQuery.parseJSON($data);
				obj.setUserGroups($object);
				OBAClass.log("Trigger loadUserGroups");
				$("body").trigger("loadUserGroups");
			});
		}

	/**
	 * @methode requestGroups
	 * this methode request the API for the users object and saves it in the mealplan object of the OBAdata class
	 * @see setMealPlans()
	 * @return void
	 */
	this.requestGroups = function($week){
		$week = (typeof $week != "undefined")? $week:"";
		OBAClass.log("Request Groups...");
		var obj = this;
			$.get(this.getBaseUrl()+OBAdata.type+"api/request/getallgroups").success(function($data){
				//json
				$object = jQuery.parseJSON($data);
				obj.setGroups($object);
				OBAClass.log("Trigger loadGroups");
				$("body").trigger("loadGroups");
				$("body").trigger("loadTicksGroupsToday");
			});
			$.get(this.getBaseUrl()+OBAdata.type+"api/request/getallgroupsweek/"+$week).success(function($data){
				//json
				$object = jQuery.parseJSON($data);
				obj.setGroupsWeekTick($object);
				OBAdata.loadTicksGroupsWeek = true;
				OBAClass.log("Trigger loadGroups");
				$("body").trigger("loadTicksGroupsWeek");
			});
		}
	/**
	 * @methode requestUsers
	 * this methode request the API for the users object and saves it in the mealplan object of the OBAdata class
	 * @see setMealPlans()
	 * @return void
	 */
	this.requestUsers = function(){
		OBAClass.log("Request User...");
		var obj = this;
			$.get(this.getBaseUrl()+OBAdata.type+"api/request/getallusers").success(function($data){
				//json
				$object = jQuery.parseJSON($data);
				obj.setUsers($object);
				OBAClass.log("Trigger loadUser");
				$("body").trigger("loadUser");
			});
		}
	/**
	 * @methode requestNotifications
	 * this methode request the API for the notifications object and saves it in the notifications object of the OBAdata class
	 * @return void
	 */
	this.requestNotifications = function(){
		OBAClass.log("Request Notifications...");
		var obj = this;
			$.get(this.getBaseUrl()+OBAdata.type+"api/request/getallnotifications").success(function($data){
				//json
				$object = jQuery.parseJSON($data);
				obj.setNotifications($object);
console.log("ss");
				OBAClass.log("Trigger loadNotifications");
				$("body").trigger("loadNotifications");
			});
		}
	}
