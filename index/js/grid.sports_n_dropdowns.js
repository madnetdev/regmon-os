"use strict";

// Sports Grid + Dropdowns Grid

var $sports = false;

jQuery(function()
{

var LS = LANG.SPORTS;

var currentPage = 1;
var idPrefix = "sp_";
var pager = '#SPpager';
var url = 'php/ajax.php?i=sports';
$sports = $("#sports");
if ($sports) 
{

//sports ###############################
$sports.jqGrid({  
	url: url,
	editurl: url,
	loadonce: true,
	navOptions: { reloadGridOptions: { fromServer: true } },
	iconSet: 'fontAwesome',
	idPrefix: idPrefix,
	sortname: 'name',
	hiddengrid: true,
	caption: LS.HEADER,
	pager: pager,
	pgtext: '',
	pgbuttons: true,
	rowNum: 10,
	rowList:[5,10,20,30,50,100,200,500,'999999:Alle'],
	cmTemplate: { editoptions:{size:22}, editable:true },
	colNames:['', LANG.ID, LS.OPTIONGROUP, LS.NAME, LANG.STATUS, LANG.CREATED, LANG.MODIFIED],
	colModel:[
		{ //inline editing buttons and options
			name:'acc', hidden:(V_GROUP_ADMIN_2?true:false), width:22, fixed:true, sortable:false, editable:false, search: false, resizable:false, formatter:'actions', 
			formatoptions:{
				keys:true, //[Enter]=save,[Esc]=cancel
				delbutton:false,
				//form dialog edit
				editformbutton: true, 
				editOptions : {
					reloadAfterSubmit: true,
					//extend sto main.js
				}
			}
		},
		{name:'id',key:true,formoptions:{colpos:1, rowpos:1},  width:30,  align:"center",	editoptions:{readonly:'readonly'} },
		{name:'sport_group_id', formoptions:{colpos:1, rowpos:2},  width:100, align:"center",
				formatter:"select", edittype:"select", /*hidden:true,*/ editrules:{edithidden:true},
				editoptions:{value: V_SPORTS_GROUP_OPTIONS, defaultValue: 0, size:1, style:"width:120px"}
		},
		{name:'name', 		formoptions:{colpos:1, rowpos:3},  width:250},
		{name:'status', 	formoptions:{colpos:1, rowpos:4},  width:50,
				formatter:"select", edittype:"select", align:"center",
				editoptions:{value: "1:"+LANG.ST_ACTIVE+";0:"+LANG.ST_INACTIVE, defaultValue: '1', size:1},
				stype:'select', searchoptions: {sopt:['eq', 'ne'], value: ":;1:"+LANG.ST_ACTIVE+";0:"+LANG.ST_INACTIVE},
				cellattr: function(rowId, val, rawObject) {
					if(val==1) return " style='color:green;'"; //active
					else return " style='color:red;'"; //inactive
				}
		},
		{name:'created', 	formoptions:{colpos:1, rowpos:5}, width:64, hidden:true, editrules:{edithidden:true}, editoptions:{readonly:'readonly'} },
		{name:'modified', 	formoptions:{colpos:1, rowpos:6}, width:64, hidden:true, editrules:{edithidden:true}, editoptions:{readonly:'readonly'} }
	],
	grouping: true,
   	groupingView : {
   		groupField : ['sport_group_id'],
		groupOrder: ['asc'],
   		groupColumnShow : [false],
   		groupText : [' {0} <b>( {1} )</b>'],
   		groupCollapse : false,
   	},
	//loadComplete: function(data) {}
}) //$sports.jqGrid({ 
.jqGrid('navGrid',pager,{ //bottom bar
	iconsOverText: true,
	edit: false,	edittext: LANG.BUTTON_EDIT,
	add: !V_GROUP_ADMIN_2, addtext: LANG.BUTTON_ADD,
	del: !V_GROUP_ADMIN_2, deltext: LANG.BUTTON_DELETE,
	search: false, 	searchtext: LANG.BUTTON_SEARCH,
	view: true, 	viewtext: LANG.BUTTON_VIEW,
	refresh: true, 	refreshtext: LANG.BUTTON_RELOAD
})
.jqGrid('filterToolbar',{ //Column Search
	stringResult:true, //send as Json //filters
	searchOnEnter:false,
	defaultSearch: 'cn'
});


//SportsGroups Options Reset
$.ajax({url:'php/ajax.php?i=dropdowns&oper=sport_groups', success:function(data, result) {
	V_SPORTS_GROUP_OPTIONS = data;
	$sports.jqGrid('setColProp', 'sport_group_id', { editoptions: { value: V_SPORTS_GROUP_OPTIONS } });
}});

//set Caption from table title/alt
$sports.jqGrid('setCaption', $sports.attr('alt'))
//center Caption and change font-size
.closest("div.ui-jqgrid-view")
	.children("div.ui-jqgrid-titlebar").css({"text-align":"center", "cursor":"pointer"})
	.children("span.ui-jqgrid-title").css({"float":"none", "font-size": "17px"});

//Expand/Colapse grid from Caption click
$($sports[0].grid.cDiv).on('click',function() {
	if ($(pager).is(':hidden')) 
		$(this).removeClass('ui-corner-all');
	else $(this).addClass('ui-corner-all');
	$(".ui-jqgrid-titlebar-close",this).trigger("click");	
}).addClass('ui-corner-all');

function Responsive_Sports() { 
    var p_width = $('#C_Sports_Dropdowns_link').prop('clientWidth');// Get width of parent container
    if (p_width == null || p_width < 1){
        p_width = $('#C_Sports_Dropdowns_link').prop('offsetWidth'); // For IE, revert to offsetWidth if necessary
    }
    p_width = p_width - 1; //prevent horizontal scrollbars
	if (p_width != $sports.width()) {
		$sports.jqGrid('setGridWidth', p_width);
	}
}
Responsive_Sports();

//on window resize -> resize grids
$(window).on('resize', function() {
	Responsive_Sports();
}).trigger('resize');

$(pager).children().children().css('table-layout', 'auto'); //fix pager width
//$('#gbox_sports').removeClass('ui-corner-all').addClass('ui-corner-bottom')

} //end if (sports)

}); //end jQuery(document).ready



//##########################################################################################
//##########################################################################################
//##########################################################################################



var $dropdowns = false;
jQuery(function() 
{

var LD = LANG.DROPDOWN;

var idPrefix = 'd_';
var pager = '#Dpager';
$dropdowns = $("#dropdowns");
if ($dropdowns) 
{

//dropdowns ###############################
$dropdowns.jqGrid({  
	url: 'php/ajax.php?i=dropdowns',
	editurl: "php/ajax.php?i=dropdowns",
	iconSet: 'fontAwesome',
	idPrefix: idPrefix,
	pager: pager,
	pgtext: '',
	hiddengrid: true,
	caption: LD.HEADER,
	colNames:['', LANG.ID, LD.NAME, LD.FOR_FORMS, LANG.STATUS, LANG.CREATED, LANG.MODIFIED],
	colModel:[
		{ //inline editing buttons and options
			name: 'acc', hidden:(V_GROUP_ADMIN_2?true:false), width:22, fixed:true, sortable:false, editable:false, search: false, resizable:false, formatter:'actions', 
			formatoptions:{
				keys:true, //[Enter]=save,[Esc]=cancel
				delbutton:false,
				//form dialog edit
				editformbutton: true, 
				editOptions : {
					//extend sto main.js
				}
			}
		},
		{name:'id',key:true,formoptions:{colpos:1, rowpos:1},  width:30,  align:"center", editoptions:{readonly:'readonly'} },
		{name:'name', 		formoptions:{colpos:1, rowpos:2},  width:150, editrules:{required:true} },
		{name:'for_forms',formoptions:{colpos:1, rowpos:4}, width:80, align:"center", 
				formatter: "checkbox", formatoptions: { disabled: true},
				edittype: "checkbox", editoptions: {value:"1:0", defaultValue:"1"},
		},
		{name:'status', 	formoptions:{colpos:1, rowpos:5},  width:50,
				formatter:"select", edittype:"select", align:"center",
				editoptions:{value: "1:"+LANG.ST_ACTIVE+";0:"+LANG.ST_INACTIVE, defaultValue: '1', size:1},
				cellattr: function(rowId, val, rawObject) {
					if(val==1) return " style='color:green;'"; //active
					else return " style='color:red;'"; //inactive
				}
		},
		{name:'created', 	formoptions:{colpos:1, rowpos:6}, width:64, hidden:true, editrules:{edithidden:true}, editoptions:{readonly:'readonly'} },
		{name:'modified', 	formoptions:{colpos:1, rowpos:7}, width:64, hidden:true, editrules:{edithidden:true}, editoptions:{readonly:'readonly'} }
	],
	subGrid: true,
    subGridOptions: { 
        selectOnExpand: true,
	},
	
	//options #############################
	subGridRowExpanded: function(subgrid_id, row_id) {
		var subgrid_table_id = subgrid_id+"_t"; 
		var sub_pager = "p_"+subgrid_table_id;
		$("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><div id='"+sub_pager+"' class='scroll'></div>");
		var dropdown_id = $dropdowns.jqGrid('getRowData', row_id)['id'];
		var dropdowns_url = "php/ajax.php?i=dropdowns&oper=options&ID="+dropdown_id;
		var sub_idPrefix = "op_";
		
		$("#"+subgrid_table_id).jqGrid({
			url: dropdowns_url,
			editurl: dropdowns_url,
			iconSet: 'fontAwesome',
			idPrefix: sub_idPrefix,
			pager: sub_pager,
			pgtext: '',
			colNames:['', LANG.ID, LD.OPTIONS, LANG.STATUS, LANG.CREATED, LANG.MODIFIED],
			colModel:[
				{ //inline editing buttons and options
					name: 'acc', hidden:(V_GROUP_ADMIN_2?true:false), width:22, fixed:true, sortable:false, editable:false, search: false, resizable:false, formatter:'actions', 
					formatoptions:{
						keys:true, //[Enter]=save,[Esc]=cancel
						delbutton:false,
						//form dialog edit
						editformbutton: true, 
						editOptions : {
							//extend sto main.js
						}
					}
				},
				{name:'id',key:true,formoptions:{colpos:1, rowpos:1}, width:30,  align:"center", editoptions:{readonly:'readonly'} },
				{name:'options', 	formoptions:{colpos:1, rowpos:3}, width:225},
				{name:'status', 	formoptions:{colpos:1, rowpos:5}, width:50,
						formatter:"select", edittype:"select", align:"center",
						editoptions:{value: "1:"+LANG.ST_ACTIVE+";0:"+LANG.ST_INACTIVE, defaultValue: '1', size:1},
						cellattr: function(rowId, val, rawObject) {
							if(val==1) return " style='color:green;'"; //active
							else return " style='color:red;'"; //inactive
						}
				},
				{name:'created', 	formoptions:{colpos:1, rowpos:6}, width:64, hidden:true, editrules:{edithidden:true}, editoptions:{readonly:'readonly'} },
				{name:'modified', 	formoptions:{colpos:1, rowpos:7}, width:64, hidden:true, editrules:{edithidden:true}, editoptions:{readonly:'readonly'} }
			],
			loadComplete: function(data) {
				//SportsGroups Options Reset
				$.ajax({url:'php/ajax.php?i=dropdowns&oper=sport_groups', success:function(data, result) {
					V_SPORTS_GROUP_OPTIONS = data;
					$sports.jqGrid('setColProp', 'sport_group_id', { editoptions: { value: V_SPORTS_GROUP_OPTIONS } });
				}});
			}
	
		}) //$("#"+subgrid_table_id).jqGrid({ Options
		.jqGrid('navGrid',"#"+sub_pager,{
			iconsOverText: true,
			edit:false, 	edittext: LANG.BUTTON_EDIT,
			add:!V_GROUP_ADMIN_2,addtext: LANG.BUTTON_ADD,
			del:!V_GROUP_ADMIN_2,deltext: LANG.BUTTON_DELETE,
			search:false, 	searchtext: LANG.BUTTON_SEARCH,
			view:true, 		viewtext: LANG.BUTTON_VIEW,
			refresh:true, 	refreshtext: LANG.BUTTON_RELOAD
		});
		
		$('#gbox_'+subgrid_table_id).removeClass('ui-corner-all'); //.css('width', $('#gbox_'+subgrid_table_id).width()+4)
		$('#'+sub_pager).removeClass('ui-corner-bottom');
		$("#"+subgrid_id).parent().css('padding', '1px').prev().css("background", $dropdowns.jqGrid('getRowData', row_id)['color']);
		
		Responsive_Dropdown_Options($("#"+subgrid_table_id));
		
	}, //subGridRowExpanded options
	subGridRowColapsed: function(subgrid_id, row_id) {
		$("#"+subgrid_id+"_t").remove();
		Responsive_Dropdown();
	}
	
}) //$dropdowns.jqGrid({  
.jqGrid('navGrid',pager,{ //bottom bar
	iconsOverText: true,
	edit: false,	edittext: LANG.BUTTON_EDIT,
	add:!V_GROUP_ADMIN_2,addtext: LANG.BUTTON_ADD,
	del:!V_GROUP_ADMIN_2,deltext: LANG.BUTTON_DELETE,
	search: false, 	searchtext: LANG.BUTTON_SEARCH,
	view: true, 	viewtext: LANG.BUTTON_VIEW,
	refresh: true, 	refreshtext: LANG.BUTTON_RELOAD
});
/*.jqGrid('filterToolbar',{ //Column Search
	stringResult:true, //send as Json //filters
	searchOnEnter:false,
	defaultSearch: 'cn'
});*/

//set Caption from table title/alt
$dropdowns.jqGrid('setCaption', $dropdowns.attr('alt'))
//center Caption and change font-size
.closest("div.ui-jqgrid-view")
	.children("div.ui-jqgrid-titlebar").css({"text-align":"center", "cursor":"pointer"})
	.children("span.ui-jqgrid-title").css({"float":"none", "font-size": "17px"});

//Expand/Colapse grid from Caption click
$($dropdowns[0].grid.cDiv).on('click',function() {
	if ($(pager).is(':hidden')) 
		$(this).removeClass('ui-corner-all');
	else $(this).addClass('ui-corner-all');
	$(".ui-jqgrid-titlebar-close",this).trigger("click");	
}).addClass('ui-corner-all');

$(pager).children().children().css('table-layout', 'auto'); //fix pager width

function Responsive_Dropdown() { 
    var p_width = $('#C_Sports_Dropdowns_link').prop('clientWidth');// Get width of parent container
    if (p_width == null || p_width < 1){
        p_width = $('#C_Sports_Dropdowns_link').prop('offsetWidth'); // For IE, revert to offsetWidth if necessary
    }
    p_width = p_width - 2; //prevent horizontal scrollbars
	if (p_width != $dropdowns.width()) {
		$dropdowns.jqGrid('setGridWidth', p_width);
	
		//if have subs opened
		if ($("div[id^=dropdowns_d_]").length > 0) { 
			$("div[id^=dropdowns_d_]").each(function(){
				Responsive_Dropdown_Options($('#'+this.id+'_t'));
			});
		}
	}
}
Responsive_Dropdown();

function Responsive_Dropdown_Options(sub) { 
    var p_width = $('#C_Sports_Dropdowns_link').prop('clientWidth');// Get width of parent container
    if (p_width == null || p_width < 1){
        p_width = $('#C_Sports_Dropdowns_link').prop('offsetWidth'); // For IE, revert to offsetWidth if necessary
    }
    p_width = p_width - 27; //prevent horizontal scrollbars
	if (p_width != sub.width()) {
		sub.jqGrid('setGridWidth', p_width);
	}
}


//on window resize -> resize grids
$(window).on('resize', function() {
	Responsive_Dropdown();
}).trigger('resize');


} //end if (dropdowns)

}); //end jQuery(document).ready