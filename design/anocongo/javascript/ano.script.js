
$('.show-login-form').click(function(){
	$(this).css({"display":"none"}).next().css({"display":"block"});
	$('.login-form').css({"display":"block"});
	return false;
});
$('.hide-login-form').click(function(){
	$(this).css({"display":"none"}).prev().css({"display":"block"});
	$('.login-form').css({"display":"none"});
	return false;
});
$(function() {
	$( "#tabs" ).tabs();
	// Hover states on the static widgets
	$( "#dialog-link, #icons li" ).hover(
		function() {
			$( this ).addClass( "ui-state-hover" );
		},
		function() {
			$( this ).removeClass( "ui-state-hover" );
		}
	);
});