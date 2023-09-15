<?php // Config functions

//Encrypt/Decrypt ###########################
function Encrypt_String(string $string):mixed {
	return openssl_encrypt($string, "AES-128-ECB", "REGmon");
}
function Decrypt_String(string $encrypted_string):mixed {
	return openssl_decrypt($encrypted_string, "AES-128-ECB", "REGmon");
}

function Generate_Secret_Key(int $length = 64, bool $special_chars = true, bool $extra_special_chars = false):string {
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

function is_Docker():bool {
    return is_file("/.dockerenv");
}

function is_XAMPP():bool {
	if (isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'XAMPP') !== false) {
		return true;
	} else {
		return false;
	}
}

function reload_Config_Page():void {
	header('Location: config.php'); //reload page
}
// HTML #####################################

function get_HTML_Radio_Check_Buttons(string $config_key, string $config_value, string $option1, string $option2, string $label, string $sub_label):string {
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


function get_HTML_Radio_Check_Buttons__On_Off(string $config_key, string $config_value, string $option_on, string $option_off, string $label, string $sub_label, bool $disabled = false):string {
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


function get_HTML_Input(string $config_key, string $config_value, string $input_type, string $label, string $sub_label, string $placeholder, bool $disabled = false):string {
	return ''.
		'<label for="'.$config_key.'">'.$label.'</label>'.
		'<div class="btn-group" style="width:100%;">'.
			'<input type="'.$input_type.'" id="'.$config_key.'" name="'.$config_key.'" value="'.$config_value.'" class="form-control required" placeholder="'.$placeholder.'"'.($input_type == 'number' ? ' min="1" max="99"' : '').($disabled ? ' disabled' : '').'>'.
			'<small class="text-muted">'.$sub_label.'</small>'.
			($sub_label != '' ? '<br>' : '').
			'<br>'.
		'</div>';
}


function get_HTML_Textarea(string $config_key, string $config_value, string $input_type, string $label, string $sub_label, string $placeholder, bool $disabled = false):string {
	return ''.
		'<label for="'.$config_key.'">'.$label.'</label>'.
		'<textarea id="'.$config_key.'" name="'.$config_key.'" class="form-control required" rows="2" cols="10" wrap="soft" maxlength="64" style="overflow:hidden; resize:none;" placeholder="'.$placeholder.'"'.($disabled ? ' disabled' : '').'>'.$config_value.'</textarea>'.
		'<small class="text-muted">'.$sub_label.'</small>'.
		($sub_label != '' ? '<br>' : '').
		'<br>';
}


function get_HTML_Select(string $config_key, string $config_value, mixed $options_arr, string $label, string $sub_label, string $placeholder):string {
	$options = '';
	foreach((array)$options_arr as $option) {
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


function get_Database_Fields(bool $disabled = true):string {
	global $DB_CONFIG, $CONFIG;

	$html = '';

	$html .= get_HTML_Input( //key, value, type, label, sub_label, placeholder, disabled
		'DB_Host', 
		$DB_CONFIG['DB_Host'],
		'text', 
		'Database Hostname', 
		'ex. localhost, localhost:3306. Use "db" for Docker database.', 
		'localhost',
		$disabled
	);

	$html .= get_HTML_Input( //key, value, type, label, sub_label, placeholder, disabled
		'DB_Name', 
		$DB_CONFIG['DB_Name'], 
		'text', 
		'Database Name', 
		'', 
		'regmondb',
		$disabled
	);

	$html .= get_HTML_Input( //key, value, type, label, sub_label, placeholder, disabled
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
	
	$html .= get_HTML_Input( //key, value, type, label, sub_label, placeholder, disabled
		'DB_Pass', 
		$DB_Pass, 
		'password', 
		'Database Password', 
		'', 
		'root',
		$disabled
	);

	if ($disabled) { //not in .env config

		$html .= '<hr style="margin:0 -5px 20px; border-top:7px double #ccc;">';

		$html .= get_HTML_Input( //key, value, type, label, sub_label, placeholder, disabled
			'DB_Debug_File', 
			$CONFIG['DB_Debug_File'], 
			'text', 
			'Debug Database Queries Filename', 
			'', 
			'__log_query.log',
			false
		);

		$html .= get_HTML_Radio_Check_Buttons__On_Off( //key, value, option_on, option_off, label, sub_label, disabled
			'DB_Debug', 
			$CONFIG['DB_Debug'], 
			'ON', 
			'OFF', 
			'Debug Database Queries', 
			'Writes every sql query to the DB_Debug_File in each file directory',
			false
		);
	}

	return $html;
}


function get_DB_Migrations_Files(string $DB_Migrations_Directory):mixed {
	$DB_Migrations_Files_arr = [];

	if (is_dir($DB_Migrations_Directory)) {
		$files = array();
		//get list and sort
		if ($handle = opendir($DB_Migrations_Directory)) {
			while (false !== ($file = readdir($handle))) {
				if ($file == '.' or $file == '..') {
					continue;
				}
				if (filetype($DB_Migrations_Directory . $file) == 'file') {
					//$timestamp = filemtime($DB_Migrations_Directory . $file);
					//not work all files has the same timestamp if you clone the project
					//$files[$timestamp] = $file;
					$files[] = $file;
				}
			}
			//krsort($files); //key reverse sort --latest first
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
				$file_timestamp = filemtime($DB_Migrations_Directory . $file);
				$file_date = date("Y-m-d H:i:s", (int)$file_timestamp);

				//only _init files
				if (substr_count($file, '_init')) {
					$option_value = $file;
					$option_name = $file_date . '&nbsp; - &nbsp;' .$file . ' &nbsp; - &nbsp; ' . $size . 'KB';
		
					$DB_Migrations_Files_arr[] = [$option_value, $option_name];
				}
			}
		}
	}

	return $DB_Migrations_Files_arr;
}


function get_CONFIG__REGmon_Folder():string {
	global $_SERVER;

	$REGmon_Folder = str_replace(
		[$_SERVER['DOCUMENT_ROOT'], $_SERVER['REQUEST_URI']], 
		'', 
		$_SERVER['SCRIPT_FILENAME']
	);

	return $REGmon_Folder;
}


function get_CONFIG_Defaults_array(mixed $POST = array()):mixed {
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


function Save_Configuration(mixed $config_arr, bool $init = false):string {
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
		$config_arr['EMAIL']['Password'] = Encrypt_String($config_arr['EMAIL']['Password'].'');
	}
	

	//make json string for db
	$config_json = json_encode($config_arr, JSON_UNESCAPED_UNICODE);
	$config_json = str_replace('\/', '/', $config_json.'');
	
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


function get_Admin_User_Init_SQL(string $password, string $email, string $datetime):string {
	return "".
		// add admin user
		"INSERT INTO users (id, account, uname, passwd, location_id, group_id, lastname, firstname, email, level, status, created, modified) VALUES ".
		"('1', 'admin', 'admin', '".hash_Password($password)."', 1, 1, 'profile', 'admin', '".$email."', 99, 1, '".$datetime."', '".$datetime."');";
}

function get_Extra_Users_Init_SQL(string $password, string $email, string $datetime):string {
	return "".
		// extra users
		"INSERT INTO users (id, account, uname, passwd, location_id, group_id, lastname, firstname, email, level, status, dashboard, created, modified) VALUES ".
		"('2', 'user', 'LocationAdmin', '".hash_Password($password)."', 1, 1, 'Admin', 'Location', '".$email."', 50, 1, 0, '".$datetime."', '".$datetime."'),".
		"('3', 'user', 'GroupAdmin', '".hash_Password($password)."', 1, 1, 'Admin', 'Group', '".$email."', 45, 1, 0, '".$datetime."', '".$datetime."'),".
		"('4', 'user', 'GroupAdmin2', '".hash_Password($password)."', 1, 1, 'Admin (reduced)', 'Group', '".$email."', 40, 1, 0, '".$datetime."', '".$datetime."'),".
		"('5', 'user', 'Trainer1', '".hash_Password($password)."', 1, 1, 'Trainer', 'Test', '".$email."', 30, 1, 1, '".$datetime."', '".$datetime."'),".
		"('6', 'user', 'Athlete1', '".hash_Password($password)."', 1, 1, 'Athlete1', 'Test', '".$email."', 10, 1, 1, '".$datetime."', '".$datetime."'),".
		"('7', 'user', 'Athlete2', '".hash_Password($password)."', 1, 1, 'Athlete2', 'Test', '".$email."', 10, 1, 1, '".$datetime."', '".$datetime."');";
}

function get_Extra_LocationGroupsSample_Init_SQL(string $datetime):string {
	return "".
		// location sample data
		"INSERT INTO locations (id, name, status, admin_id, created, modified) VALUES ".
		"(1, 'Location 1', 1, 2, '".$datetime."', '".$datetime."');".
		"\n".
		// groups sample data
		"INSERT INTO `groups` (id, location_id, name, status, private_key, admins_id, forms_select, forms_standard, stop_date, created, modified) VALUES ".
		"(1, 1, 'Group 1 (public)', 1, '', '3,4', '3_3,3_4,3_5,1_1,1_2,4_6', '3_3,4_6', NULL, '".$datetime."', '".$datetime."'),".
		"(2, 1, 'Group 2 (private)', 3, 'secretkey', '3', '3_3,3_4,3_5,1_1,1_2,4_6', '3_4,3_5,1_1,4_6', NULL, '".$datetime."', '".$datetime."');";
}

function get_Extra_User2Groups_Init_SQL(string $datetime):string {
	return "".
		// users2groups
		"INSERT INTO users2groups (id, user_id, group_id, forms_select, status, created, created_by, modified, modified_by) VALUES ".
		"(1, 1, 1, '3_3,3_4,3_5,1_1,1_2,4_6', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(2, 2, 1, '3_3,3_4,3_5,1_1,1_2,4_6', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(3, 3, 1, '3_3,3_4,3_5,1_1,1_2,4_6', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(4, 4, 1, '3_3,3_4,3_5,1_1,1_2,4_6', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(5, 5, 1, '3_3,3_4,3_5,1_1,1_2,4_6', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(6, 6, 1, '3_3,3_4,3_5,1_1,1_2,4_6', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(7, 7, 1, '3_3,3_4,3_5,1_1,1_2,4_6', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(8, 1, 2, '3_3,3_4,3_5,1_1,1_2,4_6', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(9, 2, 2, '3_3,3_4,3_5,1_1,1_2,4_6', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(10, 3, 2, '3_3,3_4,3_5,1_1,1_2,4_6', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(11, 4, 2, '3_3,3_4,3_5,1_1,1_2,4_6', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(12, 5, 2, '3_3,3_4,3_5,1_1,1_2,4_6', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(13, 6, 2, '3_3,3_4,3_5,1_1,1_2,4_6', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(14, 7, 2, '3_3,3_4,3_5,1_1,1_2,4_6', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init');";
}

function get_Extra_Users2Trainers_Init_SQL(string $datetime):string {
	return "".
		// users2trainers
		"INSERT INTO users2trainers (id, user_id, group_id, trainer_id, forms_select_read, forms_select_write, status, created, created_by, modified, modified_by) VALUES ".
		"(1, 6, 1, 5, '3_4,Note_n', '3_5', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(2, 6, 2, 5, '3_4', NULL, 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(3, 7, 1, 5, '3_4,3_5', NULL, 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(4, 7, 2, 5, NULL, '3_4,3_5', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init');";
}

function get_Extra_DropdownsSample_Init_SQL(string $datetime):string {
	return "".
		// dropdowns sample data [german/english]
		"INSERT INTO dropdowns (id, parent_id, name, options, status, created, modified) VALUES ".
		"(1, 0, 'Dropdown Demo StringValue', NULL, 1, '".$datetime."', '".$datetime."'),".
		"(2, 1, NULL, 'Option 1', 1, '".$datetime."', '".$datetime."'),".
		"(3, 1, NULL, 'Option 2', 1, '".$datetime."', '".$datetime."'),".
		"(4, 1, NULL, 'Option 3', 1, '".$datetime."', '".$datetime."'),".
		"(5, 0, 'Dropdown Demo Value__String', NULL, 1, '".$datetime."', '".$datetime."'),".
		"(6, 5, NULL, '1__Option 1', 1, '".$datetime."', '".$datetime."'),".
		"(7, 5, NULL, '2__Option 2', 1, '".$datetime."', '".$datetime."'),".
		"(8, 5, NULL, '3__Option 3', 1, '".$datetime."', '".$datetime."'),".
		"(9, 0, 'rating scale (0-6) [german AEB/KEB]', NULL, 1, '".$datetime."', '".$datetime."'),".
		"(10, 9, NULL, '0__trifft gar nicht zu', 1, '".$datetime."', '".$datetime."'),".
		"(11, 9, NULL, '1__', 1, '".$datetime."', '".$datetime."'),".
		"(12, 9, NULL, '2__', 1, '".$datetime."', '".$datetime."'),".
		"(13, 9, NULL, '3__', 1, '".$datetime."', '".$datetime."'),".
		"(14, 9, NULL, '4__', 1, '".$datetime."', '".$datetime."'),".
		"(15, 9, NULL, '5__', 1, '".$datetime."', '".$datetime."'),".
		"(16, 9, NULL, '6__trifft voll zu', 1, '".$datetime."', '".$datetime."'),".
		"(17, 0, 'rating scale (1-9) [german v1]', NULL, 1, '".$datetime."', '".$datetime."'),".
		"(18, 17, NULL, '1__sehr schlecht', 1, '".$datetime."', '".$datetime."'),".
		"(19, 17, NULL, '2__', 1, '".$datetime."', '".$datetime."'),".
		"(20, 17, NULL, '3__schlecht', 1, '".$datetime."', '".$datetime."'),".
		"(21, 17, NULL, '4__', 1, '".$datetime."', '".$datetime."'),".
		"(22, 17, NULL, '5__mittelmäßig', 1, '".$datetime."', '".$datetime."'),".
		"(23, 17, NULL, '6__', 1, '".$datetime."', '".$datetime."'),".
		"(24, 17, NULL, '7__gut', 1, '".$datetime."', '".$datetime."'),".
		"(25, 17, NULL, '8__', 1, '".$datetime."', '".$datetime."'),".
		"(26, 17, NULL, '9__sehr gut', 1, '".$datetime."', '".$datetime."'),".
		"(27, 0, 'RPE CR-10 [german]', NULL, 1, '".$datetime."', '".$datetime."'),".
		"(28, 27, NULL, '0__Ruhe', 1, '".$datetime."', '".$datetime."'),".
		"(29, 27, NULL, '1__Sehr leicht', 1, '".$datetime."', '".$datetime."'),".
		"(30, 27, NULL, '2__Leicht', 1, '".$datetime."', '".$datetime."'),".
		"(31, 27, NULL, '3__Moderat', 1, '".$datetime."', '".$datetime."'),".
		"(32, 27, NULL, '4__Schon Härter', 1, '".$datetime."', '".$datetime."'),".
		"(33, 27, NULL, '5__Hart', 1, '".$datetime."', '".$datetime."'),".
		"(34, 27, NULL, '6__', 1, '".$datetime."', '".$datetime."'),".
		"(35, 27, NULL, '7__Sehr hart', 1, '".$datetime."', '".$datetime."'),".
		"(36, 27, NULL, '8__Wirklich sehr hart', 1, '".$datetime."', '".$datetime."'),".
		"(37, 27, NULL, '9__', 1, '".$datetime."', '".$datetime."'),".
		"(38, 27, NULL, '10__Maximal (mehr geht nicht)', 1, '".$datetime."', '".$datetime."'),".
		"(39, 0, 'training/competition [german]', NULL, 1, '".$datetime."', '".$datetime."'),".
		"(40, 39, NULL, '1__Training', 1, '".$datetime."', '".$datetime."'),".
		"(41, 39, NULL, '2__Wettkampf', 1, '".$datetime."', '".$datetime."');";
}

function get_Extra_FormsTagsSample_Init_SQL(string $datetime):string {
	return "".
		// forms sample data [german/english]
		"INSERT INTO forms (id, name, name2, status, tags, data_json, data_names, created, created_by, modified, modified_by) VALUES ".
		"(1, 'empty form (external name)', 'empty form (internal name)', 1, 'test', NULL, NULL, '".$datetime."','Auto_Init','".$datetime."','Auto_Init'),".
		"(2, 'form with all elements', 'form for testing purposes', 1, 'test', '{\"title\":\"test (test)\",\"timer\":{\"has\":\"0\",\"min\":\"0\",\"period\":\"min\"},\"days\":{\"has\":\"0\",\"arr\":[1,2,3,4,5,6,7]},\"pages\":[{\"no\":1,\"display_times\":\"0\",\"title\":\"page 1\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":2,\"items\":[{\"type\":\"_Line\",\"no\":1,\"width\":\"100\"}]},{\"no\":3,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<h1>Header 1<br></h1>\",\"width\":\"100\"}]},{\"no\":4,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"description\",\"align\":\"left\",\"bold\":\"2\",\"width\":\"50\"},{\"type\":\"_Text\",\"no\":2,\"unid\":1,\"name\":\"text1\",\"placeholder\":\"placeholder\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":5,\"items\":[{\"type\":\"_Textarea\",\"no\":1,\"unid\":2,\"name\":\"text2\",\"placeholder\":\"placeholder\",\"required\":\"0\",\"width\":\"100\"}]},{\"no\":6,\"items\":[{\"type\":\"_Number\",\"no\":1,\"unid\":3,\"name\":\"number1\",\"placeholder\":\"placeholder\",\"required\":\"1\",\"min\":\"0\",\"max\":\"100\",\"decimal\":false,\"width\":\"100\"}]},{\"no\":7,\"items\":[{\"type\":\"_Date\",\"no\":1,\"unid\":4,\"name\":\"date1\",\"placeholder\":\"placeholder\",\"required\":\"1\",\"width\":\"50\"},{\"type\":\"_Time\",\"no\":2,\"unid\":5,\"name\":\"time1\",\"placeholder\":\"placeholder\",\"required\":\"1\",\"width\":\"50\"}]},{\"no\":8,\"items\":[{\"type\":\"_Period\",\"no\":1,\"unid\":6,\"name\":\"duration\",\"placeholder_from\":\"placeholder\",\"placeholder_to\":\"placeholder\",\"placeholder\":\"placeholder\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":9,\"items\":[{\"type\":\"_Line\",\"no\":1,\"width\":\"100\"}]},{\"no\":10,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"decription\",\"align\":\"center\",\"bold\":\"0\",\"width\":\"50\"},{\"type\":\"_Dropdown\",\"no\":2,\"unid\":7,\"name\":\"list1\",\"opt\":\"placeholder\",\"dd\":\"1\",\"has_color\":\"0\",\"color\":\"120|0\",\"required\":\"1\",\"width\":\"50\"}]},{\"no\":11,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":8,\"name\":\"list2\",\"has_title\":\"1\",\"title\":\"description\",\"talign\":\"center\",\"rdd\":\"5\",\"has_color\":\"1\",\"color\":\"120|0\",\"required\":\"0\",\"width\":\"100\"}]},{\"no\":12,\"items\":[{\"type\":\"_Accordion\",\"no\":1,\"accType\":false,\"width\":\"100\",\"Panels\":[{\"type\":\"_Accordion_Panel\",\"no\":1,\"acc_no\":1,\"label\":\"accordion panel\",\"align\":\"center\",\"bold\":\"2\",\"open\":false,\"Rows\":[{\"no\":1,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"description\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":9,\"name\":\"number2\",\"placeholder\":\"placeholder\",\"required\":\"0\",\"min\":\"5\",\"max\":\"10\",\"decimal\":true,\"width\":\"50\"}]}]},{\"type\":\"_Accordion_Panel\",\"no\":1,\"acc_no\":2,\"label\":\"accordion panel 2\",\"align\":\"center\",\"bold\":\"2\",\"open\":false,\"Rows\":[]},{\"type\":\"_Accordion_Panel\",\"no\":1,\"acc_no\":3,\"label\":\"accordion panel 3\",\"align\":\"center\",\"bold\":\"2\",\"open\":false,\"Rows\":[]}]}]}]},{\"no\":2,\"display_times\":\"0\",\"title\":\"page 2\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<h2>Header 2<br></h2>\",\"width\":\"100\"}]},{\"no\":2,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":10,\"name\":\"list3\",\"has_title\":\"1\",\"title\":\"description\",\"talign\":\"left\",\"rdd\":\"5\",\"has_color\":\"0\",\"color\":\"120|0\",\"required\":\"0\",\"width\":\"100\"}]}]}]}', '{\"1\":[\"text1\",\"_Text\"],\"2\":[\"text2\",\"_Textarea\"],\"3\":[\"number1\",\"_Number\"],\"4\":[\"date1\",\"_Date\"],\"5\":[\"time1\",\"_Time\"],\"6\":[\"duration\",\"_Period\"],\"7\":[\"list1\",\"_Dropdown\"],\"8\":[\"list2\",\"_RadioButtons\"],\"9\":[\"number2\",\"_Number\"],\"10\":[\"list3\",\"_RadioButtons\"]}', '".$datetime."','Auto_Init','".$datetime."','Auto_Init'),".
		"(3, 'Akutmaß Erholung und Beanspruchung (AEB)','offizielles REGman-Formular (AEB)',1,'Beanspruchung,Erholung,Fragebogen,Psychometrie','{\"title\":\"AEB, aktuelle Version (Akutmaß Erholung und Beanspruchung (AEB))\",\"timer\":{\"has\":\"1\",\"min\":\"15\",\"period\":\"min\"},\"days\":{\"has\":\"0\",\"arr\":[1,2,3,4,5,6,7]},\"pages\":[{\"no\":1,\"display_times\":\"3\",\"title\":\"Akutmaß Erholung und Beanspruchung (AEB)\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"Auf der nächsten Seite finden Sie eine Reihe von Aussagen, die sich auf ihr körperliches und seelisches Befinden beziehen. Bitte überlegen Sie bei jeder Aussagen, in welchem Maße diese auf Sie zutrifft.&nbsp;<p>Zur Beurteilung steht ihnen eine siebenfach abgestufte Skala zur Verfügung.&nbsp;</p>\",\"width\":\"100\"}]},{\"no\":2,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":3,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Im Augenblick fühle ich mich...\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"100\"}]},{\"no\":4,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":1,\"name\":\"AEB_Beispiel\",\"has_title\":\"1\",\"title\":\"1) erholt\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"0\",\"width\":\"100\"}]},{\"no\":5,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":6,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"Bitte denken Sie nicht zu lange über eine Aussage nach, sondern treffen Sie möglichst spontan ein Wahl.&nbsp;<p>Überlegen Sie bitte nicht, welche Beantwortung auf den ersten Blick einen bestimmten Eindruck vermittelt, sondern stufen Sie die Aussagen so ein, wie es für Sie persönlich am ehesten zutrifft. Es gibt dabei keine richtig oder falschen Antworten.&nbsp;</p>\",\"width\":\"100\"}]}]},{\"no\":2,\"display_times\":\"0\",\"title\":\"Akutmaß Erholung und Beanspruchung (AEB)\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"Im Folgenden befindet sich eine Liste von Adjektiven, die den Zustand von Erholung und Beanspruchung beschreiben. Nimm bitte für jedes Adjektiv eine Einschätzung vor und setze ein Kreuz an die Stelle, die für Deinen jetzigen Zustand am ehesten zutrifft.&nbsp;\",\"width\":\"100\"}]},{\"no\":2,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":3,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Im Augenblick fühle ich mich...\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"100\"}]},{\"no\":4,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":2,\"name\":\"AEB_1\",\"has_title\":\"1\",\"title\":\"1) erholt\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":5,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":3,\"name\":\"AEB_2\",\"has_title\":\"1\",\"title\":\"2) muskulär überanstrengt\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":6,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":4,\"name\":\"AEB_3\",\"has_title\":\"1\",\"title\":\"3) zufrieden\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":7,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":5,\"name\":\"AEB_4\",\"has_title\":\"1\",\"title\":\"4) unmotiviert\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":8,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":6,\"name\":\"AEB_5\",\"has_title\":\"1\",\"title\":\"5) aufmerksam\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":9,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":7,\"name\":\"AEB_6\",\"has_title\":\"1\",\"title\":\"6) bedrückt\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":10,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":8,\"name\":\"AEB_7\",\"has_title\":\"1\",\"title\":\"7) kraftvoll\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":11,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":9,\"name\":\"AEB_8\",\"has_title\":\"1\",\"title\":\"8) geschafft\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":12,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":10,\"name\":\"AEB_9\",\"has_title\":\"1\",\"title\":\"9) ausgeruht\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":13,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":11,\"name\":\"AEB_10\",\"has_title\":\"1\",\"title\":\"10) muskulär ermüdet\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":14,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":12,\"name\":\"AEB_11\",\"has_title\":\"1\",\"title\":\"11) ausgeglichen\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":15,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":13,\"name\":\"AEB_12\",\"has_title\":\"1\",\"title\":\"12) antriebslos\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":16,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":14,\"name\":\"AEB_13\",\"has_title\":\"1\",\"title\":\"13) aufnahmefähig\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":17,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":15,\"name\":\"AEB_14\",\"has_title\":\"1\",\"title\":\"14) gestresst\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":18,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":16,\"name\":\"AEB_15\",\"has_title\":\"1\",\"title\":\"15) leistungsfähig\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":19,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":17,\"name\":\"AEB_16\",\"has_title\":\"1\",\"title\":\"16) entkräftet\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":20,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":18,\"name\":\"AEB_17\",\"has_title\":\"1\",\"title\":\"17) muskulär locker\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":21,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":19,\"name\":\"AEB_18\",\"has_title\":\"1\",\"title\":\"18) lustlos\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":22,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":20,\"name\":\"AEB_19\",\"has_title\":\"1\",\"title\":\"19) gut gelaunt\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":23,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":21,\"name\":\"AEB_20\",\"has_title\":\"1\",\"title\":\"20) genervt\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":24,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":22,\"name\":\"AEB_21\",\"has_title\":\"1\",\"title\":\"21) mental hellwach\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":25,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":23,\"name\":\"AEB_22\",\"has_title\":\"1\",\"title\":\"22) muskulär übersäuert\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":26,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":24,\"name\":\"AEB_23\",\"has_title\":\"1\",\"title\":\"23) energiegeladen\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":27,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":25,\"name\":\"AEB_24\",\"has_title\":\"1\",\"title\":\"24) überlastet\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":28,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":26,\"name\":\"AEB_25\",\"has_title\":\"1\",\"title\":\"25) körperlich entspannt\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":29,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":27,\"name\":\"AEB_26\",\"has_title\":\"1\",\"title\":\"26) muskulär verhärtet\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":30,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":28,\"name\":\"AEB_27\",\"has_title\":\"1\",\"title\":\"27) alles im Griff habend\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":31,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":29,\"name\":\"AEB_28\",\"has_title\":\"1\",\"title\":\"28) energielos\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":32,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":30,\"name\":\"AEB_29\",\"has_title\":\"1\",\"title\":\"29) konzentriert\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":33,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":31,\"name\":\"AEB_30\",\"has_title\":\"1\",\"title\":\"30) leicht reizbar\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":34,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":32,\"name\":\"AEB_31\",\"has_title\":\"1\",\"title\":\"31) voller Power\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":35,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":33,\"name\":\"AEB_32\",\"has_title\":\"1\",\"title\":\"32) körperlich platt\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]}]}]}','{\"1\":[\"AEB_Beispiel\",\"_RadioButtons\"],\"2\":[\"AEB_1\",\"_RadioButtons\"],\"3\":[\"AEB_2\",\"_RadioButtons\"],\"4\":[\"AEB_3\",\"_RadioButtons\"],\"5\":[\"AEB_4\",\"_RadioButtons\"],\"6\":[\"AEB_5\",\"_RadioButtons\"],\"7\":[\"AEB_6\",\"_RadioButtons\"],\"8\":[\"AEB_7\",\"_RadioButtons\"],\"9\":[\"AEB_8\",\"_RadioButtons\"],\"10\":[\"AEB_9\",\"_RadioButtons\"],\"11\":[\"AEB_10\",\"_RadioButtons\"],\"12\":[\"AEB_11\",\"_RadioButtons\"],\"13\":[\"AEB_12\",\"_RadioButtons\"],\"14\":[\"AEB_13\",\"_RadioButtons\"],\"15\":[\"AEB_14\",\"_RadioButtons\"],\"16\":[\"AEB_15\",\"_RadioButtons\"],\"17\":[\"AEB_16\",\"_RadioButtons\"],\"18\":[\"AEB_17\",\"_RadioButtons\"],\"19\":[\"AEB_18\",\"_RadioButtons\"],\"20\":[\"AEB_19\",\"_RadioButtons\"],\"21\":[\"AEB_20\",\"_RadioButtons\"],\"22\":[\"AEB_21\",\"_RadioButtons\"],\"23\":[\"AEB_22\",\"_RadioButtons\"],\"24\":[\"AEB_23\",\"_RadioButtons\"],\"25\":[\"AEB_24\",\"_RadioButtons\"],\"26\":[\"AEB_25\",\"_RadioButtons\"],\"27\":[\"AEB_26\",\"_RadioButtons\"],\"28\":[\"AEB_27\",\"_RadioButtons\"],\"29\":[\"AEB_28\",\"_RadioButtons\"],\"30\":[\"AEB_29\",\"_RadioButtons\"],\"31\":[\"AEB_30\",\"_RadioButtons\"],\"32\":[\"AEB_31\",\"_RadioButtons\"],\"33\":[\"AEB_32\",\"_RadioButtons\"]}','".$datetime."','Auto_Init','".$datetime."','Auto_Init'),".
		"(4, 'Kurzskala Erholung und Beanspruchung (KEB)', 'offizielles REGman-Formular (KEB)', 1, 'Beanspruchung,Erholung,Fragebogen,Psychometrie', '{\"title\":\"Kurzskala Erholung und Beanspruchung (KEB) (offizielles REGman-Formular (KEB))\",\"timer\":{\"has\":\"1\",\"min\":\"5\",\"period\":\"min\"},\"days\":{\"has\":\"0\",\"arr\":[1,2,3,4,5,6,7]},\"pages\":[{\"no\":1,\"display_times\":\"3\",\"title\":\"Kurzskala Erholung und Beanspruchung (KEB)\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Hinweise zur Bearbeitung des Fragebogens\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"100\"}]},{\"no\":2,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<p>Auf der nächsten Seite finden sich eine Reihe von Aussagen, die sich auf Dein körperliches und seelisches Befinden beziehen. Bitte überlege bei jeder Aussage, in welchem Maße diese auf Dich zutrifft. <br></p><p>Zur Beurteilung steht Dir eine siebenfach abgestufte Skala zur Verfügung. <br></p>\",\"width\":\"100\"}]},{\"no\":3,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":4,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b> Körperliche Leistungsfähigkeit</b><h3><span style=\\\\\\\"font-weight: normal;\\\\\\\"><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">z.B.&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">kraftvoll,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">leistungsfähig,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">energiegeladen,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">voller Power</i></span></h3><h4><span style=\\\\\\\"font-weight: normal;\\\\\\\"><sub><span style=\\\\\\\"vertical-align: super;\\\\\\\"><i></i></span><i style=\\\\\\\"\\\\\\\"><p style=\\\\\\\"\\\\\\\"></p></i></sub><p style=\\\\\\\"vertical-align: super;\\\\\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":5,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":1,\"name\":\"KEB_Beispiel\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"0\",\"width\":\"100\"}]},{\"no\":6,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":7,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<p>Bitte denke nicht zu lange über eine Aussage nach, sondern triff möglichst spontan eine Wahl.</p><p>Überlege bitte nicht, welche Beantwortung möglicherweise auf den ersten Blick einen bestimmten Eindruck vermittelt, sondern stufe die Aussagen so ein, wie es für Dich persönlich am ehesten zutrifft. Es gibt dabei keine richtigen oder falschen Antworten. <br></p>\",\"width\":\"100\"}]}]},{\"no\":2,\"display_times\":\"0\",\"title\":\"Kurzskala Erholung und Beanspruchung (KEB)\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<h2 style=\\\\\\\"text-align: center;\\\\\\\"><span style=\\\\\\\"background-color: transparent;\\\\\\\"></span></h2><hr><h2 style=\\\\\\\"text-align: center;\\\\\\\"><span style=\\\\\\\"background-color: transparent;\\\\\\\"><b>Kurzskala Erholung</b></span></h2><hr><h2 style=\\\\\\\"text-align: center;\\\\\\\"><span style=\\\\\\\"background-color: transparent;\\\\\\\"></span></h2>\",\"width\":\"100\"}]},{\"no\":2,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"Im Folgenden geht es um verschiedene Facetten deines derzeitigen Erholungszustandes. Die Ausprägung \\\\\\\"trifft voll zu\\\\\\\" symbolisiert dabei den besten von dir jemals erreichten Erholungszustand.&nbsp;\",\"width\":\"100\"}]},{\"no\":3,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":4,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b> Körperliche Leistungsfähigkeit</b><h3><span style=\\\\\\\"font-weight: normal;\\\\\\\"><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">z.B.&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">kraftvoll,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">leistungsfähig,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">energiegeladen,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">voller Power</i></span></h3><h4><span style=\\\\\\\"font-weight: normal;\\\\\\\"><sub><span style=\\\\\\\"vertical-align: super;\\\\\\\"><i></i></span><i style=\\\\\\\"\\\\\\\"><p style=\\\\\\\"\\\\\\\"></p></i></sub><p style=\\\\\\\"vertical-align: super;\\\\\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":5,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":2,\"name\":\"Körperliche Leistungsfähigkeit\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":6,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":7,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b> Mentale Leistungsfähigkeit</b><h3><span style=\\\\\\\"font-weight: normal;\\\\\\\"><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">z.B.&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">aufmerksam,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">aufnahmefähig,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">konzentriert,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">mental hellwach</i></span></h3><h4><span style=\\\\\\\"font-weight: normal;\\\\\\\"><sub><span style=\\\\\\\"vertical-align: super;\\\\\\\"><i></i></span><i style=\\\\\\\"\\\\\\\"><p style=\\\\\\\"\\\\\\\"></p></i></sub><p style=\\\\\\\"vertical-align: super;\\\\\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":8,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":3,\"name\":\"Mentale Leistungsfähigkeit\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":9,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":10,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b>Emotionale Ausgeglichenheit</b><h3><span style=\\\\\\\"font-weight: normal;\\\\\\\"><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">z.B.&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">zufrieden,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">ausgeglichen,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">gut gelaunt,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">alles im Griff habend</i></span></h3><h4><span style=\\\\\\\"font-weight: normal;\\\\\\\"><sub><span style=\\\\\\\"vertical-align: super;\\\\\\\"><i></i></span><i style=\\\\\\\"\\\\\\\"><p style=\\\\\\\"\\\\\\\"></p></i></sub><p style=\\\\\\\"vertical-align: super;\\\\\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":11,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":4,\"name\":\"Emotionale Ausgeglichenheit\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":12,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":13,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b>Allgemeiner Erholungszustand</b><h3><span style=\\\\\\\"font-weight: normal;\\\\\\\"><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">z.B.&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">erholt,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">ausgeruht,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">muskulär locker,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">körperlich entspannt</i></span></h3><h4><span style=\\\\\\\"font-weight: normal;\\\\\\\"><sub><span style=\\\\\\\"vertical-align: super;\\\\\\\"><i></i></span><i style=\\\\\\\"\\\\\\\"><p style=\\\\\\\"\\\\\\\"></p></i></sub><p style=\\\\\\\"vertical-align: super;\\\\\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":14,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":5,\"name\":\"Allgemeiner Erholungszustand\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":15,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<h2 style=\\\\\\\"text-align: center;\\\\\\\"><span style=\\\\\\\"background-color: transparent;\\\\\\\"></span></h2><hr><h2 style=\\\\\\\"text-align: center;\\\\\\\"><span style=\\\\\\\"background-color: transparent;\\\\\\\"><b>Kurzskala Beanspruchung&nbsp;</b></span></h2><hr><h2 style=\\\\\\\"text-align: center;\\\\\\\"><span style=\\\\\\\"background-color: transparent;\\\\\\\"></span></h2>\",\"width\":\"100\"}]},{\"no\":16,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"Im Folgenden geht es um verschiedene Facetten deines derzeitigen Beanspruchungszustandes. Die Ausprägung \\\\\\\"trifft voll zu\\\\\\\" symbolisiert dabei den höchsten von dir jemals erreichten Beanspruchungszustand.&nbsp;\",\"width\":\"100\"}]},{\"no\":17,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":18,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b> Muskuläre Beanspruchung</b><h3><span style=\\\\\\\"font-weight: normal;\\\\\\\"><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">z.B.&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">muskulär überanstrengt,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">muskulär ermüdet,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">muskulär übersäuert,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">muskulär verhärtet</i></span></h3><h4><span style=\\\\\\\"font-weight: normal;\\\\\\\"><sub><span style=\\\\\\\"vertical-align: super;\\\\\\\"><i></i></span><i style=\\\\\\\"\\\\\\\"><p style=\\\\\\\"\\\\\\\"></p></i></sub><p style=\\\\\\\"vertical-align: super;\\\\\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":19,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":6,\"name\":\"Muskuläre Beanspruchung\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":20,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":21,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b> Aktivierungsmangel</b><h3><span style=\\\\\\\"font-weight: normal;\\\\\\\"><sub><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">z.B.&nbsp;</i></sub><i style=\\\\\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\\\\\">unmotiviert,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\\\\\">antriebslos,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\\\\\">lustlos,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\\\\\">energielos</i></span></h3><h4><span style=\\\\\\\"font-weight: normal;\\\\\\\"><sub><span style=\\\\\\\"vertical-align: super;\\\\\\\"><i></i></span><i style=\\\\\\\"\\\\\\\"><p style=\\\\\\\"\\\\\\\"></p></i></sub><p style=\\\\\\\"vertical-align: super;\\\\\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":22,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":7,\"name\":\"Aktivierungsmangel\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":23,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":24,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b> Emotionale Unausgeglichenheit</b><h3><span style=\\\\\\\"font-weight: normal;\\\\\\\"><sub><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">z.B.&nbsp;</i></sub><i style=\\\\\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\\\\\">bedrückt,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\\\\\">gestresst,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\\\\\">genervt,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\\\\\">leicht reizbar</i></span></h3><h4><span style=\\\\\\\"font-weight: normal;\\\\\\\"><sub><span style=\\\\\\\"vertical-align: super;\\\\\\\"><i></i></span><i style=\\\\\\\"\\\\\\\"><p style=\\\\\\\"\\\\\\\"></p></i></sub><p style=\\\\\\\"vertical-align: super;\\\\\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":25,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":8,\"name\":\"Emotionale Unausgeglichenheit\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":26,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":27,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b> Allgemeiner Beanspruchungszustand</b><h3><span style=\\\\\\\"font-weight: normal;\\\\\\\"><sub><i style=\\\\\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\\\\\">z.B.&nbsp;</i></sub><i style=\\\\\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\\\\\">geschafft,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\\\\\">entkräftet,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\\\\\">überlastet,&nbsp;</i><i style=\\\\\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\\\\\">körperlich platt</i></span></h3><h4><span style=\\\\\\\"font-weight: normal;\\\\\\\"><sub><span style=\\\\\\\"vertical-align: super;\\\\\\\"><i></i></span><i style=\\\\\\\"\\\\\\\"><p style=\\\\\\\"\\\\\\\"></p></i></sub><p style=\\\\\\\"vertical-align: super;\\\\\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":28,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":9,\"name\":\"Allgemeiner Beanspruchungszustand\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"9\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]}]}]}', '{\"1\":[\"KEB_Beispiel\",\"_RadioButtons\"],\"2\":[\"Körperliche Leistungsfähigkeit\",\"_RadioButtons\"],\"3\":[\"Mentale Leistungsfähigkeit\",\"_RadioButtons\"],\"4\":[\"Emotionale Ausgeglichenheit\",\"_RadioButtons\"],\"5\":[\"Allgemeiner Erholungszustand\",\"_RadioButtons\"],\"6\":[\"Muskuläre Beanspruchung\",\"_RadioButtons\"],\"7\":[\"Aktivierungsmangel\",\"_RadioButtons\"],\"8\":[\"Emotionale Unausgeglichenheit\",\"_RadioButtons\"],\"9\":[\"Allgemeiner Beanspruchungszustand\",\"_RadioButtons\"]}', '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(5, 'Schlafdokumentation (kurz)', 'Schlafdokumentation (minimal)', 1, 'Erholung,Psychometrie,Schlaf,sleep', '{\"title\":\"Schlafdokumentation (kurz) (Schlafdokumentation (minimal))\",\"timer\":{\"has\":\"0\",\"min\":\"0\",\"period\":\"min\"},\"days\":{\"has\":\"0\",\"arr\":[1,2,3,4,5,6,7]},\"pages\":[{\"no\":1,\"display_times\":\"0\",\"title\":\"Dokumentation Deiner Nacht / Deines Schlafs\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<hr><div style=\\\\\\\"text-align: center;\\\\\\\">Wie lange hast Du geschlafen?<br><hr></div>\",\"width\":\"100\"}]},{\"no\":2,\"items\":[{\"type\":\"_Period\",\"no\":1,\"unid\":1,\"name\":\"Schlafdauer\",\"placeholder_from\":\"von\",\"placeholder_to\":\"bis\",\"placeholder\":\"Schlafdauer hier eintragen\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":3,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<hr><div style=\\\\\\\"text-align: center;\\\\\\\">Wie hast Du geschlafen?<br></div><hr>\",\"width\":\"100\"}]},{\"no\":4,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":2,\"name\":\"Schlafqualität\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"17\",\"has_color\":\"1\",\"color\":\"0|120\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":5,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<hr><div style=\\\\\\\"text-align: center;\\\\\\\">Möchtest Du noch etwas hinzufügen?<br></div><hr>\",\"width\":\"100\"}]},{\"no\":6,\"items\":[{\"type\":\"_Textarea\",\"no\":1,\"unid\":3,\"name\":\"zusätzlicher Kommentar Schlafdokumentation\",\"placeholder\":\"Hier kannst Du Kommentare oder zusätzliche Informationen eintragen (optional)\",\"required\":\"0\",\"width\":\"100\"}]}]}]}', '{\"1\":[\"Schlafdauer\",\"_Period\"],\"2\":[\"Schlafqualität\",\"_RadioButtons\"],\"3\":[\"zusätzlicher Kommentar Schlafdokumentation\",\"_Textarea\"]}', '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(6, 'Trainingload (Session-RPE Methode)', 'offizielles REGman-Formular (Trainingload)', 1, 'Beanspruchung,Belastung,Load,Psychometrie,RPE,Training Load,Trainingload', '{\"title\":\"offizielles REGman-Formular für den allgemeinen Trainingload (Se (Trainingload (Session-RPE Methode))\",\"timer\":{\"has\":\"0\",\"min\":\"0\",\"period\":\"min\"},\"days\":{\"has\":\"0\",\"arr\":[1,2,3,4,5,6,7]},\"pages\":[{\"no\":1,\"display_times\":\"0\",\"title\":\"Dokumentation des Trainingloads (Session-RPE Methode)\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Line\",\"no\":1,\"width\":\"100\"}]},{\"no\":2,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":1,\"name\":\"Art (Training oder Wettkampf)\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"39\",\"has_color\":\"0\",\"color\":\"120|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":3,\"items\":[{\"type\":\"_Line\",\"no\":1,\"width\":\"100\"}]},{\"no\":4,\"items\":[{\"type\":\"_Number\",\"no\":1,\"unid\":2,\"name\":\"Dauer (Training / Wettkampf)\",\"placeholder\":\"Trainings-/Wettkampfdauer [min]\",\"required\":\"1\",\"min\":\"0\",\"max\":\"800\",\"decimal\":false,\"width\":\"100\"}]},{\"no\":5,\"items\":[{\"type\":\"_Line\",\"no\":1,\"width\":\"100\"}]},{\"no\":6,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":3,\"name\":\"Rating of Perceived Exertion (RPE)\",\"has_title\":\"1\",\"title\":\"Subjektives Belastungsempfinden\",\"talign\":\"left\",\"rdd\":\"27\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":7,\"items\":[{\"type\":\"_Line\",\"no\":1,\"width\":\"100\"}]},{\"no\":8,\"items\":[{\"type\":\"_Textarea\",\"no\":1,\"unid\":4,\"name\":\"Trainingload zusätzliche Informationen\",\"placeholder\":\"zusätzliche Informationen und Kommentare (optional)\",\"required\":\"0\",\"width\":\"100\"}]}]}]}', '{\"1\":[\"Art (Training oder Wettkampf)\",\"_RadioButtons\"],\"2\":[\"Dauer (Training / Wettkampf)\",\"_Number\"],\"3\":[\"Rating of Perceived Exertion (RPE)\",\"_RadioButtons\"],\"4\":[\"Trainingload zusätzliche Informationen\",\"_Textarea\"]}', '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init');".
		"\n".
		// tags sample data [german/english]
		"INSERT INTO tags (id, name, status, created, created_by, modified, modified_by) VALUES ".
		"(1, 'test', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(2, 'Beanspruchung', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(3, 'Erholung', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(4, 'Fragebogen', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(5, 'Psychometrie', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(6, 'Schlaf', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(7, 'sleep', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(8, 'Belastung', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(9, 'Load', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(10, 'RPE', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(11, 'Training Load', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init'),".
		"(12, 'Trainingload', 1, '".$datetime."', 'Auto_Init', '".$datetime."', 'Auto_Init');";
}

function get_Extra_NotesSampleData_Init_SQL(string $datetime):string {
	return "".
		// sample notes data (for user-id 6 = "Athlete1") [german]
		"INSERT INTO comments (id, user_id, group_id, isAllDay, showInGraph, name, comments, color, created, created_end, modified) VALUES ".
		"(1, 6, 1, 1, 0, 'Urlaub', NULL, 'rgba(238,238,238,0.5)', '2023-05-20 00:00:00', '2023-06-01 23:59:59', '2023-09-13 11:05:36'),".
		"(2, 6, 1, 1, 0, 'Schulterprellung', NULL, 'rgba(23,144,190,1)', '2023-06-26 00:00:00', '2023-07-06 23:59:59', '2023-09-13 11:05:36'),".
		"(3, 6, 1, 1, 0, 'Urlaub am Bodensee', NULL, 'rgba(238,238,238,0.5)', '2023-08-24 00:00:00', '2023-09-03 23:59:59', '2023-09-13 11:05:36'),".
		"(4, 6, 1, 0, 1, 'Test_Note_Name', 'Test_comments', 'rgb(165,165,165)', '2023-09-13 07:45:00', '2023-09-13 08:15:00', '2023-09-13 11:05:36');";
}

function get_Extra_FormsSampleData_Init_SQL(string $datetime):string {
	return "".
		// actual data for specific forms (for user-id 6 = "Athlete1") [german]
		"INSERT INTO forms_data (id, user_id, form_id, category_id, group_id, res_json, status, created, created_end, created_by, modified, modified_by) VALUES ".
		"(1, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"3__\",\"4\":\"5__\",\"5\":\"4__\",\"6\":\"1__\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-04-07 07:30:00', '2023-04-07 08:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(2, 6, 5, 3, 1, '{\"1\":[\"22:55\",\"06:45\",\"07:50\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-04-07 08:00:00', '2023-04-07 08:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(3, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"3__\",\"4\":\"4__\",\"5\":\"6__trifft voll zu\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"3__\",\"8\":\"2__\",\"9\":\"0__trifft gar nicht zu\"}', 1, '2023-04-08 08:30:00', '2023-04-08 09:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(4, 6, 5, 3, 1, '{\"1\":[\"23:55\",\"08:20\",\"08:25\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-04-08 09:00:00', '2023-04-08 09:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(5, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"1__\",\"4\":\"2__\",\"5\":\"4__\",\"6\":\"1__\",\"7\":\"4__\",\"8\":\"3__\",\"9\":\"2__\"}', 1, '2023-04-09 07:00:00', '2023-04-09 07:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(6, 6, 5, 3, 1, '{\"1\":[\"22:15\",\"07:00\",\"08:45\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-04-09 07:30:00', '2023-04-09 08:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(7, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"45\",\"3\":\"7__Sehr hart\",\"4\":\"Intervalle 10x2min mit je 1min Pause, insgesamt 7,4 km (mit Polar Uhr gelaufen)\"}', 1, '2023-04-09 17:15:00', '2023-04-09 18:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(8, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"2__\",\"4\":\"4__\",\"5\":\"3__\",\"6\":\"3__\",\"7\":\"3__\",\"8\":\"2__\",\"9\":\"4__\"}', 1, '2023-04-10 07:29:00', '2023-04-10 07:59:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(9, 6, 5, 3, 1, '{\"1\":[\"22:55\",\"07:10\",\"08:15\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-04-10 07:59:00', '2023-04-10 08:29:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(10, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"4__\",\"4\":\"5__\",\"5\":\"5__\",\"6\":\"1__\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"1__\"}', 1, '2023-04-11 06:55:00', '2023-04-11 07:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(11, 6, 5, 3, 1, '{\"1\":[\"23:00\",\"06:45\",\"07:45\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-04-11 07:25:00', '2023-04-11 07:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(12, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"3__\",\"4\":\"4__\",\"5\":\"5__\",\"6\":\"1__\",\"7\":\"1__\",\"8\":\"2__\",\"9\":\"1__\"}', 1, '2023-04-12 10:35:00', '2023-04-12 11:05:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(13, 6, 5, 3, 1, '{\"1\":[\"01:22\",\"10:30\",\"09:08\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-04-12 11:05:00', '2023-04-12 11:35:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(14, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"45\",\"3\":\"9__Wirklich sehr hart\",\"4\":\"Schneller 5er\"}', 1, '2023-04-12 14:15:00', '2023-04-12 15:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(15, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"3__\",\"4\":\"5__\",\"5\":\"3__\",\"6\":\"3__\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"4__\"}', 1, '2023-04-13 10:10:00', '2023-04-13 10:40:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(16, 6, 5, 3, 1, '{\"1\":[\"01:05\",\"10:00\",\"08:55\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-04-13 10:40:00', '2023-04-13 11:10:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(17, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"3__\",\"4\":\"4__\",\"5\":\"5__\",\"6\":\"1__\",\"7\":\"1__\",\"8\":\"1__\",\"9\":\"1__\"}', 1, '2023-04-14 09:30:00', '2023-04-14 10:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(18, 6, 5, 3, 1, '{\"1\":[\"00:05\",\"09:30\",\"09:25\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-04-14 10:00:00', '2023-04-14 10:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(19, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"55\",\"3\":\"4__Schon härter\",\"4\":\"9,5 km\"}', 1, '2023-04-14 19:35:00', '2023-04-14 20:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(20, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"2__\",\"4\":\"4__\",\"5\":\"4__\",\"6\":\"3__\",\"7\":\"3__\",\"8\":\"3__\",\"9\":\"3__\"}', 1, '2023-04-15 08:07:00', '2023-04-15 08:37:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(21, 6, 5, 3, 1, '{\"1\":[\"23:15\",\"07:50\",\"08:35\"],\"2\":\"2__\",\"3\":\"\"}', 1, '2023-04-15 08:37:00', '2023-04-15 09:07:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(22, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"2__\",\"4\":\"3__\",\"5\":\"3__\",\"6\":\"2__\",\"7\":\"3__\",\"8\":\"2__\",\"9\":\"2__\"}', 1, '2023-04-16 07:23:00', '2023-04-16 07:53:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(23, 6, 5, 3, 1, '{\"1\":[\"23:20\",\"07:05\",\"07:45\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-04-16 07:53:00', '2023-04-16 08:23:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(24, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"4__\",\"4\":\"4__\",\"5\":\"5__\",\"6\":\"1__\",\"7\":\"2__\",\"8\":\"2__\",\"9\":\"2__\"}', 1, '2023-04-17 08:02:00', '2023-04-17 08:32:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(25, 6, 5, 3, 1, '{\"1\":[\"22:45\",\"07:40\",\"08:55\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-04-17 08:32:00', '2023-04-17 09:02:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(26, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"3__\",\"4\":\"4__\",\"5\":\"5__\",\"6\":\"1__\",\"7\":\"2__\",\"8\":\"2__\",\"9\":\"1__\"}', 1, '2023-04-18 07:00:00', '2023-04-18 07:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(27, 6, 5, 3, 1, '{\"1\":[\"00:00\",\"06:50\",\"06:50\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-04-18 07:30:00', '2023-04-18 08:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(28, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"5__\",\"4\":\"4__\",\"5\":\"6__trifft voll zu\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"1__\",\"9\":\"0__trifft gar nicht zu\"}', 1, '2023-04-19 13:30:00', '2023-04-19 14:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(29, 6, 5, 3, 1, '{\"1\":[\"02:05\",\"13:15\",\"11:10\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-04-19 14:00:00', '2023-04-19 14:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(30, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"2__\",\"4\":\"3__\",\"5\":\"3__\",\"6\":\"1__\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"1__\"}', 1, '2023-04-20 11:10:00', '2023-04-20 11:40:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(31, 6, 5, 3, 1, '{\"1\":[\"03:30\",\"11:10\",\"07:40\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-04-20 11:40:00', '2023-04-20 12:10:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(32, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"120\",\"3\":\"4__Schon härter\",\"4\":\"Beach-Volleyball\"}', 1, '2023-04-20 14:00:00', '2023-04-20 16:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(33, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"3__\",\"4\":\"3__\",\"5\":\"1__\",\"6\":\"5__\",\"7\":\"4__\",\"8\":\"2__\",\"9\":\"5__\"}', 1, '2023-04-21 07:00:00', '2023-04-21 07:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(34, 6, 5, 3, 1, '{\"1\":[\"23:15\",\"06:55\",\"07:40\"],\"2\":\"7__gut\",\"3\":\"\"}', 1, '2023-04-21 07:30:00', '2023-04-21 08:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(35, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"2__\",\"4\":\"4__\",\"5\":\"3__\",\"6\":\"4__\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"4__\"}', 1, '2023-04-22 07:55:00', '2023-04-22 08:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(36, 6, 5, 3, 1, '{\"1\":[\"23:20\",\"07:45\",\"08:25\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-04-22 08:25:00', '2023-04-22 08:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(37, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"2__\",\"4\":\"1__\",\"5\":\"3__\",\"6\":\"2__\",\"7\":\"5__\",\"8\":\"5__\",\"9\":\"4__\"}', 1, '2023-04-23 07:33:00', '2023-04-23 08:03:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(38, 6, 5, 3, 1, '{\"1\":[\"23:40\",\"07:15\",\"07:35\"],\"2\":\"8__\",\"3\":\"\"}', 1, '2023-04-23 08:03:00', '2023-04-23 08:33:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(39, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"6__trifft voll zu\",\"3\":\"6__trifft voll zu\",\"4\":\"5__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"0__trifft gar nicht zu\"}', 1, '2023-04-24 11:20:00', '2023-04-24 11:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(40, 6, 5, 3, 1, '{\"1\":[\"23:20\",\"11:00\",\"11:40\"],\"2\":\"1__sehr schlecht\",\"3\":\"\"}', 1, '2023-04-24 11:50:00', '2023-04-24 12:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(41, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"5__\",\"4\":\"5__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"1__\"}', 1, '2023-04-25 07:39:00', '2023-04-25 08:09:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(42, 6, 5, 3, 1, '{\"1\":[\"23:40\",\"06:45\",\"07:05\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-04-25 08:09:00', '2023-04-25 08:39:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(43, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"1__\",\"4\":\"3__\",\"5\":\"2__\",\"6\":\"1__\",\"7\":\"4__\",\"8\":\"3__\",\"9\":\"5__\"}', 1, '2023-04-26 07:55:00', '2023-04-26 08:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(44, 6, 5, 3, 1, '{\"1\":[\"01:50\",\"07:45\",\"05:55\"],\"2\":\"9__sehr gut\",\"3\":\"\"}', 1, '2023-04-26 08:25:00', '2023-04-26 08:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(45, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"4__\",\"4\":\"5__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"0__trifft gar nicht zu\"}', 1, '2023-04-27 09:38:00', '2023-04-27 10:08:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(46, 6, 5, 3, 1, '{\"1\":[\"23:10\",\"09:30\",\"10:20\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-04-27 10:08:00', '2023-04-27 10:38:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(47, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"3__\",\"4\":\"4__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"3__\",\"8\":\"2__\",\"9\":\"1__\"}', 1, '2023-04-28 07:10:00', '2023-04-28 07:40:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(48, 6, 5, 3, 1, '{\"1\":[\"23:35\",\"07:05\",\"07:30\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-04-28 07:40:00', '2023-04-28 08:10:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(49, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"3__\",\"4\":\"4__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"4__\",\"8\":\"2__\",\"9\":\"1__\"}', 1, '2023-04-29 07:50:00', '2023-04-29 08:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(50, 6, 5, 3, 1, '{\"1\":[\"00:30\",\"07:45\",\"07:15\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-04-29 08:20:00', '2023-04-29 08:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(51, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"2__\",\"4\":\"5__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-04-30 08:25:00', '2023-04-30 08:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(52, 6, 5, 3, 1, '{\"1\":[\"00:45\",\"08:15\",\"07:30\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-04-30 08:55:00', '2023-04-30 09:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(53, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"5__\",\"4\":\"5__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"3__\",\"9\":\"2__\"}', 1, '2023-05-01 07:40:00', '2023-05-01 08:10:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(54, 6, 5, 3, 1, '{\"1\":[\"23:45\",\"07:35\",\"07:50\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-05-01 08:10:00', '2023-05-01 08:40:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(55, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"6__trifft voll zu\",\"3\":\"5__\",\"4\":\"4__\",\"5\":\"6__trifft voll zu\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"2__\",\"9\":\"0__trifft gar nicht zu\"}', 1, '2023-05-02 09:36:00', '2023-05-02 10:06:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(56, 6, 5, 3, 1, '{\"1\":[\"22:35\",\"08:05\",\"09:30\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-05-02 10:06:00', '2023-05-02 10:36:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(57, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"1__\",\"3\":\"0__trifft gar nicht zu\",\"4\":\"1__\",\"5\":\"1__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"6__trifft voll zu\",\"8\":\"4__\",\"9\":\"5__\"}', 1, '2023-05-03 10:05:00', '2023-05-03 10:35:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(58, 6, 5, 3, 1, '{\"1\":[\"23:16\",\"10:00\",\"10:44\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-05-03 10:35:00', '2023-05-03 11:05:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(59, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"2__\",\"4\":\"3__trifft gar nicht zu\",\"5\":\"3__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-05-04 11:10:00', '2023-05-04 11:40:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(60, 6, 5, 3, 1, '{\"1\":[\"00:50\",\"11:10\",\"10:20\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-05-04 11:40:00', '2023-05-04 12:10:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(61, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"5__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-05-05 07:00:00', '2023-05-05 07:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(62, 6, 5, 3, 1, '{\"1\":[\"00:15\",\"06:55\",\"06:40\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-05-05 07:30:00', '2023-05-05 08:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(63, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"3__\",\"4\":\"3__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"2__\",\"9\":\"1__\"}', 1, '2023-05-06 07:50:00', '2023-05-06 08:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(64, 6, 5, 3, 1, '{\"1\":[\"00:15\",\"07:45\",\"07:30\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-05-06 08:20:00', '2023-05-06 08:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(65, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"4__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"0__trifft gar nicht zu\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-05-07 08:12:00', '2023-05-07 08:42:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(66, 6, 5, 3, 1, '{\"1\":[\"22:55\",\"08:05\",\"09:10\"],\"2\":\"1__sehr schlecht\",\"3\":\"\"}', 1, '2023-05-07 08:42:00', '2023-05-07 09:12:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(67, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"4__\",\"4\":\"3__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"1__\"}', 1, '2023-05-08 07:41:00', '2023-05-08 08:11:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(68, 6, 5, 3, 1, '{\"1\":[\"00:20\",\"07:30\",\"07:10\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-05-08 08:11:00', '2023-05-08 08:41:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(69, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"65\",\"3\":\"6__\",\"4\":\"10km im Gonsenheimer Wald\"}', 1, '2023-05-08 18:20:00', '2023-05-08 19:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(70, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"5__\",\"4\":\"6__\",\"5\":\"2__\",\"6\":\"3__\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"4__\"}', 1, '2023-05-09 07:55:00', '2023-05-09 08:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(71, 6, 5, 3, 1, '{\"1\":[\"23:45\",\"07:50\",\"08:05\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-05-09 08:25:00', '2023-05-09 08:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(72, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"5__\",\"4\":\"3__\",\"5\":\"4__\",\"6\":\"1__\",\"7\":\"2__\",\"8\":\"4__\",\"9\":\"1__\"}', 1, '2023-05-10 11:35:00', '2023-05-10 12:05:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(73, 6, 5, 3, 1, '{\"1\":[\"01:40\",\"11:30\",\"09:50\"],\"2\":\"2__\",\"3\":\"\"}', 1, '2023-05-10 12:05:00', '2023-05-10 12:35:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(74, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"4__\",\"4\":\"5__\",\"5\":\"3__\",\"6\":\"1__\",\"7\":\"3__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-05-11 11:05:00', '2023-05-11 11:35:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(75, 6, 5, 3, 1, '{\"1\":[\"01:45\",\"11:00\",\"09:15\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-05-11 11:35:00', '2023-05-11 12:05:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(76, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"3__\",\"4\":\"4__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"3__\",\"8\":\"2__\",\"9\":\"2__\"}', 1, '2023-05-12 08:20:00', '2023-05-12 08:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(77, 6, 5, 3, 1, '{\"1\":[\"23:50\",\"08:15\",\"08:25\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-05-12 08:50:00', '2023-05-12 09:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(78, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"40\",\"3\":\"5__Hart\",\"4\":\"7km laufen im Volkspark\"}', 1, '2023-05-12 19:55:00', '2023-05-12 20:35:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(79, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"1__\",\"4\":\"2__\",\"5\":\"2__\",\"6\":\"3__\",\"7\":\"4__\",\"8\":\"5__\",\"9\":\"4__\"}', 1, '2023-05-13 07:20:00', '2023-05-13 07:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(80, 6, 5, 3, 1, '{\"1\":[\"23:25\",\"07:10\",\"07:45\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-05-13 07:50:00', '2023-05-13 08:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(81, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"3__\",\"4\":\"2__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"3__\",\"8\":\"4__\",\"9\":\"2__\"}', 1, '2023-05-14 08:10:00', '2023-05-14 08:40:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(82, 6, 5, 3, 1, '{\"1\":[\"23:10\",\"08:00\",\"08:50\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-05-14 08:40:00', '2023-05-14 09:10:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(83, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"2__\",\"4\":\"4__\",\"5\":\"4__\",\"6\":\"1__\",\"7\":\"3__\",\"8\":\"2__\",\"9\":\"2__\"}', 1, '2023-05-15 08:15:00', '2023-05-15 08:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(84, 6, 5, 3, 1, '{\"1\":[\"23:25\",\"08:05\",\"08:40\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-05-15 08:45:00', '2023-05-15 09:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(85, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"70\",\"3\":\"3__Moderat\",\"4\":\"10km langsam, mit Martin, Stadionrunde\"}', 1, '2023-05-15 18:15:00', '2023-05-15 19:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(86, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"4__\",\"4\":\"2__\",\"5\":\"3__\",\"6\":\"2__\",\"7\":\"4__\",\"8\":\"4__\",\"9\":\"3__\"}', 1, '2023-05-16 07:45:00', '2023-05-16 08:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(87, 6, 5, 3, 1, '{\"1\":[\"00:35\",\"07:40\",\"07:05\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-05-16 08:15:00', '2023-05-16 08:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(88, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"2__\",\"4\":\"4__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"3__\",\"8\":\"1__\",\"9\":\"5__\"}', 1, '2023-05-17 09:30:00', '2023-05-17 10:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(89, 6, 5, 3, 1, '{\"1\":[\"01:40\",\"09:25\",\"07:45\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-05-17 10:00:00', '2023-05-17 10:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(90, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"5__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"2__\"}', 1, '2023-05-18 10:20:00', '2023-05-18 10:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(91, 6, 5, 3, 1, '{\"1\":[\"00:25\",\"10:10\",\"09:45\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-05-18 10:50:00', '2023-05-18 11:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(92, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"45\",\"3\":\"5__Hart\",\"4\":\"Brückenrunde nach Gefühl, 7,3 km\"}', 1, '2023-05-18 17:50:00', '2023-05-18 18:35:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(93, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"2__\",\"4\":\"4__\",\"5\":\"3__\",\"6\":\"2__\",\"7\":\"3__\",\"8\":\"2__\",\"9\":\"4__\"}', 1, '2023-05-19 11:00:00', '2023-05-19 11:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(94, 6, 5, 3, 1, '{\"1\":[\"01:45\",\"10:50\",\"09:05\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-05-19 11:30:00', '2023-05-19 12:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(95, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"3__\",\"4\":\"4__\",\"5\":\"4__\",\"6\":\"1__\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"1__\"}', 1, '2023-05-20 08:10:00', '2023-05-20 08:40:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(96, 6, 5, 3, 1, '{\"1\":[\"01:10\",\"08:05\",\"06:55\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-05-20 08:40:00', '2023-05-20 09:10:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(97, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"6__trifft voll zu\",\"4\":\"5__trifft gar nicht zu\",\"5\":\"3__\",\"6\":\"1__\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"2__\"}', 1, '2023-05-21 11:20:00', '2023-05-21 11:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(98, 6, 5, 3, 1, '{\"1\":[\"23:50\",\"11:15\",\"11:25\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-05-21 11:50:00', '2023-05-21 12:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(99, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"1__\",\"4\":\"4__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"4__\",\"8\":\"2__\",\"9\":\"2__\"}', 1, '2023-05-22 10:20:00', '2023-05-22 10:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(100, 6, 5, 3, 1, '{\"1\":[\"00:35\",\"10:15\",\"09:40\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-05-22 10:50:00', '2023-05-22 11:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(101, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"3__\",\"4\":\"4__\",\"5\":\"4__\",\"6\":\"1__\",\"7\":\"3__\",\"8\":\"4__\",\"9\":\"1__\"}', 1, '2023-05-23 09:10:00', '2023-05-23 09:40:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(102, 6, 5, 3, 1, '{\"1\":[\"01:05\",\"09:00\",\"07:55\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-05-23 09:40:00', '2023-05-23 10:10:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(103, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"5__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"3__\",\"6\":\"3__\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"4__\"}', 1, '2023-05-24 10:40:00', '2023-05-24 11:10:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(104, 6, 5, 3, 1, '{\"1\":[\"02:12\",\"10:35\",\"08:23\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-05-24 11:10:00', '2023-05-24 11:40:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(105, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"5__\",\"4\":\"5__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-05-25 10:45:00', '2023-05-25 11:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(106, 6, 5, 3, 1, '{\"1\":[\"00:00\",\"10:40\",\"10:40\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-05-25 11:15:00', '2023-05-25 11:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(107, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"3__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"2__\"}', 1, '2023-05-26 10:08:00', '2023-05-26 10:38:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(108, 6, 5, 3, 1, '{\"1\":[\"23:08\",\"09:40\",\"10:32\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-05-26 10:38:00', '2023-05-26 11:08:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(109, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"6__trifft voll zu\",\"3\":\"4__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"2__\"}', 1, '2023-05-27 11:16:00', '2023-05-27 11:46:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(110, 6, 5, 3, 1, '{\"1\":[\"00:25\",\"11:01\",\"10:36\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-05-27 11:46:00', '2023-05-27 12:16:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(111, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"2__\",\"4\":\"2__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"4__\",\"8\":\"3__\",\"9\":\"1__\"}', 1, '2023-05-28 10:05:00', '2023-05-28 10:35:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(112, 6, 5, 3, 1, '{\"1\":[\"00:30\",\"09:55\",\"09:25\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-05-28 10:35:00', '2023-05-28 11:05:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(113, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"4__\",\"4\":\"6__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"1__\",\"9\":\"1__\"}', 1, '2023-05-29 09:55:00', '2023-05-29 10:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(114, 6, 5, 3, 1, '{\"1\":[\"01:05\",\"09:45\",\"08:40\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-05-29 10:25:00', '2023-05-29 10:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(115, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"3__\",\"4\":\"4__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"4__\",\"8\":\"2__\",\"9\":\"3__\"}', 1, '2023-05-30 08:20:00', '2023-05-30 08:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(116, 6, 5, 3, 1, '{\"1\":[\"00:47\",\"08:18\",\"07:31\"],\"2\":\"8__\",\"3\":\"\"}', 1, '2023-05-30 08:50:00', '2023-05-30 09:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(117, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"3__\",\"4\":\"5__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-05-31 08:15:00', '2023-05-31 08:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(118, 6, 5, 3, 1, '{\"1\":[\"00:40\",\"08:10\",\"07:30\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-05-31 08:45:00', '2023-05-31 09:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(119, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"150\",\"3\":\"5__Hart\",\"4\":\"Beachvolleyball\"}', 1, '2023-05-31 16:30:00', '2023-05-31 19:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(120, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"3__\",\"4\":\"5__trifft gar nicht zu\",\"5\":\"1__\",\"6\":\"3__\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"4__\"}', 1, '2023-06-01 11:15:00', '2023-06-01 11:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(121, 6, 5, 3, 1, '{\"1\":[\"03:02\",\"11:10\",\"08:08\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-06-01 11:45:00', '2023-06-01 12:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(122, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"3__\",\"4\":\"5__\",\"5\":\"2__\",\"6\":\"3__\",\"7\":\"4__\",\"8\":\"1__\",\"9\":\"3__\"}', 1, '2023-06-02 08:15:00', '2023-06-02 08:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(123, 6, 5, 3, 1, '{\"1\":[\"00:50\",\"08:05\",\"07:15\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-06-02 08:45:00', '2023-06-02 09:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(124, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"2__\",\"4\":\"3__\",\"5\":\"4__\",\"6\":\"1__\",\"7\":\"4__\",\"8\":\"2__\",\"9\":\"3__\"}', 1, '2023-06-03 06:55:00', '2023-06-03 07:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(125, 6, 5, 3, 1, '{\"1\":[\"22:55\",\"06:45\",\"07:50\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-06-03 07:25:00', '2023-06-03 07:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(126, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"3__\",\"4\":\"5__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"4__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-06-04 08:50:00', '2023-06-04 09:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(127, 6, 5, 3, 1, '{\"1\":[\"01:30\",\"08:45\",\"07:15\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-06-04 09:20:00', '2023-06-04 09:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(128, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"4__\",\"4\":\"5__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-06-05 08:20:00', '2023-06-05 08:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(129, 6, 5, 3, 1, '{\"1\":[\"23:00\",\"08:05\",\"09:05\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-06-05 08:50:00', '2023-06-05 09:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(130, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"5__\",\"4\":\"6__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"1__\",\"9\":\"1__\"}', 1, '2023-06-06 08:45:00', '2023-06-06 09:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(131, 6, 5, 3, 1, '{\"1\":[\"23:35\",\"08:30\",\"08:55\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-06-06 09:15:00', '2023-06-06 09:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(132, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"4__\",\"4\":\"5__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-06-07 08:50:00', '2023-06-07 09:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(133, 6, 5, 3, 1, '{\"1\":[\"23:35\",\"08:40\",\"09:05\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-06-07 09:20:00', '2023-06-07 09:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(134, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"150\",\"3\":\"2__Leicht\",\"4\":\"Fahrradtour nach Oppenheim\"}', 1, '2023-06-07 15:00:00', '2023-06-07 17:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(135, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"2__\",\"4\":\"4__\",\"5\":\"2__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"3__\",\"8\":\"1__\",\"9\":\"4__\"}', 1, '2023-06-08 10:50:00', '2023-06-08 11:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(136, 6, 5, 3, 1, '{\"1\":[\"03:25\",\"10:40\",\"07:15\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-06-08 11:20:00', '2023-06-08 11:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(137, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"2__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"3__\"}', 1, '2023-06-09 06:50:00', '2023-06-09 07:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(138, 6, 5, 3, 1, '{\"1\":[\"23:50\",\"06:40\",\"06:50\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-06-09 07:20:00', '2023-06-09 07:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(139, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"5__\",\"4\":\"4__\",\"5\":\"3__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-06-10 06:55:00', '2023-06-10 07:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(140, 6, 5, 3, 1, '{\"1\":[\"23:55\",\"06:50\",\"06:55\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-06-10 07:25:00', '2023-06-10 07:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(141, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"4__\",\"4\":\"4__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"3__\",\"9\":\"1__\"}', 1, '2023-06-11 09:20:00', '2023-06-11 09:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(142, 6, 5, 3, 1, '{\"1\":[\"23:00\",\"09:10\",\"10:10\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-06-11 09:50:00', '2023-06-11 10:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(143, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"5__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-06-12 08:25:00', '2023-06-12 08:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(144, 6, 5, 3, 1, '{\"1\":[\"23:05\",\"08:20\",\"09:15\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-06-12 08:55:00', '2023-06-12 09:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(145, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"65\",\"3\":\"4__Schon härter\",\"4\":\"10km Stadionrunde, sehr warm, über 30 Grad\"}', 1, '2023-06-12 17:45:00', '2023-06-12 18:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(146, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"5__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"2__\",\"6\":\"4__\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"4__\"}', 1, '2023-06-13 08:55:00', '2023-06-13 09:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(147, 6, 5, 3, 1, '{\"1\":[\"23:20\",\"08:35\",\"09:15\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-06-13 09:25:00', '2023-06-13 09:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(148, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"2__\",\"4\":\"5__\",\"5\":\"2__\",\"6\":\"2__\",\"7\":\"1__\",\"8\":\"1__\",\"9\":\"4__\"}', 1, '2023-06-14 10:45:00', '2023-06-14 11:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(149, 6, 5, 3, 1, '{\"1\":[\"01:45\",\"10:35\",\"08:50\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-06-14 11:15:00', '2023-06-14 11:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(150, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"4__\",\"4\":\"5__\",\"5\":\"3__\",\"6\":\"2__\",\"7\":\"1__\",\"8\":\"1__\",\"9\":\"3__\"}', 1, '2023-06-15 08:25:00', '2023-06-15 08:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(151, 6, 5, 3, 1, '{\"1\":[\"00:20\",\"08:15\",\"07:55\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-06-15 08:55:00', '2023-06-15 09:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(152, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"5__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"1__\",\"7\":\"0__trifft gar nicht zu\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-06-16 08:40:00', '2023-06-16 09:10:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(153, 6, 5, 3, 1, '{\"1\":[\"23:35\",\"08:20\",\"08:45\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-06-16 09:10:00', '2023-06-16 09:40:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(154, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"5__\",\"4\":\"5__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"1__\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-06-17 08:45:00', '2023-06-17 09:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(155, 6, 5, 3, 1, '{\"1\":[\"00:25\",\"08:35\",\"08:10\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-06-17 09:15:00', '2023-06-17 09:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(156, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"4__\",\"4\":\"6__\",\"5\":\"6__trifft voll zu\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"1__\",\"9\":\"1__\"}', 1, '2023-06-18 08:50:00', '2023-06-18 09:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(157, 6, 5, 3, 1, '{\"1\":[\"23:30\",\"08:40\",\"09:10\"],\"2\":\"2__\",\"3\":\"\"}', 1, '2023-06-18 09:20:00', '2023-06-18 09:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(158, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"45\",\"3\":\"5__Hart\",\"4\":\"7km Volkspark, steigernde Geschwindigkeit\"}', 1, '2023-06-18 19:30:00', '2023-06-18 20:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(159, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"5__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"3__\",\"6\":\"2__\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"3__\"}', 1, '2023-06-19 07:55:00', '2023-06-19 08:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(160, 6, 5, 3, 1, '{\"1\":[\"23:35\",\"08:45\",\"09:10\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-06-19 08:25:00', '2023-06-19 08:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(161, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"4__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"1__\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"2__\"}', 1, '2023-06-20 07:35:00', '2023-06-20 08:05:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(162, 6, 5, 3, 1, '{\"1\":[\"23:40\",\"07:25\",\"07:45\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-06-20 08:05:00', '2023-06-20 08:35:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(163, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"5__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-06-21 08:55:00', '2023-06-21 09:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(164, 6, 5, 3, 1, '{\"1\":[\"00:30\",\"08:45\",\"08:15\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-06-21 09:25:00', '2023-06-21 09:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(165, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"265\",\"3\":\"3__Moderat\",\"4\":\"Fahrradtour nach Bad Sobernheim (60km) mit einigen Stopps\"}', 1, '2023-06-21 12:30:00', '2023-06-21 16:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(166, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"4__\",\"4\":\"5__trifft gar nicht zu\",\"5\":\"3__\",\"6\":\"1__\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"3__\"}', 1, '2023-06-22 10:15:00', '2023-06-22 10:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(167, 6, 5, 3, 1, '{\"1\":[\"01:30\",\"10:10\",\"08:40\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-06-22 10:45:00', '2023-06-22 11:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(168, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"3__\",\"4\":\"4__trifft gar nicht zu\",\"5\":\"4__\",\"6\":\"1__\",\"7\":\"2__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-06-23 07:45:00', '2023-06-23 08:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(169, 6, 5, 3, 1, '{\"1\":[\"00:15\",\"07:35\",\"07:20\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-06-23 08:15:00', '2023-06-23 08:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(170, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"5__\",\"4\":\"4__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"2__\",\"9\":\"1__\"}', 1, '2023-06-24 07:45:00', '2023-06-24 08:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(171, 6, 5, 3, 1, '{\"1\":[\"00:50\",\"07:35\",\"06:45\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-06-24 08:15:00', '2023-06-24 08:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(172, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"120\",\"3\":\"4__Schon härter\",\"4\":\"Volleyballtraining Bleidenstadt, ohne Springen, Beginn Vorbereitung\"}', 1, '2023-06-24 20:00:00', '2023-06-24 22:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(173, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"4__\",\"4\":\"5__trifft gar nicht zu\",\"5\":\"2__\",\"6\":\"3__\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"4__\"}', 1, '2023-06-25 08:40:00', '2023-06-25 09:10:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(174, 6, 5, 3, 1, '{\"1\":[\"00:25\",\"08:30\",\"08:05\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-06-25 09:10:00', '2023-06-25 09:40:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(175, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"4__\",\"4\":\"4__\",\"5\":\"3__\",\"6\":\"2__\",\"7\":\"3__\",\"8\":\"1__\",\"9\":\"3__\"}', 1, '2023-06-26 08:15:00', '2023-06-26 08:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(176, 6, 5, 3, 1, '{\"1\":[\"01:30\",\"08:05\",\"06:35\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-06-26 08:45:00', '2023-06-26 09:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(177, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"2__\",\"4\":\"1__\",\"5\":\"0__trifft gar nicht zu\",\"6\":\"2__\",\"7\":\"2__\",\"8\":\"3__\",\"9\":\"6__trifft voll zu\"}', 1, '2023-06-27 07:35:00', '2023-06-27 08:05:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(178, 6, 5, 3, 1, '{\"1\":[\"00:55\",\"07:25\",\"06:30\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-06-27 08:05:00', '2023-06-27 08:35:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(179, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"5__\",\"4\":\"5__\",\"5\":\"2__\",\"6\":\"4__\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"3__\"}', 1, '2023-06-28 09:30:00', '2023-06-28 10:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(180, 6, 5, 3, 1, '{\"1\":[\"00:00\",\"09:10\",\"09:10\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-06-28 10:00:00', '2023-06-28 10:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(181, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"2__\",\"4\":\"4__\",\"5\":\"2__\",\"6\":\"2__\",\"7\":\"3__\",\"8\":\"2__\",\"9\":\"3__\"}', 1, '2023-06-29 09:15:00', '2023-06-29 09:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(182, 6, 5, 3, 1, '{\"1\":[\"01:55\",\"09:10\",\"07:15\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-06-29 09:45:00', '2023-06-29 10:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(183, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"3__\",\"4\":\"4__\",\"5\":\"2__\",\"6\":\"4__\",\"7\":\"4__\",\"8\":\"2__\",\"9\":\"3__\"}', 1, '2023-06-30 08:20:00', '2023-06-30 08:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(184, 6, 5, 3, 1, '{\"1\":[\"23:40\",\"08:10\",\"08:30\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-06-30 08:50:00', '2023-06-30 09:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(185, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"4__\",\"4\":\"5__\",\"5\":\"3__\",\"6\":\"2__\",\"7\":\"1__\",\"8\":\"1__\",\"9\":\"3__\"}', 1, '2023-07-01 07:10:00', '2023-07-01 07:40:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(186, 6, 5, 3, 1, '{\"1\":[\"23:05\",\"07:00\",\"07:55\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-07-01 07:40:00', '2023-07-01 08:10:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(187, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"75\",\"3\":\"3__Moderat\",\"4\":\"DIenstagskick, noch mit Schulterbescherden gespielt, eher ruhiger\"}', 1, '2023-07-01 19:25:00', '2023-07-01 20:40:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(188, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"4__\",\"4\":\"5__trifft gar nicht zu\",\"5\":\"2__\",\"6\":\"4__\",\"7\":\"2__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"4__\"}', 1, '2023-07-02 07:20:00', '2023-07-02 07:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(189, 6, 5, 3, 1, '{\"1\":[\"00:45\",\"07:10\",\"06:25\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-07-02 07:50:00', '2023-07-02 08:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(190, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"3__\",\"4\":\"4__\",\"5\":\"3__\",\"6\":\"1__\",\"7\":\"4__\",\"8\":\"1__\",\"9\":\"3__\"}', 1, '2023-07-03 08:30:00', '2023-07-03 09:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(191, 6, 5, 3, 1, '{\"1\":[\"01:45\",\"08:20\",\"06:35\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-07-03 09:00:00', '2023-07-03 09:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(192, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"4__\",\"4\":\"5__\",\"5\":\"3__\",\"6\":\"2__\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-07-04 06:55:00', '2023-07-04 07:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(193, 6, 5, 3, 1, '{\"1\":[\"22:50\",\"06:45\",\"07:55\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-07-04 07:25:00', '2023-07-04 07:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(194, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"2__\",\"4\":\"2__\",\"5\":\"4__\",\"6\":\"1__\",\"7\":\"5__\",\"8\":\"4__\",\"9\":\"2__\"}', 1, '2023-07-05 09:00:00', '2023-07-05 09:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(195, 6, 5, 3, 1, '{\"1\":[\"00:45\",\"08:45\",\"08:00\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-07-05 09:30:00', '2023-07-05 10:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(196, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"3__\",\"4\":\"5__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-07-06 10:45:00', '2023-07-06 11:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(197, 6, 5, 3, 1, '{\"1\":[\"00:50\",\"10:30\",\"09:40\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-07-06 11:15:00', '2023-07-06 11:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(198, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"5__\",\"4\":\"4__\",\"5\":\"4__\",\"6\":\"1__\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"1__\"}', 1, '2023-07-07 07:35:00', '2023-07-07 08:05:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(199, 6, 5, 3, 1, '{\"1\":[\"23:55\",\"07:25\",\"07:30\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-07-07 08:05:00', '2023-07-07 08:35:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(200, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"3__\",\"4\":\"4__\",\"5\":\"3__\",\"6\":\"1__\",\"7\":\"3__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-07-08 06:55:00', '2023-07-08 07:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(201, 6, 5, 3, 1, '{\"1\":[\"23:35\",\"06:45\",\"07:10\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-07-08 07:25:00', '2023-07-08 07:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(202, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"65\",\"3\":\"5__Hart\",\"4\":\"10km Stadionrunde, anstrengend\"}', 1, '2023-07-08 19:15:00', '2023-07-08 20:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(203, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"3__\",\"4\":\"4__\",\"5\":\"2__\",\"6\":\"3__\",\"7\":\"4__\",\"8\":\"1__\",\"9\":\"4__\"}', 1, '2023-07-09 07:15:00', '2023-07-09 07:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(204, 6, 5, 3, 1, '{\"1\":[\"22:45\",\"07:05\",\"08:20\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-07-09 07:45:00', '2023-07-09 08:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(205, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"4__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"1__\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-07-10 07:45:00', '2023-07-10 08:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(206, 6, 5, 3, 1, '{\"1\":[\"22:45\",\"07:35\",\"08:50\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-07-10 08:15:00', '2023-07-10 08:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(207, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"5__\",\"4\":\"5__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-07-11 08:15:00', '2023-07-11 08:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(208, 6, 5, 3, 1, '{\"1\":[\"22:45\",\"08:05\",\"09:20\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-07-11 08:45:00', '2023-07-11 09:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(209, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"2__\",\"4\":\"2__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"5__\",\"8\":\"4__\",\"9\":\"1__\"}', 1, '2023-07-12 09:50:00', '2023-07-12 10:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(210, 6, 5, 3, 1, '{\"1\":[\"00:05\",\"09:30\",\"09:25\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-07-12 10:20:00', '2023-07-12 10:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(211, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"40\",\"3\":\"9__Wirklich sehr hart\",\"4\":\"Schneller 5km Lauf im 5min/km Schnitt\"}', 1, '2023-07-12 10:30:00', '2023-07-12 11:10:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(212, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"5__\",\"4\":\"4__trifft gar nicht zu\",\"5\":\"3__\",\"6\":\"1__\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"2__\"}', 1, '2023-07-13 09:55:00', '2023-07-13 10:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(213, 6, 5, 3, 1, '{\"1\":[\"02:20\",\"09:40\",\"07:20\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-07-13 10:25:00', '2023-07-13 10:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(214, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"4__\",\"4\":\"4__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-07-14 07:45:00', '2023-07-14 08:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(215, 6, 5, 3, 1, '{\"1\":[\"22:10\",\"07:30\",\"09:20\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-07-14 08:15:00', '2023-07-14 08:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(216, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"5__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-07-15 08:20:00', '2023-07-15 08:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(217, 6, 5, 3, 1, '{\"1\":[\"22:45\",\"08:00\",\"09:15\"],\"2\":\"1__sehr schlecht\",\"3\":\"\"}', 1, '2023-07-15 08:50:00', '2023-07-15 09:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(218, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"4__\",\"4\":\"5__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-07-16 08:10:00', '2023-07-16 08:40:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(219, 6, 5, 3, 1, '{\"1\":[\"23:15\",\"08:00\",\"08:45\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-07-16 08:40:00', '2023-07-16 09:10:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(220, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"6__trifft voll zu\",\"4\":\"5__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"0__trifft gar nicht zu\",\"8\":\"1__\",\"9\":\"1__\"}', 1, '2023-07-17 08:25:00', '2023-07-17 08:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(221, 6, 5, 3, 1, '{\"1\":[\"00:20\",\"08:20\",\"08:00\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-07-17 08:55:00', '2023-07-17 09:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(222, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"45\",\"3\":\"2__Leicht\",\"4\":\"Langsamer 7km Lauf, Volkspark\"}', 1, '2023-07-17 20:15:00', '2023-07-17 21:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(223, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"5__\",\"4\":\"5__trifft gar nicht zu\",\"5\":\"3__\",\"6\":\"2__\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"3__\"}', 1, '2023-07-18 06:50:00', '2023-07-18 07:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(224, 6, 5, 3, 1, '{\"1\":[\"01:13\",\"06:40\",\"05:27\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-07-18 07:20:00', '2023-07-18 07:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(225, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"4__\",\"4\":\"5__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"3__\",\"8\":\"1__\",\"9\":\"3__\"}', 1, '2023-07-19 11:50:00', '2023-07-19 12:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(226, 6, 5, 3, 1, '{\"1\":[\"03:03\",\"11:45\",\"08:42\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-07-19 12:20:00', '2023-07-19 12:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(227, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"4__\",\"4\":\"4__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"1__\"}', 1, '2023-07-20 09:25:00', '2023-07-20 09:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(228, 6, 5, 3, 1, '{\"1\":[\"01:20\",\"09:15\",\"07:55\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-07-20 09:55:00', '2023-07-20 10:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(229, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"4__\",\"4\":\"4__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-07-21 08:00:00', '2023-07-21 08:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(230, 6, 5, 3, 1, '{\"1\":[\"00:30\",\"07:55\",\"07:25\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-07-21 08:30:00', '2023-07-21 09:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(231, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"100\",\"3\":\"5__Hart\",\"4\":\"Fußball in Drais + Fahrrad Hin- und Rückfahrt je 8 km\"}', 1, '2023-07-21 20:15:00', '2023-07-21 21:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(232, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"4__\",\"4\":\"2__\",\"5\":\"1__\",\"6\":\"4__\",\"7\":\"3__\",\"8\":\"4__\",\"9\":\"5__\"}', 1, '2023-07-22 06:55:00', '2023-07-22 07:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(233, 6, 5, 3, 1, '{\"1\":[\"23:40\",\"06:45\",\"07:05\"],\"2\":\"8__\",\"3\":\"\"}', 1, '2023-07-22 07:25:00', '2023-07-22 07:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(234, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"4__\",\"4\":\"4__\",\"5\":\"1__\",\"6\":\"5__\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"5__\"}', 1, '2023-07-23 08:25:00', '2023-07-23 08:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(235, 6, 5, 3, 1, '{\"1\":[\"23:45\",\"08:15\",\"08:30\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-07-23 08:55:00', '2023-07-23 09:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(236, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"4__\",\"4\":\"5__trifft gar nicht zu\",\"5\":\"4__\",\"6\":\"2__\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"2__\"}', 1, '2023-07-24 06:50:00', '2023-07-24 07:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(237, 6, 5, 3, 1, '{\"1\":[\"23:35\",\"06:45\",\"07:10\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-07-24 07:20:00', '2023-07-24 07:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(238, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"3__\",\"4\":\"5__trifft gar nicht zu\",\"5\":\"4__\",\"6\":\"1__\",\"7\":\"2__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-07-25 10:05:00', '2023-07-25 10:35:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(239, 6, 5, 3, 1, '{\"1\":[\"02:05\",\"10:00\",\"07:55\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-07-25 10:35:00', '2023-07-25 11:05:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(240, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"3__\",\"4\":\"4__\",\"5\":\"3__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"4__\",\"8\":\"1__\",\"9\":\"3__\"}', 1, '2023-07-26 11:00:00', '2023-07-26 11:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(241, 6, 5, 3, 1, '{\"1\":[\"02:05\",\"10:45\",\"08:40\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-07-26 11:30:00', '2023-07-26 12:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(242, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"5__\",\"4\":\"5__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-07-27 09:00:00', '2023-07-27 09:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(243, 6, 5, 3, 1, '{\"1\":[\"00:35\",\"08:55\",\"08:20\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-07-27 09:30:00', '2023-07-27 10:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(244, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"5__\",\"4\":\"4__\",\"5\":\"4__\",\"6\":\"2__\",\"7\":\"3__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-07-28 07:45:00', '2023-07-28 08:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(245, 6, 5, 3, 1, '{\"1\":[\"00:30\",\"07:40\",\"07:10\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-07-28 08:15:00', '2023-07-28 08:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(246, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"100\",\"3\":\"7__Sehr hart\",\"4\":\"Fußball in Drais\"}', 1, '2023-07-28 20:20:00', '2023-07-28 22:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(247, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"4__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"2__\",\"6\":\"4__\",\"7\":\"2__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"5__\"}', 1, '2023-07-29 08:05:00', '2023-07-29 08:35:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(248, 6, 5, 3, 1, '{\"1\":[\"23:45\",\"08:00\",\"08:15\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-07-29 08:35:00', '2023-07-29 09:05:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(249, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"5__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"4__\",\"6\":\"1__\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"2__\"}', 1, '2023-07-30 08:25:00', '2023-07-30 08:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(250, 6, 5, 3, 1, '{\"1\":[\"23:40\",\"08:20\",\"08:40\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-07-30 08:55:00', '2023-07-30 09:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(251, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"4__\",\"4\":\"5__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"1__\",\"7\":\"2__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-07-31 07:45:00', '2023-07-31 08:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(252, 6, 5, 3, 1, '{\"1\":[\"23:15\",\"07:35\",\"08:20\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-07-31 08:15:00', '2023-07-31 08:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(253, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"45\",\"3\":\"3__Moderat\",\"4\":\"7km Volkspark entspannt\"}', 1, '2023-07-31 18:45:00', '2023-07-31 19:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(254, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"2__\",\"4\":\"4__\",\"5\":\"3__\",\"6\":\"3__\",\"7\":\"3__\",\"8\":\"2__\",\"9\":\"4__\"}', 1, '2023-08-01 08:30:00', '2023-08-01 09:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(255, 6, 5, 3, 1, '{\"1\":[\"23:20\",\"07:50\",\"08:30\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-08-01 09:00:00', '2023-08-01 09:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(256, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"6__trifft voll zu\",\"3\":\"5__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"6__trifft voll zu\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-08-02 10:00:00', '2023-08-02 10:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(257, 6, 5, 3, 1, '{\"1\":[\"00:45\",\"09:45\",\"09:00\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-08-02 10:30:00', '2023-08-02 11:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(258, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"5__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-08-03 10:40:00', '2023-08-03 11:10:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(259, 6, 5, 3, 1, '{\"1\":[\"02:25\",\"10:40\",\"08:15\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-08-03 11:10:00', '2023-08-03 11:40:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(260, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"5__\",\"4\":\"5__trifft gar nicht zu\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"2__\"}', 1, '2023-08-04 07:20:00', '2023-08-04 07:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(261, 6, 5, 3, 1, '{\"1\":[\"00:50\",\"07:15\",\"06:25\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-08-04 07:50:00', '2023-08-04 08:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(262, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"100\",\"3\":\"7__Sehr hart\",\"4\":\"Fußball in Drais, wenig gegessen vorher\"}', 1, '2023-08-04 20:20:00', '2023-08-04 22:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(263, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"5__\",\"4\":\"5__trifft gar nicht zu\",\"5\":\"2__\",\"6\":\"4__\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"5__\"}', 1, '2023-08-05 06:55:00', '2023-08-05 07:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(264, 6, 5, 3, 1, '{\"1\":[\"00:30\",\"06:45\",\"06:15\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-08-05 07:25:00', '2023-08-05 07:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(265, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"4__\",\"4\":\"5__trifft gar nicht zu\",\"5\":\"4__\",\"6\":\"2__\",\"7\":\"0__trifft gar nicht zu\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"3__\"}', 1, '2023-08-06 08:03:00', '2023-08-06 08:33:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(266, 6, 5, 3, 1, '{\"1\":[\"23:25\",\"07:50\",\"08:25\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-08-06 08:33:00', '2023-08-06 09:03:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(267, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"2__\",\"4\":\"4__\",\"5\":\"4__\",\"6\":\"1__\",\"7\":\"4__\",\"8\":\"2__\",\"9\":\"2__\"}', 1, '2023-08-07 07:19:00', '2023-08-07 07:49:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(268, 6, 5, 3, 1, '{\"1\":[\"23:45\",\"07:10\",\"07:25\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-08-07 07:49:00', '2023-08-07 08:19:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(269, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"2__\",\"4\":\"5__\",\"5\":\"3__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"3__\",\"8\":\"1__\",\"9\":\"3__\"}', 1, '2023-08-08 07:45:00', '2023-08-08 08:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(270, 6, 5, 3, 1, '{\"1\":[\"00:35\",\"07:35\",\"07:00\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-08-08 08:15:00', '2023-08-08 08:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(271, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"5__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-08-09 10:00:00', '2023-08-09 10:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(272, 6, 5, 3, 1, '{\"1\":[\"00:10\",\"09:55\",\"09:45\"],\"2\":\"2__\",\"3\":\"\"}', 1, '2023-08-09 10:30:00', '2023-08-09 11:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(273, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"4__\",\"4\":\"3__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"2__\",\"9\":\"2__\"}', 1, '2023-08-10 09:45:00', '2023-08-10 10:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(274, 6, 5, 3, 1, '{\"1\":[\"01:25\",\"09:35\",\"08:10\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-08-10 10:15:00', '2023-08-10 10:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(275, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"3__\",\"4\":\"4__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"4__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-08-11 07:52:00', '2023-08-11 08:22:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(276, 6, 5, 3, 1, '{\"1\":[\"00:25\",\"07:30\",\"07:05\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-08-11 08:22:00', '2023-08-11 08:52:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(277, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"3__\",\"4\":\"2__\",\"5\":\"3__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"4__\",\"8\":\"3__\",\"9\":\"3__\"}', 1, '2023-08-12 07:00:00', '2023-08-12 07:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(278, 6, 5, 3, 1, '{\"1\":[\"22:55\",\"06:50\",\"07:55\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-08-12 07:30:00', '2023-08-12 08:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(279, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"4__\",\"4\":\"5__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"1__\"}', 1, '2023-08-13 08:05:00', '2023-08-13 08:35:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(280, 6, 5, 3, 1, '{\"1\":[\"23:30\",\"07:55\",\"08:25\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-08-13 08:35:00', '2023-08-13 09:05:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(281, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"3__\",\"4\":\"3__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"3__\",\"8\":\"2__\",\"9\":\"2__\"}', 1, '2023-08-14 08:20:00', '2023-08-14 08:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(282, 6, 5, 3, 1, '{\"1\":[\"23:00\",\"08:10\",\"09:10\"],\"2\":\"3__schlecht\",\"3\":\"\"}', 1, '2023-08-14 08:50:00', '2023-08-14 09:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(283, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"3__\",\"4\":\"3__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"3__\",\"9\":\"2__\"}', 1, '2023-08-15 06:55:00', '2023-08-15 07:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(284, 6, 5, 3, 1, '{\"1\":[\"23:10\",\"06:50\",\"07:40\"],\"2\":\"7__gut\",\"3\":\"\"}', 1, '2023-08-15 07:25:00', '2023-08-15 07:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(285, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"45\",\"3\":\"4__Schon härter\",\"4\":\"7km, erst langsam, dann 3 km schneller\"}', 1, '2023-08-15 20:00:00', '2023-08-15 20:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(286, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"3__\",\"4\":\"4__\",\"5\":\"5__\",\"6\":\"1__\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-08-16 07:05:00', '2023-08-16 07:35:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(287, 6, 5, 3, 1, '{\"1\":[\"00:15\",\"07:00\",\"06:45\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-08-16 07:35:00', '2023-08-16 08:05:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(288, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"4__\",\"4\":\"5__\",\"5\":\"3__\",\"6\":\"1__\",\"7\":\"1__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-08-17 10:10:00', '2023-08-17 10:40:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(289, 6, 5, 3, 1, '{\"1\":[\"00:35\",\"10:00\",\"09:25\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-08-17 10:40:00', '2023-08-17 11:10:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(290, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"4__\",\"4\":\"3__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"3__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-08-18 07:40:00', '2023-08-18 08:10:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(291, 6, 5, 3, 1, '{\"1\":[\"00:40\",\"07:30\",\"06:50\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-08-18 08:10:00', '2023-08-18 08:40:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(292, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"60\",\"3\":\"4__Schon härter\",\"4\":\"Fußball in Drais, 4vs4 auf halbem Halbfeld, kurz wegen Verletzung von anderem Spieler\"}', 1, '2023-08-18 20:30:00', '2023-08-18 21:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(293, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"3__\",\"4\":\"4__\",\"5\":\"3__\",\"6\":\"2__\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-08-19 08:15:00', '2023-08-19 08:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(294, 6, 5, 3, 1, '{\"1\":[\"23:30\",\"08:05\",\"08:35\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-08-19 08:45:00', '2023-08-19 09:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(295, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"4__\",\"4\":\"5__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"1__\"}', 1, '2023-08-20 08:10:00', '2023-08-20 08:40:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(296, 6, 5, 3, 1, '{\"1\":[\"23:50\",\"08:00\",\"08:10\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-08-20 08:40:00', '2023-08-20 09:10:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(297, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"4__\",\"4\":\"5__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"1__\",\"9\":\"1__\"}', 1, '2023-08-21 07:00:00', '2023-08-21 07:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(298, 6, 5, 3, 1, '{\"1\":[\"00:10\",\"06:50\",\"06:40\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-08-21 07:30:00', '2023-08-21 08:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(299, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"5__\",\"4\":\"2__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"4__\",\"8\":\"4__\",\"9\":\"1__\"}', 1, '2023-08-22 07:10:00', '2023-08-22 07:40:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(300, 6, 5, 3, 1, '{\"1\":[\"23:30\",\"07:00\",\"07:30\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-08-22 07:40:00', '2023-08-22 08:10:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(301, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"3__\",\"4\":\"3__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"4__\",\"8\":\"2__\",\"9\":\"2__\"}', 1, '2023-08-23 11:00:00', '2023-08-23 11:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(302, 6, 5, 3, 1, '{\"1\":[\"01:50\",\"10:50\",\"09:00\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-08-23 11:30:00', '2023-08-23 12:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(303, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"75\",\"3\":\"3__Moderat\",\"4\":\"10km Stadionrunde mit Martin\"}', 1, '2023-08-23 17:15:00', '2023-08-23 18:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(304, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"5__\",\"4\":\"5__\",\"5\":\"4__\",\"6\":\"1__\",\"7\":\"1__\",\"8\":\"2__\",\"9\":\"2__\"}', 1, '2023-08-24 08:55:00', '2023-08-24 09:25:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(305, 6, 5, 3, 1, '{\"1\":[\"00:50\",\"08:45\",\"07:55\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-08-24 09:25:00', '2023-08-24 09:55:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(306, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"4__\",\"4\":\"5__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-08-25 09:00:00', '2023-08-25 09:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(307, 6, 5, 3, 1, '{\"1\":[\"01:05\",\"08:55\",\"07:50\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-08-25 09:30:00', '2023-08-25 10:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(308, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"4__\",\"4\":\"5__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-08-26 09:45:00', '2023-08-26 10:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(309, 6, 5, 3, 1, '{\"1\":[\"02:25\",\"09:35\",\"07:10\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-08-26 10:15:00', '2023-08-26 10:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(310, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"4__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-08-27 11:00:00', '2023-08-27 11:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(311, 6, 5, 3, 1, '{\"1\":[\"23:55\",\"10:50\",\"10:55\"],\"2\":\"2__\",\"3\":\"\"}', 1, '2023-08-27 11:30:00', '2023-08-27 12:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(312, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"5__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"6__trifft voll zu\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"0__trifft gar nicht zu\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-08-30 13:00:00', '2023-08-30 13:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(313, 6, 5, 3, 1, '{\"1\":[\"01:55\",\"12:50\",\"10:55\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-08-30 13:30:00', '2023-08-30 14:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(314, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"3__\",\"4\":\"4__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-08-31 09:07:00', '2023-08-31 09:37:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(315, 6, 5, 3, 1, '{\"1\":[\"01:15\",\"08:55\",\"07:40\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-08-31 09:38:00', '2023-08-31 10:08:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(316, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"4__\",\"4\":\"6__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"0__trifft gar nicht zu\",\"8\":\"2__\",\"9\":\"1__\"}', 1, '2023-09-01 11:07:00', '2023-09-01 11:37:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(317, 6, 5, 3, 1, '{\"1\":[\"01:30\",\"10:20\",\"08:50\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-09-01 11:37:00', '2023-09-01 12:07:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(318, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"3__\",\"4\":\"2__\",\"5\":\"3__\",\"6\":\"1__\",\"7\":\"3__\",\"8\":\"4__\",\"9\":\"3__\"}', 1, '2023-09-02 09:50:00', '2023-09-02 10:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(319, 6, 5, 3, 1, '{\"1\":[\"01:30\",\"09:35\",\"08:05\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-09-02 10:20:00', '2023-09-02 10:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(320, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"4__\",\"4\":\"4__\",\"5\":\"4__\",\"6\":\"1__\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-09-03 08:30:00', '2023-09-03 09:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(321, 6, 5, 3, 1, '{\"1\":[\"01:30\",\"08:25\",\"06:55\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-09-03 09:00:00', '2023-09-03 09:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(322, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"4__\",\"4\":\"3__\",\"5\":\"3__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"4__\",\"8\":\"2__\",\"9\":\"3__\"}', 1, '2023-09-04 08:20:00', '2023-09-04 08:50:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(323, 6, 5, 3, 1, '{\"1\":[\"00:50\",\"08:15\",\"07:25\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-09-04 08:50:00', '2023-09-04 09:20:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(324, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"4__\",\"4\":\"3__\",\"5\":\"4__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"1__\"}', 1, '2023-09-05 09:00:00', '2023-09-05 09:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(325, 6, 5, 3, 1, '{\"1\":[\"01:05\",\"08:55\",\"07:50\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-09-05 09:30:00', '2023-09-05 10:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(326, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"2__\",\"3\":\"2__\",\"4\":\"4__\",\"5\":\"2__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"3__\",\"8\":\"1__\",\"9\":\"4__\"}', 1, '2023-09-06 08:45:00', '2023-09-06 09:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(327, 6, 5, 3, 1, '{\"1\":[\"02:50\",\"08:40\",\"05:50\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-09-06 09:15:00', '2023-09-06 09:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(328, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"5__\",\"4\":\"6__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"0__trifft gar nicht zu\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-09-07 11:30:00', '2023-09-07 12:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(329, 6, 5, 3, 1, '{\"1\":[\"02:35\",\"11:20\",\"08:45\"],\"2\":\"2__\",\"3\":\"\"}', 1, '2023-09-07 12:00:00', '2023-09-07 12:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(330, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"5__\",\"4\":\"5__\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"1__\",\"9\":\"1__\"}', 1, '2023-09-08 07:15:00', '2023-09-08 07:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(331, 6, 5, 3, 1, '{\"1\":[\"23:10\",\"07:05\",\"07:55\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-09-08 07:45:00', '2023-09-08 08:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(332, 6, 6, 4, 1, '{\"1\":\"1__Training\",\"2\":\"90\",\"3\":\"4__Schon härter\",\"4\":\"Fußball in Drais\"}', 1, '2023-09-08 20:15:00', '2023-09-08 21:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(333, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"3__\",\"4\":\"4__\",\"5\":\"3__\",\"6\":\"2__\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"3__\"}', 1, '2023-09-09 07:10:00', '2023-09-09 07:40:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(334, 6, 5, 3, 1, '{\"1\":[\"23:50\",\"07:00\",\"07:10\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-09-09 07:40:00', '2023-09-09 08:10:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(335, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"4__\",\"3\":\"4__\",\"4\":\"5__\",\"5\":\"3__\",\"6\":\"1__\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"3__\"}', 1, '2023-09-10 07:00:00', '2023-09-10 07:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(336, 6, 5, 3, 1, '{\"1\":[\"23:30\",\"06:50\",\"07:20\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-09-10 07:30:00', '2023-09-10 08:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(337, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"3__\",\"4\":\"5__\",\"5\":\"4__\",\"6\":\"1__\",\"7\":\"2__\",\"8\":\"1__\",\"9\":\"2__\"}', 1, '2023-09-11 07:15:00', '2023-09-11 07:45:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(338, 6, 5, 3, 1, '{\"1\":[\"23:00\",\"07:00\",\"08:00\"],\"2\":\"4__\",\"3\":\"\"}', 1, '2023-09-11 07:45:00', '2023-09-11 08:15:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(339, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"3__\",\"3\":\"3__\",\"4\":\"2__\",\"5\":\"3__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"4__\",\"8\":\"2__\",\"9\":\"4__\"}', 1, '2023-09-12 07:13:00', '2023-09-12 07:43:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(340, 6, 5, 3, 1, '{\"1\":[\"00:05\",\"07:00\",\"06:55\"],\"2\":\"6__\",\"3\":\"\"}', 1, '2023-09-12 07:43:00', '2023-09-12 08:13:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(341, 6, 4, 3, 1, '{\"1\":\"\",\"2\":\"5__\",\"3\":\"4__\",\"4\":\"5__trifft gar nicht zu\",\"5\":\"5__\",\"6\":\"0__trifft gar nicht zu\",\"7\":\"1__\",\"8\":\"0__trifft gar nicht zu\",\"9\":\"1__\"}', 1, '2023-09-13 09:30:00', '2023-09-13 10:00:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init'),".
		"(342, 6, 5, 3, 1, '{\"1\":[\"00:40\",\"09:25\",\"08:45\"],\"2\":\"5__mittelmäßig\",\"3\":\"\"}', 1, '2023-09-13 10:00:00', '2023-09-13 10:30:00', 'Auto_Init', '2023-09-13 11:05:36', 'Auto_Init');";
		
}

function get_Extra_CategoriesSample_Init_SQL(string $datetime):string {
	return "".
		// categories sample data [german]
		"INSERT INTO categories (id, parent_id, sort, name, status, color, created, created_by, modified, modified_by) VALUES ".
		"(1, 0, 1, 'forms for testing', 1, '#cccccc', '".$datetime."','Auto_Init','".$datetime."','Auto_Init'),".
		"(2, 0, 2, 'Diagnostik', 1, '#f2f2f2', '".$datetime."','Auto_Init','".$datetime."','Auto_Init'),".
		"(3, 2, 1, 'Psychometrie', 1, '#ED7D31', '".$datetime."','Auto_Init','".$datetime."','Auto_Init'),".
		"(4, 0, 3, 'Training und Wettkampf', 1, '#5B9BD5', '".$datetime."','Auto_Init','".$datetime."','Auto_Init');";
}

function get_Extra_Forms2Categories_Init_SQL(string $datetime):string {
	return "".
		// forms2categories
		"INSERT INTO forms2categories (id, form_id, category_id, sort, status, stop_date, created, created_by, modified, modified_by) VALUES ".
		"(1, 1, 1, 1, 1, NULL, '".$datetime."','Auto_Init','".$datetime."','Auto_Init'),".
		"(2, 2, 1, 2, 1, NULL, '".$datetime."','Auto_Init','".$datetime."','Auto_Init'),".
		"(3, 3, 3, 1, 1, NULL, '".$datetime."','Auto_Init','".$datetime."','Auto_Init'),".
		"(4, 4, 3, 2, 1, NULL, '".$datetime."','Auto_Init','".$datetime."','Auto_Init'),".
		"(5, 5, 3, 3, 1, NULL, '".$datetime."','Auto_Init','".$datetime."','Auto_Init'),".
		"(6, 6, 4, 1, 1, NULL, '".$datetime."','Auto_Init','".$datetime."','Auto_Init');";
}

function get_Extra_DashboardSample_Init_SQL(string $datetime):string {
	return "".
		// dashboard sample data [german]
		"INSERT INTO dashboard (id, user_id, group_id, name, type, options, sort, color, created, created_by, modified, modified_by) VALUES ".
		"(1, 6, 1, 'Kurzskala Erholung und Beanspruchung (KEB)', 'form', '3_4', 1, 'rgb(237, 125, 49)', '".$datetime."','Auto_Init','".$datetime."','Auto_Init'),".
		"(2, 6, 1, 'Trainingload (Session-RPE Methode)', 'form', '4_6', 2, '#5B9BD5', '".$datetime."','Auto_Init','".$datetime."','Auto_Init'),".
		"(3, 6, 1, 'Meine Formularauswahl', 'link', 1, 3, '#008000', '".$datetime."','Auto_Init','".$datetime."','Auto_Init');";
}

function get_Sports_Init_SQL_EN(string $datetime):string {
	return "".
		// sports sample data [english]
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
		"(46, 5, NULL, 'Diving', 1, '".$datetime."', '".$datetime."'),".
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

function get_Sports_Init_SQL_DE(string $datetime):string {
	return "" .
		// sports sample data [german]
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

function get_FormTemplates_Init_SQL_DE(string $datetime):string {
	return "" .
	// form templates sample data [german]
	"INSERT INTO `templates_forms` (`id`, `user_id`, `location_id`, `group_id`, `form_id`, `name`, `data_json`, `created`, `created_by`, `modified`, `modified_by`) VALUES ".
	"(1, 6, 1, 1, 6, 'test_form_template', '{\"data\":{\"_2\":{\"name\":\"Dauer (Training / Wettkampf)\",\"sel_val\":\"6|2\",\"base_form_id\":\"6\",\"form_id\":\"6\",\"form_name\":\"Trainingload (Session-RPE Methode)\",\"field_name\":\"Dauer (Training / Wettkampf)\",\"field_type\":\"_Number\",\"field_num\":\"2\",\"cell_id\":\"RC\",\"data_or_calc\":\"data\",\"show\":\"0\",\"type\":\"line\",\"line\":\"Solid\",\"p_range\":\"0\",\"color\":\"\",\"markers\":\"null\",\"labels\":\"false\",\"axis\":\"axis_1\"},\"_3\":{\"name\":\"Rating of Perceived Exertion (RPE)\",\"sel_val\":\"6|3\",\"base_form_id\":\"6\",\"form_id\":\"6\",\"form_name\":\"Trainingload (Session-RPE Methode)\",\"field_name\":\"Rating of Perceived Exertion (RPE)\",\"field_type\":\"_RadioButtons\",\"field_num\":\"3\",\"cell_id\":\"RE\",\"data_or_calc\":\"data\",\"show\":\"0\",\"type\":\"line\",\"line\":\"Solid\",\"p_range\":\"0\",\"color\":\"\",\"markers\":\"null\",\"labels\":\"false\",\"axis\":\"axis_1\"},\"_B1\":{\"name\":\"Calculation1\",\"sel_val\":\"6|1\",\"base_form_id\":\"6\",\"form_id\":\"6\",\"form_name\":\"Trainingload (Session-RPE Methode)\",\"field_name\":\"Formula1\",\"field_type\":\"_Number\",\"field_num\":\"B1\",\"cell_id\":\"BA\",\"data_or_calc\":\"calc\",\"show\":\"1\",\"type\":\"column\",\"line\":\"Solid\",\"p_range\":\"0\",\"color\":\"\",\"markers\":\"null\",\"labels\":\"false\",\"axis\":\"axis_1\",\"formula_cells\":\"1\",\"formula_period\":\"lines\",\"formula_after\":\"0\",\"formula_X_axis_show\":\"0\",\"formula_Full_Period\":\"0\",\"formula_input\":\"if({RE}>7,{RC}*{RE},\\\"\\\")\"}},\"athlete_name_show\":\"0\",\"form_name_show\":\"0\"}', '".$datetime."','Auto_Init','".$datetime."','Auto_Init');";
}