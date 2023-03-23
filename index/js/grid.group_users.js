"use strict";

// Group Users Grid

var $group_users = false;

jQuery(function() 
{

var st_all = '<span class="req">.</span>'; //all
var st_no = '<span class="req G_no" title="'+LANG.R_STATUS.REQUEST_REJECTED+'">0</span>'; //0
var st_yes = '<span class="req G_yes" title="'+LANG.R_STATUS.REQUEST_ACCEPTED+'">1</span>'; //1
var st_leaveR = '<span class="req G_leaveR" title="'+LANG.R_STATUS.CANCELED_ACCESS_USER+'">5</span>'; //5
var st_leaveA = '<span class="req G_leaveA" title="'+LANG.R_STATUS.CANCELED_ACCESS_GROUP+'">15</span>'; //15
var st_waitLR = '<span class="req G_waitLR" title="'+LANG.R_STATUS.REQ_WAIT_CANCELED_USER+'">7</span>'; //7
var st_waitLA = '<span class="req G_waitLA" title="'+LANG.R_STATUS.REQ_WAIT_CANCELED_GROUP+'">17</span>'; //17
var st_waitN = '<span class="req G_waitN" title="'+LANG.R_STATUS.REQ_WAIT_REJECTED_USER+'">8</span>'; //8
var st_wait = '<span class="req G_wait" title="'+LANG.R_STATUS.REQUEST_WAIT+'">9</span>'; //9
var st_new = '<span class="req G_new" title="'+LANG.R_STATUS.REQ_WAIT_NEW_USER+'">10</span>'; //10
var st_newx = '<span class="req G_newx" title="'+LANG.R_STATUS.REQ_WAIT_USER_INACTIVE+'">11</span>'; //11
var req_status = ':X;1:'+st_yes+';5:'+st_leaveR+';15:'+st_leaveA+';0:'+st_no+';7:'+st_waitLR+';17:'+st_waitLA+';8:'+st_waitN+';9:'+st_wait+';10:'+st_new+';11:'+st_newx;

var LU = LANG.USERS;
var initDate = function (el) {
	setTimeout(function () {
		$(el).after(' <i class="fa fa-calendar" style="font-size:14px;"></i>').next()
			.on('click',function(e) {
				$(el).datepicker('show');
				return false;
			});
		$(el).datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: "-85:-5",
			//showButtonPanel: true,
			dateFormat:LANG.DATEPICKER.DATE
		});
		$('.ui-datepicker').css({'font-size':'75%'});
	}, 100);
};
//var V_USER_LVL_OPTIONS = "0:"; //from index.php
//var V_SPORTS_OPTIONS = "0:"; //from grid.group_users.php
//var V_BODY_HEIGHT_OPTIONS = "0:"; //from grid.group_users.php
var currentPage = 1;
var idPrefix = "ug_";
var pager = "#UGpager";
$group_users = $("#group_users");
if ($group_users) 
{

//Users Group ###############################
$group_users.jqGrid({  
	url: 'php/ajax.php?i=users&oper=group&group_id='+V_GROUP,
	editurl: 'php/ajax.php?i=users&act=group_add_edit&group_id='+V_GROUP+'&location_id='+V_Group_2_Location[V_GROUP][0],
	loadonce: true,
	iconSet: 'fontAwesome',
	idPrefix: idPrefix,
	pager: pager,
	sortname: 'id',
	//caption: LU.HEADER,
	pgbuttons: true,
	rowNum: 10,
	rowList:[5,10,20,30,50,100,200,500,'999999:Alle'],
	//loadonce: true,
	multiselect:true,
	colNames:['', LANG.ID, LU.USERNAME, LU.PASSWORD, LU.PASS_CONFIRM, LU.FIRSTNAME, LU.LASTNAME, LU.BIRTH_DATE, LU.SPORT, LU.SEX, LU.BODY_HEIGHT, LU.EMAIL, LU.TELEPHONE, LU.LEVEL, LU.LAST_LOGIN, LU.LOGIN_COUNT, LANG.CREATED, LANG.MODIFIED, LANG.STATUS],
	colModel:[
		{ //inline editing buttons and options
			name: 'acc', hidden:!(V_ADMIN||V_LOCATION_ADMIN||V_GROUP_ADMIN||V_GROUP_ADMIN_2), width:22, fixed:true, sortable:false, editable:false, search: false, resizable:false, formatter:'actions', 
			formatoptions:{
				keys:true, //[Enter]=save,[Esc]=cancel
				delbutton:false,
				editformbutton:true, 
				editOptions:{
					width:400,
					afterShowForm: function(form) {
						//gray out not used fields
						$('input[readonly], select[readonly]').css({'background-color':'#eee','background-image':'none'});
						$('#sport').chosen({placeholder_text_multiple: LU.SPORT, no_results_text:'Nichts gefunden!'});
						$('#sport_chosen .chosen-results').css('max-height', '195px');
						$('.navButton').hide();
					},
					afterComplete: function (response, postdata, formid) {
						if (V_GROUP_ADMINS_OPTIONS != undefined) {
							//Group Admins Reset
							$.ajax({url:'php/ajax.php?i=groups&oper=groups_admins&location_id='+V_Group_2_Location[V_GROUP][0], success:function(data, result) {
								V_GROUP_ADMINS_OPTIONS = data;
								$location_groups.jqGrid('setColProp', 'admins_id', { editoptions: { value: V_GROUP_ADMINS_OPTIONS } });
							}});
						}
					}
				}
			}
		},
		{name:'id',key:true, width:35, align:"center", hidden:true, /*formatter:'number',*/ sorttype:'int'},
		{name:'uname',		 width:80, hidden:true, editrules:{edithidden:true}	/*editoptions:{readonly:'readonly'}*/ },
		{name:'passwd', 	 width:50, edittype:'password', hidden:true, editrules:{edithidden:true} },
		{name:'pass_confirm', width:50, edittype:'password', hidden:true, editrules:{edithidden:true} },
		{name:'firstname', 	width:90},
		{name:'name', 	 	width:90},
		{name:'birth_date', width:98, align:"right", 
			sorttype:"date", formatter:"date", formatoptions:{srcformat:"Y-m-d", newformat:LANG.GRID.DATE},
			editoptions:{ dataInit:initDate, style:"width:120px" },
			searchoptions: { sopt: ['cn', 'eq', 'ne', 'lt', 'le', 'gt', 'ge'] }
		},
		{name:'sport', width:80,
				formatter:"select", edittype:"select", align:"center",
				editoptions:{value: V_SPORTS_OPTIONS, defaultValue: '000', size:3, style:"width:200px", multiple:true}
		},
		{name:'sex', width:60,
				formatter:"select", edittype:"select", align:"center",
				editoptions:{value: "0:"+LU.SEX_MALE+";1:"+LU.SEX_FEMALE, defaultValue: '0', size:1, style:"width:120px"},
				stype:'select', searchoptions: {sopt:['eq', 'ne'], value:":;0:"+LU.SEX_MALE+";1:"+LU.SEX_FEMALE},
		},
		{name:'body_height', width:40,
				formatter:"select", edittype:"select", align:"center",
				editoptions:{value: V_BODY_HEIGHT_OPTIONS, defaultValue: '100 cm', size:1}
		},
		{name:'email', width:130, hidden:true, editrules:{edithidden:true} },
		{name:'telephone', width:130, hidden:true, editrules:{edithidden:true} },
		{name:'level', width:65,
				formatter:"select", edittype:"select", align:"center",
				editoptions:{value: V_USER_LVL_OPTIONS, defaultValue: '10', size:1, style:"width:180px"},
				stype:'select', searchoptions: {sopt:['eq', 'ne'], value:":;"+V_USER_LVL_OPTIONS},
		},
		{name:'lastlogin', 	width:64, hidden:true, editrules:{edithidden:true}, editoptions:{readonly:'readonly'} },
		{name:'logincount', width:40, hidden:true, editrules:{edithidden:true}, editoptions:{readonly:'readonly'}, align:"right" },
		{name:'created', 	width:64, hidden:true, editrules:{edithidden:true}, editoptions:{readonly:'readonly'} },
		{name:'modified', 	width:64, hidden:true, editrules:{edithidden:true}, editoptions:{readonly:'readonly'} },
		{name:'status',		width:30, formatter:"select", edittype:"select", align:"center",
			fixed:true, editable:false, resizable:false,
			editoptions:{value: req_status},
			stype:'select', searchoptions: {sopt:['eq', 'ne'], value: req_status}
		}
	],
	loadComplete: function(data) {
		//goto currentPage
		if (this.p.datatype === 'json' && currentPage !=1) {
			setTimeout(function() {
				$group_users.trigger("reloadGrid",[{page:currentPage}]);
			}, 250);
		}
		else if (this.p.datatype === 'json') {
			setTimeout(function() {
				$group_users.trigger("reloadGrid",[{current:true}]);
			}, 250);
		}
	}
})
//Column Search
.jqGrid('filterToolbar',{
	stringResult:true, //send as Json //filters
	searchOnEnter:false,
	defaultSearch: 'cn'
})
//bottom bar
.jqGrid('navGrid',pager,{
	iconsOverText: true,
	edit: false,	edittext: LANG.BUTTON_EDIT,
	add: (V_ADMIN||V_LOCATION_ADMIN||V_GROUP_ADMIN||V_GROUP_ADMIN_2), addtext: LANG.BUTTON_ADD,
	del: false, 	deltext: LANG.BUTTON_DELETE,
	search: false, 	searchtext: LANG.BUTTON_SEARCH,
	view: false, 	viewtext: LANG.BUTTON_VIEW,
	refresh: false, refreshtext: LANG.BUTTON_RELOAD
},
{}, //edit
{ //add
	width:400,
	afterShowForm: function(form) {
		//gray out not used fields
		$('input[readonly], select[readonly]').css({'background-color':'#eee','background-image':'none'});
		$('#sport').chosen({placeholder_text_multiple: LU.SPORT, no_results_text:'Nichts gefunden!'});
		$('#sport_chosen .chosen-results').css('max-height', '195px');
		currentPage = $group_users.jqGrid("getGridParam", "page"); //for loadComplete
	},
	afterComplete: function (response, postdata, formid) {
		if (V_GROUP_ADMINS_OPTIONS != undefined) {
			//Group Admins Reset
			$.ajax({url:'php/ajax.php?i=groups&oper=groups_admins&location_id='+V_Group_2_Location[V_GROUP][0], success:function(data, result) {
				V_GROUP_ADMINS_OPTIONS = data;
				$location_groups.jqGrid('setColProp', 'admins_id', { editoptions: { value: V_GROUP_ADMINS_OPTIONS } });
			}});
		}
	}
},
{}, //del
{}, //search
{}  //view
);


/* //get it from grid.group_users.php
//Sports Options Reset
$.ajax({url:'php/ajax.php?i=sports&oper=sports_options', success:function(data, result) {
	V_SPORTS_OPTIONS = '00'+data;
	$group_users.jqGrid('setColProp', 'sport', { editoptions: { value: V_SPORTS_OPTIONS } });
}});
//BodyHeight Options Reset
$.ajax({url:'php/ajax.php?i=dropdowns&oper=user_height', success:function(data, result) {
	V_BODY_HEIGHT_OPTIONS = data;
	$group_users.jqGrid('setColProp', 'body_height', { editoptions: { value: V_BODY_HEIGHT_OPTIONS } });
}});
*/

$(pager).children().children().css('table-layout', 'auto'); //fix pager width
$('#gbox_group_users').removeClass('ui-corner-all').addClass('ui-corner-bottom')
$('#gbox_group_users .ui-jqgrid-hdiv').css('overflow', 'visible'); //fix header for chosen

//Request Status Select ###############################################################
$('select[name="status"]').chosen({width:'26px', disable_search:true});


/*$("#selectAll").on('click',function(){
	$group_users.jqGrid('resetSelection'); //clear select
	var ids = $group_users.jqGrid('getDataIDs');
	for (var i=0, il=ids.length; i < il; i++) {
		$group_users.jqGrid('setSelection',ids[i], true);
	}
});*/


var group_users_ids = [];
function get_Group_Users_IDS_Names() {
	group_users_ids = [];
	var ids = $group_users.jqGrid('getGridParam','selarrrow'); //selected rows
	var ids_uncheck = [];
	var header = LANG.REQUEST.NOBODY_SELECTED;
	var add_ID_name = function(id, status) {
		group_users_ids.push(id+'_'+status);
		names.push('<li>'+$group_users.jqGrid('getCell', id, 'firstname') +' '+ $group_users.jqGrid('getCell', id, 'name'));
	};
	if (ids.length>0) {
		var names = [];
		for (var i=0, i1=ids.length; i < i1; i++) {
			var status = $('#'+ids[i]+' td:last').text();
			if (status == '1' || status == '10') {
				add_ID_name(ids[i], status);
				header = LANG.REQUEST.CANCEL_ACCESS_TO;
			}
			else ids_uncheck.push(ids[i]);
		}
		for (var i=0, i2=ids_uncheck.length; i < i2; i++) {
			$group_users.jqGrid('setSelection',ids_uncheck[i], false);
		}
		return '<b>'+header+'</b><br><hr style="margin:10px -10px;">'+names.join("<br> ");
	}
	else return '<b>'+header+'</b><br>';
}

$("#group_user_cancel_access_groupadmin").confirmation({
	href: 'javascript:void(0)',
	html:true, placement: 'top',
	title: function() { return get_Group_Users_IDS_Names(); },
	btnOkLabel: LANG.YES, btnOkClass: 'btn btn-sm btn-success mr10',
	btnCancelLabel: LANG.NO, btnCancelClass: 'btn btn-sm btn-danger',
	onConfirm: function(e, button) {
		if (group_users_ids.length != 0) {
			var data = {request: 'user2group_Answer', action: 'group_user_cancel_access_groupadmin', group_id: V_GROUP, group_users_ids: group_users_ids};
			$.post('index/ajax.request.php', data, function(data, result){
				$("#req_group_users_message").html(data);
				//reload grid
				currentPage = $group_users.jqGrid("getGridParam", "page"); //for loadComplete
				$group_users.trigger("reloadGrid", { fromServer: true }); //free-jqgrid only
			});
		}
	}
});


function Responsive_Group_Users() { 
    var p_width = $('#C_Group_Users_link').prop('clientWidth');// Get width of parent container
    if (p_width == null || p_width < 1){
        p_width = $('#C_Group_Users_link').prop('offsetWidth'); // For IE, revert to offsetWidth if necessary
    }
    p_width = p_width - 2; //prevent horizontal scrollbars
	if (p_width != $group_users.width()) {
		$group_users.jqGrid('setGridWidth', p_width);
	}
}
Responsive_Group_Users();

//on window resize -> resize grids
$(window).on('resize', function() {
	Responsive_Group_Users();
}).trigger('resize');


} //end if (group_users)

}); //end jQuery(document).ready