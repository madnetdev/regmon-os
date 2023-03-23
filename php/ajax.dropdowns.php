<?php // ajax Dropdowns

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
				case 'options': 
				case 'for_forms': 
				case 'status': 
					$values[$key] = $val;
				  break;
			}
		}		
		
		$values['for_forms'] = isset($values['for_forms']) ? $values['for_forms'] : 0;

		// Check if all fields are filled up
		//if (trim($values['name']) == '') { echo $LANG->EMPTY_DROPDOWN_NAME; exit;} //check on client

		if (isset($ID)) {
			$values['idd'] = $ID;
		}
		
		if (isset($values['name'])) { //an einai parent
			$where_id = '';
			if ($id != 0) $where_id = "AND id != $id"; //if edit = have id
			$row = $db->fetchRow("SELECT * FROM dropdowns WHERE name=? $where_id", array($values['name']));
			if ($db->numberRows() > 0)  {
				echo $LANG->WARN_DROPDOWN_EXIST;
				exit;
			}
		}
		
		// INSERT 
		if ($action == 'add')
		{
			//Insert
			$values['can_del_edit'] = 1;
			$values['modified'] = get_date_time_SQL('now');
			$values['created'] = get_date_time_SQL('now');
			
			$insert_id = $db->insert($values, "dropdowns");
			
			echo check_insert_result($insert_id);
		}
		// UPDATE 
		elseif ($action == 'edit') 
		{
			$row = $db->fetchRow("SELECT can_del_edit FROM dropdowns WHERE id=?", array($id));
			if ($row['can_del_edit'] == 0) {
				echo $LANG->WARN_DROPDOWN_NOT_CHANGE; //Cannot change this
				exit;
			}
			$values['modified'] = get_date_time_SQL('now');
			
			$result = $db->update($values, "dropdowns", "id=?", array($id));

			echo check_update_result($result);
		}

	  break;
	  
	case 'del': // DELETE 
		
		$row = $db->fetchRow("SELECT * FROM dropdowns WHERE id=?", array($id));
		if ($db->numberRows() > 0)  {
			if ($row['can_del_edit'] == 0) {
				echo $LANG->WARN_DROPDOWN_NOT_DELETE; //'cannot delete this';
				exit;
			}
			
			$row2 = $db->fetchRow("SELECT * FROM dropdowns WHERE idd=?", array($id));
			if ($db->numberRows() > 0)  {
				echo str_replace('{OPTIONS_NUM}', $db->numberRows(), $LANG->WARN_DROPDOWN_DELETE); //'Cannot delete. Have 5 options'
			}
			else {
				$result = $db->delete("dropdowns", "id=?", array($id));
				echo check_delete_result($result);
			}
		}

	  break;


	case 'sport_groups': // SELECT 

		//Sports Groups Select Options
		$ajax_options = true;
		$sport_groups_options = get_Sport_Groups($ajax_options);
		echo $sport_groups_options;
		
	  break;

	case 'user_height': // SELECT 

		//Body_Height Select Options
		$body_height_selected = '';
		$ajax_options = true;
		$user_height_options = get_User_Height_Options($body_height_selected, $ajax_options);
		echo $user_height_options;
		
	  break;
	  
	case 'options': // SELECT 
		
		$responce = new stdClass();
		$sidx = $sidx ?? '';
		$sord = $sord ?? '';
		$rows = $db->fetch("SELECT * FROM dropdowns WHERE idd=? ORDER BY $sidx $sord", array($ID)); 
		$i=0;
		if ($db->numberRows() > 0)  {
			foreach ($rows as $row) {
				$responce->rows[$i] = $responce->rows[$i]['cell'] = array(
					'',
					$row['id'],
					$row['options'],
					$row['status'],
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
	  
	case 'view': // SELECT 
	default: //view
		
		$responce = new stdClass();
		$sidx = $sidx ?? '';
		$sord = $sord ?? '';
		$rows = $db->fetch("SELECT * FROM dropdowns WHERE name IS NOT NULL ORDER BY $sidx $sord", array()); 
		$i=0;
		if ($db->numberRows() > 0)  {
			foreach ($rows as $row) {
				$responce->rows[$i] = $responce->rows[$i]['cell'] = array(
					'',
					$row['id'],
					$row['name'],
					$row['for_forms'],
					$row['status'],
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