<?php // Group Users Grid
require_once('../_settings.regmon.php');
require('../login/validate.php');
//require_once('../php/functions.php');

if (!$ADMIN AND !$LOCATION_ADMIN AND !$GROUP_ADMIN AND !$GROUP_ADMIN_2) exit;

$location_id = isset($_REQUEST['location_id']) ? $_REQUEST['location_id'] : false;
$group_id = isset($_REQUEST['group_id']) ? $_REQUEST['group_id'] : false;
if (!$location_id) exit;
if (!$group_id) exit;
?>
<script type="text/javascript" src="index/js/grid.group_users.js<?=$G_VER;?>"></script>
<table id="group_users" alt=""></table>
<div id="UGpager"></div>
<br>
<div id="req_group_users_message" style="text-align:center;"></div>
<div style="text-align:center; padding:5px 0 20px;">
	<button id="group_user_cancel_access_groupadmin" type="button" class="btn btn-danger bttn bttn_red"><?=$LANG->REQUEST_GROUP_LEAVE_USER;?> &nbsp; &nbsp; <span class="req G_leaveA"></span></button>
</div>
