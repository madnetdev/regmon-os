<?php // ajax Trainer Athletes Select
require_once('../_settings.regmon.php');
require('../login/validate.php');

$group_id = isset($_REQUEST['group_id']) ? $_REQUEST['group_id'] : false;
$athlete_id = isset($_REQUEST['athlete_id']) ? $_REQUEST['athlete_id'] : false;
if (!$group_id) exit;


$html = '';

//Select Athletes in Group with Trainer this User-$UID
$rows = $db->fetch("SELECT u.id, u.lastname, u.firstname FROM `users2groups` u2g 
JOIN `users` u ON u.id = u2g.user_id AND u.level = 10 AND u.status = 1
JOIN `users2trainers` u2t ON u.id = u2t.user_id AND u2g.group_id = u2t.group_id AND u2t.status = 1 AND u2t.trainer_id = ?
WHERE u2g.group_id = ? AND u2g.status = 1 ORDER BY u.id", array($UID, $group_id)); 
//print_r($rows); 
if ($db->numberRows() > 0) {
	$html = '<label for="TRN_ATH_select" style="font-size:17px;">'.$LANG->LVL_ATHLETE.' : &nbsp; </label><select name="TRN_ATH_select" id="TRN_ATH_select">';
	$html .= '<option value=""></option>';
	foreach ($rows as $row) {
		$selected = '';
		if ($athlete_id == $row['id']) $selected = ' selected';
		$html .= '<option value="'.$row['id'].'"'.$selected.'>'.$row['firstname'].' &nbsp; '.$row['lastname'].' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </option>';
	}
	$html .= '</select>';
}
else {
	$html = '<div class="empty_message">'.$LANG->ATHLETES_NOT_AVALABLE.'</div>';
}

echo $html;
?>
<?php /*<script>jQuery(function(){ init_Trainer__Athletes_Select(); });</script>*/?>
