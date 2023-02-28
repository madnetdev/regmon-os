<?php
declare(strict_types=1);

namespace REGmon;

//Version
$G_Version = "3.200";
$G_VER = "?ver=".$G_Version;


if (file_exists(__DIR__.'/__config.regmon.php')) {
	require_once(__DIR__.'/__config.regmon.php');
} 
else {
	//__config.regmon.php missing --run install script
	//TODO: @@@@@@@@@@@ make install script
	die('"__config.regmon.php" is missing!');
}

	
// localhost config
if ($_SERVER['HTTP_HOST'] == 'localhost' OR 
	$_SERVER['HTTP_HOST'] == "localhost:8080" OR 
	$_SERVER['HTTP_HOST'] == "regmon_os.test") 
{
	$CONFIG['PRODUCTION'] = false;
	$CONFIG['HTTP'] = 'http://';
	$CONFIG['DOMAIN'] = $_SERVER['HTTP_HOST'];
}else {
	die('only localhost for now');
	
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

?>