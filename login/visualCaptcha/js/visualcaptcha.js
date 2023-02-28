( function( window, $ ) {
    $( function() {
	
		if ($.cookie('LANG') != 'de') {
			var
				LANG_accessibilityAlt = 'Sound icon',
				LANG_accessibilityTitle = 'Accessibility option: listen to a question and answer it!',
				LANG_accessibilityDescription = 'Type below the <strong>answer</strong> to what you hear. Numbers or words:',
				LANG_explanation = 'Click or touch the <strong>ANSWER</strong>',
				LANG_refreshAlt = 'Refresh/reload icon',
				LANG_refreshTitle = 'Refresh/reload: get new images!'; // and accessibility option!'
		}
		else {
			var
				LANG_accessibilityAlt = 'Sound-Symbol',
				LANG_accessibilityTitle = 'Option Erreichbarkeit: hören Sie eine Frage-Antwort-it!',
				LANG_accessibilityDescription = 'Typ unter dem <strong> Antwort </strong>, was Sie hören. Zahlen oder Wörter:',
				LANG_explanation = 'Berühren Sie folgendes Symbol: <strong>ANSWER</strong>',
				LANG_refreshAlt = 'Erfrischen/Nachladen',
				LANG_refreshTitle = 'Erfrischen/Nachladen';
		}
		
        var captchaEl = $( '#login-captcha' ).visualCaptcha({
            imgPath: 'login/visualCaptcha/img/',
            captcha: {
                numberOfImages: 5, //def=5 hardcoded for security
				routes : {
					start : "/login/visualCaptcha/start",
					image : "/login/visualCaptcha/image",
					audio : "/login/visualCaptcha/audio"
				}
            },
			language: {
				accessibilityAlt: LANG_accessibilityAlt,
				accessibilityTitle: LANG_accessibilityTitle,
				accessibilityDescription: LANG_accessibilityDescription,
				explanation: LANG_explanation,
				refreshAlt: LANG_refreshAlt,
				refreshTitle: LANG_refreshTitle
			}
		} );
        var captcha = captchaEl.data( 'captcha' );
    } );
}( window, jQuery ) );