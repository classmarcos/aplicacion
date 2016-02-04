$(function(){

	var carga_direccion_estafeta = function() { $.ajax({
														 type: 'POST', 
														 cache: false,
														 data: { id: $.cookie('configuracion') },
														 url: link_to('consult_estafeta'),
														 dataType: 'json',
														 timeout: 9000,
														 success: function(data, status, xml){	
														 	$('#text_puntodireccion_actual').empty().append('Seleccion actual: ID: ' + data[0].Codigo + ' Ciudad:' + data[0].Ciudad + ' Direccion:' + data[0].Direccion);

														 },
														 error: function(xml, status, error){
														    $('#text_puntodireccion_actual').empty().append('Seleccion actual: ' + error);
														 }/*,
														 complete: function(xml, status){

														 }*/
												}); }
	carga_direccion_estafeta();

	var seleccion_direccion_estafeta = '';

	if ($.cookie('hoja')) $('#hojaselect').val($.cookie('hoja')) ;

	$('#btn_selhoja').on('click', function(){
		$.cookie('hoja', $('#hojaselect').val() , { path: '/' });
		
		var titulo = 'Configuracion de hoja de impresion Aceptada';
		var cuerpo = $.cookie('hoja') + " Aceptado";
		var footer = '<button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>';
		var id_modal = 'modalidad';
		var id_generador = 'generate_modal';

		ventana_modal(titulo, cuerpo, footer, id_modal, id_generador);
	});

	$('div#ttabla table tbody tr').on('click', function(){

		$('#text_puntodireccion').empty().append("Nueva Seleccion: ID:" + $(this).children('td').eq(0).html() + " Ciudad:" + $(this).children('td').eq(2).html() + " Direccion:" + $(this).children('td').eq(3).html());
		seleccion_direccion_estafeta = $(this).children('td').eq(0).html();
	});

	$('#btn_confirmar_estafeta').on('click', function(){
		var titulo = 'Configuracion de estafeta aceptada';
		var cuerpo = 'ID ' + seleccion_direccion_estafeta + " Aceptado";
		var footer = '<button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>';
		var id_modal = 'modalidad';
		var id_generador = 'generate_modal';
		if (!seleccion_direccion_estafeta) {
			var titulo = 'Error';
			var cuerpo = 'Nada que asignar, por favor seleccione una direccion';
		} else {
			$.cookie('configuracion', seleccion_direccion_estafeta , { expires: 365, path: '/'   });
		}
		ventana_modal(titulo, cuerpo, footer, id_modal, id_generador);
		carga_direccion_estafeta();
	});

	


	/*function validatePhone(txtPhone) {
	    var a = document.getElementById(txtPhone).value;
	    var filter = /[\d]{3}-[\d]{3}-[\d]{4}/;
	    if (filter.test(a)) {
	        return true;
	    }
	    else {
	        return false;
	    }
	}


	var ret;

	function refrescaInputs(){
		if (ret) {
			$("#inputName").val(ret.Nombre);
			$("#inputDireccion").val(ret.Direccion);
			$("#inputCiudad").val(ret.Ciudad);
			$("#inputTelefono").val(ret.Telefono);
			$("#inputFax").val(ret.Fax);
		}
	};

	$("#list").jqGrid({ 
		url: link_to('data'),
		mtype: 'POST',
		datatype: "json", 
		colNames:['Codigo','Nombre','Ciudad', 'Direccion', 'Telefono','Fax'], 
		colModel:[ 
		{name:'Codigo',index:'Codigo', width: 90}, 
		{name:'Nombre',index:'Nombre', align:'center', width: 200}, 
		{name:'Ciudad',index:'Ciudad',align:'center', width: 200 }, 
		{name:'Direccion',index:'Direccion',align:'right', width: 385 }, 
		{name:'Telefono',index:'Telefono',align:'right', width: 100 },
		{name:'Fax',index:'Fax',align:'right', width: 100 }
		],
		autowidth: true,
		shrinkToFit: true,
		rowNum:20,
		rowList:[10,20,30], 
		pager: '#pager', 
		sortname: 'Codigo', 
		viewrecords: true, 
		sortorder: "asc", 
		caption:"Direccion Estafetas",
		onSelectRow: function (id) {
		    ret = $(this).jqGrid('getRowData',id);
		    if ($('#panel_contenedor').hasClass('panel-warning')){
		    	refrescaInputs();
		    }
		}
	}); 
	$("#list").jqGrid('navGrid','#pager',{edit:false,add:false,del:false});

	$(document).on('keydown',function(e){
	            if(e.which == 113) {
	                $('#search_list').click();
	            }else if(e.which == 115) {
	                $('#fbox_list_reset').click();
	            }
	                
	        });
	$(document).ready(function(){
			if ($.cookie('configuracion')) {
				$.post(link_to('data'), { parametro: $.cookie('configuracion') }, function(data){
					$('#seleccion-actual').html("Seleccion actual: ID:" + data[0].Codigo + " Nombre:" + data[0].Nombre + " Ciudad:" + data[0].Ciudad + " Direccion:" + data[0].Direccion + " Telefono:" + data[0].Telefono + " Fax:" + data[0].Fax);
				}, "json");
				
			}
	});


	$("#list").setGridWidth($('.col-sm-6').width());
	    if ($( window ).height() - 800 > 160)
	            $("#list").setGridHeight($( window ).height() - 800);
	        else
	            $("#list").setGridHeight(160);

	    $(window).on('resize', function(){
	        $("#list").setGridWidth($('.col-sm-6').width());
	        if ($( window ).height() - 800 > 160)
	            $("#list").setGridHeight($( window ).height() - 800);
	        else
	            $("#list").setGridHeight(160);
	    });

	$('#btn-seleccionar').click(function(){
		$.cookie('configuracion', ret.Codigo , { expires: 365, path: '/'   });
		$('#seleccion-actual').html("Seleccion actual: ID:" + ret.Codigo + " Nombre:" + ret.Nombre + " Ciudad:" + ret.Ciudad + " Direccion:" + ret.Direccion + " Telefono:" + ret.Telefono + " Fax:" + ret.Fax);
	});




	$("#btn-agregar").click(function(){
		$("form#form-registro-estafetas :input").each(function(){
				 		$(this).val('');
				 	});
		
		$('#inputName').focus();
		$('#panel-title-add-edit-reg').html("Agregar Estafeta");
		if ($('#panel_contenedor').hasClass('panel-success')){
			$('#row-funcion').fadeToggle( "slow" );
			return;
		}

		$('#panel_contenedor').removeClass("panel-warning").addClass("panel-success");
		$("div.form-group.has-feedback").removeClass("has-warning").addClass("has-success");
		if (!$('#panel_contenedor').is(":visible")) {
			$('#row-funcion').fadeToggle( "slow" );
		}
		
		
	});

	/*******************************************
						BTN-Eliminar
	********************************************
	

	$("#btn-eliminar").click(function(){

		$("form#form-registro-estafetas :input").each(function(){
				 		$(this).val('');
				 	});

		$('#panel_contenedor').removeClass("panel-success panel-warning");
		$("div.form-group.has-feedback").removeClass("has-warning has-success");
		$('#row-funcion').fadeOut( "slow", function(){

			if (ret) { 
				$('#modal-body-p-contenido').html("¿Esta Seguro que desea borrar el campo ID:'" + ret.Codigo +"' - Nombre:'" + ret.Nombre + "'");
				$('#modal-borra-elemento').modal('toggle');
			} 
			else { 
				alert("Por favor seleccione un elemento");
			}
		} );

			
	});

	$("#modal-borra-elemento-btn-aceptar").click(function(){
		$('#modal-borra-elemento').modal('toggle');
		$.post(link_to('delete'), {Codigo: ret.Codigo}, function(data){
			alert(data.message);
			$('#refresh_list').click();
		}, "json");
	});

	/*******************************************
						FIN BTN-Eliminar
	********************************************

	$("#btn-editar").click(function(){
		$('#panel-title-add-edit-reg').html("Editar Estafeta");



		if ($('#panel_contenedor').hasClass('panel-warning')){
			$('#row-funcion').fadeToggle( "slow" );
			return;
		}

		$('#panel_contenedor').removeClass("panel-success").addClass("panel-warning");
		$("div.form-group.has-feedback").removeClass("has-success").addClass("has-warning");
		if (!$('#panel_contenedor').is(":visible")) {
			$('#row-funcion').fadeToggle( "slow" );
		}
		
	});

	$('#btn_aceptar-registro-estafeta').click(function(){

		var a = true;//Codigo Bajaviano

		$("form#form-registro-estafetas :input").not("form#form-registro-estafetas #inputFax, form#form-registro-estafetas input[name='Codigo']").each(function(){
			if ($.trim($(this).val()) == ''){
				alert('El campo ' + $(this).attr('name') + ' no puede estar vacio.');
				$(this).focus();
				a = false;
				return false;
			}

		});


		if (a && !validatePhone('inputTelefono')){
			alert('El Telefono esta invalido');
			$('#inputTelefono').focus();
			a = false;
			return false;
		}

		if (a || ($.trim($('#inputFax').val().length) == 0) || (!validatePhone('inputFax'))){
			alert('El Fax esta invalido');
			$('#inputFax').focus();
			a = false;
			return false;
		}

		if (a) {

			if ($('#panel_contenedor').hasClass('panel-success')){
				$.post(link_to('create'), 

					$('#form-registro-estafetas').serialize()

				 ,function(data){
				 	$("form#form-registro-estafetas :input").each(function(){
				 		$(this).val('');
				 	});
				 	alert(data.message);
				$('#refresh_list').click();
				},'json');
			} else if ($('#panel_contenedor').hasClass('panel-warning')){

				if ($("#inputName").val() == ret.Nombre && $("#inputDireccion").val() == ret.Direccion 
					&& $("#inputCiudad").val() == ret.Ciudad && $("#inputTelefono").val() == ret.Telefono
					&& $("#inputFax").val() == ret.Fax) {

					alert('Nada que editar, no se ha detectado ningun cambio.');
					return false;
				}

				$('#form-registro-estafetas').append('<input type="hidden" value="' + ret.Codigo + '" name="id"/>');

				$.post(link_to('edit'), $('#form-registro-estafetas').serialize(), function(data){
					$('input[name="Codigo"]').remove();
					$('#refresh_list').click();
					alert(data.message);
				}, 'json');
			}
		}
	});*/
	$('#btn-prueba-pop').on('click', function(){
		$(location).attr('href',OpenInNewTab(''));
	});

	
});