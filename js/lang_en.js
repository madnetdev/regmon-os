LANG = {
	LANG_CURRENT	: 'en', //not change
	
	//moment date format
	MOMENT : {
		DATE 			: 'YYYY-MM-DD', //default --not used
		DATE_TIME 		: 'YYYY-MM-DD HH:mm:ss', //default --not used
		DATE_TIME_NOSECS: 'YYYY-MM-DD HH:mm', //default --not used
	},
	//grid date format
	GRID : {
		DATE 			: 'Y-m-d',
		DATE_TIME 		: 'Y-m-d H:i:s',
	},
	//datepicker date format
	DATEPICKER : {
		DATE 			: 'yy-mm-dd',
	},

	//Date Select
	DATE_TODAY 			: 'Today',
	DATE_CLEAR 			: 'Clear selection',
	DATE_CLOSE 			: 'Close',
	DATE_SELECT_TIME 	: 'Select Time',
	DATE_MONTH_SELECT 	: 'Select Month',
	DATE_MONTH_PREV 	: 'Previous Month',
	DATE_MONTH_NEXT 	: 'Next Month',
	DATE_YEAR_SELECT 	: 'Select Year',
	DATE_YEAR_PREV 		: 'Previous Year',
	DATE_YEAR_NEXT 		: 'Next Year',
	DATE_DECADE_SELECT	: 'Select Decade',
	DATE_DECADE_PREV	: 'Previous Decade',
	DATE_DECADE_NEXT	: 'Next Decade',
	DATE_CENTURY_PREV 	: 'Previous Century',
	DATE_CENTURY_NEXT 	: 'Next Century',	
	
	ID 				: 'ID',
	STATUS 			: 'Status',
	ST_ACTIVE 		: 'Active',
	ST_INACTIVE		: 'Inactive',
	ST_PRIVATE 		: 'Private',
	CREATED			: 'Created',
	CREATED_BY		: 'Created by',
	MODIFIED		: 'Changed',
	MODIFIED_BY		: 'Changed by',
	ARE_YOU_SURE	: 'Are you sure?',
	YES				: 'Yes',
	NO				: 'No',
	OK				: 'OK',
	CLOSE			: 'Close',
	BACK			: 'Back',
	SEARCH			: 'Search',
	NO_RESULTS 		: 'Nothing found!',
	NEW_OPTION 		: 'New option',
	SELECT_OPTION 	: 'Select an Option',
	SELECT_TRAINER 	: 'Select a Trainer',
	SELECT_ATHLETE 	: 'Select an Athlete',
	NOTHING_SELECTED: 'Nothing selected',
	GROUPING_NO		: 'No grouping',
	GROUPING_BY		: 'Grouping by',

	//Page Warnings
	PROBLEM_LOADING_PAGE	: 'The requested content cannot be loaded.<br>Please try again later.',
	LEAVE_PAGE_WARNING		: 'Do you really want to leave this page?\nAll changes will be lost',
	WARN_CONFIRM_PASSWORD 	: 'Warning! Password and Password Confirm do not match',
	WRITE_ACCESS_PROBLEM 	: 'Data entry for this group is paused or finished.<br><br>Please contact a group admin for more information.',
	WARN_USERNAME_EXIST 	: 'Warning! This name is already taken. <br> Please use a different name.',
	
	CONFIRM_DELETE_ENTRY 	: 'Do you really want to delete the selected entry?',
	ENTRY_DELETED_SUCCESS 	: 'Entry Deleted.',
	NOT_HAVE_ACCESS_RIGHTS 	: 'You do not have access rights',

	//Buttons
	BUTTON_ADD 				: 'Add',
	BUTTON_EDIT 			: 'Edit',
	BUTTON_DELETE 			: 'Delete',
	BUTTON_CANCEL 			: 'Cancel',
	BUTTON_VIEW 			: 'View',
	BUTTON_SEARCH 			: 'Search',
	BUTTON_RELOAD 			: 'Reload',
	BUTTON_SAVE 			: 'Save',
	BUTTON_DUPLICATE		: 'Form Duplicate',
	//index buttons
	BUTTON_DATUM 			: 'Date',
	BUTTON_DATUM_TOOLTIP 	: 'Go to Date',
	BUTTON_COMMENT 			: 'Comment',
	BUTTON_COMMENT_TOOLTIP 	: 'Add Comment',

	//messages
	UPDATE_OK	: 'Updated successfully!',
	INSERT_OK	: 'Inserted successfully!',
	DELETE_OK	: 'Deleted successfully!',

	LOGIN : {
		ACCESSIBILITY_ALT 			: 'Sound icon',
		ACCESSIBILITY_TITLE 		: 'Accessibility option: listen to a question and answer it!',
		ACCESSIBILITY_DESCRIPTION 	: 'Type below the <strong>answer</strong> to what you hear. Numbers or words:',
		CAPTCHA_EXPLANATION 		: 'Click or touch the <strong>ANSWER</strong>',
		CAPTCHA_REFRESH_ALT 		: 'Refresh/reload icons',
		CAPTCHA_REFRESH_TITLE 		: 'Refresh/reload icons'
	},

	LOCATIONS : {
		HEADER 		: 'Locations',
		NAME 		: 'Location Name',
		ADMIN 		: 'Location Admin'
	},
	
	GROUPS : {
		HEADER 				: 'Groups',
		LOCATION			: 'Location',
		NAME 				: 'Group name',
		PRIVATE 			: 'Private',
		PRIVATE_KEY 		: 'Private<br> Key',
		PRIVATE_KEY_ERROR 	: 'Privat Schlüssel Fehler',
		ADMIN 				: 'Group<br> Admin',
		STOP_DATE 			: 'Available<br> Until',
	},
	
	USERS : {
		HEADER 			: 'Users',
		ACCOUNT 		: 'Account',
		USERNAME 		: 'Username',
		PASSWORD 		: 'Password',
		PASS_CONFIRM	: 'Password Confirm',
		LASTNAME 		: 'Last Name',
		FIRSTNAME 		: 'First name',
		BIRTH_DATE 		: 'Birth date',
		SPORT 			: 'Sport',
		SEX 			: 'Gender',
		SEX_MALE 		: 'Male',
		SEX_FEMALE		: 'Female',
		SEX_OTHER		: 'Other',
		BODY_HEIGHT 	: 'Body height',
		EMAIL 			: 'Email',
		TELEPHONE 		: 'Mobile',
		LEVEL 			: 'Level',
		GROUP 			: 'Group (active)',
		LOCATION 		: 'Location (active)',
		LAST_LOGIN 		: 'Last Login',
		LOGIN_COUNT 	: 'Number of Logins',
		LAST_IP 		: 'Last IP',
		ERGEBNISSE 		: 'Results',
		
		//LEVELS
		LVL_ADMIN 			: 'Admin',
		LVL_LOCATION 		: 'Location Admin',
		LVL_GROUP_ADMIN		: 'Group Admin',
		LVL_GROUP_ADMIN_2	: 'Group Admin (reduced)',
		LVL_ATHLETE			: 'Athlete',
		LVL_TRAINER 		: 'Trainer'
	},

	CATEGORIES : {
		HEADER 		: 'Categories',
		NAME 		: 'Category',
		PARENT 		: 'Parent Category',
		COLOR 		: 'Color',
		ORDER 		: 'Order',
		FORMS 		: 'Forms',
		FORMS_COUNT	: 'Number of<br> Forms',
		AVAILABLE 	: 'Available',
		STANDARD 	: 'Proposed',
		READ 		: 'Read',
		WRITE 		: 'Write'
	},
		
	FORMS : {
		CATEGORIES 		: 'Categories',
		NAME 			: 'External Name',
		NAME2 			: 'Internal Name',
		TAGS 			: 'Tags',
		DETAILS 		: 'Details',
		AVAILABLE 		: 'Available',
		STANDARD 		: 'Proposed',
		READ 			: 'Read',
		WRITE 			: 'Write',
		OPEN_CLOSE_ALL 	: 'Close all / Expand all',
		FORM_EDIT		: 'Edit Form',
		FORM_SAVED		: 'Form Saved.',
		FORM_DATA_SAVED	: 'Form Data Saved.',
		FORM_DB_ERROR	: 'ERROR!<br>DB error. Update failed.',
		
		DISPLAY_TIMES	: 'Display this page only the first X times',
		DISPLAY_TIMES_INFO: 'Conditions for using this function: \n There must be no required field on this page nd the form must contain at least one other page that is always displayed.',
		DISPLAY_TIMES_0	: 'Always',
		DISPLAY_TIMES_1	: '1 time',
		DISPLAY_TIMES_2	: '2 times',
		DISPLAY_TIMES_3	: '3 times',
		DISPLAY_TIMES_4	: '4 times',
		DISPLAY_TIMES_5	: '5 times',
		DISPLAY_TIMES_FIELD_ERROR : 'Warning!<br>Display this page only the first X times:<br> - There must be no required field on this page',
		DISPLAY_TIMES_FIELD_ERROR : 'Warning!<br>Conditions for using this function:<br> There must be no required field on this page and the form must contain at least one other page that is always displayed.',

		ITEM_DELETE		: 'Delete',
		ITEM_SAVE		: 'Save',
		ITEM_CANCEL		: 'Cancel',
		ITEM_RESET		: 'Reset',
		ITEM_WIDTH		: 'Width',
		ITEM_EMPTY		: 'Empty',
		ITEM_SPACE		: 'Space',
		ITEM_LINE		: 'Line',
		ITEM_LABEL		: 'Label',
		ITEM_TEXT_HTML	: 'Text (Html)',
		ITEM_TEXT		: 'Text',
		ITEM_TEXTAREA	: 'Textarea',
		ITEM_NUMBER		: 'Number',
		ITEM_DATE		: 'Date',
		ITEM_TIME		: 'Time',
		ITEM_PERIOD		: 'Period',
		ITEM_DROPDOWN	: 'Dropdown',
		ITEM_RADIO		: 'Radio Buttons',
		ITEM_ACCORDION	: 'Accordion',
		ITEM_ACCORDION_PANEL : 'Accordion Panel',
		
		FORM_TITLE			: 'Page',
		PAGE_TITLE 			: 'Page Title',
		CENTER				: 'Centered',
		FORM_ITEM_ADD		: 'Add New Item',
		FORM_ROW_ADD		: 'Add New Row',
		FORM_ROW_DUPLICATE	: 'Duplicate Row',
		FORM_ROW_DELETE		: 'Delete Row',
		ATHLETE_SELECT_SAVE : 'Form selection saved.',
		GROUP_SELECT_SAVE 	: 'Available forms saved for this Group. <br>Group:',
		ATHLETE_2_TRAINER_SELECT_SAVE: 'Form selection saved. <br>Trainer: ',

		TIME_BETWEEN_ERROR	: 'Please enter a valid time, between 00:00 and 23:59',
		TIME_LIMIT_EXCEEDED : 'You have exceeded the time limit. Would you like to fill in the form again?',
		
		GROUP_SELECT_SEARCH 	: 'Search...',
		GROUP_SELECT_PLACEHOLDER: 'Select Group...',
		GROUPS_SELECTED 		: 'Selected Groups',
		GROUPS_SELECT_ALL 		: 'Select All',
		GROUPS_ALL_SELECTED 	: 'All Selected',
		GROUPS_SELECT_NO_GROUP 	: 'No Group',
		
		ATHLETE_SELECT_SEARCH 		: 'Search...',
		ATHLETE_SELECT_PLACEHOLDER	: 'Select Athlete...',
		ATHLETES_SELECTED 			: 'Selected Athletes',
		ATHLETES_SELECT_ALL 		: 'Select All',
		ATHLETES_ALL_SELECTED 		: 'All Selected',
		ATHLETES_SELECT_NO_ATHLETE 	: 'No Athlete',
		
		DEFAULT_TEMPLATE_SELECT : 'Please select default form template',
		PARENTHESES_ERROR 		: 'Parentheses Error',
		ALLOWED_CHARS_ERROR 	: 'only allowed "({+-*/._})" and numbers',
	},
	
	FORMS2CATEGORIES : {
		CATEGORY 	: 'Category',
		FORM_SELECT : 'Form<br> Select',
		FORM_ID		: 'Form<br> ID',
		FORM_NAME	: 'Form',
		ORDER 		: 'Order',
		STOP_DATE 	: 'Available<br> Until',
	},
	
	DROPDOWN : {
		HEADER 		: 'Dropdown menu',
		NAME 		: 'Name',
		OPTIONS 	: 'Options',
		PARENT_ID 	: 'Parent ID',
		OPTION_PLACEHOLDER : 'Option or NUM__Option'
	},
	
	SPORTS : {
		HEADER 		: 'Sports',
		OPTIONGROUP : 'Sport Groups',
		OPTIONS 	: 'Sports',
		NAME 		: 'Sport Names',
		PARENT_ID 	: 'Parent ID'
	},
	
	TAGS : {
		HEADER 		: 'Tags',
		NAME 		: 'Tag Names'
	},
	
	TEMPLATES : {
		FORM_ID 		: 'Form<br>ID',
		FORM_NAME 		: 'Form Name',
		FORM_STATUS 	: 'Form<br>Status',
		USER_ID 		: 'User<br>ID',
		LOCATION_ID 	: 'Location<br>ID',
		GROUP_ID 		: 'Group<br>ID',
		TEMPLATE_ID 	: 'Template<br>ID',
		TEMPLATE_NAME 	: 'Template Name',
		Y_AXIS_ID 		: 'Y-Axis<br>ID',
		Y_AXIS_NAME 	: 'Y-Axis Name',
	},

	PERMISSIONS : {
		GLOBAL_VIEW 	: 'Global<br>View',
		GLOBAL_EDIT 	: 'Global<br>Edit',
		LOCATION_VIEW 	: 'Location<br>View',
		LOCATION_EDIT 	: 'Location<br>Edit',
		GROUP_VIEW 		: 'Group<br>View',
		GROUP_EDIT 		: 'Group<br>Edit',
		TRAINER_VIEW 	: 'Trainer<br>View',
		TRAINER_EDIT 	: 'Trainer<br>Edit',
		PRIVATE 		: 'Private',
	},

	RESULTS : {
	},

	//Dashboard
	DASH : {
		NAME 			: 'Name',
		COLOR 			: 'Color',
		POSITION 		: 'Position',
		TYPE 			: 'Type',
		SELECT_TYPE 	: 'Select Type',
		TYPE_CALENDAR 	: 'Calendar',
		TYPE_OPTIONS 	: 'Options',
		TYPE_FORMS 		: 'Forms',
		TYPE_RESULTS 	: 'Results',
		TYPE_RESULTS_GRP: 'Results (Group)',
		VIEW		 	: 'View',
		VIEW_SELECT	 	: 'Select View',
		VIEW_MONTH	 	: 'Month View',
		VIEW_WEEK	 	: 'Week View',
		VIEW_DAY	 	: 'Day View',
		DATE	 		: 'Date',
		DATE_CURRENT	: 'Current Date',
		OPTION			: 'Option',
		OPTION_SELECT	: 'Select Option',
		OPTION_1		: 'Forms Selection',
		OPTION_2		: 'Data Management (Import, Export)',
		OPTION_3		: 'Group Access',
		OPTION_4		: 'Group Users',
		OPTION_5		: 'Leave the Training Group',
		OPTION_6		: 'Athlete Management',
		OPTION_7		: 'Approvals of the Athletes',
		OPTION_8		: 'Trainer Management',
		OPTION_9		: 'Trainer Approvals',
		OPTION_10		: 'Group Available Forms',
		OPTION_11		: 'Forms',
		OPTION_12		: 'Categories',
		OPTION_13		: 'Lists (Sports, Dropdowns, etc.)',
		OPTION_14		: 'Location Groups',
		OPTION_15		: 'Import',
		OPTION_16		: 'Export',
		FORM			: 'Form',
		FORM_SELECT		: 'Form Select',
		FORM_COLOR_USE	: 'use Form Color',
		TEMPLATE		: 'Template',
		TEMPLATE_SELECT	: 'Template Select',
		PERIOD			: 'Period',
		PERIOD_TEMPLATE	: 'Template Period',
		PERIOD_STATIC	: 'static',
		PERIOD_DYNAMIC	: 'dynamic',
		PERIOD_FROM		: 'From',
		PERIOD_TO		: 'To',
		PERIOD_LAST		: 'The last',
		PERIOD_LAST_MINS	: 'Minutes',
		PERIOD_LAST_HOURS	: 'Hours',
		PERIOD_LAST_DAYS	: 'Days',
		PERIOD_LAST_WEEKS	: 'Weeks',
		PERIOD_LAST_MONTHS	: 'Months',
		PERIOD_LAST_YEARS	: 'Years',
	},

	REQUEST : {
		WAS_SENT_AT			: 'The request was sent at {DATE_TIME}',
		STATUS_UPDATED		: 'Status updated at {DATE_TIME}',
		USER_LEAVE_GROUP	: 'leave Group', //leave Group (by User)
		NOBODY_SELECTED		: 'Nobody Selected',
		REQUEST_ACCESS_FROM	: 'Request access from :',
		CANCEL_REQUEST_FROM	: 'Cancel requests from :',
		CANCEL_ACCESS_TO	: 'Cancel Access to :',
	},

	//Request Status Icons Explain (tooltips) --> the same on .php file
	R_STATUS : {
		NO_REQUEST				: 'No Request', //. No request yet
		REQUEST_REJECTED		: 'Request Rejected', //0 Request Rejected
		REQUEST_ACCEPTED		: 'Request Accepted', //1 Request Accepted
		CANCELED_ACCESS_TRAINER	: 'Canceled Access (by Trainer)', //5 Canceled Access (by Trainer)
		CANCELED_ACCESS_ATHLETE	: 'Canceled Access (by Athlete)', //15 Canceled Access (by Athlete)
		REQ_WAIT_CANCELED_TRAINER: 'Waiting Access (after Canceled Access by Trainer)', //7 Waiting Access (after Canceled Access by Trainer)
		REQ_WAIT_CANCELED_ATHLETE: 'Waiting Access (after Canceled Access by Athlete)', //17 Waiting Access (after Canceled Access by Athlete)
		REQ_WAIT_REJECTED_ATHLETE: 'Waiting Access (after Rejected Request by Athlete)', //8 Waiting Access (after Rejected Request by Athlete)
		REQUEST_WAIT			: 'Waiting Access', //9 Waiting Access (New - first time)
		//Group ############################################################
		CANCELED_ACCESS_USER	: 'Canceled Access (by User)', //5 Canceled Access (by User)
		CANCELED_ACCESS_GROUP	: 'Canceled Access (by Groupadmin)', //15 Canceled Access (by Groupadmin)
		REQ_WAIT_CANCELED_USER	: 'Waiting Access (after Canceled Access by User)', //7 Waiting Access (after Canceled Access by User)
		REQ_WAIT_CANCELED_GROUP	: 'Waiting Access (after Canceled Access by Groupadmin)', //17 Waiting Access (after Canceled Access by Groupadmin)
		REQ_WAIT_REJECTED_USER	: 'Waiting Access (after Rejected Request by Groupadmin)', //8 Waiting Access (after Rejected Request by Groupadmin)
		REQ_WAIT_NEW_USER		: 'New account', //10 New Account
		REQ_WAIT_USER_INACTIVE	: 'Inactive Account', //11 Inactive Account
	},

	
	END : 'End'
};
