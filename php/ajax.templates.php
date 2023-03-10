<?php // Templates
if ($SEC_check != $CONFIG['SEC_Page_Secret']) exit;

switch ($action) {
	case 'add': // INSERT /////////////////////////////////////////////////////////////////
	case 'edit': // UPDATE /////////////////////////////////////////////////////////////////
		$template = isset($_REQUEST['template']) ? $_REQUEST['template'] : false;
		$is_axis = '0';
			if ($template == 'forms_templates') $is_axis = '0';
		elseif ($template == 'templates2') $is_axis = '3';
		elseif ($template == 'axis') $is_axis = '1';
		
		$values = array();
		$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : '0';
		$values['user_id'] = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '0';
		$values['location_id'] = isset($_REQUEST['location_id']) ? $_REQUEST['location_id'] : '0';
		$values['group_id'] = isset($_REQUEST['group_id']) ? $_REQUEST['group_id'] : '0';
		$values['form_id'] = isset($_REQUEST['form_id']) ? $_REQUEST['form_id'] : '0';
		$values['name'] = isset($_REQUEST['templatename']) ? $_REQUEST['templatename'] : '';
		$values['GlobalView'] = isset($_REQUEST['GlobalView']) ? ($_REQUEST['GlobalView']=='Ja'?'1':'0') : '1';
		$values['GlobalEdit'] = isset($_REQUEST['GlobalEdit']) ? ($_REQUEST['GlobalEdit']=='Ja'?'1':'0') : '0';
		$values['LocationView'] = isset($_REQUEST['LocationView']) ? ($_REQUEST['LocationView']=='Ja'?'1':'0') : '1';
		$values['LocationEdit'] = isset($_REQUEST['LocationEdit']) ? ($_REQUEST['LocationEdit']=='Ja'?'1':'0') : '0';
		$values['GroupView'] = isset($_REQUEST['GroupView']) ? ($_REQUEST['GroupView']=='Ja'?'1':'0') : '1';
		$values['GroupEdit'] = isset($_REQUEST['GroupEdit']) ? ($_REQUEST['GroupEdit']=='Ja'?'1':'0') : '0';
		$values['TrainerView'] = isset($_REQUEST['TrainerView']) ? ($_REQUEST['TrainerView']=='Ja'?'1':'0') : '1';
		$values['TrainerEdit'] = isset($_REQUEST['TrainerEdit']) ? ($_REQUEST['TrainerEdit']=='Ja'?'1':'0') : '0';
		$values['Private'] = isset($_REQUEST['Private']) ? ($_REQUEST['Private']=='Ja'?'1':'0') : '0';
		$values['is_axis'] = $is_axis;
		$update = $db->update($values, "graphs", "id=?", array($id));
		
		echo check_update_result($update);
		
	  break;
	
	case 'del': // DELETE /////////////////////////////////////////////////////////////////

	  break;

	case 'template_duplicate': // Duplicate Template //////////////////////////////////////////////////////////////
		
		$row = $db->fetchRow("SELECT * FROM graphs WHERE id = ?", array($ID));
		if ($db->numberRows() > 0)  {
			unset($row['id']);
			$row['name'] .= '_kopie';
			$row['modified'] = date("Y-m-d H:i:s");
			$row['modified_by'] = $USERNAME;
			$row['created'] = date("Y-m-d H:i:s");
			$row['created_by'] = $USERNAME;
			
			$insert_id = $db->insert($row, "graphs");
			
			echo check_insert_result($insert_id);
		}
		
	  break;
	  

	case 'forms_templates': // SELECT /////////////////////////////////////////////////////////////////
		if ($where != '') $where = ' WHERE 1 ' .$where;
		$responce = new stdClass();
		$forms = $db->fetchAllwithKey("SELECT id, name, name2, status FROM forms f $where ORDER BY id", array() ,'id');
		//echo "<pre>";print_r($forms);exit;

		$saves = $db->fetchAllwithKey("SELECT id, user_id, location_id, group_id, form_id, name, GlobalView, GlobalEdit, LocationView, LocationEdit, GroupView, GroupEdit, TrainerView, TrainerEdit, Private, created, created_by, modified, modified_by FROM graphs WHERE is_axis=0 ORDER BY form_id, name", array(), 'id'); //fetchAllwithKey2,'form_id', 'id'
		$i=0;
		if ($db->numberRows() > 0)  {
			foreach ($saves as $save) {
				$responce->rows[$i] = $responce->rows[$i]['cell'] = array(
					'',
					$save['id'],
					$save['form_id'],
					(isset($forms[$save['form_id']]) ? $forms[$save['form_id']]['name'].' ('.$forms[$save['form_id']]['name2'].')' :''),
					(isset($forms[$save['form_id']]) ? $forms[$save['form_id']]['status'] :'0'),
					$save['name'],
					$save['user_id'],
					$save['location_id'],
					$save['group_id'],
					$save['GlobalView'],
					$save['GlobalEdit'],
					$save['LocationView'],
					$save['LocationEdit'],
					$save['GroupView'],
					$save['GroupEdit'],
					$save['TrainerView'],
					$save['TrainerEdit'],
					$save['Private'],
					$save['created'],
					$save['created_by'],
					$save['modified'],
					$save['modified_by']
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
	  
	  
	case 'templates2': // SELECT /////////////////////////////////////////////////////////////////
		
		$responce = new stdClass();
		$saves3 = $db->fetchAllwithKey("SELECT id, user_id, location_id, group_id, form_id, name, GlobalView, GlobalEdit, LocationView, LocationEdit, GroupView, GroupEdit, TrainerView, TrainerEdit, Private, created, created_by, modified, modified_by FROM graphs WHERE is_axis=3 ORDER BY form_id, name", array(), 'id'); 
		$i=0;
		if ($db->numberRows() > 0)  {
			foreach ($saves3 as $save) {
				$responce->rows[$i] = $responce->rows[$i]['cell'] = array(
					'',
					$save['id'],
					$save['name'],
					$save['user_id'],
					$save['location_id'],
					$save['group_id'],
					$save['GlobalView'],
					$save['GlobalEdit'],
					$save['LocationView'],
					$save['LocationEdit'],
					$save['GroupView'],
					$save['GroupEdit'],
					$save['TrainerView'],
					$save['TrainerEdit'],
					$save['Private'],
					$save['created'],
					$save['created_by'],
					$save['modified'],
					$save['modified_by']
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

	case 'axis': // SELECT /////////////////////////////////////////////////////////////////
		
		$responce = new stdClass();
		$axis = $db->fetchAllwithKey("SELECT id, user_id, location_id, group_id, form_id, name, GlobalView, GlobalEdit, LocationView, LocationEdit, GroupView, GroupEdit, TrainerView, TrainerEdit, Private, created, created_by, modified, modified_by FROM graphs WHERE is_axis=1 ORDER BY name", array(), 'id'); 
		$i=0;
		if ($db->numberRows() > 0)  {
			foreach ($axis as $save) {
				$responce->rows[$i] = $responce->rows[$i]['cell'] = array(
					'',
					$save['id'],
					$save['name'],
					$save['user_id'],
					$save['location_id'],
					$save['group_id'],
					$save['GlobalView'],
					$save['GlobalEdit'],
					$save['LocationView'],
					$save['LocationEdit'],
					$save['GroupView'],
					$save['GroupEdit'],
					$save['TrainerView'],
					$save['TrainerEdit'],
					$save['Private'],
					$save['created'],
					$save['created_by'],
					$save['modified'],
					$save['modified_by']
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