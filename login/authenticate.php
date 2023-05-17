<?php
require_once('../_settings.regmon.php');
require_once('login_functions.php');
require_once('../php/date_functions.php');


$login = '../login.php'; //login page
$success = '../'; //index page


// Initialize Session
session_cache_limiter( false );
session_start();


//Init DB #######################
require_once('../php/class.db.php');	
$db = db::open('mysqli', $CONFIG['DB_Name'], $CONFIG['DB_User'], $CONFIG['DB_Pass'], $CONFIG['DB_Host']);
if ($CONFIG['DB_Debug']) $db->logToFile($CONFIG['DB_Debug_File']); //enable query logging
//Init DB #######################


//global vars
$ADMIN = $LOCATION_ADMIN = $GROUP_ADMIN = $GROUP_ADMIN_2 = $TRAINER = $ATHLETE = false;
$USER = $ACCOUNT = $UID = $USERNAME = false;


// LogLimiter #######################
require_once('class.loglimiter.php');
$Blocked_IP = false;
$CLL = $CONFIG['LogLimiter'];
$LogLimiter = new LogLimiter($db, $CLL['Max_Attempts'], $CLL['Block_Minutes'], $CLL['Reset_Attempts_Minutes']);
if ($LogLimiter->checkBlock()) { // if true this IP is blocked
	//die("Sorry, but we are not enjoyed by your bruteforce attempt!"); 
	$Blocked_IP = true;
}


if ($CONFIG['Use_VisualCaptcha']) {
	//validate CAPTCHA #######################
	$Captcha = false;
	//require ('../vendor/autoload.php');
	require ('visualCaptcha/Session.php');
	require ('visualCaptcha/Captcha.php');
	$visualCaptcha_session = new \visualCaptcha\Session();
	$app_captcha = new \visualCaptcha\Captcha($visualCaptcha_session);
	$app_frontendData = $app_captcha->getFrontendData();
	if (isset($_POST['form_submit']) && $_POST['form_submit'] == '1') {
		if ($imageAnswer = ($_POST[$app_frontendData['imageFieldName']] ?? '')) {
			if ($app_captcha->validateImage($imageAnswer)) {
				$Captcha = true;
			}
		} 
	}
}
else {
	$Captcha = true;
}


$Inactive_User = false;

//Valid Captcha and not Blocked IP
if ($Captcha AND !$Blocked_IP) {
	//validate User
	$username = $_POST['username'] ?? '';
	$password = $_POST['password'] ?? '';
	$UIP = $_SERVER['REMOTE_ADDR'] ?? '';

	$USER = $db->fetchRow("SELECT * FROM users WHERE uname=?", array($username));
	if ($db->numberRows() > 0) {

		if (verify_Password($password, $USER["passwd"])) 
		{
			//successfull login

			//Valid User --logged in and active
			if ($USER["status"] == '1') {

				//global vars
				$UID = $USER['id'];
				$ACCOUNT = $USER['account'];
				$USERNAME = $USER['uname'];

				
				//clean the failed attempts of this IP address.
				$LogLimiter->login(); 


				//update logincount, lastlogin and last_ip
				$values = array(
					'logincount' => $USER['logincount'] + 1,
					'lastlogin' => get_date_time_SQL('now'),
					'last_ip' => $UIP
				);
				$db->update($values, "users", 'id=?', array($USER['id']));


				/**
				 * make the user HASH
				 * include username, password, (IP) 
				 * so if any of them changes, logout the user
				 */
				$hash_string = $CONFIG['SEC_Hash_Secret'] . $USERNAME . ($CONFIG['SEC_Hash_IP'] ? $UIP : '') . $USER['passwd'];
				unset($USER['passwd']);
				$HASH = hash_Secret($hash_string, $CONFIG['SEC_Hash_Secret']);
								

				setcookie ("UID", $UID, 0, '/'.$CONFIG['REGmon_Folder']);
				setcookie ("ACCOUNT", $ACCOUNT, 0, '/'.$CONFIG['REGmon_Folder']);
				setcookie ("USERNAME", $USERNAME, 0, '/'.$CONFIG['REGmon_Folder']);
				setcookie ("HASH", $HASH, 0, '/'.$CONFIG['REGmon_Folder']);


				//Dashboard
				if ($USER["dashboard"] == '1') {
					setcookie ("DASHBOARD", '1', 0, '/'.$CONFIG['REGmon_Folder']);
					setcookie ("DASH_ON_LOGIN", '1', 0, '/'.$CONFIG['REGmon_Folder']);
				} else {
					setcookie ("DASHBOARD", '0', 0, '/'.$CONFIG['REGmon_Folder']);
				}

				//level - user type
				if ($USER["level"] == 99) {
					$ADMIN = true;
				}
				elseif ($USER["level"] == 50) {
					$LOCATION_ADMIN = true;
				}
				elseif ($USER["level"] == 45) {
					$GROUP_ADMIN = true;
				}
				elseif ($USER["level"] == 40) {
					$GROUP_ADMIN_2 = true;
				}
				elseif ($USER["level"] == 30) {
					$TRAINER = true;
				}
				elseif ($USER["level"] == 10) {
					$ATHLETE = true;
				}
				else { //unknown level
					$success = $login;
				}
			}
			else {
				$Inactive_User = true;
			}
		}
		else {
			$USER = false;
		}
	}
	else {
		$USER = false;
	}
}
else {
	$USER = false;
}


//find next page
$new_page = $login;


//not Valid user
if ($USER === false) {
	//log the failed attempt for this IP address.
	$LogLimiter->failedAttempt();

	//fail reason
	if ($Blocked_IP) {
		$new_page = $login.'?blockedIP=1';
	}
	elseif (!$Captcha) {
		$new_page = $login.'?captchaError=1';
	}
	else { //simple failure
		$new_page = $login.'?failure=1';
	}
}
//inactive user
elseif ($Inactive_User) {
	$new_page = $login.'?inactive=1';
}
//user logged in
else {
	$new_page = $success;
}


//Redirect to new page
header( 'Location: ' . ($new_page ?: '/') );
exit; 
?>