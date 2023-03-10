<?php
declare(strict_types=1);
$PATH_2_ROOT = '../';
require_once($PATH_2_ROOT.'_settings.regmon.php');
require($PATH_2_ROOT.'login/validate.php');
require_once($PATH_2_ROOT.'php/functions.php');

if (!isset($_REQUEST['i'])) exit;

$SEC_check = $CONFIG['SEC_Page_Secret']; //secure ajax sub pages from direct call

$ajax = $_REQUEST['i'];
$action = isset($_REQUEST['oper']) ? $_REQUEST['oper'] : '';
$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0; //db_id
$ID = isset($_REQUEST['ID']) ? (int)$_REQUEST['ID'] : 0; //regmon_id

$sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : '';	// get index for sorting
$sord = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : ''; 	// get sorting direction

$responce = new stdClass();

$where = '';

switch($ajax) {
	case 'users':
	case 'locations':
	case 'groups':
	case 'forms':
	case 'forms_data':
	case 'categories':
	case 'forms2categories':
	case 'templates':
	case 'importTrackers':
	case 'sports':
	case 'dropdowns':
		if (file_exists('ajax.'.$ajax.'.php')) {
			include('ajax.'.$ajax.'.php');
		}
  break;
}
	

////////////////////////////////////
function check_update_result($result) {
	global $LANG, $db;
	
	if ($result >= 1) {
		return 'OK_update';
	}
	elseif ($result == 0) {
		return $LANG->UPDATE_NOTHING;
	}
	else {
		if (substr_count($db->_error(), 'Duplicate entry') <> 0) {
			return $LANG->UPDATE_ERROR;
		}
		else {
			return $LANG->UPDATE_ERROR;
			//return 'Error! '.$db->_error();
		}
	}
}

////////////////////////////////////
function check_insert_result($insert_id) {
	global $LANG, $db;
	
	if (!$insert_id) { 
		if (substr_count($db->_error(), 'Duplicate entry') <> 0) {
			return $LANG->WARN_USERNAME_EXIST;
		}
		else {
			return $LANG->INSERT_ERROR;
			//return 'Error! '.$db->_error();
		}
	}
	else {
		//we get the error in $insert_id --instead of $db->_error()
		if (substr_count($insert_id, 'Duplicate entry') <> 0) {
			return $LANG->WARN_USERNAME_EXIST;
		}
		return 'OK_insert'; //$LANG->INSERT_OK;
	}
}

////////////////////////////////////
function check_delete_result($result) {
	global $LANG;
	
	if (!$result) {
		return $LANG->DELETE_ERROR; //echo mysql_error();
	}
	else {
		return 'OK_delete'; //$LANG->DELETE_OK;
	}
}

?>