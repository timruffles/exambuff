$(document).ready(function(){
	$('#card').submit(function(){
		$('div.checkpoint').append('<p>Sending payment details to payment gateway over secure connection. Please wait, this may take a while. If the connection times out, check your account order page; unless your order appears there you have not been charged.</p>');
		$('div.checkpoint').removeClass('no-messages');
		return true;
	});
	
	
});