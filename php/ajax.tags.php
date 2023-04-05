<?php // ajax Tags

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
					$values[$key] = $val;
				  break;
			}
		}		
				
		// Check if all fields are filled up
		if (trim($values['name']) == '') {
			echo $LANG->EMPTY_TAG_NAME;
			exit;
		}

		$where_id = '';
		if ($id != 0) {
			$where_id = "AND id != " . ((int)$id); //if edit = have id
		}
		$row = $db->fetchRow("SELECT * FROM tags WHERE name=? $where_id", array($values['name']));
		if ($db->numberRows() > 0)  {
			echo $LANG->WARN_TAG_EXIST;
		}
		else {
			// INSERT
			if ($action == 'add') {
				$values['modified'] = get_date_time_SQL('now');
				$values['modified_by'] = $USERNAME;
				$values['created'] = get_date_time_SQL('now');
				$values['created_by'] = $USERNAME;
				
				$insert_id = $db->insert($values, "tags");
				
				echo check_insert_result($insert_id);
			}
			// UPDATE
			elseif ($action == 'edit') {
				$values['modified'] = get_date_time_SQL('now');
				$values['modified_by'] = $USERNAME;
				
				$result = $db->update($values, "tags", "id=?", array($id));

				echo check_update_result($result);
			}
		}

	  break;
	  

	case 'del': // DELETE 
		
		//TODO: what if any forms has already selected this tag ??? @@@@@@@@

		$result = $db->delete("tag", "id=?", array($id));
			
		echo check_delete_result($result);

	  break;
	  

	case 'get_tags_select': // SELECT - Get Tags 
		
		$options = '<select>'; 
		$rows = $db->fetch("SELECT name FROM tags ORDER BY name", array()); 
		if ($db->numberRows() > 0)  {
			foreach ($rows as $row) {
				$options .= '<option value="'.addslashes($row['name']).'">'.addslashes($row['name']).'</option>';
			}
		}
		$options .= '</select>'; 
		
		echo $options;
		
	  break;
	  

	case 'view': // SELECT 
	default: //view
		
		$responce = new stdClass();
		$rows = $db->fetch("SELECT * FROM tags ORDER BY name", array()); 
		$i=0;
		if ($db->numberRows() > 0)  {
			foreach ($rows as $row) {
				$responce->rows[$i] = $responce->rows[$i]['cell'] = array(
					'',
					$row['id'],
					$row['name'],
					$row['status'],
					get_date_time_SQL($row['created'].''),
					$row['created_by'],
					get_date_time_SQL($row['modified'].''),
					$row['modified_by']
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