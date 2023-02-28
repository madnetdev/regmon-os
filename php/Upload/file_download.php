<?php // downloads a user uploaded file
$PATH_2_ROOT = '../../';
require_once($PATH_2_ROOT.'_settings.regmon.php');
require($PATH_2_ROOT.'login/validate.php');

$uid = isset($_GET['uid']) ? (int)$_GET['uid'] : false;
$group_id = isset($_GET['group_id']) ? (int)$_GET['group_id'] : false;
$mode = isset($_GET['mode']) ? $_GET['mode'] : false;
$file = isset($_GET['file']) ? $_GET['file'] : false;
if (!$uid OR !$group_id OR !$mode OR !$file) exit;

$dir = $PATH_2_ROOT . $CONFIG['REGmon_Files'] . $mode .'/'. $uid .'/'. $group_id .'/';
$get_file = realpath($dir.'/'.$file);
if (is_file($get_file)) {

	header('Set-Cookie: fileDownload=true; path='.'/'.$CONFIG['REGmon_Folder']); 
	header('Cache-Control: max-age=60, must-revalidate'); 
	header('Content-Disposition: attachment; filename="'.$file.'"');

	readfile($get_file);
}
else echo 'ERROR_download';
?>