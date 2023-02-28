<?php // upload index - calls UploadHandler
$PATH_2_ROOT = '../../';
require_once($PATH_2_ROOT.'_settings.regmon.php');
require($PATH_2_ROOT.'login/validate.php');

ini_set('default_charset', 'utf-8');

$upload_modes = ['trackers']; //only trackers for now
$upload_allowed_file_types = "(json|csv)";

$mode = $_GET['mode'] ?? false;
$uid = $_GET['uid'] ?? false;
$group_id = $_GET['group_id'] ?? false;
if (!$uid OR !$group_id OR !$mode OR !in_array($mode, $upload_modes)) {
	exit; 
}

$upload_folder = $PATH_2_ROOT . $CONFIG['REGmon_Files'] . $mode.'/'.$uid.'/'.$group_id.'/';

$upload_options = array(
	'upload_dir' => $upload_folder,
	'upload_url' => $upload_folder,
	'inline_file_types' => '/\.'.$upload_allowed_file_types.'$/i',
	'accept_file_types' => '/\.'.$upload_allowed_file_types.'$/i'
);

require('UploadHandler.php');
$upload_handler = new UploadHandler($upload_options);
?>