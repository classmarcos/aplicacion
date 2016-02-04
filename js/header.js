$(function(){

	//Esta es la programacion de los botones del menu superior
	$('a#btn_pagos_adelantados').click(function(){
		$( "#form_pagos_adelantados" ).submit();
	});

	$('a#btn_extensiones').click(function(){
		$("#form_extensiones").submit();
	});

});

