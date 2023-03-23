<?php // ajax Form Row Item
require_once('../_settings.regmon.php');
require('../login/validate.php');

$SEC_check = $CONFIG['SEC_Page_Secret']; //secure ajax sub pages from direct call
$EDIT = true; 
require("form_functions.php");

$row_item = isset($_REQUEST['row_item']) ? $_REQUEST['row_item'] : '0_0_0'; 
$row_item_type = isset($_REQUEST['row_item_type']) ? $_REQUEST['row_item_type'] : "text"; 

$row_item_arr = explode('_', $row_item);
$row = $row_item_arr[0]; //row num
$item = $row_item_arr[1]; //item num

$html = '';

$basic_Items = array(
	'_Empty',
	'_Space',
	'_Line',
	'_Label',
	'_Html',
	'_Text',
	'_Textarea',
	'_Date',
	'_Time',
	'_Period'
);

//Basic Items
if (in_array($row_item_type, $basic_Items)) {
	$html .= get_Form_Row_Item($row_item_type, $row, array("no"=>$item));
}
//Items with extra options
elseif ($row_item_type == "_Number") {
	$html .= get_Form_Row_Item('_Number', $row, array("no"=>$item,"min"=>"","max"=>"","decimal"=>"0"));
}
elseif ($row_item_type == "_Dropdown") {
	$html .= get_Form_Row_Item('_Dropdown', $row, array("no"=>$item,"dd"=>"","opt"=>$LANG->FORM_ITEM_SELECT_OPTION));
}
elseif ($row_item_type == "_Dropdown_Select_Only") {
	$dd = isset($_REQUEST['dd']) ? $_REQUEST['dd'] : 0; 
	$opt = isset($_REQUEST['opt']) ? $_REQUEST['opt'] : ''; 
	$has_color = isset($_REQUEST['has_color']) ? $_REQUEST['has_color'] : 0; 
	$color = isset($_REQUEST['color']) ? $_REQUEST['color'] : '120|0'; //def=Red-Yellow-Green - 120|0
	
	$html .= get_Form_Row_Item('_Dropdown_Select_Only', $row, array("no"=>$item,"dd"=>$dd,"opt"=>$opt,"has_color"=>$has_color,"color"=>$color));
}
elseif ($row_item_type == "_RadioButtons" OR $row_item_type == "_Radio_Buttons_Select_Only") { 
	$rdd = isset($_REQUEST['rdd']) ? $_REQUEST['rdd'] : 0; 
	$has_title = isset($_REQUEST['has_title']) ? $_REQUEST['has_title'] : 0; 
	$title = isset($_REQUEST['title']) ? $_REQUEST['title'] : ''; 
	$talign = isset($_REQUEST['talign']) ? $_REQUEST['talign'] : 'left'; 
	$has_color = isset($_REQUEST['has_color']) ? $_REQUEST['has_color'] : 0; 
	$color = isset($_REQUEST['color']) ? $_REQUEST['color'] : '120|0'; //def=Red-Yellow-Green - 120|0
	
	$html .= get_Form_Row_Item($row_item_type, $row, array("no"=>$item,"has_title"=>$has_title,"title"=>$title,"talign"=>$talign,"has_color"=>$has_color,"color"=>$color,"rdd"=>$rdd));
}
elseif ($row_item_type == "_Accordion" OR $row_item_type == "_Accordion_Panel") {
	$acc_item = isset($_REQUEST['acc_item']) ? $_REQUEST['acc_item'] : 1; 
	
	$acc = isset($_REQUEST['acc']) ? $_REQUEST['acc'] : 0; 
	$has_title = isset($_REQUEST['has_title']) ? $_REQUEST['has_title'] : 0; 
	$title = isset($_REQUEST['title']) ? $_REQUEST['title'] : ''; 
	$talign = isset($_REQUEST['talign']) ? $_REQUEST['talign'] : 'left'; 
	$has_color = isset($_REQUEST['has_color']) ? $_REQUEST['has_color'] : 0; 
	$color = isset($_REQUEST['color']) ? $_REQUEST['color'] : '120|0'; //def=Red-Yellow-Green - 120|0
	
	$html .= get_Form_Row_Item($row_item_type, $row, array("no"=>$item, "acc_no"=>$acc_item));
}

echo $html;
?>