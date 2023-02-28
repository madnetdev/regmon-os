LANG = {
	LANG_CURRENT	: 'de', //not change
	
	ALL				: 'Alle',
	ID 				: 'ID',
	STATUS 			: 'Status',
	ST_ACTIVE 		: 'Aktiv',
	ST_INACTIVE		: 'Inaktiv',
	CREATED			: 'Erstellt',
	CREATED_BY		: 'Erstellt von',
	MODIFIED		: 'Geändert',
	MODIFIED_BY		: 'Geändert von',
	ARE_YOU_SURE	: 'Sind Sie sicher?',
	YES				: 'Ja',
	NO				: 'Nein',
	OK				: 'OK',
	CLOSE			: 'Ende',
	BACK			: 'Zurück',
	SEARCH			: 'Suche',
	NO_RESULTS 		: 'Nichts gefunden!',
	NEW_OPTION 		: 'Neue Option',
	SELECT_OPTION 	: 'Wähle eine Option',
	SELECT_TRAINER 	: 'Wähle einen Trainer',
	SELECT_ATHLETE 	: 'Wähle einen Sportler',
	NOTHING_SELECTED: 'nichts ausgewählt',
	GROUPING_NO		: 'keine Gruppierung',
	GROUPING_BY		: 'Gruppierung nach',

	//Page Warnings
	PROBLEM_LOADING_PAGE	: 'Die aufgerufene Seite kann nicht geladen werden.<br>Bitte versuchen Sie es später noch einmal.',
	LEAVE_PAGE_WARNING		: 'Wollen Sie die Seite wirklich verlassen?\n\nAlle Änderungen werden verloren gehen',
	TIME_END_WARNING		: 'Du hast die Pausenzeit überschritten. Möchtest du den Fragebogen erneut ausfüllen? …',
	INVALID_TIME 			: 'Bitte geben Sie ein gültiges Uhrzeit ein.',
	WARN_CONFIRM_PASSWORD	: 'Warnung! Passwort und Passwort bestätigen stimmt nicht überein',
	WRITE_ACCESS_PROBLEM: 'Die Dateneingabe für diese Gruppe ist pausiert oder beendet.<br><br>Bitte kontaktiere einen Gruppenadmin für weitere Informationen.',
	
	CONFIRM_DELETE_ENTRY 	: 'Soll der ausgewählte Eintrag wirklich gelöscht werden?',
	ENTRY_DELETED_SUCCESS 	: 'Eintrag gelöscht.',
	NOT_HAVE_ACCESS_RIGHTS 	: 'Sie haben keine Zugriffsrechte',
	
	BUTTON_DATUM 			: 'Datum',
	BUTTON_DATUM_TOOLTIP 	: 'Gehe zu Datum',
	BUTTON_COMMENT 			: 'Notiz',
	BUTTON_COMMENT_TOOLTIP 	: 'Notiz hinzufügen',

	//messages
	UPDATE_OK			: 'Erfolgreich aktualisiert!',
	INSERT_OK			: 'Erfolgreich eingefügt!',
	DELETE_OK			: 'Erfolgreich gelöscht!',
		
	//forms
	PAGE				: 'Seite',
	DISPLAY_TIMES		: 'Diese Seite nur die ersten Male anzeigen', //'Anzeigezeiten',
	SUBPAGE_TITLE 		: 'Seite Titel',
	CENTER				: 'Zentriert',
	ADD_NEW_ITEM		: 'Neues Element hinzufügen',
	ADD_NEW_VALUE		: 'Neuen Wert hinzufügen',
	ITEM				: 'Element',
	TYPE				: 'Typ',
	EXAMPLE				: 'Beispiel',
	AVAILABLE_FIELDS	: 'Verfügbaren Felder',
	CATEGORY			: 'Kategorie',
	CATEGORY_TITLE 		: 'Kategorie Titel',
	FORM_ATHLETE_SAVE 	: 'Formularauswahl gespeichert.',
	FORM_ADMIN_SAVE 	: 'verfügbare Formulare für diese Gruppe gespeichert. <br>Gruppe:',
	SHARES_TRAINER_SAVE : 'Freigaben gespeichert. <br>Trainer:',
	
	//form details
	REQUIRED	: 'Pflichtfeld',
	MIN			: 'MIN',
	MAX			: 'MAX',
	INTEGER		: 'Ganzzahl', //ganze Zahl //integer
	DECIMAL		: 'Dezimal', //Dezimalzahl //decimal
	WIDTH		: 'Breite',
	ITEM_TITLE	: 'Bezeichnung',

	//Date Select
	DATE_TODAY 			: 'heute',
	DATE_CLEAR 			: 'zurücksetzen',
	DATE_CLOSE 			: 'schließen',
	DATE_SELECT_TIME 	: 'Zeit auswählen',
	DATE_MONTH_SELECT 	: 'Wähle Monat',
	DATE_MONTH_PREV 	: 'Vorheriger Monat',
	DATE_MONTH_NEXT 	: 'Nächster Monat',
	DATE_YEAR_SELECT 	: 'Wähle Jahr',
	DATE_YEAR_PREV 		: 'Vorherigers Jahr',
	DATE_YEAR_NEXT 		: 'Nächsters Jahr',
	DATE_DECADE_SELECT 	: 'Wähle Dekade',
	DATE_DECADE_PREV 	: 'Vorherige Dekade',
	DATE_DECADE_NEXT 	: 'Nächste Dekade',
	DATE_CENTURY_PREV 	: 'Vorheriges Jahrhundert',
	DATE_CENTURY_NEXT 	: 'Nächstes Jahrhundert',	
	
	//Buttons
	BUTTON_ADD 		: 'Hinzufügen',
	BUTTON_EDIT 	: 'Bearbeiten',
	BUTTON_DELETE 	: 'Löschen',
	BUTTON_CANCEL 	: 'Abbrechen',
	BUTTON_VIEW 	: 'Ansicht',
	BUTTON_SEARCH 	: 'Suchen',
	BUTTON_RELOAD 	: 'Neu Laden',
	BUTTON_SAVE 	: 'Speichern',
	BUTTON_DUPLICATE: 'Formular duplizieren',
	COLUMNS			: 'Spalten',
	CHOOSE_COLUMNS	: 'Spalten auswählen',
	

	//location Table/Form Fields
	LOCATIONS : {
		HEADER 		: 'Standorte',
		NAME 		: 'Standortnamen',
		ADMIN 		: 'Standortadmin'
	},
	
	//groups Table/Form Fields
	GROUPS : {
		HEADER 				: 'Gruppen',
		LOCATION			: 'Standort',
		NAME 				: 'Gruppenname',
		PRIVATE 			: 'Privat',
		PRIVATE_KEY 		: 'Privat Schlüssel',
		PRIVATE_KEY_ERROR 	: 'Privat Schlüssel Fehler',
		ADMIN 				: 'Gruppenadmin',
		STOP_DATE 			: 'Stoppdatum'
	},
	
	//categories Table/Form Fields
	CATEGORIES : {
		HEADER 		: 'Kategorien',
		NAME 		: 'Kategorie',
		PARENT 		: 'Eltern-Kategorie',
		COLOR 		: 'Farbe',
		ORDER 		: 'interne<br> Reihenfolge', //'Ordnung',
		FORMS 		: 'Formulare',
		FORMS_COUNT	: 'Anzahl der<br> Formulare',
		AVAILABLE 	: 'Verfügbar',
		STANDARD 	: 'Vorgeschlagen',
		READ 		: 'Lesen',
		WRITE 		: 'Schreiben',
		OPEN_CLOSE_ALL : 'Alles schließen / Alles erweitern'
	},
	
	//forms Table/Form Fields
	FORMS : {
		HEADER 		: 'Formulare',
		CATEGORIES 	: 'Kategorien',
		NAME 		: 'externer Name', //Name
		NAME2 		: 'interner Name', //Name2
		TAGS 		: 'Schlagwörter', //Tags
		COLOR 		: 'Farbe',
		DETAILS 	: 'bearbeiten',
		AVAILABLE 	: 'Verfügbar',
		STANDARD 	: 'Vorgeschlagen',
		READ 		: 'Lesen',
		WRITE 		: 'Schreiben',
		OPEN_CLOSE_ALL : 'Alles schließen / Alles erweitern'
	},
	
	//forms2categories Table/Form Fields
	FORMS2CATEGORIES : {
		HEADER 		: 'Formulare zu Kategorien',
		CATEGORY 	: 'Kategorie',
		FORM_SELECT : 'Formular<br> auswählen',
		FORM_NAME	: 'Formular',
		ORDER 		: 'interne<br> Reihenfolge', //'Ordnung',
		STOP_DATE 	: 'Verfügbar bis',
	},
	
	//features Table/Form Fields
	FEATURES : {
		HEADER 		: 'Features',
		NAME 		: 'Featurename',
		COLOR 		: 'Farbe',
		CATEGORY 	: 'Kategorie'
	},
	
	//features Table/Form Fields
	FORMS : {
		HEADER 		: 'Formulare',
		NAME 		: 'Formularname',
		DETAILS 	: 'Details',
		AVAILABLE 	: 'Verfügbar',
		STANDARD 	: 'Vorgeschlagen',
		READ 		: 'Lesen',
		WRITE 		: 'Schreiben',
		OPEN_CLOSE_ALL : 'Alles schließen / Alles erweitern'
	},

	//sports Table/Form Fields
	SPORTS : {
		HEADER 		: 'Sportarten',
		OPTIONGROUP : 'Sportgruppe',
		NAME 		: 'Sportartnamen'
	},
	
	//dropdown menus Table/Form Fields
	DROPDOWN : {
		HEADER 		: 'Dropdownmenü',
		NAME 		: 'Name',
		OPTIONS 	: 'Optionen',
		FOR_FORMS	: 'für Formulare'
	},
	
	//users Table/Form Fields
	USERS : {
		HEADER 			: 'Benutzern',
		ACCOUNT 		: 'Konto',
		USERNAME 		: 'Benutzername',
		PASSWORD 		: 'Passwort',
		PASS_CONFIRM	: 'Passwort bestätigen',
		LASTNAME 		: 'Name',
		FIRSTNAME 		: 'Vorname',
		BIRTH_DATE 		: 'Geburtsdatum',
		SPORT 			: 'Sportart',
		SEX 			: 'Geschlecht',
		BODY_HEIGHT 	: 'Körperhöhe',
		EMAIL 			: 'Email',
		TELEPHONE 		: 'Mobiltelefon',
		LEVEL 			: 'Ebene',
		GROUP 			: 'Gruppe (aktiv)',
		LOCATION 		: 'Standort (aktiv)',
		PERMISSIONS 	: 'Berechtigungen',
		LAST_LOGIN 		: 'Letzte Anmeldung',
		LOGIN_COUNT 	: 'Anzahl der Anmeldungen',
		LAST_IP 		: 'Letzte IP',
		ERGEBNISSE 		: 'Ergebnisse',
		
		SEX_MALE 		: 'Männlich',
		SEX_FEMALE		: 'Weiblich',
		SEX_OTHER		: 'Divers',
		
		GROUPING_NO		: 'keine Gruppierung',
		GROUPING_BY		: 'Gruppierung nach',
		
		//LEVELS
		LVL_ADMIN 		: 'Admin',
		LVL_LOCATION 	: 'Standortadmin',
		LVL_GROUP_ADMIN	: 'Gruppenadmin',
		LVL_GROUP_ADMIN_2	: 'Gruppenadmin (reduziert)',
		LVL_ATHLETE		: 'Sportler',
		LVL_TRAINER 	: 'Trainer',

		ID 				: 'ID',
		USER_ID 		: 'Benutzer ID',
		TYPE 			: 'Typ',
		COMMENT 		: 'Bemerkung'
	},

	//Dashboard
	DASH : {
		NAME 			: 'Name',
		COLOR 			: 'Farbe',
		POSITION 		: 'Position',
		TYPE 			: 'Inhalt',
		SELECT_TYPE 	: 'Inhalt auswählen',
		TYPE_CALENDAR 	: 'Kalender',
		TYPE_OPTIONS 	: 'Optionen',
		TYPE_FORMS 		: 'Formulare',
		TYPE_RESULTS 	: 'Ergebnisse',
		TYPE_RESULTS_GRP: 'Ergebnisse (gruppenbasiert)',
		VIEW		 	: 'Ansicht',
		VIEW_SELECT	 	: 'Ansicht auswählen',
		VIEW_MONTH	 	: 'Monatsansicht',
		VIEW_WEEK	 	: 'Wochenansicht',
		VIEW_DAY	 	: 'Tagesansicht',
		DATE	 		: 'Datum',
		DATE_CURRENT	: 'aktuelles Datum',
		OPTION			: 'Option',
		OPTION_SELECT	: 'Option auswählen',
		OPTION_1		: 'Formularauswahl',
		OPTION_2		: 'Datenmanagement (Import, Export)',
		OPTION_3		: 'Gruppenzugang',
		OPTION_4		: 'Gruppennutzer',
		OPTION_5		: 'Trainingsgruppe verlassen',
		OPTION_6		: 'Sportlerverwaltung',
		OPTION_7		: 'Freigaben der Sportler',
		OPTION_8		: 'Trainerverwaltung',
		OPTION_9		: 'Trainerfreigaben',
		OPTION_10		: 'Formularauswahl (Gruppenadmin)',
		OPTION_11		: 'Formulare',
		OPTION_12		: 'Kategorien',
		OPTION_13		: 'Listen (Sportarten, Dropdowns, usw.)',
		OPTION_14		: 'Location Gruppen',
		FORM			: 'Formular',
		FORM_SELECT		: 'Formular auswählen',
		FORM_COLOR_USE	: 'Farbe übernehmen',
		TEMPLATE		: 'Vorlage',
		TEMPLATE_SELECT	: 'Vorlage auswählen',
		PERIOD			: 'Zeitraum',
		PERIOD_TEMPLATE	: 'Vorlage Zeitraum',
		PERIOD_STATIC	: 'statisch',
		PERIOD_DYNAMIC	: 'dynamisch',
		PERIOD_FROM		: 'Von',
		PERIOD_TO		: 'Bis',
		PERIOD_LAST		: 'The last',
		PERIOD_LAST_MINS	: 'Minuten',
		PERIOD_LAST_HOURS	: 'Stunden',
		PERIOD_LAST_DAYS	: 'Tage',
		PERIOD_LAST_WEEKS	: 'Wochen',
		PERIOD_LAST_MONTHS	: 'Monate',
		PERIOD_LAST_YEARS	: 'Jahre',
	},

	//inteface ///////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////

	REQUEST_WAS_SENT_AT		: 'Die Anfrage wurde am {DATE_TIME} geschickt',
	REQUEST_STATUS_UPDATED	: 'Status am {DATE_TIME} aktualisiert',
	REQUEST_USER_LEAVE_GROUP: 'Gruppenzuordnung verlassen', //leave Group (by User)

	//athletes - group users
	REQUEST_NOBODY_SELECTED	: 'niemand ausgewählt',
	REQUEST_ACCESS_FROM		: 'Zugriff anfordern von :',
	CANCEL_REQUEST_FROM		: 'Abbrechen Anfragen von :',
	CANCEL_ACCESS_TO		: '(Gruppen)zuordnung aufheben?', //'Zuordnung Aufheben bis :',

	////////////////////////////////////////////////////////////////////////////
	//Request Status Icons Explain (tooltips) --> the same on .php file
	STATUS_NO_REQUEST				: 'Keine Anfragen', //. No request yet
	STATUS_REQUEST_REJECTED			: 'Anfrage abgelehnt', //0 Request Rejected
	STATUS_REQUEST_ACCEPTED			: 'Anfrage angenommen', //1 Request Accepted
	STATUS_CANCELED_ACCESS_TRAINER	: 'Zuordnung aufgehoben (vom Trainer)', //5 Canceled Access (by Trainer)
	STATUS_CANCELED_ACCESS_ATHLETE	: 'Zuordnung aufgehoben (vom Sportler)', //15 Canceled Access (by Athlete)
	STATUS_REQ_WAIT_CANCELED_TRAINER: 'Warte auf Zugriffserlaubnis (nach Abbruch durch Trainer)', //7 Waiting Access (after Canceled Access by Trainer)
	STATUS_REQ_WAIT_CANCELED_ATHLETE: 'Warte auf Zugriffserlaubnis  (nach Abbruch durch Sportler)', //17 Waiting Access (after Canceled Access by Athlete)
	STATUS_REQ_WAIT_REJECTED_ATHLETE: 'Warte auf Zugriffserlaubnis (nach aufgehobener Zuordnung durch Sportler)', //8 Waiting Access (after Rejected Request by Athlete)
	STATUS_REQUEST_WAIT				: 'Warte auf Zugriffserlaubnis', //9 Waiting Access (New - first time)

	//Group
	STATUS_CANCELED_ACCESS_USER		: 'Zugangsabbruch (vom Nutzer)', //5 Canceled Access (by User)
	STATUS_CANCELED_ACCESS_GROUP	: 'Zugangsabbruch (vom Gruppenadmin)', //15 Canceled Access (by Groupadmin)
	STATUS_REQ_WAIT_CANCELED_USER	: 'Warte auf Zugriffserlaubnis (nach Zugangsabbruch vom Nutzer)', //7 Waiting Access (after Canceled Access by User)
	STATUS_REQ_WAIT_CANCELED_GROUP	: 'Warte auf Zugriffserlaubnis (nach Zugangsabbruch vom Gruppenadmin)', //17 Waiting Access (after Canceled Access by Groupadmin)
	STATUS_REQ_WAIT_REJECTED_USER	: 'Warte auf Zugriffserlaubnis (nach Anfragenabbruch vom Gruppenadmin)', //8 Waiting Access (after Rejected Request by Groupadmin)
	STATUS_REQ_WAIT_NEW_USER		: 'Neues Benutzerkonto', //10 New Account
	STATUS_REQ_WAIT_USER_INACTIVE	: 'Inaktives Benutzerkonto', //11 Inactive Account


	
	END : 'End'
};
