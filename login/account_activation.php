<?php // account activation

$uname = filter_input(INPUT_GET, 'uname', FILTER_SANITIZE_STRING);
$adm = filter_input(INPUT_GET, 'adm', FILTER_SANITIZE_STRING);
$code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);
if (!$uname OR !$adm OR !$code) exit;

// load language & database ##########
require_once('no_validate.php');
// ###################################
$PATH_2_ROOT = '../';

$mes = '';
$new_data = false;
$user = $db->fetchRow("SELECT * FROM users WHERE uname = ?", array($uname)); 
if ($db->numberRows() > 0)  {
	if ($user['status'] == '1') {
		$mes = $LANG->REGISTER_ACTIVATE_READY;
	}
	else {
		$activate_code = MD5($user['account'].$user['uname'].$user['passwd']);
		if ($activate_code == $code) {
			$mes = $LANG->REGISTER_ACTIVATE_OK; 
			$values = array();
			$values['status'] = '1';
			$result = $db->update($values, "users", "uname=?", array($uname));
			
			//group access
			$values = array();
			$values['user_id'] = $user['id'];
			$values['group_id'] = $user['group_id'];
			$values['status'] = '1';
			$values['created'] = $user['created'];
			$values['created_by'] = $user['uname'];
			$values['modified'] = date("Y-m-d H:i:s");
			$values['modified_by'] = $adm;
			$save = $db->update($values, "users2groups", "user_id=? AND group_id=?", array($user['id'], $user['group_id']));
			
			// Email ///////////////////////////////////////////////////////////////////////////
			require('../php/email.php');
			$Subject = str_replace('{Username}', $user['uname'], $LANG->EMAIL_ACCOUNT_ACTIVATE_SUBJECT);
			$Message = str_replace('{Username}', $user['uname'], $LANG->EMAIL_ACCOUNT_ACTIVATE_MESSSAGE);
			$Message = str_replace('{HTTP}', $CONFIG['HTTP'], $Message);
			$Message = str_replace('{DOMAIN}', $CONFIG['DOMAIN'], $Message);
			$Message = str_replace('{REGmon_Folder}', $CONFIG['REGmon_Folder'], $Message);
						
			if (SendEmail($user['email'], $Subject, $Message) == 'OK') {}
			else error_log($user['email'].', '. $Subject.', Activate User Email Not Send');
		}
		else {
			$mes = $LANG->REGISTER_ACTIVATE_CODE_ERROR;
		}
	}
}
else {
	//Account not exists
	$mes = $LANG->REGISTER_ACTIVATE_NO_USER;
}		


$this_color = "";
$this_color_hover = "";

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
         	<h1 style="color:#333"><?=$LANG->REGISTER;?>!</h1>
			<h3 style="color: #6C3"><?=$mes;?></h3>
        </div>
	</div>
</div>
<br>
<br>
<?php //require('php/inc.footer.php');?>

</body>
</html>