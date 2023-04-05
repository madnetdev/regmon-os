<?php // inc Dashboard links

//Forms
//we get forms from the ajax.forms_menu.php

//get forms_data counts & sql filters for forms that have data
$where_forms = "AND g.form_id IN (";
$forms_data_done = array();
$forms_data = $db->fetch("SELECT COUNT(*) AS count, form_id FROM forms_data WHERE user_id=? AND form_id > 0 AND status = 1 GROUP BY form_id", array($UID)); 
if ($db->numberRows() > 0)  {
	$i = 0;
	foreach ($forms_data as $form_data) {
		if ($form_data['count'] != '0') {
			$forms_data_done[$form_data['form_id']] = $form_data['count'];
			if ($i != 0) $where_forms .= ',';
			$where_forms .= $form_data['form_id'];
			$i++;
		}
	}
} else {
	$where_forms .= "'0'";
}
$where_forms .= ")";


//Results Templates
$dash_saves_options = '';
//can see all at the moment
$saves = $db->fetchAllwithKey2("SELECT g.id, g.form_id, g.name, f.name AS form_name 
FROM templates g 
LEFT JOIN forms f ON f.id = g.form_id 
WHERE g.template_type=0 $where_forms ORDER BY g.form_id, g.name", array(), 'form_id', 'id'); 
if ($db->numberRows() > 0) {
	foreach ($saves as $fid => $save_id) {
		$saves_tmp = '';
		foreach ($save_id as $save_id => $save) {
			$saves_tmp .= '<option value="'.$save['form_id'].'__'.$save_id.'">'.$save['name'].'</option>';
		}
		$dash_saves_options .= '<optgroup label="'.$save['form_name'].'">'.$saves_tmp.'</optgroup>';
	}
}

//Results Group Templates
$dash_saves3_options = '';
//can see all at the moment
$saves3 = $db->fetchAllwithKey("SELECT id, name FROM templates WHERE template_type=2 ORDER BY form_id, name", array(), 'id'); 
if ($db->numberRows() > 0) {
	foreach ($saves3 as $save_id => $save) {
		$dash_saves3_options .= '<option value="'.$save_id.'">'.$save['name'].'</option>';
	}
}

$Dashboard_Links_Array = get_Dashboard_Links_Array($UID, $GROUP);
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
			V_DASHBOARD=[<?=$Dashboard_Links_Array;?>];
		</script>
	</div>
</div>
<div id="ssb-container" class="ssb-btns-left ssb-anim-slide" style="z-index:999; left:-9px; top:-4px;">
	<ul><li id="dashboard_link" title="Dashboard"><span class="fa fa-th"></span>&nbsp;</li></ul>
</div>
<script>
V_SAVED_DATA_OPTIONS=<?="'".$dash_saves_options."'";?>;
V_SAVED_DATA3_OPTIONS=<?="'".$dash_saves3_options."'";?>;
</script>