"use strict";

// Axis Grid

jQuery(function() 
{

const LT = LANG.TEMPLATES;
const LP = LANG.PERMISSIONS;
const grid_width_Max = 1200;
const idPrefix = "a_";
const pager = '#ATpager';
let header = 'Y-Achsen';
let $axis_templates = $("#axis_templates");
if ($axis_templates)
{

//axis_templates ###############################
$axis_templates.jqGrid({
	url: 'php/ajax.php?i=templates&oper=axis_templates',
	editurl: "php/ajax.php?i=templates&oper=edit&template_type=1",
	datatype: "json",
	idPrefix: idPrefix,
	hiddengrid: true, //to start closed without loading data
	loadonce: true,
	caption: header,
	pager: pager,
	pgtext: '',
	altRows: true, //for zebra
	gridview: true,
	sortname: 'name',
	viewrecords: true, //view 1 - 1 of 10
	headertitles:true,
	cmTemplate: { editoptions:{size:22}, editable:true },
	colNames:['', LT.Y_AXIS_ID, LT.Y_AXIS_NAME, LT.USER_ID, LT.LOCATION_ID, LT.GROUP_ID, LP.GLOBAL_VIEW, LP.GLOBAL_EDIT, LP.LOCATION_VIEW, LP.LOCATION_EDIT, LP.GROUP_VIEW, LP.GROUP_EDIT, LP.TRAINER_VIEW, LP.TRAINER_EDIT, LP.PRIVATE, LANG.CREATED, LANG.CREATED_BY, LANG.MODIFIED, LANG.MODIFIED_BY],
	colModel:[
		{ //inline editing buttons and options
			name:'acc', hidden:(V_GROUP_ADMIN_2?true:false), width:22, fixed:true, sortable:false, editable:false, search: false, resizable:false, formatter:'actions', 
			formatoptions:{
				keys:true,
				delbutton:false,
				editformbutton:true,
				editOptions: {
					width: 500,
					beforeShowForm: function(form) {
						$('.ui-jqdialog-content .FormData td.CaptionTD').each(function(){
							$(this).html($(this).html().replace('<br>',' ')); //replace <br> with ' ' in CaptionTD
						});
						//Permissions Select
						init_Permissions();
					}
				}
			}
		},
		{name:'id',key:true, width:32, align:"center", sorttype:"int", editoptions:{readonly:'readonly'} },
		{name:'templatename',width:250},
		{name:'user_id', 	 width:50, align:"center"},
		{name:'location_id', width:50, align:"center"},
		{name:'group_id', 	 width:50, align:"center"},
		{name:"GlobalView",  width:30, template: checkboxTemplate},
		{name:"GlobalEdit",  width:30, template: checkboxTemplate},
		{name:"LocationView",width:30, template: checkboxTemplate},
		{name:"LocationEdit",width:30, template: checkboxTemplate},
		{name:"GroupView",   width:30, template: checkboxTemplate},
		{name:"GroupEdit",   width:30, template: checkboxTemplate},
		{name:"TrainerView", width:30, template: checkboxTemplate},
		{name:"TrainerEdit", width:30, template: checkboxTemplate},
		{name:"Private", 	 width:30, template: checkboxTemplate},
		{name:'created',	 width:65, template: hiddenReadonlyTemplate},
		{name:'created_by',  width:80, template: hiddenReadonlyTemplate, align:"center", hidden:false},
		{name:'modified', 	 width:65, template: hiddenReadonlyTemplate},
		{name:'modified_by', width:80, template: hiddenReadonlyTemplate, align:"center", hidden:false}
	]
}) //$axis_templates.jqGrid({
//Column Search
.jqGrid('filterToolbar',{
	stringResult:true, //send as Json //filters
	searchOnEnter:false,
	defaultSearch: 'cn'
})
//bottom bar
.jqGrid('navGrid',pager,{
	iconsOverText: true,
	edit:false, edittext: LANG.BUTTON_EDIT,
	add:false/* !V_GROUP_ADMIN_2*/, addtext: LANG.BUTTON_ADD,
	del:false/*V_ADMIN*/, deltext: LANG.BUTTON_DELETE,
	search:false, searchtext: LANG.BUTTON_SEARCH,
	view:false, viewtext: LANG.BUTTON_VIEW,
	refresh:true, refreshtext: LANG.BUTTON_RELOAD,
	reloadGridOptions: { fromServer: true }
})
//dublicate button
.jqGrid("navButtonAdd", pager, {
	iconsOverText: true,
	buttonicon: "fa-copy",
	caption: LANG.BUTTON_DUPLICATE,
	title: LANG.BUTTON_DUPLICATE,
	onClickButton: function () {
		const self = $(this);
		const selRowId = self.jqGrid('getGridParam', 'selrow');
		if (selRowId != null) {
			const template_id = self.jqGrid('getCell', selRowId, 'id');
			$.ajax({url:'php/ajax.php?i=templates&oper=template_duplicate&ID='+template_id, success:function(data, result) {
				self.trigger("reloadGrid", { fromServer: true });
			}});
		}
		else {
			this.modalAlert();
		}
	}
});



$(pager).children().children().css('table-layout', 'auto'); //fix pager width

//axis_templates Groups
var axis_templates_groups = '<select id="axis_templates_Grouping" style="font-size:11px; float:left; margin:4px 0 0 21px; color:black; font-weight:normal; display:none;">\
<option value="">'+LANG.GROUPING_NO+'</option>\
<option value="user_id">'+LANG.GROUPING_BY+' Benutzer ID</option>\
<option value="location_id">'+LANG.GROUPING_BY+' Location ID</option>\
<option value="group_id">'+LANG.GROUPING_BY+' Gruppe ID</option>\
<option value="created_by">'+LANG.GROUPING_BY+' erstellt von</option>\
<option value="modified_by">'+LANG.GROUPING_BY+' geändert von</option></select>';


//set Caption from table title/alt
$axis_templates.jqGrid('setCaption', $axis_templates.attr('alt') +' '+ axis_templates_groups)
.closest("div.ui-jqgrid-view") //center Caption and change font-size
	.children("div.ui-jqgrid-titlebar").css({"text-align":"center", "cursor":"pointer"})
	.children("span.ui-jqgrid-title").css({"float":"none", "font-size": "17px"});

//Expand/Colapse grid from Caption click
$($axis_templates[0].grid.cDiv).on('click',function(e) {
	if (e.target.id == 'axis_templates_Grouping') return false; //stop trigger caption click when click on UserGrouping select
	if ($(pager).is(':hidden')) 
		$(this).removeClass('ui-corner-all');
	else $(this).addClass('ui-corner-all');
	$("#gview_axis_templates .ui-jqgrid-titlebar-close").trigger("click");	
}).addClass('ui-corner-all');

$("#gview_axis_templates .ui-jqgrid-titlebar-close").on('click',function() {
	$('#axis_templates_Grouping').toggle();
});

//axis_templates Grouping
$("#axis_templates_Grouping").on('change', function() {
	var groupingName = $(this).val();
	if (groupingName) {
		$axis_templates.jqGrid('groupingGroupBy', groupingName, {
			//groupField : [groupingName],
			//groupDataSorted : true,
			groupText : [' {0} <b>( {1} )</b>'],
			groupOrder : ['asc'],
			groupColumnShow: [true],
			groupCollapse: true
		});
	} else {
		$axis_templates.jqGrid('groupingRemove');
	}
	return false;
});


//on window resize -> resize grids
$(window).on('resize', function() {
	//main grid
	if (grid_width_Max > $(window).width()) {
		$axis_templates.jqGrid('setGridWidth', $(window).width()-30);
	} else {
		$axis_templates.jqGrid('setGridWidth', grid_width_Max);
	}
}).trigger('resize');


   
} //end if (axis_templates)

}); //end jQuery(document).ready