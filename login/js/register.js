jQuery(function($) {

	//SCROLL TO TOP ============
	function animateToTop(top) {
		if (top != 0) {
			top = 0;
			if (window.innerWidth >= 340) top = 60;
			if (window.innerWidth >= 550) top = 100;
			if (window.innerWidth >= 770) top = 115;
		}
		
		$("html, body").animate({ scrollTop: top }, "slow");
	}

	$(window).on('scroll',function() {
		if($(this).scrollTop() != 0) {
			$('#toTop').fadeIn();	
		} else {
			$('#toTop').fadeOut();
		}
	});
 
	$('#toTop').on('click',function() {
		animateToTop(0);
	});	
	
	//Languages
	$("#lang_de").on('click',function () {
		if ($.cookie('LANG') == 'de') return false;
		$("#loading").show();
		$.cookie('LANG', 'de', { expires: 365, path: '/' });
		window.location.reload();
	});
	$("#lang_en").on('click',function () {
		if ($.cookie('LANG') == 'en') return false;
		$("#loading").show();
		$.cookie('LANG', 'en', { expires: 365, path: '/' });
		window.location.reload();
	});


	// WIZARD  ================================================
	// Basic wizard with validation
	$('form#wrapped').attr('action', 'login/registration.php');
	$('form#wrapped').wizard({
		stepsWrapper: "#wrapped",
		enableSubmit:true,
		submit: "#submit",
		beforeSelect: function( event, state ) {
			if (!state.isMovingForward) {
				animateToTop();
				return true;
			}

			var inputs = $(this).wizard('state').step.find(':input');
			
			if (!inputs.valid() && $('label.error:visible').length != 0) {
				$("html, body").animate({ scrollTop: $('label.error:visible').offset().top-50 }, "slow");
			}
			else {
				animateToTop();
				//$('form#wrapped').submit();
				//$('#submit').prop('disabled', false);
				$("#loading").show();
				setTimeout(function(){$('#submit').trigger("click");}, 1000);
				
				//check if password and password confirm match --alternative http://jqueryvalidation.org/equalTo-method
				/*if ($('input#pass_confirm').val() != $('input#passwd').val()) {
					alert('passwort und passwort bestätigen Felder nicht überein');
					return false;
				}*/
			}
			return !inputs.length || !!inputs.valid();
		}
		/*afterSelect: function( event, state ) {
			console.log( event, state );
			$('button.backward').trigger("click");
			if (state.stepIndex == 1) {
				$.ajax({ //check if username exist --alternative http://jqueryvalidation.org/remote-method
					url: "login/ajax.check_user_exist.php?uname="+$('input#uname').val(),
					success: function(data) {
						if (data == 'OK') {
							$('button.forward').trigger("click");
							setTimeout(function(){$('#submit').trigger("click")}, 0);
						}
						else {
							setTimeout(function(){
								$('button.backward').trigger("click");
								alert(data.replace(/<br>/g, '\n'));}
							, 0);
						}
					}
				});
			}
		}*/
	});
	$('form#wrapped').validate({
		ignore: [":hidden:not(.chosen-select)"],
		//we not want check_user_exist to run on keyup
		onkeyup: false,
		rules: {
			uname: {
				required: true,
				minlength: 4,
				remote: "login/ajax.check_user_exist.php"
			},
			passwd: {
				required: true,
				minlength: 4
			},
			pass_confirm: {
				required: true,
				minlength: 4,
				equalTo: "#passwd"
			},
			private_key: {
				//only if private is selected
				required: function () {
                	return $('#GRP_select').val() == 'Private';
				},
				remote: "login/ajax.check_private_key.php"
			}
		},
		messages: {
			pass_confirm: {
				equalTo: "passwort und passwort bestätigen Felder nicht überein"
			},
			uname: {
				remote: jQuery.validator.format("Fehler! Dieser Name ist bereits vergeben. Bitte anderen Namen verwenden.")
			},
			private_key: {
				remote: jQuery.validator.format(LANG.GROUPS.PRIVATE_KEY_ERROR)
			}
		},
		errorPlacement: function(error, element) {
			if (element.is(':radio') || element.is(":checkbox")) {
				error.insertBefore( element.parent().next() );
			}
			else if (element.is('select')) {
				if (element.attr('id') == 'SPORTS_select') {
					error.insertBefore(element);
				}
				else {
					error.insertBefore(element.parent());
				}
			}
			else { 
				if (element.attr('id') == 'private_key') {
					error.insertBefore(element.parent());
				}
				else {
					error.insertBefore( element );
					//error.insertAfter( element );
				}
			}
		}
	});


	// Other Fileds  ================================================

	//Check and radio input styles
	$('input.check_radio').iCheck({
		checkboxClass: 'icheckbox_square-aero',
		radioClass: 'iradio_square-aero'
	});
	
	//Place holder
	$('input, textarea').placeholder();
	
	//SPORTS select
	$("#SPORTS_select").chosen({width:'100%', multiple:true, create_option:true, create_option_text:LANG.NEW_OPTION, no_results_text:LANG.NO_RESULTS, search_contains:true}).change(function() {
		$(this).parent('div').find('label.error').remove(); //remove required error if select something
	});

	//telephone
	$("#telephone").intlTelInput({initialCountry:'de', preferredCountries:['de'],separateDialCode:true});
	$("#telephone").inputFilter(function(value) { //Floating point (use . or , as decimal separator):
		return /^-?\d*[ ]?\d*$/.test(value);
	});	
	$("#telephone").on('countrychange', function(a){
		$('#countryCode').val( $('.iti__selected-dial-code').text() );
	});

	//Group Select
	$("#GRP_select").on('change', function () {
		if ($(this).val() == 'Private') {
			$('#GRP_select').parent().hide();
			$('#private_group').show();
		}
	});
	$("#private_close").on('click',function() {
		$('#private_group').hide();
		$('#GRP_select').parent().show();
		$("#GRP_select").val('');
	});

	//Home button
	$("button.home").on('click',function() {
		$("#loading").show();
		window.location.href = '.';
	});
	
});

// Filter Numbers ///////////////////////////////////////////////////////
// Restricts input for each element in the set of matched elements to the given inputFilter.
(function($) {
	$.fn.inputFilter = function(inputFilter) {
		return this.on("input keydown keyup mousedown mouseup select contextmenu drop blur", function(e) {
			this.value = this.value.replace('.', ',');
			if (inputFilter(this.value)) {
				this.oldValue = this.value;
				this.oldSelectionStart = this.selectionStart;
				this.oldSelectionEnd = this.selectionEnd;
			} else if (this.hasOwnProperty("oldValue")) {
				this.value = this.oldValue;
				this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
			}
			if ((e.type == 'blur' || e.keyCode == 13) && this.value != '') $(this).trigger('change'); //bcz in EDGE we lose event after this point
		});
	};
}(jQuery));
// Filter Numbers ///////////////////////////////////////////////////////

