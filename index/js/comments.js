"use strict";

// Comments functions

//initialize Comments
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
			$('#comment_date_end').prop('disabled','');
			$('#comment_time_div').hide();
		}
		else {
			$('#comment_date_end').val( $('#comment_date_start').val() );
			$('#comment_date_end').prop('disabled','disabled');
			$('#comment_time_div').show();
		}
	}
	on_isAllDay_check();
	
	
	//checkbox showInGraph
	$("#showInGraph").on('change', function() {
		on_showInGraph_check();
	});
	function on_showInGraph_check() {
		if ($("#showInGraph").is(':checked')) {
			$('#comment_color_div').show();
		}
		else {
			$('#comment_color_div').hide();
		}
	}
	on_showInGraph_check();
	
	color_field_dash('.cpC');
	$('#comment_color').trigger('change'); //to enable the background
	item_Comment_Date_init('#datetimepicker_comment_start', 'left');
	item_Comment_Date_init('#datetimepicker_comment_end', 'right');
	item_Comment_Date_From_To_Calc_init('#comment_date_start', '#comment_date_end');
	item_Comment_Time_init('#clockpicker_comment_time_start');
	item_Comment_Time_init('#clockpicker_comment_time_end');
	item_Comment_Time_From_To_Calc_init('#comment_time_start', '#comment_time_end');
	$("#comment_time_now").off('click').on('click',function() { //button Now
		$('#comment_time_start').val( moment().format("HH:mm") ).trigger('change'); 
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
			var t_date_start = get_date_SQL($('#comment_date_start').val());
			var t_date_end = get_date_SQL($('#comment_date_end').val());
			var t_time_start = $('#comment_time_start').val();
			var t_time_end = $('#comment_time_end').val();
			var t_title = $('#comment_title').val();
			var t_comment = $('#comment_text').val();
			var t_showInGraph = $("#showInGraph").is(':checked');
			var t_color = $('#comment_color').val();
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

//initialize Comments Create
function init_Comments_Create(from) {
	/*from (
		Cal_Button false
		Dash_Button false
		Menu_Button false
		Cal_agendaDay true
		Cal_agendaWeek true
	)*/
	//console.log('init_Comments_Create', from);
	var date = $.cookie('SELECTED_DATE') || ''; //2019-10-02 or 2019-10-02T06%3A30%3A00
	var tt1 = moment().format("HH:mm"); //now
	var in_cal = false;
	if (date.indexOf('T') != -1) {
		in_cal = true;
		tt1 = date.split('T')[1].substr(0,5);
		date = date.split('T')[0];
	}
	var time_start = tt1;
	var time_end = moment(tt1, "HH:mm").add(1, 'hour').format("HH:mm");
	if (from == 'Cal_Button') { //current date
		date = moment().format("YYYY-MM-DD");
		time_start = moment().format("HH:mm"); //now
		time_end = moment().add(1, 'hour').format("HH:mm");
		$("#isAllDay").prop('checked', true).trigger('change'); //allday true
	} 
	else if (from == 'Dash_Button') { //current date-time
		date = moment().format("YYYY-MM-DD");
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
	//console.log('init_Comments_Create', from, $.cookie('SELECTED_DATE'), date, time_start, time_end);
	$('#comment_date_start').val(get_date(date));
	$('#comment_date_end').val(get_date(date));
	$('#comment_time_start').val(time_start);
	$('#comment_time_end').val(time_end);
	$('#comment_title').val('');
	$('#comment_text').val('');
	$('#comment_color').val('rgba(238,238,238,0.5)');
	$("#showInGraph").prop('checked', '');

	init_Comments(false);
} //init_Comments_Create()

//initialize Comments Edit
function init_Comments_Edit(id, isAllDay, showInGraph, date_start, date_end, title, text, color) {
	//console.log('init_Comments_Edit', id, isAllDay, showInGraph, date_start, date_end, title, text, color);
	var dt1 = date_start.split(' ');
	var dt2 = date_end.split(' ');
	var date__start = dt1[0];
	var date__end = dt2[0];
	var time__start = dt1[1].substr(0,5);
	var time__end = dt2[1].substr(0,5);
	if (isAllDay) {
		$("#isAllDay").prop('checked', 'checked').trigger('change');
		dt2 = moment(date_end, "YYYY-MM-DD HH:mm:ss").subtract(1, 'second').format("YYYY-MM-DD HH:mm").split(' ');
		date__end = dt2[0];
		time__end = dt2[1];
	}
	else $("#isAllDay").prop('checked', '').trigger('change');
	
	$('#comment_date_start').val(get_date(date__start));
	$('#comment_date_end').val(get_date(date__end));
	$('#comment_time_start').val(time__start);
	$('#comment_time_end').val(time__end);
	$('#comment_title').val(title);
	$('#comment_text').val(text);
	$('#comment_color').val(color);
	
	init_Comments(id);
	
	//we need ot after init_Comments bcz there it reset the check
	if (showInGraph) $("#showInGraph").prop('checked', 'checked').trigger('change');
	else $("#showInGraph").prop('checked', '').trigger('change');
} //init_Comments_Edit()

//#####################################################

//initialize Comment Date
function item_Comment_Date_init(element, pos) {
	$(element).datetimepicker({ //'#datetimepicker'
		locale: LANG.LANG_CURRENT,
		format: LANG.MOMENT.DATE,
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

//initialize Comment Time
function item_Comment_Time_init(element) {
	$(element).clockpicker({
		donetext: LANG.OK
	});
}

//initialize Date From -> To = auto calc
function item_Comment_Date_From_To_Calc_init(el_From, el_To) {
	$(el_From).off('change').on('change', function () { //'#t_time_from'
		var start = $(this).val();
		var end =  $(el_To).val();
		if (end == '' || get_date_obj(start) > get_date_obj(end)) {
			$(el_To).val(start);
		}
		if (!$("#isAllDay").is(':checked')) {
			$(el_To).val(start);
		}
	});
	$(el_To).off('change').on('change', function () { //'#t_time_to'
		var start =  $(el_From).val();
		var end = $(this).val();
		if (start == '' || get_date_obj(start) > get_date_obj(end)) {
			$(el_From).val(end);
		}
	});
}

//initialize Time From -> To = auto calc
function item_Comment_Time_From_To_Calc_init(el_From, el_To) {
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

