<?php
function get_date(string $date) {
	global $LANG;
	if ($date == '') return '';
	elseif($LANG->LANG_CURRENT == 'de') {
		$date = date("d.m.Y", strtotime($date));
	}
	else $date = date("Y-m-d", strtotime($date));
	return $date;
}
function get_date_time(string $date) {
	global $LANG;
	if ($date == '') return '';
	elseif($LANG->LANG_CURRENT == 'de') {
		$date = date("d.m.Y H:i:s", strtotime($date));	
	}
	else $date = date("Y-m-d H:i:s", strtotime($date));	
	return $date;
}
function get_date_SQL(string $date) {
	if ($date == '') return '';
	else $date = date("Y-m-d", strtotime($date));
	return $date;
}
function get_date_time_SQL(string $date) {
	if ($date == '') return '';
	else $date = date("Y-m-d H:i:s", strtotime($date));	
	return $date;
}
?>