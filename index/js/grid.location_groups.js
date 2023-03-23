"use strict";

// Location Groups Grid

var $location_groups = false;

jQuery(function() 
{
var LG = LANG.GROUPS;

var initDate = function (el) {
	setTimeout(function () {
		$(el).after(' <i class="fa fa-calendar" style="font-size:14px;"></i>').next().on('click',function(e) {
				$(el).datepicker('show');
				return false;
			});
		$(el).datepicker({
			changeMonth: true,
			changeYear: true,
			//showButtonPanel: true,
			dateFormat: LANG.DATEPICKER.DATE
		});
		$('.ui-datepicker').css({'font-size':'75%'});
	}, 100);
};

var idPrefix = "g_";
var pager = '#SGpager';
$location_groups = $("#location_groups");
if ($location_groups)
{

//Location Groups ###############################
$location_groups.jqGrid({
	url: 'php/ajax.php?i=groups&ID='+V_Group_2_Location[V_GROUP][0],
	editurl: "php/ajax.php?i=groups&ID="+V_Group_2_Location[V_GROUP][0],
	idPrefix: idPrefix,
	iconSet: 'fontAwesome',
	pager: pager,
	pgtext: '',
	altRows: false, //for zebra
	cmTemplate: { editoptions:{size:22}, editable:true },
	colNames:['', LANG.ID, LG.LOCATION, LG.NAME, LANG.STATUS, LG.PRIVATE_KEY, LG.ADMIN, LG.STOP_DATE, LANG.CREATED, LANG.MODIFIED],
	colModel:[
		{ //inline editing buttons and options
			name:'acc', hidden:!(V_ADMIN||V_LOCATION_ADMIN), width:22, fixed:true, sortable:false, editable:false, search: false, resizable:false, formatter:'actions', 
			formatoptions:{
				keys:true, //[Enter]=save,[Esc]=cancel
				delbutton:false,
				editformbutton:true, 
				editOptions:{ //extend sto main.js
					width:350,
					afterShowForm: function(form) {
						//gray out not used fields
						$('input[readonly], select[readonly]').css({'background-color':'#eee','background-image':'none'});
						$('#admins_id').chosen({placeholder_text_multiple: LG.ADMIN, no_results_text:'Nichts gefunden!'});
					}
				}
			}
		},
		{name:'id',key:true,formoptions:{colpos:1, rowpos:1}, width:30,  align:"center", sorttype:'int', editoptions:{readonly:'readonly'} },
		{name:'location_id',formoptions:{colpos:1, rowpos:2}, width:100, hidden:true},
		{name:'name', 		formoptions:{colpos:1, rowpos:3}, width:250, editoptions:{style:"width:225px"}},
		{name:'status', 	formoptions:{colpos:1, rowpos:4}, width:50,
				formatter:"select", edittype:"select", align:"center",
				editoptions:{value: "1:"+LANG.ST_ACTIVE+";3:"+LG.PRIVATE+";0:"+LANG.ST_INACTIVE, defaultValue: '1', size:1, style:"width:120px"},
				cellattr: function(rowId, val, rawObject) {
						 if(val==1) return " style='color:green;'"; //active
					else if(val==3) return " style='color:blue;'"; //private
					else return " style='color:red;'"; //inactive
				}
		},
		{name:'private_key',formoptions:{colpos:1, rowpos:5}, width:80, editoptions:{style:"width:225px"}},
		{name:'admins_id', 	formoptions:{colpos:1, rowpos:6}, width:100, align:"center",
				formatter:"select", edittype:"select", /*hidden:true, editrules:{edithidden:true},*/
				editoptions:{value: V_GROUP_ADMINS_OPTIONS, size:5, style:"width:225px", multiple:true}
				/*, dataUrl: 'php/ajax.php?i=groups&oper=groups_admins'*/
		},
		{name:'stop_date',	formoptions:{colpos:1, rowpos:7}, width:85, align:"right", 
			sorttype:"date", formatter:"date", formatoptions:{srcformat:"Y-m-d", newformat:LANG.GRID.DATE},
			editoptions:{ dataInit:initDate, style:"width:120px" },
			cellattr: function(rowId, val) {
				if (moment(val, 'YYYY-MM-DD').isSame(moment(),'day')) return ' class="orange"';
				else if (moment(val, 'YYYY-MM-DD').isAfter()) return ' class="green"';
				else if (moment(val, 'YYYY-MM-DD').isBefore()) return ' class="red"';
			}
		},
		{name:'created', 	formoptions:{colpos:1, rowpos:8}, width:64, hidden:true, editrules:{edithidden:true}, editoptions:{readonly:'readonly'} },
		{name:'modified', 	formoptions:{colpos:1, rowpos:9}, width:64, hidden:true, editrules:{edithidden:true}, editoptions:{readonly:'readonly'} }
	]
}) //$location_groups.jqGrid({
.jqGrid('navGrid',pager,{ //bottom bar
	iconsOverText: true,
	edit: false,	edittext: LANG.BUTTON_EDIT,
	add: (V_ADMIN||V_LOCATION_ADMIN), addtext: LANG.BUTTON_ADD,
	del: false, 	deltext: LANG.BUTTON_DELETE,
	search: false, 	searchtext: LANG.BUTTON_SEARCH,
	view: true, 	viewtext: LANG.BUTTON_VIEW,
	refresh: true, 	refreshtext: LANG.BUTTON_RELOAD
},
{width:350}, //edit
{ //add
	width:350,
	afterShowForm: function(form) {
		//gray out not used fields
		$('input[readonly], select[readonly]').css({'background-color':'#eee','background-image':'none'});
		$('#admins_id').chosen({placeholder_text_multiple: LG.ADMIN, no_results_text:'Nichts gefunden!'});
	}
},
{}, //del
{}, //search
{ //view
	width:350
}); //pager


/*//Group Admins Reset --get it from grid.users.group.php
$.ajax({url:'php/ajax.php?i=groups&oper=groups_admins', success:function(data, result) {
	V_GROUP_ADMINS_OPTIONS = data;
	$location_groups.jqGrid('setColProp', 'admins_id', { editoptions: { value: V_GROUP_ADMINS_OPTIONS } });
}});*/

$(pager).children().children().css('table-layout', 'auto'); //fix pager width
$('#gbox_location_groups').removeClass('ui-corner-all').addClass('ui-corner-bottom')


function Responsive_Location_Groups() { 
    var p_width = $('#C_Location_Groups_link').prop('clientWidth');// Get width of parent container
    if (p_width == null || p_width < 1){
        p_width = $('#C_Location_Groups_link').prop('offsetWidth'); // For IE, revert to offsetWidth if necessary
    }
	p_width = p_width -2; //prevent horizontal scrollbars
	if (p_width != $location_groups.width()) {
		$location_groups.jqGrid('setGridWidth', p_width);
	}
}
Responsive_Location_Groups();


//on window resize -> resize grids
$(window).on('resize', function() {
	Responsive_Location_Groups();
}).trigger('resize');


} //end if (location_groups)

}); //end jQuery(document).ready