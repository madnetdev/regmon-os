<?php // ajax Users

if ($SEC_check != $CONFIG['SEC_Page_Secret']) exit;

switch ($action) {
	case 'add': // INSERT
	case 'edit': // UPDATE
		$values = array();			
		foreach ($_REQUEST as $key => $val) {
			$key = trim((string)$key); 
			$val = trim((string)$val); 
			switch($key) {
				case 'account': 
				case 'uname': 
				case 'passwd': 
				case 'lastname': 
				case 'firstname': 
				case 'sport': 
				case 'sex': 
				case 'body_height': 
				case 'email': 
				case 'telephone': 
				case 'level': 
				case 'status':
				case 'location_id':
				case 'group_id':
					$values[$key] = $val;
				  break;
				case 'birth_date':	
						if ($val != '') $values[$key] = get_date_SQL($val.'');
				  break;
			}
		}		
		
		$status = isset($values['status']) ? $values['status'] : 1;
		$level = isset($values['level']) ? $values['level'] : 10;
		
		//for group edit/add
		if (isset($_REQUEST['act']) AND $_REQUEST['act'] == 'group_add_edit') {
			if (!isset($values['status'])) $values['status'] = 1;
			//TODO: @@@@@@@ check the 000
			$values['sport'] = str_replace('000,', '', $values['sport']);
			if (isset($values['sport']) and ($values['sport'] == '000' or $values['sport'] == '')) {
				unset($values['sport']);
			}
		}
		
		// Check if all fields are filled up
		if (trim($values['uname']) == '') 		{
			echo $LANG->WARN_EMPTY_USERNAME;
			exit;
		}
		elseif (trim($values['passwd']) != trim($_REQUEST['pass_confirm'])) {
			echo $LANG->WARN_CONFIRM_PASSWORD;
			exit;
		}
		//elseif (trim($values['email']) != '') {
		elseif (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
			echo $LANG->WARN_INVALID_EMAIL;
			exit;
		}

		if ($action == 'add') {
			$values['account'] = 'user'; //$ACCOUNT;
			//$values['level'] = 10;
		}

		//the following checks is additional to $db that returns duplicate too if the following not used
		$where_id = '';
		if ($id != 0) $where_id = 'AND id != '.((int)$id); //if edit = have id
		$row = $db->fetchRow("SELECT * FROM users WHERE uname=? $where_id", array($values['uname']));
		if ($db->numberRows() > 0)  {
			echo $LANG->WARN_USERNAME_EXIST;
		}
		else {
			// INSERT ###############################
			if ($action == 'add') {
				if (trim($values['passwd']) == '') {
					echo $LANG->WARN_EMPTY_PASSWORD;
					exit;
				}
				else {
					//if pass < 8 chars
					if (strlen($values['passwd']) < 8) {
						echo $LANG->WARN_PASSWORD_CHARS;
						exit;
					}
					
					$values['passwd'] = MD5($values['passwd']);
					$values['last_ip'] = '';
					$values['modified'] = get_date_time_SQL('now');
					$values['created'] = get_date_time_SQL('now');
					
					$insert_id = $db->insert($values, "users");
					
					$save_res = check_insert_result($insert_id);
					
					//for group edit/add
					if (isset($_REQUEST['act']) AND $_REQUEST['act'] == 'group_add_edit' AND $save_res == 'OK_insert') {
						//###############################
						//group access
						$values2 = array();			
						$values2['user_id'] = $insert_id;
						$values2['group_id'] = $values['group_id'];
						$values2['status'] = '1';
						$values2['created'] = get_date_time_SQL('now');
						$values2['created_by'] = $USER['uname'];
						$values2['modified'] = get_date_time_SQL('now');
						$values2['modified_by'] = $USER['uname'];
						$users2groups = $db->insert($values2, "users2groups");
						//###############################
					}
					
					echo $save_res;
				}
			}
			// UPDATE ###############################
			elseif ($action == 'edit')
			{
				if ($values['uname'] == $USERNAME AND $status != '1')  {
					echo $LANG->WARN_DEACT_YOUR_ACC;
					exit;
				}
				if ($id == $UID AND $values['uname'] != $USERNAME)  {
					echo $LANG->WARN_CHANGE_MAIN_NAME;
					exit;
				}
				
				//TODO: change the MD5 encryption function with something better
				//TODO: check at least for one number one uppercase letter and one lowercase letter @@@@@@@@@@

				// If $password is not blank save it, else dont make changes to the current password
				if (trim($values['passwd']) != '') {
					//if pass < 8 chars
					if (strlen($values['passwd']) < 8) {
						echo $LANG->WARN_PASSWORD_CHARS;
						exit;
					}
						
					$values['passwd'] = MD5($values['passwd']);
				}
				else {
					unset($values['passwd']); //delete pass from array
				}
				
				$values['modified'] = get_date_time_SQL('now');
				
				$result = $db->update($values, "users", "id=?", array($id));
				
				echo check_update_result($result);
			}
		}

	  break;
	  
	case 'del': // DELETE 
		
		$row = $db->fetchRow("SELECT * FROM users WHERE id=?", array($id));
		
		if (($row['account'] == 'admin' AND $row['uname'] == 'admin')) {
			echo 'Warning! Admin Account cannot be deleted.';
			exit;
		}
		if ($row['uname'] == $USERNAME)  {
			echo $LANG->WARN_DELETE_YOUR_ACC;
			exit;
		}

		$result = $db->delete("users", "id=?", array($id));
			
		echo check_delete_result($result);

	  break;


	case 'dash_onlogin': // UPDATE
		$values = array();		
		$id = $_REQUEST['ath_id'];
		foreach ($_REQUEST as $key => $val) {
			$key = trim((string)$key); 
			$val = trim((string)$val); 
			switch($key) {
				case 'ath_id':
				case 'dashboard':
					$values[$key] = $val;
				  break;
			}
		}		
		
		$values['modified'] = get_date_time_SQL('now');
		
		$result = $db->update($values, "users", "id=?", array($id));
		
		//echo check_update_result($result);

	  break;
	  


	case 'trainer': // SELECT 
		
		$responce = new stdClass();
		$sidx = $sidx ?? '';
		$sord = $sord ?? '';

		if (!$ADMIN AND !$LOCATION_ADMIN AND !$GROUP_ADMIN AND !$GROUP_ADMIN_2 AND !$TRAINER) { echo '{"rows":[]}'; exit; }
		// or just //if ($ATHLETE) { echo '{"rows":[]}'; exit; }

		$group_id = isset($_REQUEST['group_id']) ? (int)$_REQUEST['group_id'] : 0;
		$trainer_id = $UID ?? 0; //for php int
		
		$where_level = "u.level = 10";
		if ($ADMIN) $where_level = "u.level IN (10,30,40,45,50)";
		elseif ($LOCATION_ADMIN) $where_level = "u.level IN (10,30,40,45)";
		elseif ($GROUP_ADMIN OR $GROUP_ADMIN_2) $where_level = "u.level IN (10,30)";

		$wher = "";
		$where = $wher . $where;
		$where = str_replace("u2t.status = 'null'", "u2t.status IS NULL", $where);
		$rows = $db->fetch("SELECT u2t.status AS request_status, u.* FROM `users2groups` u2g 
				JOIN `users` u ON u.id = u2g.user_id AND $where_level AND u.status = 1
				LEFT JOIN `users2trainers` u2t ON u.id = u2t.user_id AND u2g.group_id = u2t.group_id AND u2t.trainer_id = ?
				WHERE u2g.group_id = ? AND u2g.status = 1 $where ORDER BY $sidx $sord ", array($trainer_id, $group_id)); 
		$i=0;
		if ($db->numberRows() > 0)  {
			foreach ($rows as $row) {
				$responce->rows[$i] = $responce->rows[$i]['cell'] = array(
					$row['id'],
					$row['firstname'],
					$row['lastname'],
					get_date_SQL($row['birth_date'].''),
					$row['sport'],
					$row['sex'],
					$row['body_height'],
					get_date_time_SQL($row['created'].''),
					get_date_time_SQL($row['modified'].''),
					$row['request_status']==1?'<img class="checklist" data-id="'.$row['id'].'" src="img/checklist.png" style="cursor:pointer;" title="'.$LANG->TRAINER_2_ATHLETES_ACCESS.'">':'',
					$row['request_status']
				);
				$i++;
			}
		}

		$responce = json_encode($responce);
		
		if ($responce == '""') //if empty
			echo '{"rows":[]}';
		else 
			echo $responce;
			
	  break;


	case 'group': // SELECT 
		
		$responce = new stdClass();
		$sidx = $sidx ?? '';
		$sord = $sord ?? '';

		if (!$ADMIN AND !$LOCATION_ADMIN AND !$GROUP_ADMIN AND !$GROUP_ADMIN_2) { echo '{"rows":[]}'; exit; }
		// or just //if ($ATHLETE OR $TRAINER) { echo '{"rows":[]}'; exit; }

		$group_id = isset($_REQUEST['group_id']) ? (int)$_REQUEST['group_id'] : 0;

		$where_level = "AND u.level = 10";
		if ($ADMIN) $where_level = "AND u.level IN (10,30,40,45,50)";
		elseif ($LOCATION_ADMIN) $where_level = "AND u.level IN (10,30,40,45)";
		elseif ($GROUP_ADMIN OR $GROUP_ADMIN_2) $where_level = "AND u.level IN (10,30)";
		
		$wher = '';
		$where = $wher . $where;
				
		//users 2 group
		$rows = $db->fetch("SELECT u2g.status AS request_status, u.* FROM `users2groups` u2g 
				JOIN `users` u ON u.id = u2g.user_id $where_level
				WHERE u2g.group_id = ? $where ORDER BY $sidx $sord ", array($group_id)); 
		
		$i=0;
		//if ($db->numberRows() > 0)  {
		if (count($rows))  {
			foreach ($rows as $row) {
				$responce->rows[$i] = $responce->rows[$i]['cell'] = array(
					'',
					$row['id'],
					$row['uname'],
					'', //$row['passwd'],
					'', //repeat_pass,
					$row['firstname'],
					$row['lastname'],
					get_date_SQL($row['birth_date'].''),
					$row['sport'],
					$row['sex'],
					$row['body_height'],
					$row['email'],
					$row['telephone'],
					$row['level'],
					get_date_time_SQL($row['lastlogin'].''),
					$row['logincount'],
					get_date_time_SQL($row['created'].''),
					get_date_time_SQL($row['modified'].''),
					$row['request_status']
				);
				$i++;
			}
		}

		$responce = json_encode($responce);
		
		if ($responce == '""') //if empty
			echo '{"rows":[]}';
		else 
			echo $responce;
			
	  break;


	case 'files': //trackers
		
		$responce = new stdClass();
		
		$uid = isset($_GET['uid']) ? (int)$_GET['uid'] : false;
		$group_id = isset($_GET['group_id']) ? (int)$_GET['group_id'] : false;
		$mode = isset($_GET['mode']) ? $_GET['mode'] : false;
		if (!$uid OR !$group_id OR !$mode) {
			echo '{"rows":[]}';
			exit;
		}

		function is_Polar_CSV_file($file) {
			//1..Name,Sport,Date,Start time,Duration,Total distance (km),Average heart rate (bpm),Average speed (km/h),Max speed (km/h),Average pace (min/km),Max pace (min/km),Calories,Fat percentage of calories(%),Average cadence (rpm),Average stride length (cm),Running index,Training load,Ascent (m),Descent (m),Average power (W),Max power (W),Notes,Height (cm),Weight (kg),HR max,HR sit,VO2max,
			//2..TRIMP Studie,RUNNING,20-06-2018,11:17:03,00:30:08,4.48,156,8.9,18.8,06:44,03:11,435,19,73,,43,79,,,,,"Felix Fahrtspiel, Sehr warm und sonnig, teilweise gehen um puls runter zu bekommen",180.0,77.0,195,55,56,
			//3..Sample rate,Time,HR (bpm),Speed (km/h),Pace (min/km),Cadence,Altitude (m),Stride length (m),Distances (m),Temperatures (C),Power (W),
			//4..1,00:00:00,95,3.7,16:13,0,116,,0.70,31.3,,
			if (strpos($file, 'Name,Sport,Date,Start time,Duration,Total distance (km),Average heart rate (bpm),Average speed (km/h)') === 0 AND strpos($file, 'Sample rate,Time,HR (bpm),Speed (km/h),Pace (min/km),Cadence,Altitude (m),Stride length (m),Distances (m),Temperatures (C),Power (W)') != '') return true;
			return false;
		}
		function is_Garmin_CSV_file($file) {
			//1..Aktivitätstyp,Datum,Favorit,Titel,Distanz,Kalorien,Zeit,Ø HF,Max. HF,Aerober TE,Ø Schrittfrequenz (Laufen),Max. Schrittfrequenz (Laufen),Ø Geschwindigkeit,Maximale Geschwindigkeit,Positiver Höhenunterschied,Negativer Höhenunterschied,Ø Schrittlänge,Durchschnittliches vertikales Verhältnis,Ø vertikale Bewegung,Ø Bodenkontaktzeit,Durchschnittliche Balance der Bodenkontaktzeit,Training Stress Score®,Grit,Flow,Grundzeit,Min. Temp.,Oberflächenpause,Dekompression,Beste Rundenzeit,Max. Temp.
			//2..Radfahren,2017-04-22 13:12:32,false,"Monschau Radfahren","42.02","2,336","03:51:46","139","181","3.3","--","--","10.9","45.6","933","885","0.00","0.0","0.0","--","--","0.0","0.0","0.0","0:00","0.0","0:00","Nein","00:00.00","0.0"
			if (strpos($file, 'Aktivitätstyp,Datum,Favorit,Titel,Distanz,Kalorien,Zeit,Ø HF,Max. HF,Aerober TE') === 0)	return true;
			return false;
		}
		
		$dir = '../' . $CONFIG['REGmon_Files'] . $mode .'/'. $uid .'/'. $group_id .'/';
		$allowed_file_types = "(json|csv)";
		if (is_dir($dir)) {
			if ($handle = opendir($dir)) {
				$i=0;
				while (false !== ($file = readdir($handle))) {
					$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
					if ($ext == '') $ext = 'null';
					if (preg_match("/\." . $allowed_file_types . "$/i",$file) OR
						($ext == 'null' AND $file != '.' AND $file != '..'))
					{
						$size = round(filesize($dir.'/'.$file) / 1024, 2);
						$get_file = file_get_contents($dir.$file);
						$date_time = get_date_time_SQL(date("Y-m-d H:i:s", filemtime($dir.$file))); //filectime
						$type = '';
						$import_page ='';
						
						if ($ext == 'csv') { //CSV 
							$is_Garmin_CSV = is_Garmin_CSV_file($get_file); //garmin has less KB
							if ($is_Garmin_CSV) {
								$type = 'Garmin CSV';
								$import_page = 'import_export/import_Garmin_CSV.php';
							}
							else {
								$is_Polar_CSV = is_Polar_CSV_file($get_file);
								if ($is_Polar_CSV) {
									$type = 'Polar CSV';
									$import_page = 'import_export/import_Polar_CSV.php';
								}
							}
						}
						
						$responce->rows[$i] = $responce->rows[$i]['cell'] = array(
							$i+1,
							$file,
							$type,
							'<img src="img/ico/' .$ext. '.png" style="height:30px;">',
							$size,
							$date_time,
							($import_page!=''?'<a href="'.$import_page.'?file='.urlencode($file).'" class="file_import" style="display:block; font-size:20px; color:green; padding:5px;" title="'.$LANG->IMPORT_DATA.'"><i class="fa fa-file-code-o"></i><i class="fa fa-arrow-right" style="margin-left:5px;"></i><i class="fa fa-database" style="margin-left:5px;"></i></a>':''),
							'<a href="js/plugins/jsonTreeViewer/index.php?file='.urlencode($file).'" class="file_view" style="display:block;" title="'.$LANG->VIEW_DATA.'"><i class="fa fa-list-alt" style="font-size:20px; color:#5bc0de; cursor:pointer;"></i></a>',
							'<i class="fa fa-download file_download" style="font-size:20px; color:blue; cursor:pointer; padding:2px;" alt="'.urlencode($file).'" title="'.$LANG->FILE_DOWNLOAD.'"></i>',
							'<i class="fa fa-trash-o file_delete" style="font-size:20px; color:red; cursor:pointer;" alt="'.urlencode($file).'" title="'.$LANG->FILE_DELETE.'"></i>'
						);
						$i++;
					}
				}
				closedir($handle);
			}
		}

		$responce = json_encode($responce);
		
		if ($responce == '""') //if empty
			echo '{"rows":[]}';
		else 
			echo $responce;
			
	  break;


	case 'view': // SELECT 
	default: //view
		
		$responce = new stdClass();

		$wher = "WHERE 1 ";
		if (!$ADMIN) {
			$wher .= " AND uname = '".$USERNAME."' ";
		}

		$where = $wher . $where;
		//$sidx = str_replace('pos', 'pos*1', $sidx);
		//$rows = $db->fetch("SELECT * FROM users $where ORDER BY $sidx $sord LIMIT $start, $limit", array()); 
		$rows = $db->fetch("SELECT * FROM users $where ORDER BY id", array()); 
		$i=0;
		if ($db->numberRows() > 0)  {
			$responce = new stdClass();
			foreach ($rows as $row) {
				$responce->rows[$i] = $responce->rows[$i]['cell'] = array(
					'',
					$row['id'],
					//$row['account'],
					$row['uname'],
					'', //$row['passwd'],
					'', //repeat_pass,
					$row['location_id'],
					$row['group_id'],
					$row['firstname'],
					$row['lastname'],
					get_date_SQL($row['birth_date'].''),
					$row['sport'],
					$row['sex'],
					$row['body_height'],
					$row['email'],
					$row['telephone'],
					$row['status'],
					$row['level'],
					get_date_time_SQL($row['lastlogin'].''),
					$row['logincount'],
					$row['last_ip'],
					get_date_time_SQL($row['created'].''),
					get_date_time_SQL($row['modified'].''),
					'<div title="'.$LANG->RESULTS.'"'.
						' style="text-align:center;cursor:pointer;"'.
						' onmouseover="jQuery(this).addClass(\'ui-state-hover\');"'.
						' onmouseout="jQuery(this).removeClass(\'ui-state-hover\');">'.
							'<a href="results.php?athid='.$row['id'].'" target="_blank" style="display:inline-block;">'.
								'<span class="ui-icon ui-icon-image" style="float:left;"></span>'.
								'<span class="ui-icon ui-icon-extlink" style="float:left;"></span>'.
							'</a>'.
						'</div>'
				);
				$i++;
			}
		}

		$responce = json_encode($responce);
		
		if ($responce == '""') //if empty
			echo '{"rows":[]}';
		else 
			echo $responce;
			
	  break;
}
?>