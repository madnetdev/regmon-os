
//fix bfcach problem when browser back button is pressed and page not load properly
window.addEventListener( "pageshow", function (event) {
	var historyTraversal = event.persisted || (typeof window.performance != "undefined" && window.performance.navigation.type === 2);
	if (historyTraversal) {
		 // page was restored from the bfcach
	  window.location.reload(); //reload page
	}
});

jQuery(function(){
  loading = $("#loading");
	loading.hide();
	
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
	
  $(".new_reg").on('click',function() {
	  loading.show();
	  window.location.href = 'register.php';
  });
  $(".log_in").on('click',function() {
	  //loading.show();
  });
});
