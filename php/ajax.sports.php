<?php // Sports
if ($SEC_check != $CONFIG['SEC_Page_Secret']) exit;

switch ($action) {
	case 'add': // INSERT /////////////////////////////////////////////////////////////////
	case 'edit': // UPDATE /////////////////////////////////////////////////////////////////
		$values = array();			
		foreach ($_REQUEST as $key => $val) {
			$key = trim((string)$key); 
			$val = trim((string)$val); 
			switch($key) {
				case 'sport_group_id': 
				case 'name': 
				case 'status': 
					$values[$key] = $val;
				  break;
			}
		}		
				
		// Check if all fields are filled up
		if (trim($values['name']) == '') {
			echo $LANG->EMPTY_SPORT_NAME;
			exit;
		}

		$where_id = '';
		if ($id != 0) $where_id = "AND id != $id"; //if edit = have id
		$row = $db->fetchRow("SELECT * FROM sports WHERE name=? AND sport_group_id=? $where_id", array($values['name'], $values['sport_group_id']));
		if ($db->numberRows() > 0)  {
			echo $LANG->WARN_SPORT_EXIST;
		}
		else {
			// INSERT
			if ($action == 'add') {
				$values['modified'] = date("Y-m-d H:i:s");
				$values['created'] = date("Y-m-d H:i:s");
				
				$insert_id = $db->insert($values, "sports");
				
				echo check_insert_result($insert_id);
			}
			// UPDATE
			elseif ($action == 'edit') {
				$values['modified'] = date("Y-m-d H:i:s");
				
				$result = $db->update($values, "sports", "id=?", array($id));

				echo check_update_result($result);
			}
		}

	  break;
	  
	case 'del': // DELETE /////////////////////////////////////////////////////////////////
		
		//$row = $db->fetchRow("SELECT * FROM sports WHERE id=?", array($id));
		
		$result = $db->delete("sports", "id=?", array($id));
			
		echo check_delete_result($result);

	  break;
	  
	case 'sports_options': // SELECT /////////////////////////////////////////////////////////////////
		
		//Sports Select Options
		$ajax_options = true;
		$sports_options = get_Sports_Select_Options($ajax_options);
		echo $sports_options;
			
	  break;
	  
	case 'sports_options_grp': // SELECT /////////////////////////////////////////////////////////////////
		
		//Sports Select Options
		$SP_select = '<select id="SP_select" name="SP_select"><option value=""></option>';
		$SP_select .= get_Sports_Select_Options_By_Group();
		$SP_select .= '</select>';
		echo $SP_select;
			
	  break;
	  
	case 'view': // SELECT /////////////////////////////////////////////////////////////////
	default: //view
		
		$responce = new stdClass();
		$sidx = $sidx ?? '';
		$sord = $sord ?? '';
		$rows = $db->fetch("SELECT * FROM sports ORDER BY $sidx $sord", array()); 
		$i=0;
		if ($db->numberRows() > 0)  {
			foreach ($rows as $row) {
				$responce->rows[$i] = $responce->rows[$i]['cell'] = array(
					'',
					$row['id'],
					$row['sport_group_id'],
					$row['name'],
					$row['status'],
					get_date_time($row['created'].''),
					get_date_time($row['modified'].'')
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