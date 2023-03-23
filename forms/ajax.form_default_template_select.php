<?php // ajax Form Default Template Select
require_once('../_settings.regmon.php');
require('../login/validate.php');

$group_id = isset($_REQUEST['group_id']) ? $_REQUEST['group_id'] : 0;
$ath_id = isset($_REQUEST['ath_id']) ? $_REQUEST['ath_id'] : 0;
$cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : 0;
$form_id = isset($_REQUEST['form_id']) ? $_REQUEST['form_id'] : 0;
if (!$group_id OR !$ath_id OR !$cat_id OR !$form_id) exit;

$form_default_template = 0;
$html = '';

//group requests
$row = $db->fetchRow("SELECT template_id 
FROM users2forms 
WHERE user_id=? AND group_id=? AND category_id=? AND form_id=?", array($ath_id, $group_id, $cat_id, $form_id)); 
if ($db->numberRows() > 0)  {
	$form_default_template = $row['template_id'];
}

//$html .= '<select id="select_template_'.$ath_id.'_'.$group_id.'_'.$cat_id.'_'.$form_id.'">';
$html .= $LANG->FORM_DEFAULT_TEMPLATE.' : <br><select class="select_template" style="width:100%;">';
//get available group form templates
$templates = $db->fetchAll("SELECT id, name FROM graphs WHERE is_axis=0 AND group_id=? AND form_id=? ORDER BY name", array($group_id, $form_id)); 
if ($db->numberRows() > 0) {
	foreach ($templates as $temp) {
		$html .= '<option value="'.$temp['id'].'"'.($form_default_template == $temp['id'] ? ' selected' : '').'>'.$temp['name'].'</option>';
	}
}
$html .= '</select>';

echo $html;
?>
