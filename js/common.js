var loading;

function replaceAll(str, find, replace) {
	function escapeRegExp(str) {
		return str.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
	}
	return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}
function replaceAll_Object(str, obj) {
	Object.keys(obj).forEach(function(key,index) {
		str = replaceAll(str, key, obj[key]);
	});
	return str;
}
function replaceAll_Object_Exact(str, obj) {
	Object.keys(obj).forEach(function(key,index) {
		//console.log(str, key, obj[key]);
		if (str == key) { //replace only if match exacly
			str = replaceAll(str, key, obj[key]);
		}
	});
	return str;
}

//##########################################
//Date Functions
function get_date(date) { //language specific
	if (date == '') {
		return '';
	}
	if (date.indexOf('-') != -1) {
		date = moment(date, "YYYY-MM-DD");
	}
	else if (date.indexOf('.') != -1) {
		date = moment(date, "DD.MM.YYYY");
	}
	if (LANG.LANG_CURRENT == 'en') {
		date = date.format("YYYY-MM-DD");
	} else {
		date = date.format(LANG.MOMENT.DATE);
	}
	if (date == 'Invalid date') {
		return '';
	}
	return date;
}
function get_date_obj(date) { //general
	if (date == '') {
		return '';
	}
	if (date.indexOf('-') != -1) {
		date = moment(date, "YYYY-MM-DD");
	}
	else if (date.indexOf('.') != -1) {
		date = moment(date, "DD.MM.YYYY");
	}
	return date;
}
function get_date_time(date) { //language specific
	if (date == '') {
		return '';
	}
	if (date.indexOf('-') != -1) {
		date = moment(date, "YYYY-MM-DD HH:mm:ss");
	}
	else if (date.indexOf('.') != -1) {
		date = moment(date, "DD.MM.YYYY HH:mm:ss");
	}
	if (LANG.LANG_CURRENT == 'en') {
		date = date.format("YYYY-MM-DD HH:mm:ss");
	} else {
		date = date.format(LANG.MOMENT.DATE_TIME);
	}
	if (date == 'Invalid date') {
		return '';
	}
	return date;
}
function get_date_time_noSecs(date) { //language specific
	if (date == '') {
		return '';
	}
	if (date.indexOf('-') != -1) {
		date = moment(date, "YYYY-MM-DD HH:mm");
	}
	else if (date.indexOf('.') != -1) {
		date = moment(date, "DD.MM.YYYY HH:mm");
	}
	if (LANG.LANG_CURRENT == 'en') {
		date = date.format("YYYY-MM-DD HH:mm");
	} else {
		date = date.format(LANG.MOMENT.DATE_TIME_NOSECS);
	}
	if (date == 'Invalid date') {
		return '';
	}
	return date;
}
function get_date_SQL(date) { //general
	if (date == '') {
		return '';
	}
	if (date.indexOf('-') != -1) {
		date = moment(date, "YYYY-MM-DD").format("YYYY-MM-DD");
	}
	else if (date.indexOf('.') != -1) {
		date = moment(date, "DD.MM.YYYY").format("YYYY-MM-DD");
	}
	if (date == 'Invalid date') {
		return '';
	}
	return date;
}
function get_date_time_SQL(date) { //general
	if (date == '') {
		return '';
	}
	if (date.indexOf('-') != -1) {
		return moment(date, "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD HH:mm:ss");
	}
	else if (date.indexOf('.') != -1) {
		return moment(date, "DD.MM.YYYY HH:mm:ss").format("YYYY-MM-DD HH:mm:ss");
	}
	if (date == 'Invalid date') {
		return '';
	}
	return date;
}



jQuery(function ()
{
	loading = $("#loading");
	$(document).ajaxStart(function () {
		loading.show();
	});
	$(document).ajaxStop(function () {
		if (typeof V_CONTINUE_LOADING !== 'undefined' && !V_CONTINUE_LOADING) {
			loading.hide();
		} else if (typeof V_GRID_SAVE !== 'undefined' && !V_GRID_SAVE) {
			loading.hide();
		} else {
			loading.hide();
		}
	});
	
	//Languages
	$("#lang_de").off('click').on('click', function () {
		if ($.cookie('LANG') == 'de') return false;
		$.cookie('LANG', 'de', { expires: 365, path: '/' + V_REGmon_Folder });
		window.location.reload();
	});
	$("#lang_en").off('click').on('click', function () {
		if ($.cookie('LANG') == 'en') return false;
		$.cookie('LANG', 'en', { expires: 365, path: '/' + V_REGmon_Folder });
		window.location.reload();
	});

	//Home Button
	$("button.home").off('click').on('click', function () {
		window.location.href = '.';
	});

	$("button.home_parent").off('click').on('click', function () {
		window.location.href = '../';
	});

	// SCROLL TO TOP 
	$(window).on('scroll',function() {
		if($(this).scrollTop() != 0) {
			$('#toTop').fadeIn();	
		} else {
			$('#toTop').fadeOut();
		}
	});
	
	$('#toTop').on('click',function() {
		$('body,html').animate({scrollTop:0},500);
	});	
	
});
