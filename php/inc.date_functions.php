<?php // Date Functions

if ($SEC_check != $CONFIG['SEC_Page_Secret']) exit;

function get_date(string $date) {
	global $LANG;
	if ($date == '') return '';
	elseif ($date == 'now') {
		$date = date("Y-m-d");	
	}
	if ($LANG->LANG_CURRENT == 'de') {
		return date("d.m.Y", strtotime($date));
	} else {
		return date("Y-m-d", strtotime($date));
	}
}
function get_date_time(string $date) {
	global $LANG;
	if ($date == '') {
		return '';
	}
	elseif ($date == 'now') {
		$date = date("Y-m-d H:i:s");	
	}
	if ($LANG->LANG_CURRENT == 'de') {
		return date("d.m.Y H:i:s", strtotime($date));	
	} else {
		return date("Y-m-d H:i:s", strtotime($date));
	}
}
function get_date_time_noSecs(string $date) {
	global $LANG;
	if ($date == '') {
		return '';
	}
	elseif ($date == 'now') {
		$date = date("Y-m-d H:i");	
	}
	if ($LANG->LANG_CURRENT == 'de') {
		return date("d.m.Y H:i", strtotime($date));	
	} else {
		return date("Y-m-d H:i", strtotime($date));
	}
}
function get_date_SQL(string $date) {
	if ($date == '') {
		return '';
	} 
	elseif ($date == 'now') {
		$date = date("Y-m-d");	
	}
	return date("Y-m-d", strtotime($date));
}
function get_date_time_SQL(string $date) {
	if ($date == '') {
		return '';
	} 
	elseif ($date == 'now') {
		$date = date("Y-m-d H:i:s");	
	}
	return date("Y-m-d H:i:s", strtotime($date));
}
?>