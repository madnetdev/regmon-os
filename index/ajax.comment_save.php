<?php // saves a comment to db
require_once('../_settings.regmon.php');
require('../login/validate.php');

$ID = isset($_REQUEST['ID']) ? abs($_REQUEST['ID']) : false; //abs fix negative ID
$group_id = isset($_REQUEST['group_id']) ? $_REQUEST['group_id'] : false;
$athlete_id = isset($_REQUEST['athlete_id']) ? $_REQUEST['athlete_id'] : false;
$t_isAllDay = isset($_REQUEST['t_isAllDay']) ? $_REQUEST['t_isAllDay'] : 'true';
$t_date_start = isset($_REQUEST['t_date_start']) ? $_REQUEST['t_date_start'] : date("Y-m-d");
$t_date_end = isset($_REQUEST['t_date_end']) ? $_REQUEST['t_date_end'] : date("Y-m-d");
$t_time_start = isset($_REQUEST['t_time_start']) ? $_REQUEST['t_time_start'] : date("H:i");
$t_time_end = isset($_REQUEST['t_time_end']) ? $_REQUEST['t_time_end'] : date("H:i");
$t_title = isset($_REQUEST['t_title']) ? $_REQUEST['t_title'] : '';
$t_comment = isset($_REQUEST['t_comment']) ? $_REQUEST['t_comment'] : '';
$t_showInGraph = isset($_REQUEST['t_showInGraph']) ? $_REQUEST['t_showInGraph'] : 'false';
$t_color = isset($_REQUEST['t_color']) ? $_REQUEST['t_color'] : '#aaaaaa';

if ($t_isAllDay == 'true') {
	$selected_date_start = date("Y-m-d H:i:s", strtotime($t_date_start.' 00:00:00'));
	$selected_date_end = date("Y-m-d H:i:s", strtotime($t_date_end.' 23:59:59'));
} else {
	$selected_date_start = date("Y-m-d H:i:s", strtotime($t_date_start.' '.$t_time_start));
	$selected_date_end = date("Y-m-d H:i:s", strtotime($t_date_end.' '.$t_time_end));
}

if ($group_id AND $athlete_id)
{
	//count num of comments in calendar in that day
	if (!$ID) { //dont check if is update
		$selected_date_start_day = date("Y-m-d", strtotime($t_date_start));
		$row = $db->fetchRow("SELECT COUNT(*) AS count FROM comments WHERE user_id = ? AND group_id = ? AND created LIKE '$selected_date_start_day%'", array($athlete_id, $group_id));
		if ($row['count'] >= 3) {
			//not accept more than 3 comments a day
			echo 'ERROR-MAX3';
			exit;
		}
	}

	$values = array();
	$values['user_id'] = $athlete_id;
	$values['group_id'] = $group_id;
	$values['isAllDay'] = ($t_isAllDay=='true' ? 1 : 0);
	$values['showInGraph'] = ($t_showInGraph=='true' ? 1 : 0);
	$values['name'] = $t_title;
	$values['comments'] = $t_comment;
	$values['color'] = $t_color;
	$values['modified'] = date("Y-m-d H:i:s");
	$values['created'] = $selected_date_start;
	$values['created_end'] = $selected_date_end;
	
	if ($ID) {
		$save = $db->update($values, "comments", "id=?", array($ID));
	}
	else {
		$save = $db->insert($values, "comments");
	}
	
	if ($save) {
		echo 'OK';
	}
	else {
		echo 'ERROR';
	}
}
else {
	echo 'ERROR';
}
?>