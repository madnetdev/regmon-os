<?php
$CONFIG = array();

/**
 * Database Settings
 * =================
 */
//Database Hostname ex. localhost
$CONFIG['DB_Host'] = "localhost";
//Database Name ex. regmondb
$CONFIG['DB_Name'] = "regmondb";
//Database User ex. root
$CONFIG['DB_User'] = "root";
//Database Password ex. root
$CONFIG['DB_Pass'] = "";
//Database Debug Queries Filename ex. __log_query.log
$CONFIG['DB_Debug_File'] = '__log_query.log';
/**
 * Database Debug Queries ?
 * Writes every sql query to the DB_Debug_File in the working directory
 */
$CONFIG['DB_Debug'] = false;
//$CONFIG['DB_Debug'] = true;

/**
 * Application Domain name
 * =======================
 */
$CONFIG['DOMAIN'] = "domain.com";

/**
 * REGmon_Files is where the export files and uploaded files go to.
 * It should NOT be under DOCUMENT_ROOT, so it is not accessible from outside
 * ex.: "../regmon_files/"
 */
$CONFIG['REGmon_Files'] = "../regmon_files/";

/**
 * set REGmon_Folder if you install in a directory other than DOCUMENT_ROOT
 * ex.: "regmon/" or "folder1/folder2/"
 * ----------------------------------------------
 * You can have more than one folder with the app in the same DOCUMENT_ROOT
 * ex.: "regmon1/" + "regmon2/" + "regmon3/"
 * But you CANNOT have one folder of the app inside another folder of the app
 * ex.: "regmon1/" + "regmon1/regmon2/" + "regmon1/regmon3/"  <-- NOT DO THIS
 * because cookies from "regmon2/" app will conflic with "regmon1/" app cookies
 */
$CONFIG['REGmon_Folder'] = '';

/**
 * Email Config
 * ============
 */
$CONFIG['EMAIL'] = [
	//Host - sets the SMTP server (localhost)
	'Host' 			=> 'domain.com',
	//SMTPSecure - ('ssl','tls') - ssl(465) - tls(587)
	'SMTPSecure' 	=> 'tls',
	//Port - set the SMTP port for the server (25, 465, 587)
	'Port' 			=> '587',
	//Username - SMTP account username
	'Username' 		=> 'email@domain.com',
	//Password - SMTP account password
	'Password' 		=> 'password',
	//CharSet for email - def: utf-8
	'CharSet' 		=> 'utf-8',
	/**
	 * From_Name - the name of the email sender
	 * ex.: From: {From_Name} <{Username@domain.com}>
	 * if is empty most clients set it to the Username
	 */
	'From_Name' 	=> 'App Name',
	//Support Email account - only for showing
	'Support' 		=> 'support@domain.com'
];


/**
 * Production (true) or Development (false)
 * defines the error logging in _settings.regmon.php
 */
$CONFIG['PRODUCTION'] = true;

/**
 * use https:// or http://
 * there is an override for localhost in _settings.regmon.php
 */
$CONFIG['HTTP'] = 'https://';
/**
 * force a redirect to https if a request is from http
 */
$CONFIG['Force_Redirect_To_HTTPS'] = true;

/**
 * Secret strings - used for encryption
 * ====================================
 * TODO: @@@@@@@@@@ this strings need to be generated automatically
 */
/**
 * SEC_Page_Secret is used when we want to secure pages 
 * that not required the validate.php script 
 * and from direct calls, mostly ajax. and inc. pages
 */
$CONFIG['SEC_Page_Secret'] = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
/**
 * SEC_Hash_Secret is used for hashing the user HASH cookie
 * HASH cookie is used to validate the user
 * if SEC_Hash_Secret is changed then all users will be logged out
 */
$CONFIG['SEC_Hash_Secret'] = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
/**
 * SEC_Encrypt_Secret is used for encrypting app strings
 */
$CONFIG['SEC_Encrypt_Secret'] = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
/**
 * SEC_Hash_IP is to enable the use of user IP in user HASH
 * if true and the user IP changes the user will be logged out
 */
$CONFIG['SEC_Hash_IP'] = true; 

/**
 * LogLimiter - helps us to limit bruteforces attacks.
 * ===================================================
 */
$CONFIG['LogLimiter'] = [
	/**
	 * Max_Attempts - Number of Max attempts before blocking - def:5
	 */
	'Max_Attempts' 			=> 5,
	/**
	 * Reset_Attempts_Minutes
	 * Remaining time to reset attempts (in minutes)
	 * Counting after the last attempt
	 * def: 10
	 */
	'Reset_Attempts_Minutes'=> 10,
	/**
	 * Block_Minutes - Time of blocking (in minutes) - def:10
	 */
	'Block_Minutes' 		=> 10
];

/**
 * Use_VisualCaptcha - helps us to limit bruteforces attacks.
 * In some apache configuration is not working
 * set Use_VisualCaptcha = false to bypass captcha validation
 * ===================================================
 */
$CONFIG['Use_VisualCaptcha'] = true;

/**
 * Use_Multi_Language_Selector - enable/disable the dropdown language selection
 * ---------------------------------------------------
 * The inteface can be translated in multiple languages.
 * But the content (locations, groups, categories, forms, dropdowns, sports, tags) cannot.
 * This will need a lot of work from users,
 * that need to deliver the same content for every avalable language.
 * So with this option you can disable the dropdown language selection
 * ===================================================
 */
$CONFIG['Use_Multi_Language_Selector'] = false;

/**
 * Default_Language - en, de
 * set the default language in case you set the Use_Multi_Language_Selector = false
 * this will lock the Default_Language and not let to be changed from url or cookie
 * ===================================================
 */
$CONFIG['Default_Language'] = 'en'; 

?>
