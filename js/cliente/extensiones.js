$(function(){

	 $('#inputMonto').val("");
	 $('#inputCantidad').val("");

	$( "#inputFecha" ).datepicker({ dateFormat: 'dd-mm-yy' });

	$("#btn_aceptar").click(function(){

		$("#btn_aceptar").attr("disabled", "disabled");

		if ( $('#inputCantidad').val() == null || $('#inputCantidad').val() == '' || $('#inputCantidad').val() < 1){
			$('#inputCantidad').focus();
			alert('El campo "Cantidad" no puede estar vacio o tener una cantidad menor a 1 asignacion.');
			$("#btn_aceptar").removeAttr("disabled");
			return;
		}
	
		if ( $('#inputMonto').val() == null || $('#inputMonto').val() == '' || $('#inputMonto').val() < 1){
			$('#inputMonto').focus();
			alert('El campo "Monto" no puede estar vacio o tener un valor menor a $RD 1 Peso.');
			$("#btn_aceptar").removeAttr("disabled");
			return;
		}

		$.post(link_to('lt_extensiones'), {	

			contrato: $('#inputContrato').val(),
			monto: $('#inputMonto').val(),
			cajas: $('#inputCantidad').val()

		}, function(data){

			$('#inputCantidad').val('');
	        $('#inputMonto').val('');

			var valor = 0;
			if ($.cookie('hoja')) { //El tipo de hoja de impresion
		        valor = $.cookie('hoja');
		    }
	        
	         $('#mensaje-modal').modal();
	        $(location).attr('href',OpenInNewTab('invoice/print_invoice/' + contract + '/' + valor));
	        $("#btn_aceptar").removeAttr("disabled");
		} ,

			"json"
			) 

		 .fail(function() {
			alert( "Error" );
			$("#btn_aceptar").removeAttr("disabled");
		});

		
	});

  function valid_data(object){
    if($(object).val()){
     $('#inputMonto').val($(object).val() * 200);
    }
  }

  $('#inputCantidad').on({
   change:function(){
  valid_data(this);    
   },keyup:function(){
  valid_data(this);
   }
  });

});	