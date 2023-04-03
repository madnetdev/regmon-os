<?php 
$PATH_2_ROOT = '../';
require_once($PATH_2_ROOT.'_settings.regmon.php');
require($PATH_2_ROOT.'login/validate.php');

//give time for export
ini_set("memory_limit",-1);
ini_set("max_execution_time","0"); 
set_time_limit(0); 

$gender = isset($_POST['gender']) ? $_POST['gender'] : array();
$year = isset($_POST['year']) ? $_POST['year'] : array();
$sport = isset($_POST['sport']) ? $_POST['sport'] : array();
$groups = isset($_POST['group']) ? $_POST['group'] : array();
$athletes = isset($_POST['athletes']) ? $_POST['athletes'] : array();
$date_from = isset($_POST['date_from']) ? $_POST['date_from'] : "";
$date_to = isset($_POST['date_to']) ? $_POST['date_to'] : "";
$forms = isset($_POST['forms']) ? $_POST['forms'] : array();
//$data_type = isset($_POST['data_type']) ? $_POST['data_type'] : array();
$fields = isset($_POST['fields']) ? $_POST['fields'] : array();


function get_All_Groups() {
	global $db;
	$groups = array();
	$groups_db = $db->fetch("SELECT id, name, status FROM `groups` WHERE status <> 0", array()); 
	if ($db->numberRows() > 0)  {
		foreach ($groups_db as $row) {
			$groups[$row['id']] = $row['name'].($row['status']==3? ' (privat)':'');
		}
	}
	return $groups;
}


function get_Trainer_Groups($uid) {
	global $db;
	$trainer_groups = array();
	$rows = $db->fetch("SELECT u2g.group_id 
FROM users2groups u2g 
LEFT JOIN users u ON (u.id = u2g.user_id AND u.level = 30 AND u.status = 1) 
WHERE u2g.status = 1 AND u.id = ?", array($uid)); 
	if ($db->numberRows() > 0)  {
		foreach ($rows as $row) {
			$trainer_groups[] = $row['group_id'];
		}
	}
	return $trainer_groups;
}

function get_Users2Groups($uid) {
	global $db;
	$Users2Groups = array();
	$rows = $db->fetch("SELECT group_id FROM users2groups WHERE status = 1 AND user_id = ? ", array($uid)); 
	if ($db->numberRows() > 0)  {
		foreach ($rows as $row) {
			$Users2Groups[] = $row['group_id'];
		}
	}
	return $Users2Groups;
}

function get_ATH_avail_Admins($UID, $GP_avail, $u_where) {
	global $db;
	$ATH_avail = '';
	$groups_where = '';
	$groups_where = "AND u2g.group_id IN (".$GP_avail.")"; /*if (!$ADMIN)*/
	$u_rows = $db->fetch("SELECT u.id, u.uname, u.firstname, u.lastname, u.sport FROM users u 
LEFT JOIN users2groups u2g ON u.id = u2g.user_id 
WHERE u2g.status = 1 AND u.status = 1 AND u.id != ? $groups_where $u_where 
ORDER BY u.firstname, u.lastname, u.id", array($UID)); //Group USERS
	$ATH_avail .= $UID;
	if ($db->numberRows() > 0)  {
		foreach ($u_rows as $u_row) {
				$ATH_avail .= ','.$u_row['id'];
		}
	}
	return $ATH_avail;
}

function get_ATH_avail_Trainer($UID, $GP_avail) {
	global $db;
	$ATH_avail = '';
	$groups_where = "AND u2g.group_id IN (".$GP_avail.")";
	$u_rows = $db->fetch("SELECT u.id, u.uname, u.lastname, u.firstname, u.sport 
FROM users2groups u2g 
JOIN users u ON (u.id = u2g.user_id AND u.level = 10 AND u.status = 1) 
JOIN users2trainers u2t ON (u.id = u2t.user_id AND u2g.group_id = u2t.group_id AND u2t.status = 1 AND u2t.trainer_id = ?) 
WHERE u2g.status = 1 $groups_where 
ORDER BY u.firstname, u.lastname, u.id", array($UID)); 
	$ATH_avail .= $UID;
	if ($db->numberRows() > 0) {
		foreach ($u_rows as $u_row) {
			$ATH_avail .= ','.$u_row['id'];
		}
	}
	return $ATH_avail;
}

function get_Trainer_Forms_Selected_Read_Write($trainer_id, $athletes_arr=array()) {
	global $db;
	$trainer_forms_selected_read_arr = array();
	$where_Athletes = '';
	if (count($athletes_arr)) {
		$where_Athletes = " AND user_id IN (". implode(',', $athletes_arr) .")";
	}
	$row = $db->fetchRow("SELECT user_id, forms_select_read FROM users2trainers WHERE trainer_id = ? $where_Athletes", array($trainer_id));
	if ($db->numberRows() > 0)  {
		if ($row['forms_select_read'] != '') {
			$trainer_forms_selected_read_arr[$row['user_id']] = explode(',', $row['forms_select_read']??'');
		}
	}
	return $trainer_forms_selected_read_arr;
}

function get_Users($where_USERS) {
	global $db;
	$users = array();
	$users_ids = array();
	$u_rows = $db->fetch("SELECT id, uname, lastname, firstname, sex, birth_date, sport FROM users $where_USERS", array()); 
	if ($db->numberRows() > 0)  {
		foreach ($u_rows as $u_row) {
			$users_ids[] = $u_row['id'];
			$a_name = $u_row['lastname'] != '' ? $u_row['lastname'] : $u_row['uname'];
			$a_vorname = $u_row['firstname'] != '' ? $u_row['firstname'] : $u_row['uname'];
			$users[$u_row['id']] = array(
				$u_row['id'],
				$a_name,
				$a_vorname,
				$u_row['sex'],
				get_date($u_row['birth_date'].''), 
				$u_row['sport']
			);
			//extra fields
			//$u_row['account'], $u_row['uname'], $u_row['status'], $u_row['group_id'], $u_row['body_height'], $u_row['email'],
		}
	}
	return array($users_ids, $users);
}

function get_Group_Users($group_id) {
	global $db;
	$users = array();
	$users_ids = array();
	$u_rows = $db->fetch("SELECT u.id, u.uname, u.lastname, u.firstname, u.sex, u.birth_date, u.sport 
FROM users u 
LEFT JOIN users2groups u2g ON u.id = u2g.user_id 
WHERE u2g.status = 1 AND u.status = 1 AND u2g.group_id=? 
ORDER BY u.firstname, u.lastname, u.id", array($group_id)); 
	if ($db->numberRows() > 0)  {
		foreach ($u_rows as $u_row) {
			$users_ids[] = $u_row['id'];
			$a_name = $u_row['lastname'] != '' ? $u_row['lastname'] : $u_row['uname'];
			$a_vorname = $u_row['firstname'] != '' ? $u_row['firstname'] : $u_row['uname'];
			$users[$u_row['id']] = array(
				$u_row['id'],
				$a_name,
				$a_vorname,
				$u_row['sex'],
				get_date($u_row['birth_date'].''), 
				$u_row['sport']
			);
			//extra fields
			//$u_row['account'], $u_row['uname'], $u_row['status'], $u_row['group_id'], $u_row['body_height'], $u_row['email'],
		}
	}
	return array($users_ids, $users);
}

function getCategoryForms($category_id) {
	global $forms, $order, $category_forms_ordered;
	foreach ($forms[$category_id] as $row) {
		$category_forms_ordered[$row['form_id']] = array($row['form_id'], $row['name'], $row['data_names'], $order);
		$order++;
	}
}
function buildCategory($parent) {
	global $categories;
	if (isset($categories['parent_categories'][$parent])) {
		foreach ($categories['parent_categories'][$parent] as $category_id) {
			if (!isset($categories['parent_categories'][$category_id])) {
				if (isset($categories['forms'][$category_id])) {
					getCategoryForms($category_id); //get forms
				}
			}
			if (isset($categories['parent_categories'][$category_id])) { //have childs
				if (isset($categories['forms'][$category_id])) {
					getCategoryForms($category_id); //get forms
				}
				buildCategory($category_id); //get childs
			}
		}
	}
}
function get_All_Categories() {
	global $db, $forms, $categories;

	//make an array to hold categories info and parent/child keys 
	$categories = array('categories' => array(), 'parent_categories' => array(), 'forms' => array());
	$categories_rows = $db->fetch("SELECT * FROM categories WHERE status = 1 ORDER BY parent_id, sort, name", array()); 
	if ($db->numberRows() > 0)  {
		foreach ($categories_rows as $row) {
			$categories['categories'][$row['id']] = $row; //categories array with id as key
			$categories['parent_categories'][$row['parent_id']][] = $row['id']; //child categories with parent as key
			if (isset($forms[$row['id']])) {
				$categories['forms'][$row['id']] = $forms[$row['id']]; //forms array with cat_id as key
			}
		}
		//echo "<pre>";print_r($categories);echo "</pre>"; exit;
		buildCategory(0);
	}
	//print_r($categories);
	/*Array (
		[categories] => Array (
			[17] => Array (
				[id] => 17
				[parent_id] => 0
				[sort] => 2
				[name] => Diagnostik
				[status] => 1
				[color] => #f2f2f2
				[created] => 2018-11-16 14:19:25
				[created_by] => admin
				[modified] => 2018-11-28 17:39:11
				[modified_by] => admin
			)
		)
		[parent_categories] => Array (
			[17] => Array (
				[0] => 20
				[1] => 21
				[2] => 22
			)
		)
		[forms] => Array (
			[17] => Array (
				[0] => Array (
					[form_id] => 1
					[category_id] => 17
					[name] => Testformular
					[data_names] => {"1":["Textfeld1","_Text"],"2":["number1","_Number"],"3":["number2","_Number"],"4":["Textareafeld1","_Textarea"],"5":["datum1","_Date"],"6":["uhrzeit1","_Time"],"7":["dauer1","_Period"],"8":["dropdown1","_Dropdown"],"9":["fragebogenformat1","_RadioButtons"]}
				)
			)
		)
	)
	*/
	return $categories;
}

function get_All_Forms() {
	global $db;
	$forms_rows = $db->fetch("SELECT f2c.form_id, f2c.category_id, f.name, f.data_names FROM forms2categories f2c
LEFT JOIN forms f ON form_id = f.id
WHERE f.status = 1 ORDER BY f2c.category_id, f.name", array()); 
	$forms = array();
	if ($db->numberRows() > 0)  {
		foreach ($forms_rows as $row) {
			$forms[$row['category_id']][] = $row; //forms array with cat_id as key
		}
	}
	//print_r($forms);
	return $forms;
}


?>