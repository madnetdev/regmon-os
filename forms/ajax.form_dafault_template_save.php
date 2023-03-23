<?php // ajax Form Default Template Save
require_once('../_settings.regmon.php');
require('../login/validate.php');

$group_id = isset($_REQUEST['group_id']) ? $_REQUEST['group_id'] : 0;
$ath_id = isset($_REQUEST['ath_id']) ? $_REQUEST['ath_id'] : 0;
$cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : 0;
$form_id = isset($_REQUEST['form_id']) ? $_REQUEST['form_id'] : 0;
$template_id = isset($_REQUEST['template_id']) ? $_REQUEST['template_id'] : 0;
if (!$group_id OR !$ath_id OR !$cat_id OR !$form_id OR !$template_id) exit;

$values = array();
$values['user_id'] = $ath_id;
$values['group_id'] = $group_id;
$values['category_id'] = $cat_id;
$values['form_id'] = $form_id;
$values['template_id'] = $template_id;
$values['modified'] = get_date_time_SQL('now');
$values['modified_by'] = $USERNAME;

$def = $db->fetchRow("SELECT id FROM users2forms WHERE user_id=? AND group_id=? AND category_id=? AND form_id=?", array($ath_id, $group_id, $cat_id, $form_id)); 
if ($db->numberRows() > 0) { //exist
	$update = $db->update($values, "users2forms", "user_id=? AND group_id=? AND category_id=? AND form_id=?", array($ath_id, $group_id, $cat_id, $form_id));
}
else { //new
	$values['created'] = get_date_time_SQL('now');
	$values['created_by'] = $USERNAME;
	$insert = $db->insert($values, "users2forms");
}
?>