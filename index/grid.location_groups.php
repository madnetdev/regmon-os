<?php // Location Groups Grid
require_once('../_settings.regmon.php');
require('../login/validate.php');

if (!$ADMIN AND !$LOCATION_ADMIN) exit;

$location_id = isset($_REQUEST['location_id']) ? $_REQUEST['location_id'] : false;
if (!$location_id) exit;
?>
<table id="location_groups" alt="<?=$LANG->LOCATION_GROUPS;?>"></table>
<div id="SGpager"></div>
<div id="location_groups_message" style="text-align:center;"></div>
<script>
<?php 
//Group Admins Select Options
$admins_options = ':'; 
$rows = $db->fetch("SELECT id, uname FROM users WHERE status = 1 AND (level = 40 OR level = 45) AND location_id = ? ORDER BY id", array($location_id)); 
if ($db->numberRows() > 0)  {
	foreach ($rows as $row) {
		$admins_options .=  ';' . $row['id'].':'.addslashes($row['uname']);
	}
}
//$('#LOCATION_GROUPS_name').html(' &nbsp; ( < ?=$location['name'];? > )');
?>
V_GROUP_ADMINS_OPTIONS = "<?=$admins_options;?>";
<?php include('../index/js/grid.location_groups.js');?>
</script>
