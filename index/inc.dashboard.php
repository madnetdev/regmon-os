<?php // inc Dashboard links

//Forms
//we get forms from the ajax.forms_menu.php


//get forms_data counts & sql filters for forms that have data
$where_forms = '';
// get Forms with forms_data
$Forms_with_Forms_Data_arr = get_Forms_with_Forms_Data_count_array($UID);
if (count($Forms_with_Forms_Data_arr)) {
	$where_forms = implode(',', array_keys($Forms_with_Forms_Data_arr));
} else {
	$where_forms = '0';
}
$where_forms = "AND t.form_id IN (".$where_forms.")";


//get Results Templates options --template_type=0
$dash_saves_options = '';
//can see all at the moment
$saves = $db->fetchAllwithKey2("SELECT t.id, t.form_id, t.name, f.name AS form_name 
FROM templates t 
LEFT JOIN forms f ON f.id = t.form_id 
WHERE t.template_type=0 $where_forms 
ORDER BY t.form_id, t.name", array(), 'form_id', 'id'); 
if ($db->numberRows() > 0) {
	foreach ($saves as $fid => $save_id) {
		$saves_tmp = '';
		foreach ($save_id as $save_id => $save) {
			$saves_tmp .= '<option value="'.$save['form_id'].'__'.$save_id.'">'.htmlspecialchars($save['name']).'</option>';
		}
		$dash_saves_options .= '<optgroup label="'.htmlspecialchars($save['form_name']).'">'.$saves_tmp.'</optgroup>';
	}
}


//get Results Group Templates options --template_type=2
$dash_saves2_options = '';
//can see all at the moment
$saves2 = $db->fetchAllwithKey("SELECT id, name 
FROM templates 
WHERE template_type=2 
ORDER BY form_id, name", array(), 'id'); 
if ($db->numberRows() > 0) {
	foreach ($saves2 as $save_id => $save) {
		$dash_saves2_options .= '<option value="'.$save_id.'">'.htmlspecialchars($save['name']).'</option>';
	}
}


$Dashboard_Links_Arr = get_Dashboard_Links_Array($UID, $GROUP);
?>

<div id="dashboard_div" class="dashboard_nav" style="width:0px; height:0px;">
	<a href="javascript:void(0)" class="closebtn" onclick="closeDashboard()"title="Dashboard schließen">&times;</a>
	<div style="margin:15px 0 15px 0;">
		<div style="float:left; margin-top:25px; margin-bottom:-10px; margin-right:-152px;">
			<label style="vertical-align:text-bottom; font-weight:600;">
				<i><?=$LANG->DASHBOARD_ON_LOGIN;?>:&nbsp;&nbsp;</i>
				<input type="checkbox" id="open_dashboard_onlogin" style="vertical-align:text-bottom;"<?=($USER["dashboard"]=='1'?' checked':'');?>>
			</label>
		</div>		
		<button type="button" id="add_dashboard" class="bttn" style="padding:7px 10px;" data-dash="|||||" data-dash_options="__"><i class="fa fa-plus-circle" style="font-size:16px;"></i>&nbsp; <?=$LANG->DASHBOARD_NEW_LINK;?></button>
		<button type="button" id="add_dashboard_notext" class="bttn" title="<?=$LANG->DASHBOARD_NEW_LINK;?>" style="padding:7px 10px;" data-dash_options="_"><i class="fa fa-plus-circle" style="font-size:16px;"></i></button>
	</div>
	<nav id="dashboard" class="navv"></nav>
	<div id="dashboard_script" style="display:none;">
		<script>
			V_DASHBOARD=[<?=$Dashboard_Links_Arr;?>];
		</script>
	</div>
</div>
<div id="ssb-container" class="ssb-btns-left ssb-anim-slide" style="z-index:999; left:-9px; top:-4px;">
	<ul><li id="dashboard_link" title="Dashboard"><span class="fa fa-th"></span>&nbsp;</li></ul>
</div>
<script>
V_SAVED_DATA_OPTIONS=<?="'".$dash_saves_options."'";?>;
V_SAVED_DATA2_OPTIONS=<?="'".$dash_saves2_options."'";?>;
</script>