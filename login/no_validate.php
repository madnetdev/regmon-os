<?php // load defaults without validate a user
// used by pages where we not have a logged in user ex. register.php
require_once(__DIR__.'/../_settings.regmon.php');
require_once(__DIR__.'/../login/login_functions.php');

//Init DB ###############################################
require_once(__DIR__.'/../php/class.db.php');	
$db = db::open('mysqli', $CONFIG['DB_Name'], $CONFIG['DB_User'], $CONFIG['DB_Pass'], $CONFIG['DB_Host']);
//set db log from the URL with page.php?dblog --not work for ajax calls
if (!$CONFIG['DB_Debug'] and isset($_GET['dblog'])) {
	$CONFIG['DB_Debug'] = true;
}
if ($CONFIG['DB_Debug']) {
	//enable query logging
	$db->logToFile($CONFIG['DB_Debug_File']);
}
//Init DB ###############################################


//Load languages
require_once(__DIR__.'/../php/class.language.php');
$LANG = Language::getInstance($CONFIG['REGmon_Folder'], $CONFIG['Default_Language'], $CONFIG['Use_Multi_Language_Selector']);


//Load Date functions -> they based on language
require_once(__DIR__.'/../php/date_functions.php');

//Load Global functions
require_once(__DIR__.'/../php/global_functions.php');


//continue to the page that call this
?>
