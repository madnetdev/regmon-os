<?php // General Functions

function get_Sport_Groups($ajax_options=false) {
	global $db;
	$sport_groups = array();
	$sport_groups_ajax_options = '0:'; 
	$rows = $db->fetch("SELECT o.id, o.options 
FROM dropdowns d 
LEFT JOIN dropdowns o ON o.idd = d.id 
WHERE d.name='Sport_Groups' AND o.status=1 ORDER BY o.options", array());
	if ($db->numberRows() > 0) {
		foreach ($rows as $row) {
			$sport_groups[$row['id']] = $row['options'];
			$sport_groups_ajax_options .=  ';' . $row['id'].':'.addslashes($row['options']);
		}
	}
	if ($ajax_options) return $sport_groups_ajax_options;
	return $sport_groups;
}

function get_Sports_Select_Options($ajax_options = false) {
	global $db;
	//Sports Select Options
	$sports_options = '';
	$sports_ajax_options = ': '; 
	$rows = $db->fetch("SELECT name FROM sports WHERE status = 1 ORDER BY name", array()); 
	if ($db->numberRows() > 0)  {
		foreach ($rows as $row) {
			$sports_options .= '<option value="'.$row['name'].'">'.$row['name'].'</option>';
			$sports_ajax_options .=  ';' . $row['name'].':'.addslashes($row['name']);
		}
	}
	if ($ajax_options) return $sports_ajax_options;
	return $sports_options;
}

function get_Sports_Select_Options_By_Group($sport_selected = '') {
	global $db;
	//Sports Groups
	$sports_groups = get_Sport_Groups();

	//Sports Select Options
	$SP_select_options_grp = '';
	$SP_select_options = '';
	$rows = $db->fetch("SELECT id, name, sport_group_id FROM sports WHERE status = 1 ORDER BY sport_group_id, name", array()); 
	if ($db->numberRows() > 0)  {
		$SP_open_group = false;
		$SP_group = '';
		$SP_group_tmp = '';
		$sport_arr = explode(',', $sport_selected);
		foreach ($rows as $row) {
		
			$t_selected = '';
			if (in_array($row['name'], $sport_arr)) $t_selected = ' selected'; //mark selected
			
			if (isset($sports_groups[$row['sport_group_id']])) {
				$SP_group = $sports_groups[$row['sport_group_id']];
			}
			
			//Group
			if ($SP_group <> $SP_group_tmp) {
				if ($SP_open_group) {
					$SP_select_options_grp .= '</optgroup>';
				}
				$SP_select_options_grp .= '<optgroup label="'.$SP_group.'">';
				$SP_open_group = true;
			}
			
			//option
			if ($SP_group == '') {
				$SP_select_options .= '<option value="'.$row['name'].'"'.$t_selected.'>'.$row['name'].'</option>';
			} else {
				$SP_select_options_grp .= '<option value="'.$row['name'].'"'.$t_selected.'>'.$row['name'].'</option>';
			}
			
			$SP_group_tmp = $SP_group;
		}
		if ($SP_open_group) {
			$SP_select_options_grp .= '</optgroup>';
		}
	}
	$SP_select_options = $SP_select_options_grp . $SP_select_options;

	return $SP_select_options;
}

function get_User_Height_Options($body_height_selected = '', $ajax_options = false) {
	global $db;
	//Body Height Select Options //Body_Height
	$user_height_options = ''; 
	$user_height_ajax_options = '0:'; 
	$rows = $db->fetch("SELECT o.id, o.options 
FROM dropdowns d 
LEFT JOIN dropdowns o ON o.idd = d.id 
WHERE d.name='Body_Height' AND o.status=1 ORDER BY o.options", array()); 
	if ($db->numberRows() > 0)  {
		foreach ($rows as $row) {
			//RangeOfValues(100->250) cm //range of values
			if (substr_count($row['options'], 'RangeOfValues') != 0) {
				$tmp1 = explode('(', $row['options']??'');
				$tmp2 = explode(')', $tmp1[1]??'');
				$range = explode('->',$tmp2[0]??'');
				$unit = $tmp2[1];
				for ($i = $range[0]; $i <= $range[1]; $i++) {
					$t_selected = '';
					if ($i.$unit == $body_height_selected) $t_selected = ' selected'; //mark selected
					$user_height_options .=  '<option value="'.$i.$unit.'"'.$t_selected.'>'.$i.$unit.'</option>';
					$user_height_ajax_options .=  ';'. $i.$unit .':'. $i.$unit;
				}
			}
			else {
				$t_selected = '';
				if ($row['options'] == $body_height_selected) $t_selected = ' selected'; //mark selected
				$user_height_options .=  '<option value="'.$row['options'].'"'.$t_selected.'>'.$row['options'].'</option>';
				$user_height_ajax_options .=  ';'. addslashes($row['options']) .':'. addslashes($row['options']);
			}
		}
	}
	if ($ajax_options) return $user_height_ajax_options;
	return $user_height_options;
}




?>
