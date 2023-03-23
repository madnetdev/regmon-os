"use strict";

// FancyBox Defaults


var confirm_Close_Form_iframe = function(){
	if (!confirm("\n\n"+LANG.LEAVE_PAGE_WARNING+"\n\n")){} //return false;
	else {
		window.frames[0].frameElement.contentWindow.stop_beforeunload_IE();
		setTimeout($.fancybox.close, 200);
	}
}

//http://fancyapps.com/fancybox/#docs
var fancyBoxDefaults = {
	padding:0, //def:15
	margin:10, //def:20
	maxWidth:540,
	minWidth:250,
	modal:true,
	live:false,
	tpl:{error:'<p class="fancybox-error">'+LANG.PROBLEM_LOADING_PAGE+'</p>'},
	afterClose:function() {
		//location.reload();
		return;
	},
	beforeShow:function() {
		$('.not_display').show(); //show spacer
	},
	afterShow:function() {
		$('.fancybox-skin').append('<a title="'+LANG.CLOSE+'" class="fancybox-item fancybox-close" href="javascript:jQuery.fancybox.close();"></a>'); //close button
		setTimeout(function(){
			$('.not_display').hide(); //hide spacer //give space to link so that fit when is bold on hover
		}, 0);
		
		//if new page has fancy_placeholder - hide it
		setTimeout(function () {
			$("#fancy_placeholder").hide();
		}, 0);
	}
}; //if some difference use -> $.extend(fancyBoxDefaults,{maxWidth: 800})
var fancyBoxDefaults_iframe = {
	padding:0, //def:15
	margin:10, //def:20
	modal:true,
	live:false,
	tpl:{error:'<p class="fancybox-error">'+LANG.PROBLEM_LOADING_PAGE+'</p>'},
	maxWidth:'100%',
	width:'100%',
	//fitToView : false,
	autoSize:false, height:'100%', //full height
	beforeLoad:function() {	
		loading.show();
		//open in new page if is iphone/ipad-safari
		if (is_iOS()) {
			window.location.href = this.href+'&iOS';
			return false;
		}
	},
	afterLoad:function() { loading.hide(); },
	afterClose:function() {
		//location.reload();
		return;
	},
	afterShow:function() {
		var close = '';
		//console.log(this.href);
		if (this.href.indexOf('form.php')!=-1) {
			close = 'javascript:confirm_Close_Form_iframe();';
			if (this.href.indexOf('view=true')!=-1) { //no confirm on View
				close = 'javascript:jQuery.fancybox.close();';
			}
		}
		else close = 'javascript:jQuery.fancybox.close();';
		$('.fancybox-skin').append('<a title="'+LANG.BACK+'" class="fancybox-item fancybox-back" href="'+close+'"></a>'); //close button
		$('.fancybox-skin').append('<a title="'+LANG.CLOSE+'" class="fancybox-item fancybox-close" href="'+close+'"></a>'); //close button
		
		//if new page has fancy_placeholder - hide it
		var _self = this;
		setTimeout(function () {
			var iframe = document.getElementById( $($(_self)[0].content).attr('id') );
			var elmnt = iframe.contentWindow.document.getElementById("fancy_placeholder");
			//elmnt.style.display = "none";
			$(elmnt).hide();
		}, 0);
	}
}; //if some difference use -> $.extend(fancyBoxDefaults,{maxWidth: 800})

