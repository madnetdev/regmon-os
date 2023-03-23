<?php // ajax Locations

if ($SEC_check != $CONFIG['SEC_Page_Secret']) exit;

switch ($action) {
	case 'add': // INSERT 
	case 'edit': // UPDATE 
		$values = array();			
		foreach ($_REQUEST as $key => $val) {
			$key = trim((string)$key); 
			$val = trim((string)$val); 
			switch($key) {
				case 'name': 
				case 'status': 
				case 'admin_id': 
					$values[$key] = $val;
				  break;
			}
		}		
		
		// Check if all fields are filled up
		if (trim($values['name']) == '') {
			echo $LANG->EMPTY_LOCATION_NAME;
			exit;
		}

		//check admin user
		if (!$ADMIN) {
			//this may not needed because only admins can have access
			//Location Admin
			$admin = $db->fetchRow("SELECT u.id, u.lastname FROM users u
					LEFT JOIN locations s ON u.id = s.admin_id
					WHERE s.id = ? AND u.level = 50 AND u.id = ?", array($id, $UID)); 
			if (!$db->numberRows() > 0)  {
				echo $LANG->NEED_ADMIN_RIGHTS;
				exit; //no admin user
			}
		}
		
		$where_id = '';
		if ($id != 0) $where_id = "AND id != $id"; //if edit = have id
		$row = $db->fetchRow("SELECT * FROM locations WHERE name=? $where_id", array($values['name']));
		if ($db->numberRows() > 0)  {
			echo $LANG->WARN_LOCATION_EXIST;
		}
		else 
		{
			// INSERT 
			if ($action == 'add')
			{
				//Insert
				$values['modified'] = get_date_time_SQL('now');
				$values['created'] = get_date_time_SQL('now');
				
				$insert_id = $db->insert($values, "locations");
				
				echo check_insert_result($insert_id);
			}
			// UPDATE 
			elseif ($action == 'edit')
			{
				$values['modified'] = get_date_time_SQL('now');
				
				$result = $db->update($values, "locations", "id=?", array($id));

				echo check_update_result($result);
			}
		}

	  break;
	  
	case 'del': // DELETE 
		
		//check admin user
		if (!$ADMIN) {
			//Location Admin
			$admin = $db->fetchRow("SELECT u.id, u.lastname FROM users u
					LEFT JOIN locations s ON u.id = s.admin_id
					WHERE s.id = ? AND u.level = 50 AND u.id = ?", array($id, $UID)); 
			if (!$db->numberRows() > 0)  {
				echo $LANG->NEED_ADMIN_RIGHTS;
				exit; //no admin user
			}
		}

		//TODO: what if Location has Groups ???? need work here @@@@@@@@@@@

		/*
		$row = $db->fetchRow("SELECT * FROM locations WHERE id=?", array($id));
		
		$result = $db->delete("locations", "id=?", array($id));
			
		echo check_delete_result($result);
		*/

	  break;
	  
	case 'location_admins': // SELECT 
		
		//Admin Select Options
		$admins_options = ':'; 
		$rows = $db->fetch("SELECT id, uname FROM users WHERE status = 1 AND level = 50 ORDER BY id", array()); 
		if ($db->numberRows() > 0)  {
			foreach ($rows as $row) {
				$admins_options .=  ';' . $row['id'].':'.addslashes($row['uname']);
			}
		}

		echo $admins_options;
			
	  break;
	  
	case 'location_options': // SELECT 
		
		//Location Select Options
		$location_options = ':'; 
		$stnd = $db->fetch("SELECT id, name FROM locations WHERE status = 1 ORDER BY name", array()); 
		if ($db->numberRows() > 0)  {
			foreach ($stnd as $stn) {
				$location_options .=  ';' . $stn['id'].':'.addslashes($stn['name']);
			}
		}
		
		echo $location_options;
			
	  break;
	  
	case 'view': // SELECT 
	default: //view
		
		$responce = new stdClass();
		$sidx = $sidx ?? '';
		$sord = $sord ?? '';
		$order = '';
		if (trim($sidx) != '') {
			$order = "ORDER BY $sidx $sord";
		}
		$rows = $db->fetch("SELECT * FROM locations $order", array());
		$i=0;
		if ($db->numberRows() > 0)  {
			foreach ($rows as $row) {
				$responce->rows[$i] = $responce->rows[$i]['cell'] = array(
					'',
					$row['id'],
					$row['name'],
					$row['status'],
					$row['admin_id'],
					get_date_time_SQL($row['created'].''),
					get_date_time_SQL($row['modified'].'')
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