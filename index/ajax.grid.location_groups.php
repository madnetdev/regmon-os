<?php // Location Groups Grid
require_once('../_settings.regmon.php');
require('../login/validate.php');

if (!$ADMIN AND !$LOCATION_ADMIN) exit;

$location_id = isset($_REQUEST['location_id']) ? $_REQUEST['location_id'] : false;
if (!$location_id) exit;
?>
<script type="text/javascript" src="../index/js/grid.location_groups.js<?=$G_VER;?>"></script>
<table id="location_groups" alt="<?=$LANG->LOCATION_GROUPS;?>"></table>
<div id="SGpager"></div>
