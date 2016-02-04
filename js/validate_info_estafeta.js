$(function(){
	
	if (!$.cookie('configuracion'))
						$(location).attr('href',link_to('puntodireccion'));

});