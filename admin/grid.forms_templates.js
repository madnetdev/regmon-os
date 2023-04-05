"use strict";

// Form Templates Grid

jQuery(function() 
{

const LT = LANG.TEMPLATES;
const LP = LANG.PERMISSIONS;
const grid_width_Max = 1200;
const idPrefix = "ft_";
const pager = '#FTpager';
let header = 'Formulare Vorlagen';
let $forms_templates = $("#forms_templates");
if ($forms_templates)
{

//forms_templates ###############################
$forms_templates.jqGrid({
	url: 'php/ajax.php?i=templates&oper=forms_templates',
	editurl: "php/ajax.php?i=templates&oper=edit&template_type=0",
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
	colNames:['', LT.TEMPLATE_ID, LT.FORM_ID, LT.FORM_NAME, LT.FORM_STATUS, LT.TEMPLATE_NAME, LT.USER_ID, LT.LOCATION_ID, LT.GROUP_ID, LP.GLOBAL_VIEW, LP.GLOBAL_EDIT, LP.LOCATION_VIEW, LP.LOCATION_EDIT, LP.GROUP_VIEW, LP.GROUP_EDIT, LP.TRAINER_VIEW, LP.TRAINER_EDIT, LP.PRIVATE, LANG.CREATED, LANG.CREATED_BY, LANG.MODIFIED, LANG.MODIFIED_BY],
	colModel:[
		{ //inline editing buttons and options
			name:'acc', hidden:(V_GROUP_ADMIN_2?true:false), width:22, fixed:true, sortable:false, editable:false, search: false, resizable:false, formatter:'actions', 
			formatoptions:{
				keys:true,
				delbutton:false,
				editformbutton:true,
				editOptions: {
					width:500,
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
		{name:'id',key:true, formoptions:{colpos:1, rowpos:1}, width:32, align:"center", sorttype:"int", editoptions:{readonly:'readonly'} },
		{name:'form_id', 	 formoptions:{colpos:1, rowpos:2}, width:30, editoptions:{readonly:'readonly'}},
		{name:'form_name', 	 formoptions:{colpos:1, rowpos:3}, width:150, editoptions:{readonly:'readonly'}},
		{name:'form_status', formoptions:{colpos:1, rowpos:4}, width:50, template: aktivInaktivTemplate, editoptions:{readonly:'readonly'}},
		{name:'templatename',formoptions:{colpos:2, rowpos:1}, width:150},
		{name:'user_id', 	 formoptions:{colpos:1, rowpos:5}, width:50, align:"center"},
		{name:'location_id', formoptions:{colpos:1, rowpos:6}, width:50, align:"center"},
		{name:'group_id', 	 formoptions:{colpos:1, rowpos:7}, width:50, align:"center"},
		{name:"GlobalView",  formoptions:{colpos:2, rowpos:2}, width:30, template: checkboxTemplate},
		{name:"GlobalEdit",  formoptions:{colpos:2, rowpos:3}, width:30, template: checkboxTemplate},
		{name:"LocationView",formoptions:{colpos:2, rowpos:4}, width:30, template: checkboxTemplate},
		{name:"LocationEdit",formoptions:{colpos:2, rowpos:5}, width:30, template: checkboxTemplate},
		{name:"GroupView",   formoptions:{colpos:2, rowpos:6}, width:30, template: checkboxTemplate},
		{name:"GroupEdit",   formoptions:{colpos:2, rowpos:7}, width:30, template: checkboxTemplate},
		{name:"TrainerView", formoptions:{colpos:2, rowpos:8}, width:30, template: checkboxTemplate},
		{name:"TrainerEdit", formoptions:{colpos:2, rowpos:9}, width:30, template: checkboxTemplate},
		{name:"Private", 	 formoptions:{colpos:2, rowpos:10},width:30, template: checkboxTemplate},
		{name:'created',	 formoptions:{colpos:1, rowpos:8}, width:65, template: hiddenReadonlyTemplate},
		{name:'created_by',  formoptions:{colpos:1, rowpos:9}, width:80, template: hiddenReadonlyTemplate, align:"center", hidden:false},
		{name:'modified', 	 formoptions:{colpos:1, rowpos:10}, width:65, template: hiddenReadonlyTemplate},
		{name:'modified_by', formoptions:{colpos:1, rowpos:11}, width:80, template: hiddenReadonlyTemplate, align:"center", hidden:false},
	]
}) //$forms_templates.jqGrid({
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

//forms_templates Groups
var forms_templates_groups = '<select id="Forms_TemplatesGrouping" style="font-size:11px; float:left; margin:4px 0 0 21px; color:black; font-weight:normal; display:none;">\
<option value="">'+LANG.GROUPING_NO+'</option>\
<option value="form_id">'+LANG.GROUPING_BY+' Formular ID</option>\
<option value="formname">'+LANG.GROUPING_BY+' Formular Name</option>\
<option value="status">'+LANG.GROUPING_BY+' Formular Status</option>\
<option value="user_id">'+LANG.GROUPING_BY+' Benutzer ID</option>\
<option value="location_id">'+LANG.GROUPING_BY+' Location ID</option>\
<option value="group_id">'+LANG.GROUPING_BY+' Gruppe ID</option>\
<option value="created_by">'+LANG.GROUPING_BY+' erstellt von</option>\
<option value="modified_by">'+LANG.GROUPING_BY+' geändert von</option></select>';


//set Caption from table title/alt
$forms_templates.jqGrid('setCaption', $forms_templates.attr('alt') +' '+ forms_templates_groups)
.closest("div.ui-jqgrid-view") //center Caption and change font-size
	.children("div.ui-jqgrid-titlebar").css({"text-align":"center", "cursor":"pointer"})
	.children("span.ui-jqgrid-title").css({"float":"none", "font-size": "17px"});

//Expand/Colapse grid from Caption click
$($forms_templates[0].grid.cDiv).on('click',function(e) {
	if (e.target.id == 'Forms_TemplatesGrouping') return false; //stop trigger caption click when click on UserGrouping select
	if ($(pager).is(':hidden')) 
		$(this).removeClass('ui-corner-all');
	else $(this).addClass('ui-corner-all');
	$("#gview_forms_templates .ui-jqgrid-titlebar-close").trigger("click");	
}).addClass('ui-corner-all');

$("#gview_forms_templates .ui-jqgrid-titlebar-close").on('click',function() {
	$('#Forms_TemplatesGrouping').toggle();
});

//Templates Grouping
$("#Forms_TemplatesGrouping").on('change', function() {
	var groupingName = $(this).val();
	if (groupingName) {
		$forms_templates.jqGrid('groupingGroupBy', groupingName, {
			groupText : [' {0} <b>( {1} )</b>'],
			groupOrder : ['asc'],
			groupColumnShow: [true],
			groupCollapse: true
		});
	} else {
		$forms_templates.jqGrid('groupingRemove');
	}
	return false;
});


//on window resize -> resize grids
$(window).on('resize', function() {
	//main grid
	if (grid_width_Max > $(window).width()) {
		$forms_templates.jqGrid('setGridWidth', $(window).width()-30);
	} else {
		$forms_templates.jqGrid('setGridWidth', grid_width_Max);
	}
}).trigger('resize');


   
} //end if (forms_templates)

}); //end jQuery(document).ready