<?php // deletes a user uploaded file
$PATH_2_ROOT = '../../';
require_once($PATH_2_ROOT.'_settings.regmon.php');
require($PATH_2_ROOT.'login/validate.php');

$uid = isset($_POST['uid']) ? (int)$_POST['uid'] : false;
$group_id = isset($_POST['group_id']) ? (int)$_POST['group_id'] : false;
$mode = isset($_POST['mode']) ? $_POST['mode'] : false;
$file = isset($_POST['file']) ? $_POST['file'] : false;
if (!$uid OR !$group_id OR !$mode OR !$file) exit;

$dir = $PATH_2_ROOT . $CONFIG['REGmon_Files'] . $mode .'/'. $uid .'/'. $group_id .'/';
$get_file = realpath($dir.'/'.$file);
if (is_file($get_file)) {
	unlink($get_file);
	echo 'OK_delete';
}
else echo 'ERROR_delete';
?>