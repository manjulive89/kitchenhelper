Notification = function(){
	var obj = this;
	$("#notifications-page #notifications").on("click",".notif",function(){
		$notifications = r.getNotifications();
		$notification = obj.getNotification($(this).attr("data-fixed"),$(this).attr("data-id"));
		new OBA().dialog($notification.title,$notification.message,function(){$('#ask-dialog').modal('hide');});
		});
	$("#notifications-page #notifications").on("click",".nedit",function(){
		$notification = obj.getNotification($(this).attr("data-fixed"),$(this).attr("data-id"));
		$edit = "<input id=\"new_title\" type='text' value=\""+$notification.title+"\" class=\"form-control\"><br>";
		$edit += "<textarea class='form-control' id='new_text'>"+$notification.message+"</textarea>";
		new OBA().dialog("Editor",$edit,function(){
			$notification.message = $("#new_text").val();
			$notification.title = $("#new_title").val();
			$.post(r.getBaseUrl()+OBAdata.type+"api/update/update",{data:$notification,type:"Notification"}).done(function(){
				OBAClass.updated();
				OBAdata.loadNotifications = false;				
				r.requestNotifications();
				d.displayNotifications();
				});
			$('#ask-dialog').modal('hide');
			
			});
		});
	$("#notifications-page #notifications").on("click",".nimportant",function(){
			$notification = obj.getNotification($(this).attr("data-fixed"),$(this).attr("data-id"));
			$notification.important = ($notification.important == true)? false:true;
			$.post(r.getBaseUrl()+OBAdata.type+"api/update/update",{data:$notification,type:"Notification"}).done(function(){
				OBAClass.updated();
				OBAdata.loadNotifications = false;				
				r.requestNotifications();
				d.displayNotifications();
			});
		});
	$("#notifications-page #notifications").on("click",".nfixed",function(){
			$notification = obj.getNotification($(this).attr("data-fixed"),$(this).attr("data-id"));
			$notification.fixed = ($notification.fixed == true)? false:true;
			console.log($notification.fixed);
			$.post(r.getBaseUrl()+OBAdata.type+"api/update/update",{data:$notification,type:"Notification"}).done(function(){
				OBAClass.updated();
				OBAdata.loadNotifications = false;
				r.requestNotifications();
				d.displayNotifications();
			});
		});
	$("#notifications-page #notifications").on("click",".ndel",function(){
			$notification = obj.getNotification($(this).attr("data-fixed"),$(this).attr("data-id"));
			$id = $(this).attr("data-id");
			new OBA().dialog("Remove Notification","Do you want to remove this notification?",function(){
			$.post(r.getBaseUrl()+OBAdata.type+"api/update/delete",{data:$notification,type:"Notification"}).done(function(){
				$(".list-group-item[data-id='"+$id+"']").remove();
				$('#ask-dialog').modal('hide');
			});
			});
		});
	$("#save-notif").click(function(){
		$title = new OBA().sec($("#title").val());
		if($title.length > 4){
			$("#title").val("");
			$text = new OBA().sec($("#input-text-notif").val());
			$("#input-text-notif").val("");
			$important = $("#important"). prop("checked");
			$fixed =$("#fixed").prop("checked");
			 $("#important").prop('checked', false);
			  $("#fixed").prop('checked', false);
			data = {
				title:$title,
				message:$text,
				important:$important,
				fixed:$fixed,
				date:((new Date().getTime())/1000),
				id:null
				}
			$.post(r.getBaseUrl()+OBAdata.type+"api/update/update",{data:data,type:"Notification"}).done(function(){
				OBAdata.loadNotifications = false;
				r.requestNotifications();
				d.displayNotifications();
				});
		}else{
			alert("The title should be longer then 4 letters");
			}
		})	
	/**
	 * getNotofocations
	 * returns notification by index
	 **/
	this.getNotification = function (fixed,index){
		notif = r.getNotifications(fixed,index);
	    return notif;
		}
	}
