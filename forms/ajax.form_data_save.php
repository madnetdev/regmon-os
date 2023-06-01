<?php // ajax Form Data Save
$PATH_2_ROOT = '../';
require_once($PATH_2_ROOT.'_settings.regmon.php');
require($PATH_2_ROOT.'login/validate.php');

$athlete_id = isset($_POST['athlete_id']) ? $_POST['athlete_id'] : $UID;
$form_id = isset($_POST['form_id']) ? $_POST['form_id'] : 0;
$category_id = isset($_POST['category_id']) ? $_POST['category_id'] : 0;
$group_id = isset($_POST['group_id']) ? $_POST['group_id'] : $GROUP;
$Form_Select_Group = isset($_POST['Form_Select_Group']) ? $_POST['Form_Select_Group'] : array();

$CHANGE = (isset($_POST['change']) AND ($_POST['change']=='true')) ? true : false;
$change_id = isset($_POST['change_id']) ? $_POST['change_id'] : 0;

//selected_date + selected_date_end
$selected_date = get_date_time_SQL('now');
$selected_date_end = get_date_time_SQL('now');
if (isset($_POST['form_date']) AND isset($_POST['form_time'])) {
	$selected_date = date("Y-m-d H:i:s", (int)strtotime($_POST['form_date'].' '.$_POST['form_time'].':00'));	
	if (isset($_POST['form_time_end']) AND $_POST['form_time_end'] != '') {
		$selected_date_end = date("Y-m-d H:i:s", (int)strtotime($_POST['form_date'].' '.$_POST['form_time_end'].':00'));	
	}
}
elseif (isset($_POST['form_date'])) {
	$selected_date = date("Y-m-d H:i:s", (int)strtotime($_POST['form_date'].' '.date("H:i:s")));	
}
elseif (isset($_POST['form_time'])) {
	$selected_date = date("Y-m-d H:i:s", (int)strtotime(date("Y-m-d").' '.$_POST['form_time'].':00'));
}

//unset fields not want
unset($_POST['group_id']);
unset($_POST['athlete_id']);
unset($_POST['form_id']);
unset($_POST['category_id']);
unset($_POST['form_date']);
unset($_POST['form_time']);
unset($_POST['form_time_end']);
unset($_POST['change']);
unset($_POST['change_id']);
unset($_POST['Form_Select_Group']);

// Save 
$values = array();
$values['user_id'] = $athlete_id;
$values['form_id'] = $form_id;
$values['category_id'] = $category_id;
$values['group_id'] = $group_id;
$values['res_json'] = json_encode($_POST);
$values['modified'] = get_date_time_SQL('now');
$values['modified_by'] = $USERNAME;

$values['created'] = $selected_date;
if ($selected_date != $selected_date_end) {
	$values['created_end'] = $selected_date_end;
}

if ($CHANGE) {
	//Update
	$update = $db->update($values, "forms_data", "id=?", array($change_id));
}
else {
	//Insert
	$values['created_by'] = $USERNAME;

    //multiply Groups Selection
	if (count($Form_Select_Group)) {
		foreach ($Form_Select_Group as $group_id) {
			$values['group_id'] = $group_id;
            //save form_data in each Selected Group
			$insert_id = $db->insert($values, "forms_data");
		}
	}
    else {
        //current Group
		$insert_id = $db->insert($values, "forms_data");
	}
}

?>
