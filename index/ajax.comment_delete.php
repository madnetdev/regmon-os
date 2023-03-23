<?php // ajax Comment Delete
require_once('../_settings.regmon.php');
require('../login/validate.php');

$ID = isset($_REQUEST['ID']) ? abs($_REQUEST['ID']) : false; //abs fix negative ID
$group_id = isset($_REQUEST['group_id']) ? $_REQUEST['group_id'] : false;
$athlete_id = isset($_REQUEST['athlete_id']) ? $_REQUEST['athlete_id'] : false;

if ($ID AND $group_id AND $athlete_id) 
{
	$delete = $db->delete("comments", "user_id = ? AND group_id = ? AND id = ?", array($athlete_id, $group_id, $ID));

	if ($delete) {
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