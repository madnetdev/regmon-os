<?php // ajax Dashboard Delete
require_once('../_settings.regmon.php');
require('../login/validate.php');
require('../index/index_functions.php');

$group_id = isset($_REQUEST['group_id']) ? $_REQUEST['group_id'] : false;
$ath_id = isset($_REQUEST['ath_id']) ? $_REQUEST['ath_id'] : false;
$dash_id = isset($_REQUEST['dash_id']) ? $_REQUEST['dash_id'] : false;
if (!$group_id OR !$ath_id OR !$dash_id) exit;

if ($dash_id AND $dash_id != '') { //delete dashboard entry
	$db->delete("dashboard", "user_id=? AND group_id=? AND id=?", array($ath_id, $group_id, $dash_id));
}

//return the new Dashboard Links Array
$Dashboard_Links_Arr = get_Dashboard_Links_Array($ath_id, $group_id);
?>
<script>
V_DASHBOARD=[<?=$Dashboard_Links_Arr;?>];
</script>