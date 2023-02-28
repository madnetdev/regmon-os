<?php //ajax check if user exist

$uname = filter_input(INPUT_GET, 'uname', FILTER_SANITIZE_STRING);
$uid = filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT);
if (!$uname OR $uname == '') exit;

// load language & database ##########
require_once('no_validate.php');
// ###################################


$where = '';
if ($uid) { //if is the same user
	$where = 'AND id != '.((int)$uid);
}  

if ($uname) {
	$row = $db->fetchRow("SELECT * FROM users WHERE uname=? $where", array($uname));
	if ($db->numberRows() > 0)  {
		if ($uid) echo $LANG->NAME_EXIST;
		else echo 'false';
	}
	else {
		if ($uid) echo 'OK';
		else echo 'true';
	}
}
else {
	if ($uid) echo $LANG->ERROR;
	else echo 'false';
}
?>