LANG = {
	LANG_CURRENT	: 'de', //not change
	
	//moment date funcions
	MOMENT : {
		DATE 			: 'DD.MM.YYYY', //moment format
		DATE_TIME 		: 'DD.MM.YYYY HH:mm:ss', //moment format
		DATE_TIME_NOSECS: 'DD.MM.YYYY HH:mm', //moment format --noSeconds
	},
	//grid date funcions
	GRID : {
		DATE 			: 'd.m.Y',
		DATE_TIME 		: 'd.m.Y H:i:s',
	},
	//datepicker date funcions
	DATEPICKER : {
		DATE 			: 'dd.mm.yy',
	},

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
	WARN_CONFIRM_PASSWORD	: 'Warnung! Passwort und Passwort bestätigen Felder nicht überein',
	WRITE_ACCESS_PROBLEM: 'Die Dateneingabe für diese Gruppe ist pausiert oder beendet.<br><br>Bitte kontaktiere einen Gruppenadmin für weitere Informationen.',
	WARN_USERNAME_EXIST 	: 'Warnung! Dieser Name ist bereits vergeben. Bitte anderen Namen verwenden.',
	
	CONFIRM_DELETE_ENTRY 	: 'Soll der ausgewählte Eintrag wirklich gelöscht werden?',
	ENTRY_DELETED_SUCCESS 	: 'Eintrag gelöscht.',
	NOT_HAVE_ACCESS_RIGHTS 	: 'Sie haben keine Zugriffsrechte',
	
	//Buttons
	BUTTON_ADD 				: 'Hinzufügen',
	BUTTON_EDIT 			: 'Bearbeiten',
	BUTTON_DELETE 			: 'Löschen',
	BUTTON_CANCEL 			: 'Abbrechen',
	BUTTON_VIEW 			: 'Ansicht',
	BUTTON_SEARCH 			: 'Suchen',
	BUTTON_RELOAD 			: 'Neu Laden',
	BUTTON_SAVE 			: 'Speichern',
	BUTTON_DUPLICATE		: 'Formular duplizieren',
	//index buttons
	BUTTON_DATUM 			: 'Datum',
	BUTTON_DATUM_TOOLTIP 	: 'Gehe zu Datum',
	BUTTON_COMMENT 			: 'Notiz',
	BUTTON_COMMENT_TOOLTIP 	: 'Notiz hinzufügen',

	//messages
	UPDATE_OK	: 'Erfolgreich aktualisiert!',
	INSERT_OK	: 'Erfolgreich eingefügt!',
	DELETE_OK	: 'Erfolgreich gelöscht!',

	LOCATIONS : {
		HEADER 		: 'Standorte',
		NAME 		: 'Standortnamen',
		ADMIN 		: 'Standortadmin'
	},
	
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
		WRITE 		: 'Schreiben'
	},
	
	FORMS : {
		CATEGORIES	 	: 'Kategorien',
		NAME 			: 'externer Name',
		NAME2 			: 'interner Name',
		TAGS 			: 'Schlagwörter',
		DETAILS 		: 'bearbeiten',
		AVAILABLE 		: 'Verfügbar',
		STANDARD 		: 'Vorgeschlagen',
		READ 			: 'Lesen',
		WRITE 			: 'Schreiben',
		OPEN_CLOSE_ALL 	: 'Alles schließen / Alles erweitern',
		FORM_EDIT		: 'Formular bearbeiten',
		FORM_SAVED		: 'Formular gespeichert.',
		FORM_DATA_SAVED	: 'Eintrag gespeichert.',
		FORM_DB_ERROR	: 'FEHLER!<br>DB-Fehler. Aktualisierung fehlgeschlagen.',
		
		DISPLAY_TIMES	: 'Diese Seite nur die ersten Male anzeigen',
		DISPLAY_TIMES_INFO: 'Bedingung zur Nutzung dieser Funktion: \n Auf dieser Seite darf kein Pflichtfeld existieren und das Formular muss mindestens eine weitere, immer angezeigte Seite enthalten.',
		DISPLAY_TIMES_0	: 'Immer',
		DISPLAY_TIMES_1	: '1 mal',
		DISPLAY_TIMES_2	: '2 mal',
		DISPLAY_TIMES_3	: '3 mal',
		DISPLAY_TIMES_4	: '4 mal',
		DISPLAY_TIMES_5	: '5 mal',
		DISPLAY_TIMES_FIELD_ERROR : 'Warnung!<br>Diese Seite nur die ersten Male anzeigen: <br> - Kein Pflichtfeld Feld auf der Seite',
		DISPLAY_TIMES_INFO_ERROR : 'Warnung!<br>Bedingung zur Nutzung dieser Funktion: <br> Auf dieser Seite darf kein Pflichtfeld existieren und das Formular muss mindestens eine weitere, immer angezeigte Seite enthalten.',

		ITEM_DELETE		: 'Löschen',
		ITEM_SAVE		: 'Speichern',
		ITEM_CANCEL		: 'Abbrechen',
		ITEM_RESET		: 'zurücksetzen',
		ITEM_WIDTH		: 'Breite',
		ITEM_EMPTY		: 'Leer',
		ITEM_SPACE		: 'Raum',
		ITEM_LINE		: 'Linie',
		ITEM_LABEL		: 'Bezeichnung',
		ITEM_TEXT_HTML	: 'Text (Html)',
		ITEM_TEXT		: 'Textfeld',
		ITEM_TEXTAREA	: 'Textareafeld',
		ITEM_NUMBER		: 'Zahlfeld',
		ITEM_DATE		: 'Datum',
		ITEM_TIME		: 'Uhrzeit',
		ITEM_PERIOD		: 'Dauer',
		ITEM_DROPDOWN	: 'Dropdown',
		ITEM_RADIO		: 'Fragebogenformat',
		ITEM_ACCORDION	: 'Klappbox-Umgebung',
		ITEM_ACCORDION_PANEL : 'Klappbox',
		
		FORM_TITLE			: 'Seite',
		PAGE_TITLE 			: 'Seite Titel',
		CENTER				: 'Zentriert',
		ADD_NEW_ITEM		: 'Neues Element hinzufügen',
		ATHLETE_SELECT_SAVE : 'Formularauswahl gespeichert.',
		GROUP_SELECT_SAVE 	: 'verfügbare Formulare für diese Gruppe gespeichert. <br>Gruppe:',
		ATHLETE_2_TRAINER_SELECT_SAVE : 'Freigaben gespeichert. <br>Trainer:',

		TIME_BETWEEN_ERROR: 'Bitte gib eine Uhrzeit zwischen 00:00 und 23:59 Uhr ein.',
		TIME_LIMIT_EXCEEDED : 'Du hast die Pausenzeit überschritten. Möchtest du den Fragebogen erneut ausfüllen?',
		
		GROUP_SELECT_SEARCH 	: 'Suche...',
		GROUP_SELECT_PLACEHOLDER: 'Gruppe auswählen...',
		GROUPS_SELECTED 		: 'Gruppen ausgewählt',
		GROUPS_SELECT_ALL 		: 'Alle auswählen',
		GROUPS_ALL_SELECTED 	: 'Alle ausgewählt',
		GROUPS_SELECT_NO_GROUP 	: 'Keine Gruppe',
		
		ATHLETE_SELECT_SEARCH 		: 'Suche...',
		ATHLETE_SELECT_PLACEHOLDER	: 'Sportler*in auswählen...',
		ATHLETES_SELECTED 			: 'Sportler*innen ausgewählt',
		ATHLETES_SELECT_ALL 		: 'Alle auswählen',
		ATHLETES_ALL_SELECTED 		: 'Alle ausgewählt',
		ATHLETES_SELECT_NO_ATHLETE 	: 'Keine Sportler*in',
	},
	
	RESULTS : {
		DEFAULT_TEMPLATE_SELECT : 'Bitte Standardvorlage auswählen',
		PARENTHESES_ERROR 		: 'Klammern Fehler',
		ALLOWED_CHARS_ERROR 	: 'nur erlaubt "({+-*/._})" und Zahlen',
	},

	FORMS2CATEGORIES : {
		CATEGORY 	: 'Kategorie',
		FORM_SELECT : 'Formular<br> auswählen',
		FORM_NAME	: 'Formular',
		ORDER 		: 'interne<br> Reihenfolge', //'Ordnung',
		STOP_DATE 	: 'Verfügbar bis',
	},
	
	SPORTS : {
		HEADER 		: 'Sportarten',
		OPTIONGROUP : 'Sportgruppe',
		NAME 		: 'Sportartnamen'
	},
	
	DROPDOWN : {
		HEADER 		: 'Dropdownmenü',
		NAME 		: 'Name',
		OPTIONS 	: 'Optionen',
		FOR_FORMS	: 'für Formulare'
	},
	
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
		SEX_MALE 		: 'Männlich',
		SEX_FEMALE		: 'Weiblich',
		SEX_OTHER		: 'Divers',
		BODY_HEIGHT 	: 'Körperhöhe',
		EMAIL 			: 'Email',
		TELEPHONE 		: 'Mobiltelefon',
		LEVEL 			: 'Ebene',
		GROUP 			: 'Gruppe (aktiv)',
		LOCATION 		: 'Standort (aktiv)',
		LAST_LOGIN 		: 'Letzte Anmeldung',
		LOGIN_COUNT 	: 'Anzahl der Anmeldungen',
		LAST_IP 		: 'Letzte IP',
		ERGEBNISSE 		: 'Ergebnisse',
		
		//LEVELS
		LVL_ADMIN 			: 'Admin',
		LVL_LOCATION 		: 'Standortadmin',
		LVL_GROUP_ADMIN		: 'Gruppenadmin',
		LVL_GROUP_ADMIN_2	: 'Gruppenadmin (reduziert)',
		LVL_ATHLETE			: 'Sportler',
		LVL_TRAINER 		: 'Trainer'
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
		OPTION_15		: 'Import',
		OPTION_16		: 'Export',
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

	REQUEST : {
		WAS_SENT_AT			: 'Die Anfrage wurde am {DATE_TIME} geschickt',
		STATUS_UPDATED		: 'Status am {DATE_TIME} aktualisiert',
		USER_LEAVE_GROUP	: 'Gruppenzuordnung verlassen', //leave Group (by User)
		NOBODY_SELECTED		: 'niemand ausgewählt',
		REQUEST_ACCESS_FROM	: 'Zugriff anfordern von :',
		CANCEL_REQUEST_FROM	: 'Abbrechen Anfragen von :',
		CANCEL_ACCESS_TO	: '(Gruppen)zuordnung aufheben?', //'Zuordnung Aufheben bis :',
	},

	//Request Status Icons Explain (tooltips) --> the same on .php file
	R_STATUS : {
		NO_REQUEST				: 'Keine Anfragen', //. No request yet
		REQUEST_REJECTED		: 'Anfrage abgelehnt', //0 Request Rejected
		REQUEST_ACCEPTED		: 'Anfrage angenommen', //1 Request Accepted
		CANCELED_ACCESS_TRAINER	: 'Zuordnung aufgehoben (vom Trainer)', //5 Canceled Access (by Trainer)
		CANCELED_ACCESS_ATHLETE	: 'Zuordnung aufgehoben (vom Sportler)', //15 Canceled Access (by Athlete)
		REQ_WAIT_CANCELED_TRAINER: 'Warte auf Zugriffserlaubnis (nach Abbruch durch Trainer)', //7 Waiting Access (after Canceled Access by Trainer)
		REQ_WAIT_CANCELED_ATHLETE: 'Warte auf Zugriffserlaubnis  (nach Abbruch durch Sportler)', //17 Waiting Access (after Canceled Access by Athlete)
		REQ_WAIT_REJECTED_ATHLETE: 'Warte auf Zugriffserlaubnis (nach aufgehobener Zuordnung durch Sportler)', //8 Waiting Access (after Rejected Request by Athlete)
		REQUEST_WAIT			: 'Warte auf Zugriffserlaubnis', //9 Waiting Access (New - first time)
		//Group ############################################################
		CANCELED_ACCESS_USER	: 'Zugangsabbruch (vom Nutzer)', //5 Canceled Access (by User)
		CANCELED_ACCESS_GROUP	: 'Zugangsabbruch (vom Gruppenadmin)', //15 Canceled Access (by Groupadmin)
		REQ_WAIT_CANCELED_USER	: 'Warte auf Zugriffserlaubnis (nach Zugangsabbruch vom Nutzer)', //7 Waiting Access (after Canceled Access by User)
		REQ_WAIT_CANCELED_GROUP	: 'Warte auf Zugriffserlaubnis (nach Zugangsabbruch vom Gruppenadmin)', //17 Waiting Access (after Canceled Access by Groupadmin)
		REQ_WAIT_REJECTED_USER	: 'Warte auf Zugriffserlaubnis (nach Anfragenabbruch vom Gruppenadmin)', //8 Waiting Access (after Rejected Request by Groupadmin)
		REQ_WAIT_NEW_USER		: 'Neues Benutzerkonto', //10 New Account
		REQ_WAIT_USER_INACTIVE	: 'Inaktives Benutzerkonto', //11 Inactive Account
	},

	
	END : 'End'
};
