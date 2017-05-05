/**
 * @file oba.js
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 07.06.2016 17:59:15 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * OBA main javascript class
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */
OBA = function(){
	/**
	 * ###############
	 * helper methodes
	 * ###############
	 **/
	this.debug = true;
	this.log = function(msg){
			if(this.debug == true){
				console.log("["+new Date()+"] [LOG] "+msg);
			}
		}
	 /**
	  * @methode time()
	  * is the methode to change the time on the screen in a frequent
	  * @param String $id is the DOM ID for the element which shows the time
	  * @param int $duration is the frequent of update in secounds
	  * @return void
	  **/
	 this.time = function($id,$duration){
		 var obj = this;
		 setInterval(function(){
			 $($id).text(obj.timeMaker(new Date().getHours())+":"+obj.timeMaker(new Date().getMinutes()));
			 },($duration*1000));
		 }
	 /**
	  * @methode date()
	  * is the methode to change the date on the screen in a frequent
	  * @param String $id is the DOM ID for the element which shows the date
	  * @param int $duration is the frequent of update in minutes
	  **/
	 this.date = function($id,$duration){
		 setInterval(function(){
			 $mons = ["January","Feburary","March","April","May","June","July","August","September","October","November","December"];
			 $day = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
			 $($id).text($day[new Date().getDay()]+" "+new Date().getDate()+". "+$mons[new Date().getMonth()]+" "+new Date().getFullYear());
			 },($duration*1000*60))
		 };
	/**
	 * @methode sec(data)
	 * @param string str
	 * @return string
	 * Clean from <>
	 * */
	 this.sec = function(str){
	 var re = /(<|>)/g; 
	 var subst = ''; 
	 
	 return str.replace(re, subst);
		 }
	/**
	 * @methode timeMaker(str)
	 * creates out of a num String of the format: [HHMM] a time string of the format [HH:MM]
	 * @param mixed time
	 * @return string or int
	 **/
	this.timeMaker = function(time){
			if(time.length == 3){
				time = "0"+time;
				}
			if(typeof time == "string"){
				var re = /([0-9]{2})/; 
				var subst = '$1:';  
				return time.replace(re, subst);
			}else{
				if(time < 10){
					return "0"+time;
					}else{
						return time;
						}
				}
		}
	this.week = new Date().getWeekNumber();
	this.week = new Date().getWeekNumber();
	this.day = new Date().getDay();
	this.month = new Date().getMonth()+1;
	this.setWeek=function(week){
				$("#week").text("Week "+week);
				//calculate: 52*7*24*60 secounds since
				secounds = parseInt(this.week)*7*24*60*60*1000;
				monday  =	secounds - (60*60*24*3*1000);
				sat =	secounds + (60*60*24*3*1000);
				t = parseInt(this.day)-4;
				if(t == -4){
					t = (t*-1)-1;
				}
				today = secounds + (60*60*24*t*1000);				
				today = new Date(new Date("1-1-"+new Date().getFullYear()).getTime()+today);
				this.month = today.getMonth()+1;
				$day = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
				$mons = ["January","Feburary","March","April","May","June","July","August","September","October","November","December"];
				console.log("TODAYW");
				$("#today").text($day[today.getDay()]+" "+today.getDate()+". "+$mons[today.getMonth()]+" "+today.getFullYear());
				time_begin = new Date(new Date("1-1-"+new Date().getFullYear()).getTime()+monday);
				time_end =new Date(new Date("1-1-"+new Date().getFullYear()).getTime()+sat);
				$("#date-ss").text(new Date(time_begin).getDate()+" "+$mons[new Date(time_begin).getMonth()]+" - "+new Date(time_end).getDate()+" "+$mons[new Date(time_end).getMonth()]);		
		}
	/**
	 * getDayOfWeek
	 * @param int day
	 * day you need the date 0-6
	 * @param int week
	 * week of year
	 * @return Date
	 **/
	this.getDayOfWeek=function(day,week){
				secounds = parseInt(week)*7*24*60*60*1000;
				monday  =	secounds - (60*60*24*3*1000);
				sat =	secounds + (60*60*24*3*1000);
				t = parseInt(day)-4;
				if(t == -4){
					t = (t*-1)-1;
				}
				thatday = secounds + (60*60*24*t*1000);
				return new Date(new Date("1-1-"+new Date().getFullYear()).getTime()+thatday);
		}
	this.updated = function(){
		$(".updated").addClass("go");
		setTimeout(function(){
			$(".updated").removeClass("go");
			},1500);
		}
	this.loader=function(id){
		$(id).html("<center><img src='"+OBAdata.baseUrl+"makeup/imgs/loader.gif' class=\"text-center\" \></center>");
		}
		this.getHelptext = function(index,key){
			if(typeof key == "undefined" && typeof index == "undefined"){
				return OBAdata.helptexts;
				}else if (typeof key != "undefined" && typeof index != "undefined"){
					if(typeof OBAdata.helptexts[index] != "undefined" && typeof OBAdata.helptexts[index].data[key] != "undefined"){
					return OBAdata.helptexts[index].data[key].content;
					}else{
						return "["+key+"]";
						}
					}
		};
		this.getSettings = function(index){
			if(typeof index == "undefined"){
				return OBAdata.settings;
				}else if (typeof index != "undefined"){
					if(typeof OBAdata.settings[index] != "undefined"){
					return OBAdata.settings[index];
					}
				}
		};		
		this.displayHelptexts = function(){
			ht = this.getHelptext();
			$.each(ht,function(index,value){
				$.each(value.data,function(key,content){
					$("."+key).html(content.content);
					})
				});
			}
		/**
		 * toggle
		 * 
		 * @param string element
		 * It has to be a Doom Element name. It can be a ID (#[Name]) or a Class (.[name])
		 **/
		this.toggle = function(element){
		this.log("toggle");
		var $target = $($(element).attr("data-toggle"));
		if($target.hasClass("hidden")){
		$(element).find("span").removeClass("glyphicon-menu-down");
		$(element).find("span").addClass("glyphicon-menu-up");
		$target.removeClass("hidden");
		}else{
		$(element).find("span").addClass("glyphicon-menu-down");
		$(element).find("span").removeClass("glyphicon-menu-up");
		$target.addClass("hidden");
			}
		}
		this.dialog = function(title,msg,func,size){
			func = (typeof func == "undefined")? function(){$('#ask-dialog').modal('hide');}:func;
			size = (typeof size == "undefined")? "modal-sm":size;
			$html = "<div class='modal fade dialog-question' id=\"ask-dialog\" tabindex='-1' role='dialog' aria-labelledby='dialabel'> <div class='modal-dialog "+size+"'> <div class='modal-content'> <div class='modal-header'> <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <h4 class='modal-title' id='dialabel'>"+title+"</h4> </div> <div class='modal-body'> "+msg+" </div> <div class='modal-footer'> <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button> <button type='button' id=\"okay\" class='btn btn-primary'>Okay</button> </div> </div> </div> </div>";
				//console.log($(".dialog-question").length);
				if($(".dialog-question").length > 0){
					$(".dialog-question").remove();
				}
				$("body").append($html);
				$('#ask-dialog').modal('show');
				$('#ask-dialog #okay').click(func);
				$('#ask-dialog').on('hidden.bs.modal', function (e) {
				  $(this).remove();
				});
			}
	}

