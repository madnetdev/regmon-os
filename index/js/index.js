if (!PRODUCTION) "use strict"; //remove on production so "const" works on iOS Safari 

var V_FEATURES_OPTIONS;
var V_GRID_SAVE = false;
var V_SELECTED_DATE;
var V_ANIMATE_RUN = false;
var V_requestsCount = 0;

var $features = false;
var clearTrainingForm;
var loading;
var item_comm_Date_From_To_Calc_init,
	item_comm_Time_From_To_Calc_init,
	item_comm_Time_init,
	item_comm_Date_init;
	
var confirm_Close_Form_iframe = function(){
	if (!confirm("\n\n"+LANG.LEAVE_PAGE_WARNING+"\n\n")){} //return false;
	else {
		window.frames[0].frameElement.contentWindow.stop_beforeunload_IE();
		setTimeout($.fancybox.close, 200);
	}
}
var fancyBox_scrollTop = 0;
var fancyBox_scrollTop_last = 0;
//http://fancyapps.com/fancybox/#docs
var fancyBoxDefaults = {
	padding:0, //def:15
	margin:10, //def:20
	maxWidth:540,
	minWidth:250,
	modal:true,
	live:false,
	tpl:{error:'<p class="fancybox-error">'+LANG.PROBLEM_LOADING_PAGE+'</p>'},
	afterClose:function() {
		//location.reload();
		return;
	},
	beforeShow:function() {
		$('.not_display').show(); //show spacer
	},
	afterShow:function() {
		$('.fancybox-skin').append('<a title="'+LANG.CLOSE+'" class="fancybox-item fancybox-close" href="javascript:jQuery.fancybox.close();"></a>'); //close button
		setTimeout(function(){
			$('.not_display').hide(); //hide spacer //give space to link so that fit when is bold on hover
		}, 0);
		
		//if new page has fancy_placeholder - hide it
		setTimeout(function () {
			$("#fancy_placeholder").hide();
		}, 0);
	}
}; //if some difference use -> $.extend(fancyBoxDefaults,{maxWidth: 800})
var fancyBoxDefaults_iframe = {
	padding:0, //def:15
	margin:10, //def:20
	modal:true,
	live:false,
	tpl:{error:'<p class="fancybox-error">'+LANG.PROBLEM_LOADING_PAGE+'</p>'},
	maxWidth:'100%',
	width:'100%',
	//fitToView : false,
	autoSize:false, height:'100%', //full height
	beforeLoad:function() {	
		loading.show();
		//open in new page if is iphone/ipad-safari
		if (is_iOS()) {
			window.location.href = this.href+'&iOS';
			return false;
		}
	},
	afterLoad:function() { loading.hide(); },
	afterClose:function() {
		//location.reload();
		return;
	},
	afterShow:function() {
		var close = '';
		//console.log(this.href);
		if (this.href.indexOf('form.php')!=-1) {
			close = 'javascript:confirm_Close_Form_iframe();';
			if (this.href.indexOf('view=true')!=-1) { //no confirm on View
				close = 'javascript:jQuery.fancybox.close();';
			}
		}
		else close = 'javascript:jQuery.fancybox.close();';
		$('.fancybox-skin').append('<a title="'+LANG.BACK+'" class="fancybox-item fancybox-back" href="'+close+'"></a>'); //close button
		$('.fancybox-skin').append('<a title="'+LANG.CLOSE+'" class="fancybox-item fancybox-close" href="'+close+'"></a>'); //close button
		
		//if new page has fancy_placeholder - hide it
		var _self = this;
		setTimeout(function () {
			var iframe = document.getElementById( $($(_self)[0].content).attr('id') );
			var elmnt = iframe.contentWindow.document.getElementById("fancy_placeholder");
			//elmnt.style.display = "none";
			$(elmnt).hide();
		}, 0);
	}
}; //if some difference use -> $.extend(fancyBoxDefaults,{maxWidth: 800})



window.addEventListener('online', function(e) {
	V_ONLINE = true;
    // Resync data with server.
    console.log("You are online");
    //Page.hideOfflineWarning();
}, false);
window.addEventListener('offline', function(e) {
	V_ONLINE = false;
    // Queue up events for server.
    console.log("You are offline");
    //Page.showOfflineWarning();
}, false);
// Check if the user is connected.
if (navigator.onLine) {
	V_ONLINE = true;
    console.log("Start online");
} else {
	V_ONLINE = false;
    console.log("Start offline");
    // Show offline message
    //Page.showOfflineWarning();
}


function hasAccess() {
	if ((V_GROUP in V_User_2_Groups) && (V_User_2_Groups[V_GROUP].status == '1' || V_User_2_Groups[V_GROUP].status == '2')) {
		return true;
	}
	return false;
}

function hasWriteAccess() {
	if ((V_GROUP in V_User_2_Groups) && (V_User_2_Groups[V_GROUP].status == '1')) {
		return true;
	}
	return false;
}


jQuery(function() 
{
	loading = $("#loading");
	$(document).ajaxStart(function () {
		loading.show();
	});
	$(document).ajaxStop(function () {
		if (!V_GRID_SAVE) {
			loading.hide();
		}
	});
	
	//Languages
	$("#lang_de").on('click',function () {
		if ($.cookie('LANG') == 'de') return false;
		$("#loading").show();
		$.cookie('LANG', 'de', { expires: 365, path: '/' });
		window.location.reload();
	});
	$("#lang_en").on('click',function () {
		if ($.cookie('LANG') == 'en') return false;
		$("#loading").show();
		$.cookie('LANG', 'en', { expires: 365, path: '/' });
		window.location.reload();
	});

	//nav button
	$('.nav_link').on('click',function() {
		loading.show();
	});
	
	//button Export
	$("button.export").on('click',function() {
		loading.show();
		window.location.href = 'export.php'; //?gid='+V_GROUP;
	});
	//button Import
	$("button.import").on('click',function() {
		loading.show();
		window.location.href = 'import.php'; //?gid='+V_GROUP;
	});
	//button Profile
	$("a.nav_profile").fancybox(fancyBoxDefaults);
	
	//Place holder
	$('input, textarea').placeholder();

	//tooltip --gone at the end
	//$('[data-toggle="tooltip"]').tooltip({ trigger: "hover" }); //if not give hover it not close after click


	
	//Group Select ###############################################################
	$("#GRP_select").chosen({width:'100%', placeholder_text_single: LANG.SELECT_OPTION, no_results_text: LANG.NO_RESULTS, search_contains: true, disable_search_threshold: 10});
	
	$('#GRP_select').on('chosen:showing_dropdown', function() {
		$('#GRP_select_chosen .chosen-results li').each(function() {
			//get v_value class --it has the group_id
			var val = $(this).attr("class").match(/v_[\w]*\b/);
			if (val) {
				val = val[0].split('_')[1];
				$(this).append('<span title="'+$('#GRP_select option[value="'+val+'"]').attr('data-status')+'">&nbsp;</span>');
			}
		});
	});	
	
	V_GROUP = $("#GRP_select").val();
	
	//init icon and submit buttons
	group_icons_buttons();
	
	//private
	$("#private_submit").on('click',function() {
		var p_val = encodeURIComponent( $('#private_key').val() ); //support for special characters
		if (p_val == '') return false;
		var location = (V_Group_2_Location[V_GROUP] && V_Group_2_Location[V_GROUP][0]) ? V_Group_2_Location[V_GROUP][0] : V_LOCATION;
		var p_found = false;
		$.ajax({
			url: "login/ajax.check_private_key.php?private_key="+p_val+'&location_id='+location,
			success: function(data_res) {
				if (data_res != 'false' && data_res != '') {
					var action = 'group_user_request_access';
					if (V_User_2_Groups[data_res]) { //if user where in this group before
						if (V_User_2_Groups[data_res].status == 0) action = 'group_user_request_access_AN';
						if (V_User_2_Groups[data_res].status == 5) action = 'group_user_request_access_AL_user';
						if (V_User_2_Groups[data_res].status == 15) action = 'group_user_request_access_AL_groupadmin';
					}
					var data = {request: 'user2group', action: action, group_id: data_res, location_id: location};
					$.post('index/ajax.request.php', data, function(data, result){
						V_GRID_SAVE = true; //for continue loading
						window.location.reload();
					});
				}
				else {
					alert(LANG.GROUPS.PRIVATE_KEY_ERROR);
				}
			}
		});
	});
	$("#private_close").on('click',function() {
		$('#private_group').hide();
		$('#GRP_select_chosen').show();
	});
	
	
	//Group Select on Change
	$("#GRP_select").on('change', function () 
	{
		if ($(this).val() == '') return false;
		if ($(this).val() == 'Private') {
			$('#GRP_select_chosen').hide();
			$('#private_group').css('display', 'inline-block');
			
			$('#GRP_select').val(V_GROUP);
			$("#GRP_select").trigger("chosen:updated");
		}
		else {
			V_GROUP = $(this).val();
			$.cookie('ATHLETE', V_UID);
			
			$.post('index/ajax.user_group_update.php', {group_id: V_GROUP, location_id: V_Group_2_Location[V_GROUP][0], u_id: V_UID}, function(data, result){
				V_GRID_SAVE = true; //for continue loading
				window.location.reload();
			});
		}
	});
	
	//Calendar / Options Buttons
	$('input[name="options_calendar"]').on('change', function () {
		if (this.id == 'view_calendar') {
			$("#group_data").hide();
			$("#group_calendar").show();
			$("#view_calendar").parent().css('font-weight', 'bold');
			$("#view_options").parent().css('font-weight', 'normal');
			enable_Athletes_Select();
		}
		else {
			$("#group_data").show();
			$("#group_calendar").hide();
			$("#view_calendar").parent().css('font-weight', 'normal');
			$("#view_options").parent().css('font-weight', 'bold');
			disable_Athletes_Select();
		}
		$(window).trigger('resize'); //it need this bcz calendar loses the scrollbar
	});
	$("#group_data").hide();
	$("#view_calendar").trigger("click"); //init calendar view

	
	//button submit_group
	$('button.submit_group').confirmation({
		href: 'javascript:void(0)',
		title: LANG.ARE_YOU_SURE, placement: 'top',
		btnOkLabel: LANG.YES, btnOkClass: 'btn btn-sm btn-success mr10',
		btnCancelLabel: LANG.NO, btnCancelClass: 'btn btn-sm btn-danger',
		onConfirm: function(e, button) {
			if ($("#GRP_select").val() == '') return false;
			var submit_group_id = $(button).prop('id');
			if (submit_group_id == 'group_user_cancel_access_user') {
				//double check
				if (!confirm("\n\n"+LANG.REQUEST_USER_LEAVE_GROUP+"\n\n"+LANG.ARE_YOU_SURE+"\n\n")) {
					return false;
				}
			}
			var data = {request: 'user2group', action: submit_group_id, group_id: V_GROUP, location_id: V_Group_2_Location[V_GROUP][0]};
			$.post('index/ajax.request.php', data, function(data, result){
				$("#group_buttons_message").html(data).show();
				V_GRID_SAVE = true; //for continue loading
				$.cookie('ATHLETE', V_UID);
				window.location.reload();
			});
		}
	});
	
	
	
	//#################################################
	//ACCORDEON #######################################
	$('#C_Requests_From_Trainers_link').on('click',function() {
		if ($('#A_Requests_From_Trainers').text().trim()=='') {
			load_Trainers_Requests();
		}
	});
	$('#C_Request_Access_From_Athletes_link').on('click',function() {
		if ($('#A_Request_Access_From_Athletes').text().trim()=='') {
			load_Users_2_Trainers();
		}
	});
	$('#C_Group_Requests_link').on('click',function() {
		if ($('#A_Group_Requests').text().trim()=='') {
			load_Group_Requests();
		}
	});
	$('#C_Group_Users_link').on('click',function() {
		if ($('#A_Group_Users').text().trim()=='') {
			load_Users_2_Group();
		}
	});
	$('#C_Location_Groups_link').on('click',function() {
		if ($('#A_Location_Groups').text().trim()=='') {
			load_Location_Groups();
		}
	});
	
	//Edit choice of Group Forms - AJAX after click
	$('#C_Athlete_Forms_Select_link').on('click',function() {
		if ($('#C_Athlete_Forms_Select').text().trim()=='') {
			load_Forms_ATHLETE_Selection();
		}
	});
	//Edit choice of Trainers Access Forms - AJAX after click
	$('#C_Athlete_Give_Forms_Access_To_Trainers_link').on('click',function() {
		if ($('#C_Athlete_Give_Forms_Access_To_Trainers').text().trim()=='') {
			load_Athlete__Trainers_Select(-1);
		}
	});
	//Show choice of Trainers Access Forms - AJAX after click
	$('#C_Trainer_Access_To_Athletes_Forms_link').on('click',function() {
		if ($('#C_Trainer_Access_To_Athletes_Forms').text().trim()=='') {
			load_Trainer__Athletes_Select(-1);
		}
	});
	//Edit choice of Group Forms - AJAX after click
	$('#C_Group_Forms_Select_link').on('click',function() {
		if ($('#C_Group_Forms_Select').text().trim()=='') {
			load_Forms_ADMIN_Selection();
		}
	});
	$('#C_Forms_link').on('click',function() {
		if ($('#A_Forms').text().trim()=='') {
			load_Forms();
		}
	});
	$('#C_Categories_link').on('click',function() {
		if ($('#A_Categories').text().trim()=='') {
			load_Categories();
		}
	});
	$('#C_Sports_Dropdowns_link').on('click',function() {
		if ($('#A_Sports_Dropdowns').text().trim()=='') {
			load_Sports_Dropdowns();
		}
	});

	load_Box_Forms_Menu();

	
	//#################################################
	//#################################################
	//Calendar ########################################
	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		defaultView: 'agendaWeek',
		allDaySlot: true,
		allDayText: '',
		lang: "de",
		navLinks: true,
		displayEventTime: false,	
		height: 550,
		contentHeight: 500,
		//forceEventDuration:true,
		//minTime:'06:00:00',
		//maxTime:'22:00:00',
		//defaultDate: '2016-02-12',
		//editable: true,
		//eventLimit: true, // allow "more" link when too many events
		events: {
			url: getCalendarUrl(),
			cache: true, //this will stop calendar adding a timestamp at the end of each url
			error: function() {
			}
			//color: 'yellow',   // for all
			//textColor: 'green' // for all
		},
		eventRender: function (event, element, view) {
			//console.log(event, event.start._d.getUTCHours());
			element.popover({
				//container: view.name=='month' ? '.fc-body' : '.fc-time-grid',
				container: (view.name=='month' || event.allDay) ? '#calendar' : '.fc-time-grid',
				viewport: {selector:  (view.name=='month' || event.allDay) ? '#calendar' : '.fc-time-grid', padding: 2},
				title: "<b>"+event.title+"</b>",
				//placement: 'auto',
				placement: function (context, source) {
					if (view.name=='month' || event.allDay) {
						//return 'auto';
						var popoverHeight = 220; //190;
						var conteiner = $(window).height();
						var scrollTop = $(window).scrollTop();
						var offset = $(source).offset();				
						//console.log(1, $(window).height() + $(window).scrollTop() - offset.top -220);
						if ((conteiner + scrollTop - offset.top - popoverHeight) > 0) {
							return 'bottom';
						}
						return 'top';
					}
					else {
						var popoverHeight = 290; //190;
						var conteiner = $('.fc-time-grid').height();
						//var scrollTop = $('.fc-scroller').scrollTop();
						var offset = $(source).offset();				
						//console.log(2, conteiner - (offset.top+popoverHeight), conteiner, (offset.top+popoverHeight));
						if (conteiner - (offset.top+popoverHeight) > 150) {
							return 'bottom';
						}
						return 'top';
					}
				},				
				html:true,
				//trigger:"click focus",
				trigger:"manual",
				content: replaceAll(event.msg, "\n", '<br>')
			});
			
			if (event.status == '0') {
				$(element).addClass('event_deactivated');
			}
		},
		//eventAfterAllRender: function (view) { //put it in source
			//$('.fc-center h2').text($('.fc-center h2').text().replace(' —','. —'));
		//},
		eventClick: function(event, jsEvent, view) {
			//console.log(event.start._i, event.start._d);
			//close other popups
			var this_pop = $(this).attr('aria-describedby');
			$('.popover.in').each(function(i, el) {
				//console.log(this_pop);
				if (el.id != this_pop) $("a[aria-describedby="+el.id+"]").popover('toggle');
			});
			//show this popup
			$(this).popover('toggle');
			
			//allDay popups need reset
			if (event.allDay) $(this).data('bs.popover').tip().css({'margin-top': '0px', 'margin-left': '0px'});
			
			var event_el = this;
			$("button#Cal_Edit_"+event.id).fancybox(fancyBoxDefaults_iframe);
			$("button#Cal_Res_"+event.id).fancybox(fancyBoxDefaults_iframe);
			$("button#Cal_Res_Sub_"+event.id).fancybox(fancyBoxDefaults_iframe);
			if (event.status == '1') {
				$("button#forms_data_deactivate_"+event.id).show();
				$("button#forms_data_activate_"+event.id).hide();				
				$("button#Cal_Res_Sub_"+event.id).show();
			} else {
				$("button#forms_data_deactivate_"+event.id).hide();
				$("button#forms_data_activate_"+event.id).show();				
				$("button#Cal_Res_Sub_"+event.id).hide();
			}
			$("button#forms_data_deactivate_"+event.id).on('click',function() {
				$.get('php/ajax.php?i=forms_data&oper=status&ID='+event.id+'&status=0', function(data, result){
					event.status = '0';
					$('.popover').popover('hide'); //hide all popovers
					$("button#forms_data_deactivate_"+event.id).hide();
					$("button#forms_data_activate_"+event.id).show();
					$("button#Cal_Res_Sub_"+event.id).hide();
					$(event_el).addClass('event_deactivated');
					$('#calendar').fullCalendar('updateEvent', event);
				});
			});
			$("button#forms_data_activate_"+event.id).on('click',function() {
				$.get('php/ajax.php?i=forms_data&oper=status&ID='+event.id+'&status=1', function(data, result){
					event.status = '1';
					$('.popover').popover('hide'); //hide all popovers
					$("button#forms_data_deactivate_"+event.id).show();
					$("button#forms_data_activate_"+event.id).hide();
					$("button#Cal_Res_Sub_"+event.id).show();
					$(event_el).removeClass('event_deactivated');
					$('#calendar').fullCalendar('updateEvent', event);
				});
			});
			$("button#Cal_Res_Del_"+event.id).confirmation({
				href: 'javascript:void(0)',
				title: LANG.CONFIRM_DELETE_ENTRY, placement: 'top',
				btnOkLabel: LANG.YES, btnOkClass: 'btn btn-sm btn-success mr10',
				btnCancelLabel: LANG.NO, btnCancelClass: 'btn btn-sm btn-danger',
				onConfirm: function(e, button) {
					$.get('php/ajax.php?i=forms_data&oper=status&ID='+event.id+'&status=-1', function(data, result){
						$('.popover').popover('hide'); //hide all popovers
						$(event_el).hide();
						parent.Swal({
							type: 'success',
							title: LANG.ENTRY_DELETED_SUCCESS,
							showConfirmButton: false,
							timer: 2000
						});
					});
				}
			});
			//comments
			$("button#comment_delete").on('click',function() {
				var data = {group_id: V_GROUP, athlete_id: V_ATHLETE, ID: event.id};
				$.post('index/ajax.comment_delete.php', data, function(data, result){
					$('.popover').popover('hide'); //hide all popovers
					$('#calendar').fullCalendar( 'refetchEvents' );
				});
			});
			$("button#comment_edit").on('click',function() {
				$('.popover').popover('hide'); //hide all popovers
				$.fancybox($("#create_comment"), $.extend({},fancyBoxDefaults,{minWidth: 300}));
				//console.log(event);
				init_Comments_Edit(event.id, event.allDay, event.showInGraph, event.start._i, event.end._i, event.title, event.text, event.color2);
			});
		},
		dayClick: function(date, jsEvent, view) {
			V_SELECTED_DATE = date.format();
			//console.log(V_SELECTED_DATE, jsEvent, jsEvent.target, $(jsEvent.target).hasClass('fc-day'), view.name);
			$.cookie('SELECTED_DATE', V_SELECTED_DATE);
			if (hasWriteAccess()) {
				if (jsEvent.target.tagName == "TD") { //bcz it opens with a click to popover
					if (view.name != 'month' && V_SELECTED_DATE.indexOf('T')==-1){ //all-day comment
						if (V_TRAINER_W_PERMS.indexOf('All') != -1 || V_TRAINER_W_PERMS.indexOf('Notiz_n') != -1) {
							$.fancybox($("#create_comment"), $.extend({},fancyBoxDefaults,{minWidth: 300}));
							init_Comments_Create('Cal_'+view.name);
						}
						else {
							$.fancybox('<div class="empty_message">'+LANG.NOT_HAVE_ACCESS_RIGHTS+'</div>', $.extend({},fancyBoxDefaults,{minWidth: 300, minHeight:60}));
						}
					}
					else {
						jsEvent.preventDefault();
						jsEvent.stopPropagation(); //not click the behind header

						setTimeout(function(){
							$.fancybox($("#A_Box_Forms_Menu"),fancyBoxDefaults);
							setTimeout(function(){
								$("#A_Box_Forms_Menu").parent('.fancybox-inner').css('height','auto');
							}, 300);
						}, 300);
					}
				}
			}
			else {
				var ptext = '<div style="font-size:17px; padding:25px 10px; text-align:center; font-weight:bold;">'+LANG.WRITE_ACCESS_PROBLEM+'<div class="not_display" style="width:520px;"></div></div>';
				$.fancybox($.extend({},fancyBoxDefaults,{minWidth: 300, content:ptext, beforeShow:function(){} }));
			}
		},
		eventMouseover: function(calEvent, jsEvent, view) {
			$(this).css('opacity', '0.5');
		},
		eventMouseout: function(event, jsEvent, view) {
			if (event.status == '0') {
				$(this).css('opacity', '0.8');
			} else {
				$(this).css('opacity', '1');
			}
		},
		loading: function(bool) {
			$('.popover').popover('hide'); //hide all popovers
		},
		viewRender: function( view, element) {
			$('.popover.in').popover('hide'); //hide all popovers
		}
	});	
	

	//add Comment Button
	//on mozila have float:left from .fc .fc-toolbar > * > *
	$("#calendar .fc-toolbar .fc-center h2").after('<br style="float:none;">' +
		//Go to date button
		'<div class="input-group" id="datetimepicker_hiddenDate" style="float:left; margin-left:-3px;"><input type="hidden" id="hiddenDate"/><button id="gotodate" type="button" title="'+LANG.BUTTON_DATUM_TOOLTIP+'" data-toggle="tooltip" data-placement="top" data-container="body" class="input-group-addon fc-button fc-state-default fc-corner-left fc-corner-right" style="height:25px; width:auto; padding:0 5px; border-left:1px solid rgba(0, 0, 0, 0.1);"><i class="fa fa-calendar"></i> '+LANG.BUTTON_DATUM+'</button></div>' +
		//border-left: 1px solid rgba(0, 0, 0, 0.1); bcz the .input-group-addon which needed it, zero it
		//addComment button
		'<button id="addComment" type="button" title="'+LANG.BUTTON_COMMENT_TOOLTIP+'" data-toggle="tooltip" data-placement="top" data-container="body" class="fc-button fc-state-default fc-corner-left fc-corner-right" style="float:right; height:25px; padding:0 5px;"><i class="fa fa-commenting"></i> '+LANG.BUTTON_COMMENT+'</button>'+
	'');
	$('#addComment').on('hover', function() {
		$(this).addClass('fc-state-hover');
	}, function() {
		$(this).removeClass('fc-state-hover');
	});
	$('#addComment').on('click',function() {
		if (V_TRAINER_W_PERMS.indexOf('All') != -1 || V_TRAINER_W_PERMS.indexOf('Notiz_n') != -1) {
			$.fancybox($("#create_comment"), $.extend({},fancyBoxDefaults,{minWidth: 300}));
			init_Comments_Create('Cal_Button');
		}
		else {
			$.fancybox('<div class="empty_message">Sie haben keine Zugriffsrechte</div>', $.extend({},fancyBoxDefaults,{minWidth: 300, minHeight:60}));
		}
	});
	
	$('#gotodate').on('hover', function() {
		$(this).addClass('fc-state-hover');
	}, function() {
		$(this).removeClass('fc-state-hover');
	});
	
	// https://eonasdan.github.io/bootstrap-datetimepicker/
	$('#datetimepicker_hiddenDate').datetimepicker({
		locale: 'de',
		format: 'YYYY-MM-DD',
		showTodayButton: true,
		showClose: true,
		allowInputToggle: true,
		widgetPositioning: {horizontal: 'auto', vertical: 'bottom'},
		//debug: true, //Will cause the date picker to stay open after a blur event.
		//icons: { date: "fa fa-calendar" },
		tooltips: {
			today: LANG.DATE_TODAY,
			clear: LANG.DATE_CLEAR,
			close: LANG.DATE_CLOSE,
			selectTime: LANG.DATE_SELECT_TIME,
			selectMonth: LANG.DATE_MONTH_SELECT,
			prevMonth: LANG.DATE_MONTH_PREV,
			nextMonth: LANG.DATE_MONTH_NEXT,
			selectYear: LANG.DATE_YEAR_SELECT,
			prevYear: LANG.DATE_YEAR_PREV,
			nextYear: LANG.DATE_YEAR_NEXT,
			selectDecade: LANG.DATE_DECADE_SELECT,
			prevDecade: LANG.DATE_DECADE_PREV,
			nextDecade: LANG.DATE_DECADE_NEXT,
			prevCentury: LANG.DATE_CENTURY_PREV,
			nextCentury: LANG.DATE_CENTURY_NEXT
		}
	});
	$("#datetimepicker_hiddenDate").on("dp.change", function (e) {
		$('#calendar').fullCalendar('gotoDate', e.date);
	});

	//if User not have any data --> message to click on Calendar
	$.get('php/ajax.php?i=forms_data&oper=cal_count&ID='+V_ATHLETE+'&group_id='+V_GROUP, function(data, result){
		if (data == '0') { //user not have data in calendar
			$('#calendar').addClass('no_calendar_data');
		}
	});

	load_New_Info(true);
	setInterval(function(){ 
		load_New_Info(false);
	}, 300000); // 5 mins
	
	//tooltip
	$('[data-toggle="tooltip"]').tooltip({ trigger: "hover" }); //if not give hover it not close after click
}); //jQuery(function()

//##############################################################################
//Functions ####################################################################
//##############################################################################

function load_New_Info(show_loading) {
	if (!V_GROUP_TRAINER) {
		if (V_ONLINE) {
			$('#rC_loading').show();
			$('#requestsCount').hide();
			$.post('index/ajax.requests_count.php', {group_id: V_GROUP}, function(data, result){
				if (data == 'login') {
					window.location.reload();
				}
				else {
					if (V_ADMIN || V_LOCATION_ADMIN || V_GROUP_ADMIN || V_GROUP_ADMIN_2) {
						$('#GRP_requestsCount').hide();
						if (data > 0) {
							$('#requestsCount').show();
							$('#requestsCountValue').text(data);
							$('#GRP_requestsCount').show();
							$('#GRP_requestsCountValue').text(data);
							if (V_requestsCount != data) {
								if ($('#A_Group_Requests').text().trim()!='') {
									load_Group_Requests();
								}
							}
							V_requestsCount = data;
						}
					}
					else if (!V_GROUP_TRAINER) {
						$('#ATH_requestsCount').hide();
						if (data > 0) {
							$('#requestsCount').show();
							$('#requestsCountValue').text(data);
							$('#ATH_requestsCount').show();
							$('#ATH_requestsCountValue').text(data);
							if (V_requestsCount != data) {
								if ($('#A_Requests_From_Trainers').text().trim()!='') {
									load_Trainers_Requests();
								}
							}
							V_requestsCount = data;
						}
					}
				}
				$('#rC_loading').hide();
			});
		}
		if (!show_loading) {
			loading.hide();
		}
	}
}

function getCalendarUrl() {
	return "php/ajax.php?i=forms_data&oper=cal&ID="+V_ATHLETE+"&group_id="+V_GROUP;
}

function init_Athletes_Select() {
	//Athlete Select ###############################################################
	$("#ATH_select").chosen({width:'100%', no_results_text: LANG.NO_RESULTS, search_contains: true, disable_search_threshold: 10});
	enable_Athletes_Select();
	
	//Athlete Select Change
	$("#ATH_select").on('change', function () {
		$('.popover').popover('hide'); //hide all popovers
		$('#calendar').fullCalendar('removeEventSources');
		//$('#calendar').fullCalendar('removeEventSource', getCalendarUrl());
		V_ATHLETE = $(this).val();
		$.cookie('ATHLETE', V_ATHLETE);
		
		//we not want anymore to change the options based on the selected user
		//options is always from the current logged in user - verion > 1.911
		
		load_Box_Forms_Menu();
		$('.popover').popover('hide'); //hide all popovers
		$('#calendar').fullCalendar('addEventSource', getCalendarUrl());
		
		//User not have any data -- message to click on Calendar
		$.get('php/ajax.php?i=forms_data&oper=cal_count&ID='+V_ATHLETE+'&group_id='+V_GROUP, function(data, result){
			if (data == '0') { //user not have data in calendar
				$('#calendar').addClass('no_calendar_data');
			} else {
				$('#calendar').removeClass('no_calendar_data');
			}
		});
	});
}
function enable_Athletes_Select() {
	$("#ATH_name_div").hide();
	$("#ATH_select_div").show();
}
function disable_Athletes_Select() {
	$("#ATH_name_div").show();
	$("#ATH_select_div").hide();
}



//##############################################################################
function init_Comments_Create(from) {
	/*from (
		Cal_Button false
		Dash_Button false
		Menu_Button false
		Cal_agendaDay true
		Cal_agendaWeek true
	)*/
	//console.log('init_Comments_Create', from);
	var dt1 = $.cookie('SELECTED_DATE') || ''; //2019-10-02 or 2019-10-02T06%3A30%3A00
	var tt1 = moment().format("HH:mm"); //now
	var in_cal = false;
	if (dt1.indexOf('T') != -1) {
		in_cal = true;
		tt1 = dt1.split('T')[1].substr(0,5);
		dt1 = dt1.split('T')[0];
	}
	var time_start = tt1;
	var time_end = moment(tt1, "HH:mm").add(1, 'hour').format("HH:mm");
	if (from == 'Cal_Button') { //current date
		dt1 = moment().format("YYYY-MM-DD");
		time_start = moment().format("HH:mm"); //now
		time_end = moment().add(1, 'hour').format("HH:mm");
		$("#isAllDay").prop('checked', true).trigger('change'); //allday true
	} 
	else if (from == 'Dash_Button') { //current date-time
		dt1 = moment().format("YYYY-MM-DD");
		time_start = moment().format("HH:mm"); //now
		time_end = moment().add(1, 'hour').format("HH:mm");
		$("#isAllDay").prop('checked', false).trigger('change'); //allday false
	} 
	else if (from == 'Menu_Button') { //click date or date-time
		if (in_cal) $("#isAllDay").prop('checked', false).trigger('change'); //allday false for week-day click
		else $("#isAllDay").prop('checked', true).trigger('change'); //allday true for month click
	} 
	else if (from == 'Cal_agendaDay' || from == 'Cal_agendaWeek') { //click cal-ollday bat --date 
		if (in_cal) $("#isAllDay").prop('checked', false).trigger('change'); //allday false for week-day click
		else $("#isAllDay").prop('checked', true).trigger('change'); //allday true for month click
	} 
	else {
		if (in_cal) $("#isAllDay").prop('checked', false).trigger('change');
		else $("#isAllDay").prop('checked', true).trigger('change');
	}
	dt1 = dt1.split('-');
	var date = dt1[2]+'.'+dt1[1]+'.'+dt1[0];
	//console.log('init_Comments_Create', from, $.cookie('SELECTED_DATE'), date, time_start, time_end);
	$('#comm_date_start').val(date);
	$('#comm_date_end').val(date);
	$('#comm_time_start').val(time_start);
	$('#comm_time_end').val(time_end);
	$('#comm_title').val('');
	$('#comm_text').val('');
	$('#comm_color').val('rgba(238,238,238,0.5)');
	$("#showInGraph").prop('checked', '');

	init_Comments(false);
} //init_Comments_Create()

function init_Comments_Edit(id, isAllDay, showInGraph, date_start, date_end, title, text, color) {
	//console.log('init_Comments_Edit', id, isAllDay, showInGraph, date_start, date_end, title, text, color);
	var dt1 = date_start.split(' ');
	var dt2 = date_end.split(' ');
	var dt1d = dt1[0].split('-');
	var dt2d = dt2[0].split('-');
	var date__start = dt1d[2]+'.'+dt1d[1]+'.'+dt1d[0];
	var date__end = dt2d[2]+'.'+dt2d[1]+'.'+dt2d[0];
	var time__start = dt1[1].substr(0,5);
	var time__end = dt2[1].substr(0,5);
	if (isAllDay) {
		$("#isAllDay").prop('checked', 'checked').trigger('change');
		dt2 = moment(date_end, "YYYY-MM-DD HH:mm:ss").subtract(1, 'second').format("YYYY-MM-DD HH:mm").split(' ');
		dt2d = dt2[0].split('-');
		date__end = dt2d[2]+'.'+dt2d[1]+'.'+dt2d[0];
		time__end = dt2[1];
	}
	else $("#isAllDay").prop('checked', '').trigger('change');
	
	$('#comm_date_start').val(date__start);
	$('#comm_date_end').val(date__end);
	$('#comm_time_start').val(time__start);
	$('#comm_time_end').val(time__end);
	$('#comm_title').val(title);
	$('#comm_text').val(text);
	$('#comm_color').val(color);
	
	init_Comments(id);
	
	//we need ot after init_Comments bcz there it reset the check
	if (showInGraph) $("#showInGraph").prop('checked', 'checked').trigger('change');
	else $("#showInGraph").prop('checked', '').trigger('change');
} //init_Comments_Edit()

function init_Comments(id) {
	//console.log('init_Comments', id);
	$('label.error:visible').remove();
	
	$('#comment_error').hide();
	
	//checkbox isAllDay
	$("#isAllDay").on('change', function() {
		on_isAllDay_check();
	});
	function on_isAllDay_check() {
		if ($("#isAllDay").is(':checked')) {
			$('#comm_date_end').prop('disabled','');
			$('#comm_time_div').hide();
		}
		else {
			$('#comm_date_end').val( $('#comm_date_start').val() );
			$('#comm_date_end').prop('disabled','disabled');
			$('#comm_time_div').show();
		}
	}
	on_isAllDay_check();
	
	
	//checkbox showInGraph
	$("#showInGraph").on('change', function() {
		on_showInGraph_check();
	});
	function on_showInGraph_check() {
		if ($("#showInGraph").is(':checked')) {
			$('#comm_color_div').show();
		}
		else {
			$('#comm_color_div').hide();
		}
	}
	on_showInGraph_check();
	
	color_field_dash('.cpC');
	$('#comm_color').trigger('change'); //to enable the background
	item_comm_Date_init('#datetimepicker_comm_start', 'left');
	item_comm_Date_init('#datetimepicker_comm_end', 'right');
	item_comm_Date_From_To_Calc_init('#comm_date_start', '#comm_date_end');
	item_comm_Time_init('#clockpicker_comm_time_start');
	item_comm_Time_init('#clockpicker_comm_time_end');
	item_comm_Time_From_To_Calc_init('#comm_time_start', '#comm_time_end');
	$("#comm_time_now").off('click').on('click',function() { //button Now
		$('#comm_time_start').val( moment().format("HH:mm") ).trigger('change'); 
	});


	//button Save Comment
	$("button#comment_save").off('click').on('click',function() {
		$('form#create_comment').validate();
		var inputs = $('form#create_comment').find(':input');
		if (!inputs.valid() && $('label.error:visible').length != 0) {
			//console.log(inputs, inputs.valid(), $('label.error:visible').length);
		}
		else {
			var t_isAllDay = $("#isAllDay").is(':checked');
			var t_date_start = moment($('#comm_date_start').val(), 'DD.MM.YYYY').format("YYYY-MM-DD");
			var t_date_end = moment($('#comm_date_end').val(), 'DD.MM.YYYY').format("YYYY-MM-DD");
			var t_time_start = $('#comm_time_start').val();
			var t_time_end = $('#comm_time_end').val();
			var t_title = $('#comm_title').val();
			var t_comment = $('#comm_text').val();
			var t_showInGraph = $("#showInGraph").is(':checked');
			var t_color = $('#comm_color').val();
			var data = {group_id: V_GROUP, athlete_id: V_ATHLETE, t_isAllDay: t_isAllDay, t_date_start: t_date_start, t_date_end: t_date_end, t_time_start: t_time_start, t_time_end: t_time_end, t_title: t_title, t_comment: t_comment, t_showInGraph: t_showInGraph, t_color: t_color};
			if (id) data['ID'] = id;
			$.post('index/ajax.comment_save.php', data, function(data, result){
				if (data == 'ERROR-MAX3') {
					$('#comment_error').show();
				} else {
					//close and reload calendar
					$('#comment_error').hide();
					$.fancybox.close();
					$('.popover').popover('hide'); //hide all popovers
					$('#calendar').fullCalendar('refetchEvents');
					$('#calendar').removeClass('no_calendar_data');
				}
			});
		}
	});
} //init_Comments()

	
//Date From -> To = auto calc
item_comm_Date_From_To_Calc_init = function (el_From, el_To) {
	$(el_From).off('change').on('change', function () { //'#t_time_from'
		var start = $(this).val();
		var end =  $(el_To).val();
		if (end == '' || moment(start, 'DD.MM.YYYY') > moment(end, 'DD.MM.YYYY')) {
			$(el_To).val(start);
		}
		if (!$("#isAllDay").is(':checked')) {
			$(el_To).val(start);
		}
	});
	$(el_To).off('change').on('change', function () { //'#t_time_to'
		var start =  $(el_From).val();
		var end = $(this).val();
		if (start == '' || moment(start, 'DD.MM.YYYY') > moment(end, 'DD.MM.YYYY')) {
			$(el_From).val(end);
		}
	});
}

//Time From -> To = auto calc
item_comm_Time_From_To_Calc_init = function (el_From, el_To) {
	$(el_From).on('change', function () { //'#t_time_from'
		var start = $(this).val();
		var end =  $(el_To).val();
		if (end == '' || start >= end) {
			end = moment(start, 'HH:mm').add(1, 'hours').format("HH:mm");
			$(el_To).val(end!='Invalid date'?end:'');
		}
	});
	$(el_To).on('change', function () { //'#t_time_to'
		var start =  $(el_From).val();
		var end = $(this).val();
		if (start == '' || start >= end) {
			start = moment(end, 'HH:mm').subtract(1, 'hours').format("HH:mm");
			$(el_From).val(start!='Invalid date'?start:'');
		}
	});
}


//comm Time
item_comm_Time_init = function (element) {
	$(element).clockpicker({
		donetext: LANG.OK
	});
}

//comm Date
item_comm_Date_init = function (element, pos) {
	$(element).datetimepicker({ //'#datetimepicker'
		locale: 'de',
		format: 'DD.MM.YYYY',
		showTodayButton: true,
		showClose: true,
		allowInputToggle: true,
		//widgetPositioning:{horizontal: 'auto', vertical: 'auto'},
		widgetPositioning: {horizontal: pos, vertical: 'bottom'},
		//debug: true, //Will cause the date picker to stay open after a blur event.
		icons: { date: "fa fa-calendar" },
		tooltips: {
			today: LANG.DATE_TODAY,
			clear: LANG.DATE_CLEAR,
			close: LANG.DATE_CLOSE,
			selectTime: LANG.DATE_SELECT_TIME,
			selectMonth: LANG.DATE_MONTH_SELECT,
			prevMonth: LANG.DATE_MONTH_PREV,
			nextMonth: LANG.DATE_MONTH_NEXT,
			selectYear: LANG.DATE_YEAR_SELECT,
			prevYear: LANG.DATE_YEAR_PREV,
			nextYear: LANG.DATE_YEAR_NEXT,
			selectDecade: LANG.DATE_DECADE_SELECT,
			prevDecade: LANG.DATE_DECADE_PREV,
			nextDecade: LANG.DATE_DECADE_NEXT,
			prevCentury: LANG.DATE_CENTURY_PREV,
			nextCentury: LANG.DATE_CENTURY_NEXT
		}
	}).on("dp.change", function (e) {
		$(this).find('input').trigger('change'); //this=div
	});
	$(element).data("DateTimePicker").widgetPositioning({horizontal: pos, vertical: 'bottom'}); //dont know why needed again here to work
}




//##############################################################################
//Trainers Requests - Athletes Answer ##########################################
function load_Trainers_Requests() {
	if (hasAccess()) {
		$("#A_Requests_From_Trainers").load("index/trainers_requests.php", {group_id: V_GROUP});
	}
}
function init_Trainers_Requests() {
	$('.trainer_link').off('click').on('click',function() {
		var trainer_id = $(this).attr('data-id');
		Edit_Athlete_2_Trainer_Forms__Load_Open(trainer_id);
	});
	$('.trainer_status').off('click').popover();
	$('.trainer_accept').off('click').on('click',function() {
		var trainer_id = $(this).attr('data-id');
		var data = {request: 'user2trainer_Answer', action: 'trainer_accept', group_id: V_GROUP, trainer_id: trainer_id};
		$.post('index/ajax.request.php', data, function(data, result){
			if (data) $("#trainer_status_message").html(data);//.show();
			load_Trainers_Requests();
			Edit_Athlete_2_Trainer_Forms__Load_Open(trainer_id);
			load_New_Info(false);
		});
	});
	$('.trainer_reject').confirmation({
		href: 'javascript:void(0)',
		title: LANG.ARE_YOU_SURE, placement: 'top',
		btnOkLabel: LANG.YES, btnOkClass: 'btn btn-sm btn-success mr10',
		btnCancelLabel: LANG.NO, btnCancelClass: 'btn btn-sm btn-danger',
		onConfirm: function(e, button) {
			var trainer_id = $(button).attr('data-id');
			var req_status = $(button).attr('data-status');
			var data = {request: 'user2trainer_Answer', action: 'trainer_reject', group_id: V_GROUP, trainer_id: trainer_id, req_status: req_status};
			$.post('index/ajax.request.php', data, function(data, result){
				if (data) $("#trainer_status_message").html(data);//.show();
				load_Trainers_Requests();
				Edit_Athlete_2_Trainer_Forms__Load_Open(trainer_id);
				load_New_Info(false);
			});
		}
	});
}








//##############################################################################
//Group Requests - GroupAdmin Answer ###########################################
function load_Group_Requests() {
	if (hasAccess()) {
		$("#A_Group_Requests").load("index/ajax.group_requests.php", {group_id: V_GROUP});
	}
}
function init_Group_Requests() {
	$('.group_user_status').off('click').popover();
	$('.group_user_accept').off('click').on('click',function() {
		loading.show();
		var user_id = $(this).attr('data-id');
		var req_status = $(this).attr('data-status');
		var data = {request: 'user2group_Answer', action: 'group_user_accept', group_id: V_GROUP, user_id: user_id, req_status: req_status};
		$.post('index/ajax.request.php', data, function(data, result){
			if (data) $("#group_user_status_message").html(data);//.show();
			load_Group_Requests();
			$("#users_group").trigger("reloadGrid", { fromServer: true }); //free-jqgrid only
			load_New_Info(false);
			loading.hide();
		});
	});
	$('.group_user_reject').off('click').confirmation({
		href: 'javascript:void(0)',
		title: LANG.ARE_YOU_SURE, placement: 'top',
		btnOkLabel: LANG.YES, btnOkClass: 'btn btn-sm btn-success mr10',
		btnCancelLabel: LANG.NO, btnCancelClass: 'btn btn-sm btn-danger',
		onConfirm: function(e, button) {
			var user_id = $(button).attr('data-id');
			var req_status = $(button).attr('data-status');
			var data = {request: 'user2group_Answer', action: 'group_user_reject', group_id: V_GROUP, user_id: user_id, req_status: req_status};
			$.post('index/ajax.request.php', data, function(data, result){
				if (data) $("#group_user_status_message").html(data);//.show();
				load_Group_Requests();
				$("#users_group").trigger("reloadGrid", { fromServer: true }); //free-jqgrid only
				load_New_Info(false);
			});
		}
	});
}



//##############################################################################
//############################  GRIDS  #########################################
//##############################################################################


//Request_Access by Athletes from Trainers #####################################
function load_Users_2_Trainers() {
	if (hasAccess()) {
		$("#A_Request_Access_From_Athletes").load("index/grid.users_trainers.php", {group_id: V_GROUP});
	}
}

//Group Users ##################################################################
function load_Users_2_Group() {
	if (hasAccess()) {
		$("#A_Group_Users").load("index/grid.users_group.php", {group_id: V_GROUP, location_id: V_Group_2_Location[V_GROUP][0]});
	}
}

//Group Users ##################################################################
function load_Location_Groups() {
	if (hasAccess()) {
		$("#A_Location_Groups").load("index/grid.location_groups.php", {location_id: V_Group_2_Location[V_GROUP][0]});
	}
}

//Forms #########################################################
function load_Forms() {
	if (hasAccess()) {
		$("#A_Forms").load("index/grid.forms.php");
	}
}

//Categories #########################################################
function load_Categories() {
	if (hasAccess()) {
		$("#A_Categories").load("index/grid.categories.php");
	}
}

//Sports Dropdowns #############################################################
function load_Sports_Dropdowns() {
	if (hasAccess()) {
		$("#A_Sports_Dropdowns").load("index/grid.sports_dropdowns.php");
	}
}

//##############################################################################
//############################  GRIDS  #########################################
//##############################################################################



//##############################################################################
//form.menu--selection js -> go to form.menu.js
//##############################################################################



//##############################################################################
//User Profile #################################################################
function init_Profile_Edit() {
	$("#SPORTS_select").chosen({width:'100%', multiple:true, create_option:true, create_option_text:LANG.NEW_OPTION, no_results_text:LANG.NO_RESULTS, search_contains:true}).change(function() {
		$(this).parent('div').find('label.error').remove(); //remove required error if select something
	});
	$("#telephone").intlTelInput({initialCountry:'de', preferredCountries:['de'],separateDialCode:true});
	$("#telephone").inputFilter(function(value) { //Floating point (use . or , as decimal separator):
		return /^-?\d*[ ]?\d*$/.test(value);
	});	

  $("button#profile_save").off('click').on('click',function() {
		//$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" }) //for all select having class .chosen-select
		$('form#profile_edit').validate({
			ignore: [":hidden:not(.chosen-select)"],
			//rules: {passwd: "required",	pass_confirm: {equalTo: "#passwd"} },
			errorPlacement: function(error, element) {
				if (element.is(':radio') || element.is(":checkbox")) {
					error.insertBefore( element.parent().parent() );
				} else { 
					error.insertAfter( element );
				}
			}
		});
		var inputs = $('form#profile_edit').find(':input');
		if (!inputs.valid() && $('label.error:visible').length != 0) {
			$(".fancybox-inner").animate({ scrollTop: $('label.error:visible:first').offset().top - $(".fancybox-inner").offset().top + $(".fancybox-inner").scrollTop() }, "slow");
		}
		else {
			var uid 		= $('form#profile_edit input[name=uid]').val();
			var uname 		= $('form#profile_edit input[name=uname]').val();
			var passwd 		= $('form#profile_edit input[name=passwd]').val();
			var pass_confirm= $('form#profile_edit input[name=pass_confirm]').val();
			if (passwd != '') {
				//check if password and password confirm match --alternative http://jqueryvalidation.org/equalTo-method
				if (passwd != pass_confirm) {
					alert(LANG.WARN_CONFIRM_PASSWORD);
					$(".fancybox-inner").animate({ scrollTop: $('form#profile_edit input[name=passwd]').offset().top - $(".fancybox-inner").offset().top + $(".fancybox-inner").scrollTop() -25 }, "slow");
					return false;
				}
			}
			$.ajax({ //check if username exist --alternative http://jqueryvalidation.org/remote-method
				url: "login/ajax.check_user_exist.php?uname="+uname+'&uid='+uid,
				success: function(data) {
					if (data == 'OK') {
						var lastname 	= $('form#profile_edit input[name=lastname]').val();
						var firstname	= $('form#profile_edit input[name=firstname]').val();
						var email 		= $('form#profile_edit input[name=email]').val();
						var telephone	= $("form#profile_edit .iti__selected-dial-code").text()+' '+$("#telephone").val();
						var sport 		= $('form#profile_edit select[name=sport]').val();
						var body_height = $('form#profile_edit select[name=body_height]').val();
						var sex 		= $('form#profile_edit input[name=sex]:checked').val();
						var birth_year 	= $('form#profile_edit select[name=birth_year]').val();
						var birth_month = $('form#profile_edit select[name=birth_month]').val();
						var birth_day	= $('form#profile_edit select[name=birth_day]').val();
						var dashboard 	= $('form#profile_edit input[name=dashboard]:checked').val();
						var location 	= $('form#profile_edit input[name=location]').val();
						var group_id	= $('form#profile_edit input[name=group_id]').val();
						var group_name	= $('form#profile_edit input[name=group_name]').val();
						var level_id 	= $('form#profile_edit input[name=level_id]').val();
						var profile 	= $('form#profile_edit input[name=profile]').val();
						var data = {uname: uname, passwd: passwd, pass_confirm: pass_confirm, lastname: lastname, firstname: firstname, email: email, telephone: telephone, sport: sport, body_height: body_height, sex: sex, birth_year: birth_year, birth_month: birth_month, birth_day: birth_day, dashboard: dashboard, location: location, group_id: group_id, group_name: group_name, level_id: level_id, profile: profile};
						$.post('login/ajax.profile_save.php', data, function(data, result){
							$("#profile_alerts").html(data);
						});
					}
					else {
						alert(data.replace(/<br>/g, '\n'));
					}
				}
			});
		}
	});
}




//#######################################################################
//Group Select/Actions #########################################################################
function group_icons_buttons() {
	//hide messages
	$("#group_buttons_message_in").hide();
	$("#group_buttons_message").hide();
	
	//add Icon
	var g_message = '';
	var g_class = '';
	var g_submit = 'group_user_request_access';
	if (V_GROUP in V_User_2_Groups) {
		var group_status = V_User_2_Groups[V_GROUP].status;
		 g_message = LANG.REQUEST_STATUS_UPDATED.replace('{DATE_TIME}', '<b>'+V_User_2_Groups[V_GROUP].modified+'</b>');
		if (group_status=='0') {
			g_class = 'G_no';
			g_submit = 'group_user_request_access_AN';
		} else if (group_status=='1') {
			g_class = 'G_yes';
			g_submit = 'group_user_cancel_access_user';
		} else if (group_status=='2') {
			g_class = 'G_yesStop';
			g_submit = 'group_user_cancel_access_user';
		} else if (group_status=='5') {
			g_class = 'G_leaveR';
			g_submit = 'group_user_request_access_AL_user';
		} else if (group_status=='15') {
			g_class = 'G_leaveA';
			g_submit = 'group_user_request_access_AL_groupadmin';
		} else if (group_status=='7' || group_status=='17' || group_status=='8' || group_status=='9') {
			g_class = 'G_wait';
			if (group_status=='7') g_class = 'G_waitLR';
			else if (group_status=='17') g_class = 'G_waitLA';
			else if (group_status=='8') g_class = 'G_waitN';
			else if (group_status=='9') g_class = 'G_wait';
			g_submit = 'group_user_cancel_request_user';
			g_message = LANG.REQUEST_WAS_SENT_AT.replace('{DATE_TIME}', '<b>'+V_User_2_Groups[V_GROUP].modified+'</b>');
		}
	}
	
	//selected group icon
	$("#GRP_select_chosen a span").removeClass('G_yes').removeClass('G_yesStop').removeClass('G_no').removeClass('G_leaveR').removeClass('G_leaveA').removeClass('G_waitLR').removeClass('G_waitLR').removeClass('G_waitN').removeClass('G_wait').addClass(g_class);
	$("#GRP_select_chosen a span").append('<i title="'+$('#GRP_select option:selected').attr('data-status')+'">&nbsp;</i>');
	
	//group_buttons
	if (g_submit != 'group_user_cancel_access_user') { //if not have access
		$("#views").hide();
		$("#view_radio").hide();
		$("#group_buttons").show();
		//$("#group_data").hide();
	} else { //if have access
		$("#views").show();
		$("#view_radio").show();
		$("#group_buttons").hide();
		//$("#group_data").show();
	}
	$(".submit_group").hide();
	$("#"+g_submit).show();
	
	//show messages
	if (g_submit == 'group_user_request_access') {
		//no message
	} else if (g_submit == 'group_user_cancel_access_user') {
		$("#group_buttons_message_in").html(g_message).show();
	} else {
		$("#group_buttons_message").html(g_message).show();
	}
} //function group_icons_buttons()

function replaceAll(str, find, replace) {
	function escapeRegExp(str) {
		return str.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
	}
	return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}


// Filter Numbers ///////////////////////////////////////////////////////
// Restricts input for each element in the set of matched elements to the given inputFilter.
(function($) {
	$.fn.inputFilter = function(inputFilter) {
		return this.on("input keydown keyup mousedown mouseup select contextmenu drop blur", function(e) {
			this.value = this.value.replace('.', ',');
			if (inputFilter(this.value)) {
				this.oldValue = this.value;
				this.oldSelectionStart = this.selectionStart;
				this.oldSelectionEnd = this.selectionEnd;
			} else if (this.hasOwnProperty("oldValue")) {
				this.value = this.oldValue;
				this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
			}
			if ((e.type == 'blur' || e.keyCode == 13) && this.value != '') $(this).trigger('change'); //bcz in EDGE we lose event after this point
		});
	};
}(jQuery));
// Filter Numbers ///////////////////////////////////////////////////////


//is iOS
function is_iOS() { //mono ta iphone/ipad 
	var iDevices = ['iPad Simulator', 'iPhone Simulator', 'iPod Simulator', 'iPad', 'iPhone', 'iPod'];
	if (!!navigator.platform) {
		while (iDevices.length) {
			if (navigator.platform === iDevices.pop()){ return true; }
		}
	}
	return false;
}

