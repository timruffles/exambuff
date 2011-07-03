$(document).ready(function(){
	$('body').append('<div id="msgBox"></div>');
	
	var msgSelector = '#msgBox';
	
	$('form.save').intercept('change',{
		'input':function(event){
			
			$('form.save').children('input.save').attr('disabled','');
		}
	});
	
	var loading = 'Loading help, please wait';
	$('#main').intercept('click',{
		'a.inline': function(event){
			var link = $(this).attr('href');
			loadInline(link);
			return false;
		}
	});
	function loadInline(link) {
		$.post(link,{inline:true},function(data){
										showInline(msgSelector,data);
									});
		$(msgSelector).html(loading);
		$(msgSelector).fadeIn(1000);
	}
	function showInline(msgSelector,data) {
		$(msgSelector).html('<a class="close" onClick="msgBoxClose()">X</a>'+data);
	}
	//alert('eb_ui working');
});
function msgBoxClose() {
		$('#msgBox').fadeOut('500');
}