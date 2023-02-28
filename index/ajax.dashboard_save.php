<?php // saves a dashboard entry to db
require_once('../_settings.regmon.php');
require('../login/validate.php');
require('../index/index_functions.php');

$group_id = isset($_REQUEST['group_id']) ? $_REQUEST['group_id'] : false;
$ath_id = isset($_REQUEST['ath_id']) ? $_REQUEST['ath_id'] : false;
$dash_id = isset($_REQUEST['dash_id']) ? $_REQUEST['dash_id'] : 'max';
$name = isset($_REQUEST['name']) ? $_REQUEST['name'] : false;
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : false;
$options = isset($_REQUEST['options']) ? $_REQUEST['options'] : false;
$sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 0;
$color = isset($_REQUEST['color']) ? $_REQUEST['color'] : '#cccccc';
if (!$group_id OR !$ath_id OR !$name OR !$type OR !$options) exit;

$values = array();
$values['user_id'] = $ath_id;
$values['group_id'] = $group_id;
$values['name'] = $name;
$values['type'] = $type;
$values['options'] = $options;
$values['color'] = $color;
$values['modified'] = date("Y-m-d H:i:s");
$values['modified_by'] = $USERNAME;

if ($sort == 'max') {
	$sort_max = $db->fetchRow("SELECT MAX(sort) AS max_sort FROM dashboard WHERE user_id=? AND group_id=?", array($ath_id, $group_id)); 
	$sort = $sort_max['max_sort'] + 1;
}
$values['sort'] = $sort;

if ($dash_id AND $dash_id != '') { //update
	$update = $db->update($values, "dashboard", "user_id=? AND group_id=? AND id=?", array($ath_id, $group_id, $dash_id));
}
else { //new
	$values['created'] = date("Y-m-d H:i:s");
	$values['created_by'] = $USERNAME;
	$insert = $db->insert($values, "dashboard");
}

//return the new Dashboard Links Array
$Dashboard_Links_Array = get_Dashboard_Links_Array($ath_id, $group_id);
?>
<script>
V_DASHBOARD=[<?=$Dashboard_Links_Array;?>];
</script>
