<?php // Config functions

//Encrypt/Decrypt ###########################
function Encrypt_String($string) {
	return openssl_encrypt($string, "AES-128-ECB", "REGmon");
}
function Decrypt_String($encrypted_string) {
	return openssl_decrypt($encrypted_string, "AES-128-ECB", "REGmon");
}

function Generate_Secret_Key($length = 64, $special_chars = true, $extra_special_chars = false) {
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	if ($special_chars) {
		$chars .= '!@#$%^&*()';
	}
	if ($extra_special_chars) {
		$chars .= '-_ []{}<>~`+=,.;:/?|';
	}
	
	$max = strlen($chars) - 1;
	$key = '';
	for ($j = 0; $j < $length; $j++) {
		$key .= substr($chars, random_int(0, $max), 1);
	}

	return $key;
}

function is_Docker() {
    return is_file("/.dockerenv");
}

function is_XAMPP() {
	if (isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'XAMPP') !== false) {
		return true;
	} else {
		return false;
	}
}

function reload_Config_Page() {
	header('Location: config.php'); //reload page
}
// HTML #####################################

function get_HTML_Radio_Check_Buttons($config_key, $config_value, $option1, $option2, $label, $sub_label) {
	return ''.
		'<label for="'.$config_key.'">'.$label.'</label>'.
		'<div id="'.$config_key.'" class="btn-group" data-toggle="buttons" style="width:100%;">'.
			'<label class="btn btn-default'.($config_value == $option1 ? ' active' : '').'" style="width:50%;">'.
				'<input type="radio" name="'.$config_key.'" value="'.$option1.'"'.($config_value == $option1 ? ' checked' : '').'>'.$option1.
			'</label>'.
			'<label class="btn btn-default'.($config_value == $option2 ? ' active' : '').'" style="width:50%;">'.
				'<input type="radio" name="'.$config_key.'" value="'.$option2.'"'.($config_value == $option2 ? ' checked' : '').'>'.$option2.
			'</label>'.
			'<small class="text-muted">'.$sub_label.'</small>'.
		'</div>'.
		'<br>'.
		'<br>';
}


function get_HTML_Radio_Check_Buttons__On_Off($config_key, $config_value, $option_on, $option_off, $label, $sub_label, $disabled = false) {
	return ''.
		'<label for="'.$config_key.'">'.$label.'</label>'.
		'<div id="'.$config_key.'" class="btn-group" data-toggle="buttons" style="width:100%;">'.
			'<label class="btn'.($config_value == '1' ? ' active btn-success' : ' btn-default').($disabled ? ' disabled' : '').'" style="width:50%;">'.
				'<input type="radio" name="'.$config_key.'" value="1"'.($config_value == '1' ? ' checked' : '').($disabled ? ' disabled' : '').'>'.$option_on.
			'</label>'.
			'<label class="btn'.($config_value == '0' ? ' active btn-danger' : ' btn-default').($disabled ? ' disabled' : '').'" style="width:50%;">'.
				'<input type="radio" name="'.$config_key.'" value="0"'.($config_value == '0' ? ' checked' : '').($disabled ? ' disabled' : '').'>'.$option_off.
			'</label>'.
		'</div>'.
		'<small class="text-muted">'.$sub_label.'</small>'.
		'<br>'.
		'<br>';
}


function get_HTML_Input($config_key, $config_value, $input_type, $label, $sub_label, $placeholder, $disabled = false) {
	return ''.
		'<label for="'.$config_key.'">'.$label.'</label>'.
		'<div class="btn-group" style="width:100%;">'.
			'<input type="'.$input_type.'" id="'.$config_key.'" name="'.$config_key.'" value="'.$config_value.'" class="form-control required" placeholder="'.$placeholder.'"'.($input_type == 'number' ? ' min="1" max="99"' : '').($disabled ? ' disabled' : '').'>'.
			'<small class="text-muted">'.$sub_label.'</small>'.
			($sub_label != '' ? '<br>' : '').
			'<br>'.
		'</div>';
}


function get_HTML_Textarea($config_key, $config_value, $input_type, $label, $sub_label, $placeholder, $disabled = false) {
	return ''.
		'<label for="'.$config_key.'">'.$label.'</label>'.
		'<textarea id="'.$config_key.'" name="'.$config_key.'" class="form-control required" rows="2" cols="10" wrap="soft" maxlength="64" style="overflow:hidden; resize:none;" placeholder="'.$placeholder.'"'.($disabled ? ' disabled' : '').'>'.$config_value.'</textarea>'.
		'<small class="text-muted">'.$sub_label.'</small>'.
		($sub_label != '' ? '<br>' : '').
		'<br>';
}


function get_HTML_Select($config_key, $config_value, $options_arr, $label, $sub_label, $placeholder) {
	$options = '';
	foreach($options_arr as $option) {
		if (is_array($option)) {
			$option_value = $option[0];
			$option_name = $option[1];
		}
		else {
			$option_value = $option;
			$option_name = $option;
		}
		$selected = '';
		if ($config_value == $option_value) {
			$selected = ' selected';
		}
		if ($option_value == '') {
			$options .= '<option value=""' . $selected . '>' . $placeholder . '</option>';
		}
		else {
			$options .= '<option value="' . $option_value . '"' . $selected . '>' . $option_name . '</option>';	
		}
	}

	$html = ''.
		'<label for="'.$config_key.'">'.$label.'</label>'.
		'<select id="'.$config_key.'" name="'.$config_key.'" class="form-control required">'.
			$options.
		'</select>'.
		'<small class="text-muted">'.$sub_label.'</small>'.
		'<br>'.
		'<br>';

	return $html;
}


function get_Database_Fields($disabled = true) {
	global $DB_CONFIG, $CONFIG;

	echo get_HTML_Input( //key, value, type, label, sub_label, placeholder, disabled
		'DB_Host', 
		$DB_CONFIG['DB_Host'],
		'text', 
		'Database Hostname', 
		'ex. localhost, localhost:3306. Use "db" for Docker database.', 
		'localhost',
		$disabled
	);

	echo get_HTML_Input( //key, value, type, label, sub_label, placeholder, disabled
		'DB_Name', 
		$DB_CONFIG['DB_Name'], 
		'text', 
		'Database Name', 
		'', 
		'regmondb',
		$disabled
	);

	echo get_HTML_Input( //key, value, type, label, sub_label, placeholder, disabled
		'DB_User', 
		$DB_CONFIG['DB_User'], 
		'text', 
		'Database User', 
		'', 
		'root',
		$disabled
	);

	if ($disabled) { //not in .env config
		$DB_Pass = Decrypt_String($DB_CONFIG['DB_Pass']);
	}
	else {
		$DB_Pass = $DB_CONFIG['DB_Pass'];
	}
	
	echo get_HTML_Input( //key, value, type, label, sub_label, placeholder, disabled
		'DB_Pass', 
		$DB_Pass, 
		'password', 
		'Database Password', 
		'', 
		'root',
		$disabled
	);

	if ($disabled) { //not in .env config

		echo '<hr style="margin:0 -5px 20px; border-top:7px double #ccc;">';

		echo get_HTML_Input( //key, value, type, label, sub_label, placeholder, disabled
			'DB_Debug_File', 
			$CONFIG['DB_Debug_File'], 
			'text', 
			'Debug Database Queries Filename', 
			'', 
			'__log_query.log',
			!$disabled
		);

		echo get_HTML_Radio_Check_Buttons__On_Off( //key, value, option_on, option_off, label, sub_label, disabled
			'DB_Debug', 
			$CONFIG['DB_Debug'], 
			'ON', 
			'OFF', 
			'Debug Database Queries', 
			'Writes every sql query to the DB_Debug_File in each file directory',
			!$disabled
		);
	}
}


function get_DB_Migrations_Files($DB_Migrations_Directory) {
	$DB_Migrations_Files_arr = [];

	if (is_dir($DB_Migrations_Directory)) {
		//get list and sort
		if ($handle = opendir($DB_Migrations_Directory)) {
			$files = array();
			while (false !== ($file = readdir($handle))) {
				if ($file == '.' or $file == '..') {
					continue;
				}
				if (filetype($DB_Migrations_Directory . $file) == 'file') {
					$timestamp = filemtime($DB_Migrations_Directory . $file);
					$files[$timestamp] = $file;
				}
			}
			krsort($files); //key reverse sort --latest first
			//echo '<pre>'; print_r($files);
			closedir($handle);
		}

		$allowed_file_types = "(sql)";

		//loop sorted list of files
		foreach ($files as $file) {
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			if (preg_match("/\." . $allowed_file_types . "$/i", $file)) {
				$size = round(filesize($DB_Migrations_Directory . $file) / 1024, 2);
				//$get_file = file_get_contents($dir . $file);
				$file_date = date("Y-m-d H:i:s", filemtime($DB_Migrations_Directory . $file));
				//only _init_ files

				if (substr_count($file, '_init_')) {
					$option_value = $file;
					$option_name = $file_date . '&nbsp; - &nbsp;' .$file . ' &nbsp; - &nbsp; ' . $size . 'KB';
		
					$DB_Migrations_Files_arr[] = [$option_value, $option_name];
				}
			}
		}
	}

	return $DB_Migrations_Files_arr;
}


function get_CONFIG__REGmon_Folder() {
	global $_SERVER;

	$REGmon_Folder = str_replace(
		[$_SERVER['DOCUMENT_ROOT'], $_SERVER['REQUEST_URI']], 
		'', 
		$_SERVER['SCRIPT_FILENAME']
	);

	return $REGmon_Folder;
}


function get_CONFIG_Defaults_array($POST = array()) {
	global $_SERVER;

	$REGmon_Folder = get_CONFIG__REGmon_Folder();
		
	return array(
		'DB_Debug_File' 	=> $POST['DB_Debug_File'] 	?? '__log_query.log',
		'DB_Debug' 			=> $POST['DB_Debug'] 		?? 0,
		'DOMAIN' 			=> $POST['DOMAIN'] 			?? $_SERVER['SERVER_NAME'], //'localhost'
		'REGmon_Folder' 	=> $POST['REGmon_Folder'] 	?? $REGmon_Folder,
		'Production_Mode' 	=> $POST['Production_Mode'] ?? 0,
		'HTTP' 				=> $POST['HTTP'] 			?? 'http://',
		'Force_Redirect_To_HTTPS' 		=> $POST['Force_Redirect_To_HTTPS'] 	?? 0,
		'Use_Multi_Language_Selector' 	=> $POST['Use_Multi_Language_Selector'] ?? 1,
		'Use_VisualCaptcha' 			=> $POST['Use_VisualCaptcha'] 			?? 1,
		'Default_Language' 				=> $POST['Default_Language'] 			?? 'en',
		'LogLimiter' => array(
			'Max_Attempts' 			 => $POST['LogLimiter_Max_Attempts'] 			?? 5,
			'Reset_Attempts_Minutes' => $POST['LogLimiter_Reset_Attempts_Minutes'] 	?? 10,
			'Block_Minutes' 		 => $POST['LogLimiter_Block_Minutes'] 			?? 10
		),
		'EMAIL' => array(
			'Host' 			=> $POST['EMAIL_Host'] 			?? 'mail.domain.com',
			'Port' 			=> $POST['EMAIL_Port'] 			?? '587',
			'Username' 		=> $POST['EMAIL_Username'] 		?? 'email@domain.com',
			'Password' 		=> $POST['EMAIL_Password'] 		?? '',
			'From_Name' 	=> $POST['EMAIL_From_Name'] 	?? 'App Name',
			'From_Email' 	=> $POST['EMAIL_From_Email'] 	?? 'email@domain.com',
			'Reply_Name' 	=> $POST['EMAIL_Reply_Name'] 	?? 'App Name',
			'Reply_Email'	=> $POST['EMAIL_Reply_Email'] 	?? 'email@domain.com',
			'Support' 		=> $POST['EMAIL_Support'] 		?? 'support@domain.com',
		),
		'SEC_Hash_IP' 		 => $POST['SEC_Hash_IP'] 		?? 1,
		'SEC_Page_Secret' 	 => $POST['SEC_Page_Secret'] 	?? Generate_Secret_Key(),
		'SEC_Hash_Secret' 	 => $POST['SEC_Hash_Secret'] 	?? Generate_Secret_Key(),
		'SEC_Encrypt_Secret' => $POST['SEC_Encrypt_Secret'] ?? Generate_Secret_Key()
	);
}


function Save_Configuration($config_arr, $init = false) {
	global $db, $CONFIG;
	
	if ($init) { //problems --no user
		//not have $CONFIG
	}
	else { //normal config page
	}

	//set back passwords if empty and we have in CONFIG + Reset + Encrypt
	if ($config_arr['EMAIL']['Password'] == '' AND !$init) {
		$config_arr['EMAIL']['Password'] = $CONFIG['EMAIL']['Password'] ?? '';
	}
	elseif ($config_arr['EMAIL']['Password'] == ' ') {
		//give ' ' to reset field
		$config_arr['EMAIL']['Password'] = '';
	}
	elseif ($config_arr['EMAIL']['Password'] != '') {
		//encrypt pass
		$config_arr['EMAIL']['Password'] = Encrypt_String($config_arr['EMAIL']['Password']);
	}
	

	//make json string for db
	$config_json = json_encode($config_arr, JSON_UNESCAPED_UNICODE);
	$config_json = str_replace('\/', '/', $config_json);
	
	$values = array();
	$values['val'] = $config_json;


	//check if exist
	$db->fetchRow("SELECT val FROM config WHERE name = 'config'", array());
	if ($db->numberRows() > 0) {
		$db->update($values, "config", " name = 'config'", array());
	}
	else {
		$values['name'] = 'config';
		$db->insert($values, "config");
	}

	return 'OK';
}


function get_Admin_User_Init_SQL($password, $email, $datetime) {
	return "".
		//Admin User
		"INSERT INTO users (id, account, uname, passwd, location_id, group_id, lastname, firstname, email, level, status, created, modified) VALUES ".
		"('1', 'admin', 'admin', '".hash_Password($password)."', 1, 1, 'Admin', 'Admin', '".$email."', 99, 1, '".$datetime."', '".$datetime."');";
}

function get_Extra_Admin_Users_Init_SQL($password, $email, $datetime) {
	return "".
		//extra Admin Users
		"INSERT INTO users (id, account, uname, passwd, location_id, group_id, lastname, firstname, email, level, status, created, modified) VALUES ".
		"('2', 'user', 'LocationAdmin', '".hash_Password($password)."', 1, 1, 'Admin', 'Location', '".$email."', 50, 1, '".$datetime."', '".$datetime."'),".
		"('3', 'user', 'GroupAdmin', '".hash_Password($password)."', 1, 1, 'Admin', 'Group', '".$email."', 45, 1, '".$datetime."', '".$datetime."'),".
		"('4', 'user', 'GroupAdmin2', '".hash_Password($password)."', 1, 1, 'Admin (reduced)', 'Group', '".$email."', 40, 1, '".$datetime."', '".$datetime."');";
}

function get_Extra_Location_Group_Init_SQL($datetime) {
	return "".
		//location 1
		"INSERT INTO locations (id, name, status, admin_id, created, modified) VALUES ".
		"(1, 'Location 1', 1, 2, '".$datetime."', '".$datetime."');".
		"\n".
		//group 1
		"INSERT INTO `groups` (id, location_id, name, status, private_key, admins_id, forms_select, forms_standard, stop_date, created, modified) VALUES ".
		"(1, 1, 'Group 1', 1, '', '3,4', '', '', NULL, '".$datetime."', '2023-02-26 18:49:43');";
}

function get_Extra_User2Groups_Init_SQL($datetime) {
	return "".
		//users2groups
		"INSERT INTO users2groups (id, user_id, group_id, forms_select, status, created, created_by, modified, modified_by) VALUES ".
		"(1, 1, 1, NULL, 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(2, 2, 1, NULL, 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(3, 3, 1, NULL, 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(4, 4, 1, NULL, 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init');";
}

function get_Extra_DropdownsSample_Init_SQL($datetime) {
	return "".
		//dropdowns sample data
		"INSERT INTO dropdowns (id, parent_id, name, options, status, created, modified) VALUES ".
		"(1, 0, 'Dropdown Demo StringValue', NULL, 1, '".$datetime."', '".$datetime."'),".
		"(2, 1, NULL, 'Option 1', 1, '".$datetime."', '".$datetime."'),".
		"(3, 1, NULL, 'Option 2', 1, '".$datetime."', '".$datetime."'),".
		"(4, 1, NULL, 'Option 3', 1, '".$datetime."', '".$datetime."'),".
		"(5, 0, 'Dropdown Demo Value__String', NULL, 1, '".$datetime."', '".$datetime."'),".
		"(6, 5, NULL, '1__Option 1', 1, '".$datetime."', '".$datetime."'),".
		"(7, 5, NULL, '2__Option 2', 1, '".$datetime."', '".$datetime."'),".
		"(8, 5, NULL, '3__Option 3', 1, '".$datetime."', '".$datetime."');";
}


function get_Sports_Init_SQL_EN($datetime) {
	return "".
		"INSERT INTO sports (id, parent_id, name, options, status, created, modified) VALUES ".
		"(1, 0, 'Without Sport Group', NULL, 1, '".$datetime."', '".$datetime."'),".
		"(2, 0, 'Strength and Fitness', NULL, 1, '".$datetime."', '".$datetime."'),".
		"(3, 0, 'Individual Sports', NULL, 1, '".$datetime."', '".$datetime."'),".
		"(4, 0, 'Team Sports', NULL, 1, '".$datetime."', '".$datetime."'),".
		"(5, 0, 'Trend Sports', NULL, 1, '".$datetime."', '".$datetime."'),".
		"(6, 0, 'Martial Arts', NULL, 1, '".$datetime."', '".$datetime."'),".
		"(7, 0, 'Racquet Games', NULL, 1, '".$datetime."', '".$datetime."'),".
		"(11, 1, NULL, 'Nothing', 1, '".$datetime."', '".$datetime."'),".
		"(12, 1, NULL, 'Figure Skating', 1, '".$datetime."', '".$datetime."'),".
		"(13, 1, NULL, 'Artistic Cycling', 1, '".$datetime."', '".$datetime."'),".
		"(14, 1, NULL, 'Dance', 1, '".$datetime."', '".$datetime."'),".
		"(15, 1, NULL, 'Rowing', 1, '".$datetime."', '".$datetime."'),".
		"(16, 1, NULL, 'Sports Student', 1, '".$datetime."', '".$datetime."'),".
		"(17, 2, NULL, 'Fitness', 1, '".$datetime."', '".$datetime."'),".
		"(18, 2, NULL, 'Weight Training', 1, '".$datetime."', '".$datetime."'),".
		"(19, 2, NULL, 'Weight Training', 1, '".$datetime."', '".$datetime."'),".
		"(20, 2, NULL, 'Strength-Fitness', 1, '".$datetime."', '".$datetime."'),".
		"(21, 3, NULL, 'Vaulting', 1, '".$datetime."', '".$datetime."'),".
		"(22, 3, NULL, 'Weightlifting', 1, '".$datetime."', '".$datetime."'),".
		"(23, 3, NULL, 'Crossfit', 1, '".$datetime."', '".$datetime."'),".
		"(24, 3, NULL, 'Kickboxing', 1, '".$datetime."', '".$datetime."'),".
		"(25, 3, NULL, 'Apparatus Gymnastics', 1, '".$datetime."', '".$datetime."'),".
		"(26, 3, NULL, 'Modern Pentathlon', 1, '".$datetime."', '".$datetime."'),".
		"(27, 3, NULL, 'Canoe', 1, '".$datetime."', '".$datetime."'),".
		"(28, 3, NULL, 'Climb', 1, '".$datetime."', '".$datetime."'),".
		"(29, 3, NULL, 'Artistic Gymnastics', 1, '".$datetime."', '".$datetime."'),".
		"(30, 3, NULL, 'Jogging / Running', 1, '".$datetime."', '".$datetime."'),".
		"(31, 3, NULL, 'Athletics', 1, '".$datetime."', '".$datetime."'),".
		"(32, 3, NULL, 'Mountain Bike', 1, '".$datetime."', '".$datetime."'),".
		"(33, 3, NULL, 'Cycling', 1, '".$datetime."', '".$datetime."'),".
		"(34, 3, NULL, 'Swimming', 1, '".$datetime."', '".$datetime."'),".
		"(35, 3, NULL, 'Gymnastics', 1, '".$datetime."', '".$datetime."'),".
		"(36, 3, NULL, 'Triathlon', 1, '".$datetime."', '".$datetime."'),".
		"(37, 4, NULL, 'Basketball', 1, '".$datetime."', '".$datetime."'),".
		"(38, 4, NULL, 'Football', 1, '".$datetime."', '".$datetime."'),".
		"(39, 4, NULL, 'Handball', 1, '".$datetime."', '".$datetime."'),".
		"(40, 4, NULL, 'Water Polo', 1, '".$datetime."', '".$datetime."'),".
		"(41, 4, NULL, 'Ice Hockey', 1, '".$datetime."', '".$datetime."'),".
		"(42, 5, NULL, 'Curling', 1, '".$datetime."', '".$datetime."'),".
		"(43, 5, NULL, 'Paragliding', 1, '".$datetime."', '".$datetime."'),".
		"(44, 5, NULL, 'Kite Surfing', 1, '".$datetime."', '".$datetime."'),".
		"(45, 5, NULL, 'Windsurfing', 1, '".$datetime."', '".$datetime."'),".
		"(46, 5, NULL, 'Dive', 1, '".$datetime."', '".$datetime."'),".
		"(47, 5, NULL, 'Parkour', 1, '".$datetime."', '".$datetime."'),".
		"(48, 5, NULL, 'Snowboarding', 1, '".$datetime."', '".$datetime."'),".
		"(49, 6, NULL, 'Judo', 1, '".$datetime."', '".$datetime."'),".
		"(50, 6, NULL, 'Thai Boxing', 1, '".$datetime."', '".$datetime."'),".
		"(51, 6, NULL, 'Taekwondo', 1, '".$datetime."', '".$datetime."'),".
		"(52, 6, NULL, 'Ju-Jutsu', 1, '".$datetime."', '".$datetime."'),".
		"(53, 6, NULL, 'Jiu jitsu', 1, '".$datetime."', '".$datetime."'),".
		"(54, 7, NULL, 'Volleyball', 1, '".$datetime."', '".$datetime."'),".
		"(55, 7, NULL, 'Tennis', 1, '".$datetime."', '".$datetime."'),".
		"(56, 7, NULL, 'Table Tennis', 1, '".$datetime."', '".$datetime."'),".
		"(57, 7, NULL, 'Beachvolleyball', 1, '".$datetime."', '".$datetime."'),".
		"(58, 7, NULL, 'Badminton', 1, '".$datetime."', '".$datetime."');";
}

function get_Sports_Init_SQL_DE($datetime) {
	return "" .
		"INSERT INTO sports (id, parent_id, name, options, status, created, modified) " . "VALUES" .
		"(1, 0, 'Ohne Zuordnung', NULL, 1, '".$datetime."', '".$datetime."')," .
		"(2, 0, 'Kraft und Fitness', NULL, 1, '".$datetime."', '".$datetime."')," .
		"(3, 0, 'Individualsportarten', NULL, 1, '".$datetime."', '".$datetime."')," .
		"(4, 0, 'Mannschaftssportarten', NULL, 1, '".$datetime."', '".$datetime."')," .
		"(5, 0, 'Trendsportarten', NULL, 1, '".$datetime."', '".$datetime."')," .
		"(6, 0, 'Kampfsport', NULL, 1, '".$datetime."', '".$datetime."')," .
		"(7, 0, 'Rückschlagspiele', NULL, 1, '".$datetime."', '".$datetime."')," .
		"(11, 1, NULL, 'Keine', 1, '".$datetime."', '".$datetime."')," .
		"(12, 1, NULL, 'Eiskunstlauf', 1, '".$datetime."', '".$datetime."')," .
		"(13, 1, NULL, 'Kunstradfahren', 1, '".$datetime."', '".$datetime."')," .
		"(14, 1, NULL, 'Tanzen', 1, '".$datetime."', '".$datetime."')," .
		"(15, 1, NULL, 'Rudern', 1, '".$datetime."', '".$datetime."')," .
		"(16, 1, NULL, 'Sportstudent', 1, '".$datetime."', '".$datetime."')," .
		"(17, 2, NULL, 'Fitness', 1, '".$datetime."', '".$datetime."')," .
		"(18, 2, NULL, 'Kraftsport', 1, '".$datetime."', '".$datetime."')," .
		"(19, 2, NULL, 'Krafttraining', 1, '".$datetime."', '".$datetime."')," .
		"(20, 2, NULL, 'Kraft-Fitness', 1, '".$datetime."', '".$datetime."')," .
		"(21, 3, NULL, 'Voltigieren', 1, '".$datetime."', '".$datetime."')," .
		"(22, 3, NULL, 'Gewichtheben', 1, '".$datetime."', '".$datetime."')," .
		"(23, 3, NULL, 'Crossfit', 1, '".$datetime."', '".$datetime."')," .
		"(24, 3, NULL, 'Kickboxen', 1, '".$datetime."', '".$datetime."')," .
		"(25, 3, NULL, 'Geräteturnen', 1, '".$datetime."', '".$datetime."')," .
		"(26, 3, NULL, 'Moderner Fünfkampf', 1, '".$datetime."', '".$datetime."')," .
		"(27, 3, NULL, 'Kanu', 1, '".$datetime."', '".$datetime."')," .
		"(28, 3, NULL, 'Klettern', 1, '".$datetime."', '".$datetime."')," .
		"(29, 3, NULL, 'Kunstturnen', 1, '".$datetime."', '".$datetime."')," .
		"(30, 3, NULL, 'Jogging / Laufen', 1, '".$datetime."', '".$datetime."')," .
		"(31, 3, NULL, 'Leichtathletik', 1, '".$datetime."', '".$datetime."')," .
		"(32, 3, NULL, 'Mountainbike', 1, '".$datetime."', '".$datetime."')," .
		"(33, 3, NULL, 'Radsport', 1, '".$datetime."', '".$datetime."')," .
		"(34, 3, NULL, 'Schwimmen', 1, '".$datetime."', '".$datetime."')," .
		"(35, 3, NULL, 'Turnen', 1, '".$datetime."', '".$datetime."')," .
		"(36, 3, NULL, 'Triathlon', 1, '".$datetime."', '".$datetime."')," .
		"(37, 4, NULL, 'Basketball', 1, '".$datetime."', '".$datetime."')," .
		"(38, 4, NULL, 'Fußball', 1, '".$datetime."', '".$datetime."')," .
		"(39, 4, NULL, 'Handball', 1, '".$datetime."', '".$datetime."')," .
		"(40, 4, NULL, 'Wasserball', 1, '".$datetime."', '".$datetime."')," .
		"(41, 4, NULL, 'Eishockey', 1, '".$datetime."', '".$datetime."')," .
		"(42, 5, NULL, 'Curling', 1, '".$datetime."', '".$datetime."')," .
		"(43, 5, NULL, 'Paragliding', 1, '".$datetime."', '".$datetime."')," .
		"(44, 5, NULL, 'Kitesurfen', 1, '".$datetime."', '".$datetime."')," .
		"(45, 5, NULL, 'Windsurfen', 1, '".$datetime."', '".$datetime."')," .
		"(46, 5, NULL, 'Tauchen', 1, '".$datetime."', '".$datetime."')," .
		"(47, 5, NULL, 'Parkour', 1, '".$datetime."', '".$datetime."')," .
		"(48, 5, NULL, 'Snowboarding', 1, '".$datetime."', '".$datetime."')," .
		"(49, 6, NULL, 'Judo', 1, '".$datetime."', '".$datetime."')," .
		"(50, 6, NULL, 'Thaiboxen', 1, '".$datetime."', '".$datetime."')," .
		"(51, 6, NULL, 'Taekwondo', 1, '".$datetime."', '".$datetime."')," .
		"(52, 6, NULL, 'Ju-Jutsu', 1, '".$datetime."', '".$datetime."')," .
		"(53, 6, NULL, 'Jiu jitsu', 1, '".$datetime."', '".$datetime."')," .
		"(54, 7, NULL, 'Volleyball', 1, '".$datetime."', '".$datetime."')," .
		"(55, 7, NULL, 'Tennis', 1, '".$datetime."', '".$datetime."')," .
		"(56, 7, NULL, 'Tischtennis', 1, '".$datetime."', '".$datetime."')," .
		"(57, 7, NULL, 'Beachvolleyball', 1, '".$datetime."', '".$datetime."')," .
		"(58, 7, NULL, 'Badminton', 1, '".$datetime."', '".$datetime."');";
}
