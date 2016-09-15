/**
 * @file messanger.js
 * @version 1.0 
 * @projcet Kitchenhelper
 * 
 * Cyroxx Software Lizenz 1.0
 * Copyright (c) 06.06.2016 15:44:12 AEST, Cyroxx Software Projekt, Simon Renger <info@simonrenger.de>
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
 * Messanger
 * 
 * This class provieds all the functions and methodes you need for the messages tool.
 * 
 * @author Simon Renger <info@simonrenger.de>
 * @copyright Simon Renger <info@simonrenger.de>, All right reserved.
 * @license Cyroxx Software Lizenz 1.0
 * 
 */

Messanger= function(){
	var obj = this;
	$("#messages").on("click",".mail-item",function(){
			$messages = r.getMessages();
			$(".mail-item").removeClass("active");
			$(this).addClass("active");
			$msg = $messages[$(this).attr("data-id")];
			obj.show($msg,$(this).attr("data-id"));
			$(this).removeClass("alert");
			$(this).removeClass("alert-warning");
			//is it already seen by the user? If no change state:
		});
		$("#messages-preview").on("click",".del",function(){
				$id = $(this).attr("data-index");
				obj.del();
			});
		this.show= function($msg,index){
				$time =new Date((parseInt($msg.date)*1000));
				$date = new OBA().timeMaker(parseInt($time.getDate()))+"/"+new OBA().timeMaker(parseInt($time.getMonth())+1)+"/"+$time.getFullYear()+" "+new OBA().timeMaker(parseInt($time.getHours()))+":"+new OBA().timeMaker(parseInt($time.getMinutes()));
				reply = "mailto:"+$msg.sender.email;
				$("#messages-preview").html("<h2>"+$msg.title+"</h2><p class=\"text-info\"><span class= \"glyphicon glyphicon-time\"></span> "+$date+" by "+$msg.sender.name+"</p><hr><p id=\"msg\" style='white-space:pre-wrap;'></p><hr><div class=\"btn-group\" role=\"group\" aria-label=\"...\"><button type=\"button\" data-index='"+index+"' class=\"del btn btn-danger\"><span class='glyphicon glyphicon-trash'></span> Delete</button><a href=\""+reply+"\" type=\"button\" class=\"btn btn-default\"><span class=\"glyphicon glyphicon-share-alt\"></span> Reply</a><a href='"+OBAdata.baseUrl+"backend/messages/pdf/"+$msg.id+"' class=\"btn btn-default export\" data-index='"+$msg.id+"'><span class='glyphicon glyphicon-floppy-disk'></span> PDF</a></div>");			
				$("#messages-preview #msg").text($msg.message);
				if($msg.seen == 0){
					obj.seen($msg);
					if(index != 0){
						r.getMessages()[index].seen = 1;
					}
					d.displayMessagesNumber();
				}
			}
		this.del = function(){
				//asking dialog
				obj.dialog("Delete Message",OBAClass.getHelptext(2,"helptext_delmsg"),function(){
					$('#ask-dialog').modal('hide');
					$message = r.getMessages()[$id];
					$.post(OBAdata.baseUrl+OBAdata.type+"api/update/delete",{data:$message,type:"message"},function(d){
						if(d == "true"){
							$("#messages-preview").html("<div class='alert alert-success'><span class=\"glyphicon glyphicon-ok\"></span> "+OBAClass.getHelptext(2,"helptext_msg_del")+"</div>");
							$("#messages .mail-item[data-id='"+$id+"']").remove();
							}
						});
					});
			}
		this.seen = function($object){
			$.post(OBAdata.baseUrl+OBAdata.type+"api/update/seen",{data:$object});
			}
		this.dialog = function(title,msg,func){
			new OBA().dialog(title,msg,func);
			}
		this.loadMessage = function($id){
			var obj = this;
			$.get(OBAdata.baseUrl+OBAdata.type+"api/request/getmessage",{id:$id},function(d){
				$d = $.parseJSON(d);
					obj.show($d[0],0);
				});
			}
	}
