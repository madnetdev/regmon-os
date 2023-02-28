<?php // ajax check private key

$private_key = filter_input(INPUT_GET, 'private_key', FILTER_SANITIZE_STRING);
$location_id = filter_input(INPUT_GET, 'location_id', FILTER_SANITIZE_STRING);
if (!$private_key OR $private_key == '') {
	echo 'false';
	exit;
}

// load language & database ##########
require_once('no_validate.php');
// ###################################


$location_id = 0;
$where = '';
if ($location_id) { //registered user
	$where = 'AND location_id = '.((int)$location_id);
}  

if (isset($_GET['private_key'])) {
	$row = $db->fetchRow("SELECT id FROM groups WHERE status = 3 AND private_key = ? $where", array($private_key)); 
	if ($db->numberRows() > 0)  {
		if ($location_id) echo $row['id'];
		else echo 'true';
	}
	else {
		echo 'false';
	}
}
else {
	echo 'false';
}
?>