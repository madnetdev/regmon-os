<?php
declare(strict_types=1);

namespace REGmon;

//Version
$G_Version = "3.014";
$G_VER = "?ver=" . $G_Version;


if (file_exists(__DIR__.'/__config.regmon.php')) {
	require_once(__DIR__.'/__config.regmon.php');
} 
else {
	//__config.regmon.php missing --run install script
	//TODO: make install script
	die('"__config.regmon.php" is missing!');
}


/**
 * Simple Extension System
 * only for this file '_settings.regmon.php', 
 * because we never really call this file directly,
 * so we can extend this too, but can be tricky 
 * ===================================================
 */
$settings_page = '_settings.regmon.php';
//check Simple_Extension_System
if (isset($CONFIG['Simple_Extension_System'][$settings_page])) {
	$extension_page = $CONFIG['Simple_Extension_System'][$settings_page][0];
	$exit_after = $CONFIG['Simple_Extension_System'][$settings_page][1];
	if (file_exists($extension_page)) 
	{
		require($extension_page);

		if ($exit_after) {
			//exit current page
			exit;
		}
	}
}


// localhost config
if (substr_count($_SERVER['HTTP_HOST'], 'localhost') OR  
	substr_count($_SERVER['HTTP_HOST'], 'test')) 
{
	$CONFIG['PRODUCTION'] = false;
	$CONFIG['HTTP'] = 'http://';
	$CONFIG['DOMAIN'] = $_SERVER['HTTP_HOST'];
}
else {
	
	//redirect to https
	if ($CONFIG['Force_Redirect_To_HTTPS'] AND (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off")){
		$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: ' . $redirect);
		exit();
	}

}


//logging recomendations from php.ini-production & php.ini-development
if ($CONFIG['PRODUCTION']) {
	ini_set('display_errors', '0');
	ini_set('display_startup_errors', '0');
	ini_set('log_errors', '1');
	error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
}
else { //Development
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	ini_set('log_errors', '1');
	error_reporting(E_ALL);
}

ini_set('default_charset', 'utf-8');



/**
 * Simple Extension System
 * -----------------------------
 * check if we have an extension for the current file
 * and if extension file exists and require the extension file
 * if the 'exit_after' is true then exit current page
 * else continue to the current page after the extension page finished
 * ===================================================
 */
$current_page = str_replace('/', '', $_SERVER['PHP_SELF']);
//check Simple_Extension_System
if (isset($CONFIG['Simple_Extension_System'][$current_page])) {
	$extension_page = $CONFIG['Simple_Extension_System'][$current_page][0];
	$exit_after = $CONFIG['Simple_Extension_System'][$current_page][1];
	if (file_exists($extension_page)) 
	{
		require($extension_page);

		if ($exit_after) {
			//exit current page
			exit;
		}
	}
}

?>