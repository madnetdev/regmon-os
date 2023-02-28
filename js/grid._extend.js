var V_LOCATION_OPTIONS,
	V_LOCATION_ADMINS_OPTIONS,
	V_GROUP_OPTIONS,
	V_GROUP_ADMINS_OPTIONS,
	V_FEATURES_OPTIONS,
	V_FEATURES_CAT_OPTIONS,
	V_SPORTS_GROUP_OPTIONS,
	V_SPORTS_OPTIONS,
	V_SPORTS_SELECT,
	V_BODY_HEIGHT_OPTIONS,
	V_TIME_OUT_AFTER_SAVE = 2000,
	V_GRID_SAVE = false,
	V_ADMIN_VIEW = false;

var numberTemplate = {
	formatter: "number", align: "right", sorttype: "number",
	editrules: {number: true, required: true},
	searchoptions: { sopt: ["eq", "ne", "lt", "le", "gt", "ge", "nu", "nn", "in", "ni"] }
};
var checkboxTemplate = {
	formatter: "checkbox", /*formatoptions: { disabled: false},*/ align: "center", 
	edittype: "checkbox", editoptions: {value: LANG.YES+":"+LANG.NO, defaultValue: LANG.YES},
	stype: "select", searchoptions: { sopt: ["eq", "ne"], value: ":;1:"+LANG.YES+";0:"+LANG.NO }
};
var aktivInaktivTemplate = {
	fixed:true, align:"center",
	formatter:"select", edittype:"select", stype:'select', 
	searchoptions: {sopt:['eq','ne'], value:":;1:"+LANG.ST_ACTIVE+";0:"+LANG.ST_INACTIVE},	
	editoptions:{value:"1:"+LANG.ST_ACTIVE+";0:"+LANG.ST_INACTIVE, defaultValue:'1', size:1},
	cellattr: function(rowId, val) {
		if (val==1) return " style='color:green;'"; //active
		else return " style='color:red;'"; //inactive
	}
};
var hiddenReadonlyTemplate = { hidden:true, editrules:{edithidden:true}, editoptions:{readonly:'readonly'}};

jQuery(function() {
	if (typeof $.blockUI == 'function') V_ADMIN_VIEW = true;
	if (!V_ADMIN_VIEW) V_TIME_OUT_AFTER_SAVE = 1000;
	
	//JQGRID EXTEND /////////////////////////////////////////////////////
	//options
	$.extend($.jgrid.defaults, {
		datatype: "json",
		gridview: true,
		sortname: 'id',
		sortorder: "asc",
		iconSet: 'fontAwesome',
		pgbuttons: false, //look nice with arrows
		//pgtext: '',
		viewrecords: true, //view 1 - 1 of 10
		rowNum: 999,
		//rowList:[20,40,60,80,100],
		multiselect: false,
		altRows: true,
		//height: '100%', //def
		headertitles:true,
		sortable: true, //reorder columns
		//multiSort: true, //gives error
		sortIconsBeforeText: true,
		searching: { searchOnEnter: false, searchOperators: false },
		ignoreCase: true,
		autoencode: false,
		//autowidth: true, //width: '100%',
		//shrinkToFit: true,
		loadError: function(xhr,st,err) { 
			if (xhr.responseText == 'session expired') window.location.href = ".";
		},
		cmTemplate: {/*sortable:false,*/ editoptions:{size:25}, editable:true, searchoptions: {
			sopt: ['cn', 'nc', 'eq', 'ne', 'lt', 'le', 'gt', 'ge', 'bw', 'bn', 'ew', 'en', 'nu', 'nn', 'in', 'ni']
		}}
	});
	
	//edit + add -- inline + nav
	$.extend($.jgrid.edit, {
		width:330, 
		recreateForm:true,
		closeOnEscape:true,
		//closeAfterAdd: true,
		afterShowForm: function(form) {
			//gray out not used fields
			$('input[readonly], select[readonly], textarea[readonly]').css({'background-color':'#eee','background-image':'none'});
			$('select[readonly]').attr("disabled", "disabled");
		},
		beforeSubmit : function(postdata, formid) {
			if (V_ADMIN_VIEW) $.blockUI({ message: '' }); ////////////////////////
			else {
				V_GRID_SAVE = true;
			}
			return [true, ''];
		},
		afterSubmit: function (jqXHR) {
			var this_id = this.id;
			var myInfo = '<div class="ui-state-highlight ui-corner-all">' +
							'<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' +
							'<span>'+(jqXHR.responseText=="OK_insert" ? LANG.INSERT_OK : LANG.UPDATE_OK)+'</span></div>',
				$infoTr,
				$infoTd;

			if (jqXHR.responseText !== "OK_insert" && jqXHR.responseText !== "OK_update") {
				V_GRID_SAVE = false;
				if (V_ADMIN_VIEW) {$.unblockUI();} ////////////////////////
				else loading.hide();
				return [false, '<span class="ui-icon ui-icon-alert" style="float:left;"></span>'+
									'<span style="display:block; padding:1px 0px 0px 20px;">'+jqXHR.responseText+'</span>'];
			}

			$infoTr = $("table#TblGrid_"+ this_id +">tbody>tr.tinfo");
			$infoTd = $infoTr.children("td.topinfo");
			$infoTd.html(myInfo);
			$infoTr.show();

			// hide the info after 2 sec timeout
			setTimeout(function () {
				$infoTr.fadeOut("slow", function () {
					$infoTr.hide();
					$('#edithd'+ this_id +' > a').trigger("click"); //close after add is ok
					V_GRID_SAVE = false;
					if (V_ADMIN_VIEW) $.unblockUI(); ////////////////////////
					else loading.hide();
				});
			}, V_TIME_OUT_AFTER_SAVE);
			$(this).jqGrid('setGridParam', {datatype:'json'}); //if loadonce:true need this to reload grid
			return [true, "", ""]; //response should be interpreted as successful
		}
	});
	
	//delete
	$.extend($.jgrid.del, {
		closeOnEscape:true,
		//recreateForm: true,
		//reloadAfterSubmit: true,
		beforeSubmit : function(postdata, formid) {
			if (V_ADMIN_VIEW) $.blockUI({ message: '' }); ////////////////////////
			else loading.show();
			return [true, ''];
		},
		afterSubmit: function (jqXHR) {
			if (V_ADMIN_VIEW) $.unblockUI(); ////////////////////////
			else loading.hide();
			
			if (jqXHR.responseText !== "OK_delete") {
				return [false, '<span class="ui-icon ui-icon-alert" style="float:left;"></span>'+
									'<span style="display:block; padding:1px 0px 0px 20px;">'+jqXHR.responseText+'</span>'];
			}
			$(this).jqGrid('setGridParam', {datatype:'json'}); //if loadonce:true need this to reload grid
			return [true, "", ""]; //response should be interpreted as successful
		}
	});
	
	//view
	$.extend($.jgrid.view, {
		width:300,
		beforeShowForm: function(form) {
			//hide the edit icon inside id value
			setTimeout(function () {
				$('#v_id').find('span:first').css('display','none');
			}, 100);
		}
	});

}); //end jQuery(document).ready