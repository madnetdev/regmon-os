<?php // index functions

// print_r alias function
function PR($array) {
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}

function get_User_2_Groups($_UID) {
	global $db;
	$user_2_groups = array();
	$rows = $db->fetch("SELECT group_id, status, modified FROM users2groups WHERE user_id = ? ", array($_UID));
	if ($db->numberRows() > 0) {
		foreach ($rows as $row) {
			$user_2_groups[$row['group_id']]['status'] = $row['status'];
			$user_2_groups[$row['group_id']]['modified'] = get_date_time($row['modified'] . '');
		}
	}
	return $user_2_groups;
}

function get_Trainers_2_Groups() {
	global $db;
	$trainers_2_groups = array();
	$rows = $db->fetch("SELECT u2g.group_id, GROUP_CONCAT(CONVERT(u.id, CHAR(11))) AS ids 
		FROM users2groups u2g 
		LEFT JOIN users u ON u.id = u2g.user_id AND u.level = 30 AND u.status = 1 
		WHERE u2g.status = 1 GROUP BY u2g.group_id", array()); 
	if ($db->numberRows() > 0)  {
		foreach ($rows as $row) {
			$trainers_2_groups[$row['group_id']] = $row['ids'];
		}
	}
	return $trainers_2_groups;
}

function get_Locations() {
	global $db;
	$locations = array();
	$rows = $db->fetch("SELECT id, name, admin_id FROM locations WHERE status = 1 ORDER BY id", array()); 
	if ($db->numberRows() > 0)  {
		foreach ($rows as $row) {
			$locations[$row['id']] = array($row['name'], $row['admin_id']);
		}
	}
	return $locations;
}

function get_Group_Request_Status_Class($group_status) {
	$status_array = array(
		'0' => 'G_no',
		'1' => 'G_yes',
		'2' => 'G_yesStop',
		'5'	=> 'G_leaveR',
		'15'=> 'G_leaveA',
		'7'	=> 'G_waitLR',
		'17'=> 'G_waitLA',
		'8'	=> 'G_waitN',
		'9'	=> 'G_wait'
	);
	return $status_array[$group_status] ?? '';
}

// get Dashboard Links Array
function get_Dashboard_Links_Array($_UID, $_GROUP) {
	global $db;
	$dashboard_array = '';
	$dash_rows = $db->fetch("SELECT id, name, type, options, sort, color FROM dashboard WHERE user_id=? AND group_id=? ORDER BY  name", array($_UID, $_GROUP)); 
	if ($db->numberRows() > 0) {
		foreach ($dash_rows as $dash) {
			if ($dashboard_array != '') $dashboard_array .= ',';
			$dashboard_array .= '['.$dash['id'].',"'.$dash['name'].'","'.$dash['type'].'","'.$dash['options'].'",'.$dash['sort'].',"'.$dash['color'].'"]';
		}
	}
	return $dashboard_array;
}

?>