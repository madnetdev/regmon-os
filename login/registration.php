<?php // resisters a new user and send emails to admins to activate the account

$uname = filter_input(INPUT_POST, 'uname', FILTER_SANITIZE_STRING);
if (!$uname) exit;

// load language & database ##########
require_once('no_validate.php');
// ###################################
$PATH_2_ROOT = '../';

$register_ERROR = '';
$new_data = false;

//the following check is additional so the $db->insert not return duplicate error
$row = $db->fetchRow("SELECT * FROM users WHERE uname = ?", array($uname)); 
if ($db->numberRows() > 0)  {
	$register_ERROR = $LANG->WARN_USERNAME_EXIST;
}
else {
	//print_r($_POST); exit;
	$new_data = true;
	
	$values = array();			
	foreach ($_POST as $key => $val) {
		$key = trim((string)$key); 
		if ($key != 'sport') $val = trim((string)$val); 
		switch($key) {
			//case 'account': 
			case 'uname': 
			case 'passwd': 
			case 'lastname': 
			case 'firstname': 
			case 'body_height': 
			case 'sex': 
			case 'email': 
			//case 'telephone': 
			//case 'sport': 
			//case 'year': 
			//case 'month': 
			//case 'day': 
			//case 'level': 
			//case 'status':
				$values[$key] = $val;
			  break;
		}
	}		

	// Check if all fields are filled up
	if (trim($values['uname']) == '') {
		echo $LANG->WARN_EMPTY_USERNAME;
		exit;
	}
	elseif (trim($values['passwd']) != trim($_POST['pass_confirm'])) {
		echo $LANG->WARN_CONFIRM_PASSWORD; 
		exit;
	}

	$values['passwd'] = MD5($values['passwd']);
	$values['account'] = 'user';
	$values['level'] = 10;
	$values['status'] = 0; //$values['approved'] = 0;
	$values['telephone'] = $_POST['countryCode'].' '.$_POST['telephone'];
	if ($_POST['year'] != '' AND $_POST['month'] != '' AND $_POST['day'] != '') {
		$values['birth_date'] = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
	}
	$level = explode('_', $_POST['profile']);
	$values['level'] = $level[0];
	$profile = $level[1];

	if ($_POST['location_group'] == 'Private') {
		$grst = $db->fetchRow("SELECT gr.id, gr.location_id, gr.status, gr.private_key, gr.name, st.name AS location 
			FROM groups gr 
			LEFT JOIN locations st ON st.id = gr.location_id 
			WHERE gr.status = 3 AND gr.private_key = ?", array($_POST['private_key'])); 
		if ($db->numberRows() > 0)  {
			$values['location'] = $grst['location_id'];
			$location_name 		= $grst['location'];
			$values['group_id'] = $grst['id'];
			$group_name 		= $grst['name'];
		}
		else $register_ERROR = $LANG->PRIVATE_KEY_ERROR;
	}
	else {
		$location_group = explode('|', $_POST['location_group']);
		$values['location'] = $location_group[0];
		$location_name 		= $location_group[1];
		$values['group_id'] = $location_group[2];
		$group_name 		= $location_group[3];
	}
	$values['last_ip'] = '';
	$values['modified'] = date("Y-m-d H:i:s");
	$values['created'] = date("Y-m-d H:i:s");
	$activate_code = MD5($values['account'].$values['uname'].$values['passwd']);
	
	//sport
	$sports = array();
	$rows = $db->fetch("SELECT name FROM sports WHERE status = 1", array()); 
	if ($db->numberRows() > 0)  {
		foreach ($rows as $row) {
			$sports[] = $row['name'];
		}
	}
	$values['sport'] = '';
	$sport_user = '';
	$sport_admin = '';
	$i = $ii = 0;
	if (isset($_POST['sport']) AND count($_POST['sport'])) {
		foreach ($_POST['sport'] as $sport) {
			$i++;
			if ($i != 1) {
				$sport_user .= ', ';
				$sport_admin .= ', ';
			}
			//if sport not exist
			if (!in_array($sport, $sports)) {
				$activate_sport_code = MD5($CONFIG['SEC_Encrypt_Secret'] . $values['uname'].$sport);
				$activate_sport_link = "<a href='".$CONFIG['HTTP'].$CONFIG['DOMAIN'].'/'.$CONFIG['REGmon_Folder']."login/new_sport_suggestion.php?sport=".$sport."&uname=".$values['uname']."&code=".$activate_sport_code."' target='_blank'>".$LANG->REGISTER_APPROVE_PROPOSAL."</a>";
				$sport_user .= '<u style="color:blue;">'.$sport.' ('.$LANG->REGISTER_APPROVE_WAIT.')</u>';
				$sport_admin .= '<u style="color:blue;">'.$sport.' ('.$activate_sport_link.')</u>';
			}
			else {
				$ii++;
				if ($ii != 1) {
					$values['sport'] .= ',';
				}
				$values['sport'] .= $sport;
				$sport_user .= $sport;
				$sport_admin .= $sport;
			}
		}
	}
	
	//Insert
	$insert_id = $db->insert($values, "users");

	if (!$insert_id) {
		$register_ERROR = $LANG->INSERT_ERROR;
	}
	else {
		if (substr_count($insert_id, 'Duplicate entry') <> 0) { //to db mas dinei to error sto insert_id //anti gia error
			$register_ERROR = $LANG->WARN_USERNAME_EXIST;
		}
		else {

			//group access - insert
			$values2 = array();			
			$values2['user_id'] = $insert_id;
			$values2['group_id'] = $values['group_id'];
			$values2['status'] = '10';
			$values2['created'] = date("Y-m-d H:i:s");
			$values2['created_by'] = $values['uname'];
			$values2['modified'] = date("Y-m-d H:i:s");
			$values2['modified_by'] = $values['uname'];
			$users2groups = $db->insert($values2, "users2groups");
			
			// Email ///////////////////////////////////////////////////////////////////////////
			require($PATH_2_ROOT.'php/email.php');
			
			//New user account email
			$profile_title = $profile;
			$profile = $level[0] > 10 ? '<b>'.$profile.'</b>' : $profile;

			$params_Subject = [
				'{Username}' => $_POST['uname'],
				'{Profile_Title}' => $profile_title,
			];
			$Subject = strtr($LANG->EMAIL_NEW_ACCOUNT_SUBJECT, $params_Subject);

			$params_Message = [
				'{Username}' => $_POST['uname'],
				'{Password}' => $_POST['passwd'],
				'{Lastname}' => $_POST['lastname'],
				'{Firstname}' => $_POST['firstname'],
				'{Sport}' => $sport_user,
				'{Body_Height}' => $_POST['body_height'],
				'{Gender}' => ($_POST['sex']=='0' ? 'Männlich' : ($_POST['sex']=='1' ? 'Weiblich' : 'Divers')),
				'{Email}' => $_POST['email'],
				'{Telephone}' => $_POST['countryCode'].' '.$_POST['telephone'],
				'{Location}' => $location_name,
				'{Group}' => $group_name,
				'{Profile}' => $profile,
				'{HTTP}' => $CONFIG['HTTP'],
				'{DOMAIN}' => $CONFIG['DOMAIN'],
				'{REGmon_Folder}' => $CONFIG['REGmon_Folder']
			];
			$Message = strtr($LANG->EMAIL_NEW_ACCOUNT_MESSSAGE, $params_Message);

			if (SendEmail($_POST['email'], $Subject, $Message) == 'OK') {}
			else error_log($_POST['email'].', '. $Subject.', User Email Not Send');

			
			//Admin email for activation of new user account
			$admin_email = array();
			//$group_admins = $db->fetchRow("SELECT GROUP_CONCAT( u.email ) AS emails FROM users u
			$admin_rows = $db->fetch("SELECT u.lastname, u.email FROM users u
				LEFT JOIN groups gr ON gr.id = ?
				WHERE FIND_IN_SET( u.id, gr.admins_id )", array($values['group_id']));
			if (!$db->numberRows()) {
				//get the admin email if the group is not enabled for registration
				$admin_rows = $db->fetch("SELECT lastname, email FROM users WHERE account = 'admin' AND level = 99", array());
			}
			foreach ($admin_rows as $admin) {
				$activate_link = "<a href='".$CONFIG['HTTP'].$CONFIG['DOMAIN'].'/'.$CONFIG['REGmon_Folder']."login/account_activation.php?uname=".$values['uname']."&code=".$activate_code."&adm=".$admin['lastname']."' target='_blank'>";

				$Subject_admin = strtr($LANG->EMAIL_NEW_ACCOUNT_ADMIN_SUBJECT, $params_Subject);

				//overwrite some admin vals
				$params_Message['{Sport}'] = $sport_admin;
				$params_Message['{Activate_Link}'] = $activate_link;  //here may have new sports activation link

				$Message_admin = strtr($LANG->EMAIL_NEW_ACCOUNT_ADMIN_MESSSAGE, $params_Message);
				
				if (SendEmail($admin['email'], $Subject_admin, $Message_admin) == 'OK') {}
				else error_log($Subject_admin.', Admin Email Not Send');
			}
		}
	} //if insert_id
}

$this_color = "#446f91";
$this_color_hover = "#446f91";
//#####################################################################################
$title = $LANG->REGISTER_PAGE_TITLE;
require($PATH_2_ROOT.'php/inc.head.php');
//#####################################################################################
?>
</head>
<body>

<?php require($PATH_2_ROOT.'php/inc.header.php');?>

<div style="text-align:center;">
	<a href="../" id="home" class="home"> &nbsp; <?=$LANG->HOMEPAGE;?></a>
</div>

<div class="container">
	<div class="row">
        <div class="col-md-12" style="text-align:center; padding-top:80px;">
		<?php if ($register_ERROR != '') { ?>
         	<h1 style="color:#333"><?=$LANG->ERROR;?></h1>
			<br>
			<h3 style="color: #ff0000"><?=$register_ERROR;?></h3>
		<?php } else { ?>
         	<h1 style="color:#333"><?=$LANG->REGISTER_THANKS;?></h1>
			<br>
			<h3 style="color: #6C3"><?=$LANG->REGISTER_SUBMIT_SUCCESS;?></h3>
			<h3 style="color: #ffbf00"><?=$LANG->REGISTER_SUBMIT_WAIT_ACTIV;?></h3>
			<?php /*<p>You will be redirect back in 5 seconds.</p>*/?>
		<?php } ?>
        </div>
	</div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php //require($PATH_2_ROOT.'php/inc.footer.php');?>

</body>
</html>