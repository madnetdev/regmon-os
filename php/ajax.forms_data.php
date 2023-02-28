<?php //////////////////////// forms_data
if ($SEC_check != $CONFIG['SEC_Page_Secret']) exit;

switch ($action) {
	/*
	case 'add': // INSERT /////////////////////////////////////////////////////////////////
	case 'edit': // UPDATE /////////////////////////////////////////////////////////////////
	  break;
	*/

	case 'del': // DELETE /////////////////////////////////////////////////////////////////
		
		if ($ADMIN) { //delete all forms_data data
			$result = $db->delete("forms_data", "form_id=?", array($ID));
			echo check_delete_result($result);
		}
		
	  break;

	case 'status': // STATUS /////////////////////////////////////////////////////////////////
		
		$status = isset($_REQUEST['status']) ? (int)$_REQUEST['status'] : 0;
		
		$values['status'] = $status;
		
		$result = $db->update($values, "forms_data", "id=?", array($ID));

		//echo check_update_result($result);
		
	  break;
	  
	case 'cal_count': //get count
	case 'cal': // SELECT /////////////////////////////////////////////////////////////////
		
		$responce = array();
		
		$group_id = isset($_REQUEST['group_id']) ? (int)$_REQUEST['group_id'] : 0;
		$start = isset($_REQUEST['start']) ? date('Y-m-d 00:00:00', strtotime($_REQUEST['start'])) : date('Y-m-d', strtotime("-1 week"));
		$end = isset($_REQUEST['end']) ?  date('Y-m-d 23:59:59', strtotime($_REQUEST['end'])) : date('Y-m-d');
		
		$trainer_view = false;
		$where_trainer = '';
		$trainer_read_arr = array();
		$trainer_write_arr = array();
		$athlete_id = $ID ?? 0; //for php int
		
		if ($TRAINER) {
			if ($athlete_id == '-1') {
				$athlete_id = $UID; //self as athlete-trainer
			}
			if ($ID == '-1' OR $athlete_id != $UID) { //athlete-trainer
				$trainer_id = $UID ?? 0; //for php int
				$trainer_view = true;
				
				//Users2Trainers //get trainer selected Forms
				$trainer_forms_selected_r_str = '';
				$trainer_forms_selected_w_str = '';
				$row = $db->fetchRow("SELECT forms_select_r, forms_select_w FROM users2trainers WHERE user_id = ? AND group_id = ? AND trainer_id = ?", array($athlete_id, $group_id, $trainer_id)); 
				if ($db->numberRows() > 0) {
					if ($row['forms_select_r'] != '') {
						$trainer_read_arr = explode(',', $row['forms_select_r']);
						$trainer_forms_selected_r_str = "'".implode("','", $trainer_read_arr)."'"; //we have 13_1 so need to make '13_1'
					}
					if ($row['forms_select_w'] != '') {
						$trainer_write_arr = explode(',', $row['forms_select_w']);
						$trainer_forms_selected_w_str = "'".implode("','", $trainer_write_arr)."'";
					}
				}
				if ($trainer_forms_selected_r_str == '') $trainer_forms_selected_r_str = '0';
				if ($trainer_forms_selected_w_str == '') $trainer_forms_selected_w_str = '0';
				$where_trainer = " AND CONCAT(category_id,'_',form_id) IN (".$trainer_forms_selected_r_str.") ";
			}
		}
		
		if ($action != 'cal_count') {
			$cats_color = $db->fetchAllwithKey("SELECT id, color FROM categories ORDER BY id", array(), 'id'); //WHERE status != 0
			$forms_names = $db->fetchAllwithKey("SELECT id, name FROM forms ORDER BY id", array(), 'id'); 
			//TODO: @@@@@@@ WHERE status != 0 //we need this for all forms queries

			
			//$where = " WHERE user_id = '$ID' AND group_id = '$group_id' AND created BETWEEN '$start' AND '$end'";
			//we need the selected Athlete and not the trainer or admin
			$where = " WHERE user_id = '$athlete_id' AND group_id = '$group_id' AND form_id > 0 AND created BETWEEN '$start' AND '$end'";

			//forms_data
			$rows = $db->fetch("SELECT * FROM forms_data $where $where_trainer AND status != -1 ORDER BY created", array()); 
			$i=0;
			if ($db->numberRows() > 0)  {
				foreach ($rows as $row) {
					$sec = '';
					if ($trainer_view) {
						$sec = '&sec='.MD5($CONFIG['SEC_Encrypt_Secret'] . $row['form_id'] . $athlete_id . $group_id . $UID);
					}
					$date_time_end = date("Y-m-d H:i:s", (strtotime($row['created']) + (60*60))); //new +60mins
					if ($row['created_end'] != '' AND $row['created'] != $row['created_end']) { //if we have created_end
						$date_time_end = $row['created_end'];
					}
					$responce[$i] = $responce[$i]['cell'] = array(
						"id" => $row['id'],
						"title" => $forms_names[$row['form_id']]['name'],
						"start" => $row['created'],
						"end" => $date_time_end,
						"status" => $row['status'],
						"color" => $cats_color[$row['category_id']]['color'],
						"msg" => ''
						//.'<span style="white-space:nowrap;">'.$LANG->CREATED.': <b>'.$row['created'].'</b><br>'.$LANG->MODIFIED.': <b>'.$row['modified'].'</b></span>'
						.'<div style="text-align:center; font-size:0.9em; margin:0 5px;">'.
							//deactivate srv
							'<button id="forms_data_deactivate_'.$row['id'].'" type="button" class="bttn" style="padding:3px 10px; width:190px;">'.$LANG->DEACTIVATE_RECORD.' &nbsp; <i class="fa fa-eye-slash" style="font-size:16px;"></i></button>'.
							//activate srv
							'<button id="forms_data_activate_'.$row['id'].'" type="button" class="bttn" style="padding:3px 10px; width:190px;">'.$LANG->ACTIVATE_RECORD.' &nbsp; <i class="fa fa-eye" style="font-size:16px;"></i></button>'.
/* disable for now @@@@@@@@@@@@@
							//edit form ////////////////////////an mporei
							(($athlete_id == $UID OR ($trainer_view AND in_array($row['category_id'].'_'.$row['form_id'],$trainer_write_arr)))?
								'<br><button id="Cal_Edit_'.$row['id'].'" type="button" class="bttn fancybox fancybox.iframe" href="form.php?change=true&id='.$row['form_id'].'&cid='.$row['category_id'].'&fdata_id='.$row['id'].'&gid='.$row['group_id'].'&sid='.$athlete_id.'" style="margin-top:10px; padding:3px 10px; width:190px;">'.$LANG->EDIT_RECORD.'&nbsp; &nbsp;<i class="fa fa-edit" style="font-size:16px;"></i></button>'
							:'').
							//view form
							'<br><button id="Cal_Res_'.$row['id'].'" type="button" class="bttn fancybox fancybox.iframe" href="form.php?view=true&id='.$row['form_id'].'&cid='.$row['category_id'].'&fdata_id='.$row['id'].'&gid='.$row['group_id'].'&sid='.$athlete_id.'" style="margin-top:10px; padding:3px 10px; width:190px;">'.$LANG->VIEW_RECORD.' &nbsp; &nbsp;<i class="fa fa-bar-chart fa-rotate-90" style="font-size:14px;"></i></button>'.
							//view results
							'<br><button id="Cal_Res_Sub_'.$row['id'].'" type="button"  class="bttn fancybox fancybox.iframe" href="results.php?sid='.$athlete_id.'&id='.$row['form_id'].'&cat_id='.$row['category_id'].'&timestamp='.(strtotime($row['created']) + 30*60).'&iframe'.$sec.'" style="margin-top:10px; padding:3px 10px; width:190px;">'.$LANG->VIEW_RESULTS.' &nbsp; &nbsp;<i class="fa fa-bar-chart" style="font-size:16px;"></i></button>'.
							//delete form.save ////////////////////////an mporei
							(($athlete_id == $UID OR ($trainer_view AND in_array($row['category_id'].'_'.$row['form_id'],$trainer_write_arr)))?
								'<br><button id="Cal_Res_Del_'.$row['id'].'" type="button" class="bttnR" style="margin-top:10px; padding:3px 10px; width:190px;">'.$LANG->DELETE_RECORD.' &nbsp; <i class="fa fa-trash-o" style="font-size:16px;"></i></button>'
							:'').
*/
						'</div>'
					);
					$i++;
				}
			}

			//comments in calendar
			if ($athlete_id == $UID OR $UID=='1' OR $UID=='2' OR ($trainer_view AND (in_array('Notiz_n', $trainer_read_arr)))) {
				$rows = $db->fetch("SELECT * FROM comments WHERE user_id = ? AND group_id = ? ORDER BY created", array($athlete_id, $group_id));
				if ($db->numberRows() > 0)  {
					foreach ($rows as $row) {
						//FIXES //////////////////////////////////////////////////
						//calendar want full day if allDay:true --if same date and diff times not show in calendar
						$start = date("Y-m-d H:i:s", strtotime($row['created']));
						$end = date("Y-m-d H:i:s", strtotime($row['created_end']));
						if ($row['isAllDay']=='1') {
							//$start_tmp = explode(' ', $start);
							//$start = $start_tmp[0]; //only date in allDay --with time not work
							if ($row['created_end'] == '') { //if we not have created_end --old comments
								$end_tmp = explode(' ', $row['created']);
								$end = $end_tmp[0].' 23:59:59'; //only date in allDay --with time not work
							} 
							/*else {
								$end_tmp = explode(' ', $row['created_end']);
								$end = $end_tmp[0];//.' 23:59:59'; //only date in allDay --with time not work
							}*/
							$end = date("Y-m-d H:i:s", strtotime($row['created_end']) + 1); //end + 1sec bcz is 23:59:59
						}
						else {
							if ($row['created_end'] == '') { //if we not have created_end --old comments
								$end = date("Y-m-d H:i:s", (strtotime($row['created']) + (60*60))); //new +60mins
							}
						}
						//FIXES //////////////////////////////////////////////////
						
						$responce[$i] = $responce[$i]['cell'] = array(
							"id" => -$row['id'], //need to have different id than normal events so no conflic
							"title" => $row['name'],
							"start" => $start,
							"end" => $end,
							"color" => (($row['color']!='' AND str_replace(' ', '', $row['color'])!='rgba(238,238,238,0.5)')?$row['color']:'#aaaaaa'),//'#aaaaaa',
							"color2" => ($row['color']!=''?$row['color']:'#aaaaaa'),
							"allDay"=> $row['isAllDay']=='1'?true:false,
							"showInGraph"=> $row['showInGraph']=='1'?true:false,
							"text" => $row['comments'],
							"msg" => '<span>'.$row['comments'].'</span>'.
								(($athlete_id == $UID OR ($trainer_view AND in_array('Notiz_n', $trainer_write_arr)))?
									'<div class="clearfix"></div>'.
									'<div style="text-align:center; margin-top:10px;">'.
										'<button type="button" id="comment_delete" class="delete" style="margin:5px; padding:5px 30px 5px 10px; font-size:12.6px;">'.$LANG->DELETE.'</button>'.
										'<button type="button" id="comment_edit" class="edit" style="margin:5px; padding:5px 30px 5px 10px; font-size:12.6px;">'.$LANG->EDIT.'</button>'.
									'</div>'
								:'')
						);
						$i++;
					}
				}
			}
			
			$responce = json_encode($responce);
			
			if ($responce == '""') //if empty
				echo '[]';
			else 
				echo $responce;
		
		} //$action != 'cal_count'
		else { //cal_count
			$where = " WHERE user_id = '$athlete_id' AND group_id = '$group_id' AND form_id > 0";
			//forms_data
			$row_forms = $db->fetchRow("SELECT COUNT(*) AS data_num FROM forms_data $where $where_trainer AND status = 1 ORDER BY created", array()); 
			//comments in calendar
			$row_comm = $db->fetchRow("SELECT COUNT(*) AS comm_num FROM comments WHERE user_id = ? AND group_id = ? ORDER BY created", array($athlete_id, $group_id));
			echo ($row_forms['data_num'] + $row_comm['comm_num']);
		}
		
	  break;
	  
	case 'view': // SELECT /////////////////////////////////////////////////////////////////
	default: //view
		
		$responce = new stdClass();
		$sidx = $sidx ?? '';
		$sord = $sord ?? '';
		$group_id = isset($_REQUEST['group_id']) ? (int)$_REQUEST['group_id'] : 0;
		
		$wher = "WHERE user_id = '".$ID."' AND group_id = '".$group_id."' AND form_id > 0 ";

		$where = $wher . $where;
		//$sidx = str_replace('pos', 'pos*1', $sidx);
		$rows = $db->fetch("SELECT * FROM forms_data $where AND status = 1 ORDER BY $sidx $sord", array()); 
		$i=0;
		if ($db->numberRows() > 0)  {
			foreach ($rows as $row) {
				$responce->rows[$i] = $responce->rows[$i]['cell'] = array(
					//'',
					$row['id'],
					$row['user_id'],
					$row['type'],
					$row['group_id'],
					//$row['results_json'],
					get_date_time($row['created'].''),
					get_date_time($row['modified'].''),
					''
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