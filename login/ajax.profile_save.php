<?php
require_once('../_settings.regmon.php');
require('validate.php');

//print_r($_POST); exit;

$values = array();			
foreach ($_POST as $key => $val) {
	$key = trim((string)$key); 
	if ($key != 'sport') $val = trim((string)$val); 
	switch($key) {
		//case 'account': 
		case 'uname': 
		case 'lastname': 
		case 'firstname': 
		case 'body_height': 
		case 'sex': 
		case 'email': 
		case 'telephone': //with countryCode
		case 'dashboard': 
		//case 'sport': 
		//case 'year': 
		//case 'month': 
		//case 'day': 
			$values[$key] = $val;
		  break;
	}
}		

// Check if all fields are filled up
if (trim($values['uname']) == '') { echo $LANG->WARN_EMPTY_USERNAME; exit;}
if (trim($_POST['passwd']) != '') {
	if (trim($_POST['passwd']) != trim($_POST['pass_confirm'])) { echo $LANG->WARN_CONFIRM_PASSWORD; exit;}
	$values['passwd'] = MD5($_POST['passwd']);
}

if ($_POST['birth_year'] != '' AND $_POST['birth_month'] != '' AND $_POST['birth_day'] != '') {
	$values['birth_date'] = $_POST['birth_year'].'-'.$_POST['birth_month'].'-'.$_POST['birth_day'];
}
$values['modified'] = get_date_time_SQL('now');

$location_name = $_POST['location_name'];
$group_id = $_POST['group_id'];
$group_name = $_POST['group_name'];
$level_id = $_POST['level_id'];
$profile = $_POST['profile'];

//sport
$sports = array();
$rows = $db->fetch("SELECT name FROM sports WHERE status = 1", array()); 
if ($db->numberRows() > 0)  {
	foreach ($rows as $row) {
		$sports[] = $row['name'];
	}
}
$values['sport'] = '';
$sport_new = '';
$sport_all = '';
$sport_new_to_user = '';
$i = $ii = $iii = 0;
if (isset($_POST['sport']) AND count($_POST['sport'])) {
	foreach ($_POST['sport'] as $sport) {
		$i++;
		if ($i != 1) {
			$sport_all .= ', ';
		}
		if (!in_array($sport, $sports)) { //if new sport
			$iii++;
			if ($iii != 1) {
				$sport_new .= ', ';
				$sport_new_to_user .= ', ';
			}
			$activate_sport_code = MD5($CONFIG['SEC_Encrypt_Secret'] . $values['uname'].$sport);
			$activate_sport_link = "<a href='".$CONFIG['HTTP'].$CONFIG['DOMAIN'].'/'.$CONFIG['REGmon_Folder']."login/new_sport_suggestion.php?sport=".$sport."&uname=".$values['uname']."&code=".$activate_sport_code."' target='_blank'>".$LANG->REGISTER_APPROVE_PROPOSAL."</a>";
			$sport_new .= $sport;
			$sport_new_to_user .= '<u style="color:blue;">'.$sport.' ('.$LANG->REGISTER_APPROVE_WAIT.')</u>';
			$sport_all .= '<u style="color:blue;">'.$sport.' ('.$activate_sport_link.')</u>';
		}
		else {
			$ii++;
			if ($ii != 1) {
				$values['sport'] .= ',';
			}
			$values['sport'] .= $sport;
			//$sport_new .= $sport;
			$sport_all .= $sport;
		}
	}
}

//Update
$update = $db->update($values, "users", "id=?", array($UID));


if ($sport_new != '') {
	// Email ///////////////////////////////////////////////////////////////////////////
	require('../php/email.php');

	//Admin email for activation of new user account
	//$group_admins = $db->fetchRow("SELECT GROUP_CONCAT( u.email ) AS emails FROM users u
	$admin_rows = $db->fetch("SELECT u.lastname, u.email FROM users u
		LEFT JOIN `groups` gr ON gr.id = ?
		WHERE FIND_IN_SET( u.id, gr.admins_id )", array($group_id));
	if ($db->numberRows() > 0)  {} //group admins exist
	else { //else get the admin email
		$admin_rows = $db->fetch("SELECT name, email FROM users WHERE level='99'", array());
	}
	
	foreach ($admin_rows as $admin) {
		//Admin email for activation of new Sport
		$profile = ($level_id>10?'<b>'.$profile.'</b>':$profile);
		$Subject_admin = str_replace('{Sports}', $sport_new, $LANG->EMAIL_NEW_SPORTART_ADMIN_SUBJECT);
		$Message_admin = str_replace('{Username}', $_POST['uname'], $LANG->EMAIL_NEW_SPORTART_ADMIN_MESSSAGE);
		$Message_admin = str_replace('{Lastname}', $_POST['lastname'], $Message_admin);
		$Message_admin = str_replace('{Firstname}', $_POST['firstname'], $Message_admin);
		$Message_admin = str_replace('{Sport}', $sport_all, $Message_admin);
		$Message_admin = str_replace('{Email}', $_POST['email'], $Message_admin);
		$Message_admin = str_replace('{Telephone}', $_POST['telephone'], $Message_admin);
		$Message_admin = str_replace('{Location}', $location_name, $Message_admin);
		$Message_admin = str_replace('{Group}', $group_name, $Message_admin);
		$Message_admin = str_replace('{Profile}', $profile, $Message_admin);

		if (SendEmail($admin['email'], $Subject_admin, $Message_admin) == 'OK') {}
		else error_log($Subject_admin.', Admin Email Not Send');
	}
}


$success = ''.
'<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>'.$LANG->SUCCESS.'!</strong> '.$LANG->PROFILE_SAVED.' &nbsp; '
	.($sport_new!=''?$sport_new_to_user.' &nbsp; ':'')
	.'<a href="javascript:void(0)" onclick="jQuery.fancybox.close();" class="alert-link text-nowrap">'.$LANG->CLOSE.'</a>'
.'</div>';

$error = ''.
'<div class="alert alert-danger alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>'.$LANG->ERROR.'!</strong> '.$LANG->PROFILE_NOT_SAVED.'
</div>';

?>
<script>
<?php if ($update) { //echo $success; ?>
	parent.Swal({
		type: 'success',
		title: 'Änderungen gespeichert.',
		showConfirmButton: false,
		timer: 2000
	});
	//update dashboard checkbox
	<?php if ($values['dashboard'] == '0') { ?>
		//$('#open_dashboard_onlogin:checked').trigger("click"); //we not need click/trigger just change
		$('#open_dashboard_onlogin').prop('checked', false);
	<?php } else { ?>
		//$('#open_dashboard_onlogin').not(':checked').trigger("click"); //we not need click/trigger just change
		$('#open_dashboard_onlogin').prop('checked', true);
	<?php } ?>
<?php } else { //echo $error; ?>
	parent.Swal({
		type: 'error',
		title: 'Error!',
		showConfirmButton: false,
		timer: 2000
	});
<?php } ?>
</script>
