$(document).ready(function(){



    var combobox = $('#accionselect');
    var sumBalancetotal = 0;
    var input_txt_monto_pago = $('#InputMontoPagar');
    var not_many_clicks_button = 0;

    input_txt_monto_pago.prop('disabled', false);
    input_txt_monto_pago.val('');
    input_txt_monto_pago.focus();


    input_txt_monto_pago.on('keypress', function(event){
        if (event.which == 13) {
            $('#btn_pagar').trigger('click');
        }
    });

    combobox.val('0');

    var muestraModal = function(titulo, contenido, botones){
        $('#LabelModal').empty().append(titulo);
        $('#BodyModal').empty().append(contenido);
        $('#modalFooter').empty().append(botones);
        $('#infomodal').modal();
        //muestraModal("p","<p>Eso</p>",'<button type="button" class="btn btn-success">Confirmar</button>');
    }

    var tableReload = function(_type){
        $("div#pn-g").empty();

        if (_type == 0) {
            _type = "mensualidad";
        } else if (_type == 1){
            _type = "caja"
        }
        
        if (_type !== "2") {
            $("div#pn-g").append('<span>Cargando </span><img src="/telenordci/images/fbloader.gif" />');
            $.ajax({
                     type: 'POST', 
                     cache: false,
                     url: link_to('credit_info'),
                     timeout: 15000,
                     data: { 
                             parameter:contract,
                             type: _type},
                     dataType: 'json',
                     success: function(data, status, xml){
                        var sumnatoria = 0;
                        var header = "<table class='table table-striped table-bordered table-hover table-condensed'><thead>" +
                                     "<tr><th>Concepto</th><th>Monto</th><th>Pagado</th><th>Fecha</th><th>Balance</th></tr></thead><tbody>";
                        var body = "";
                        var footer = "</tbody></table>";                      
                       $.each(data.rows, function(i, item) {
                            body += "<tr><td>" + item.Concepto +
                                    "</td><td>" + item.Monto + 
                                    "</td><td>" + item.Pagado + 
                                    "</td><td>" + item.Fecha + 
                                    "</td><td>" + item.Balance + 
                                    "</td></tr>";
                                    sumnatoria += Number(item.Balance.replace(/[^0-9\.]+/g,""));
                       });
                       sumnatoria = parseFloat(sumnatoria).toFixed(2);
                       $('#balance_generado').empty().append('Balance: RD$' + sumnatoria);

                       $("div#pn-g").empty().append(header + body + footer);
                       
                        
                        sumBalancetotal = data.sumBalance;  

                     },
                     error: function(xml, status, error){
                         if(status==="timeout") {
                                alert("Opps, se agoto el tiempo de espera..., intente de nuevo.");
                                $("#generated_sumbalance").empty().append("<p class='balance' > Opps!, Intente cargar balances de nuevo.</p>");
                                sumBalancetotal = 0;
                            } else {
                                alert(status);
                                $("#generated_sumbalance").empty().append("<p class='balance' > Opps!, Intente Recargar la pagina(Presione la tecla F5)</p>");
                            }
                     }/*,
                     complete: function(xml, status){
                        
                     }*/
            });

            $.ajax({
                     type: 'POST', 
                     cache: false,
                     url: link_to('data'),
                     timeout: 15000,
                     data: { 
                             searchString:contract},
                     dataType: 'json',
                     success: function(data, status, xml){
                        $("#generated_sumbalance").empty().append("<p class='balance' > Balance: <span> RD$ " + data.rows[0].Balance + "</span></p>");
                     },
                     error: function(xml, status, error){
                         if(status==="timeout") {
                                alert("Opps, se agoto el tiempo de espera..., intente de nuevo.");
                                $("#generated_sumbalance").empty().append("<p class='balance' > Opps!, Intente cargar balances de nuevo.</p>");
                                sumBalancetotal = 0;
                            } else {
                                alert(status);
                                $("#generated_sumbalance").empty().append("<p class='balance' > Opps!, Intente Recargar la pagina(Presione la tecla F5)</p>");
                            }
                     }/*,
                     complete: function(xml, status){
                        
                     }*/
            });
        } else{
             $("#generated_sumbalance").empty().append("<p class='balance' > Balance: <span> RD$ 200.00</span></p>");
             sumBalancetotal = 200;

        }

    }

    tableReload(0);



    /*input_txt_monto_pago.keydown(function(event) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ( $.inArray(event.keyCode,[46,8,9,27,13,190]) !== -1 ||
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });*/


   /*$("#lista").jqGrid({
        mtype: 'POST',
        datatype: 'json',
        postData:{ 
        	type: 10,
            parameter:contract,
            add: 0
        },
        loadComplete: function(data) {
            if($('select[name=type]').val() == 2){
                $("#generated_sumbalance").html("<p class='balance' > Total a pagar: <span> RD$ 200.00</span></p>");
                sumBalancetotal = 200;
            } else {
                $("#generated_sumbalance").html("<p class='balance' > Total a pagar: <span> RD$ " + data.sumBalance + "</span></p>");
                sumBalancetotal = data.sumBalance;  
            }
        },
        url: link_to('credit_info'),
        colNames: ['Concepto', 'Monto', 'Pagado', 'Fecha','Balance'],
        colModel: [
        { name: 'Concepto', index: 'Concepto', width: 250, sortable: false, search:false},
        { name: 'Monto', index: 'Monto', width: 200, sortable: false, search:false, align:'right'},
        { name: 'Pagado', index: 'Pagado', width: 150, sortable: false, search:false, align:'right' },
        { name: 'Fecha', index: 'Fecha', width: 200, sortable: false, search:false, align:'center' },
        { name: 'Balance', index: 'Balance', width: 170, sortable: false, search:false, align:'right'}
        ],
        pager: '#paginador', 
        sortname: 'Contrato', 
        viewrecords: true, 
        sortorder: "desc", 
        caption:"Detalle Clientes" 
    });


	function set_total_balance (cellvalue, options, rowObject)
	{
	   total_balance += parseFloat(cellvalue);
	   return cellvalue;
	}*/

    //$("#lista").jqGrid('navGrid','#paginador',{edit:false,add:false,del:false});
    //$('#lista').setGridHeight(250);
    //$('#lista').setGridWidth(800);

    /*var grid_height = 0; //350
    var grid_width = 0;*/

    //$("#lista").setGridWidth($('.col-md-8').width() - grid_width);
    //$("#lista").setGridHeight($('.col-md-8').height() + grid_height);

    /*$(window).on('resize', function(){
        $("#lista").setGridWidth($('.col-md-8').width() - grid_width);
        //$("#lista").setGridHeight($('.col-md-8').height() + grid_height);
    });*/

    /*var gridReload = function(_type){
        jQuery("#lista").setGridParam({ 
            url: link_to('credit_info'), 
            page:1, 
            postData:{
                search:true,
                type: 10,
                parameter:contract,
                add: _type
            }
        }).trigger("reloadGrid");
    }*/ 

    

    combobox.change(function(){
    	tableReload($(this).val());
        if (combobox.val() == 2) {
            input_txt_monto_pago.val('200');
            input_txt_monto_pago.prop('disabled', true);
        } else {
            input_txt_monto_pago.prop('disabled', false);
            input_txt_monto_pago.val('');
            input_txt_monto_pago.focus();
        }
    });

    $('#btn_impfactura').click(function(){
        $(location).attr('href',OpenInNewTab('invoice/print_invoice/' + contract + '/' + $.cookie('hoja')));
    });

    $('#btn_pagar').click(function(){
        var valor_input = input_txt_monto_pago.val();
        var val_combobox_tosend;
        switch(combobox.val()){
            case "0":
                val_combobox_tosend = 0;
                break;
            case "1":
                val_combobox_tosend = 1;
                break;
            case "2":
                val_combobox_tosend = 2;
                break;
        }

    
        function limpia_con_mensaje(mensaje, titulo, botones){
            input_txt_monto_pago.val('');
            input_txt_monto_pago.focus();
            muestraModal(titulo,mensaje,botones);
        }

        function recarga_pagina(contrato){
            input_txt_monto_pago.val('');
            $(location).attr('href',OpenInSelfTab('busquedacliente/redireccionando/' + contrato));
            not_many_clicks_button = 0;
        }

        function make_payment_message(mensaje, titulo){
            muestraModal(titulo,mensaje,'<button type="button" id="btn_confirm" class="btn btn-success">Pagar</button>');
            
            $('#infomodal').on('click', '#btn_confirm', function(){ 
                        $('#infomodal').off('click', '#btn_confirm');
                        if (not_many_clicks_button === 0) {//super codigo bajaviano
                            not_many_clicks_button = 1;
                             //window.open(real_path + 'index.php/invoice/index/' + contract,'_blank'); return;
                            var reco = 0; //Variable para saber si es una reconexion o un pago , 0 Es un pago, 1 Es una reconexion La reconexion tiene su propia funcion de pago
                            if (val_combobox_tosend === 2) {
                                    reco = 1;
                            } 

                            $.post(link_to('make_payment'), { type: val_combobox_tosend , mount: valor_input , contract: contract, balance_anterior: sumBalancetotal, reconexion: reco } , function(data){
                                        window.open(real_path + 'index.php/invoice/print_invoice/' + contract + '/' + $.cookie('hoja'),'_blank');
                                        tableReload(combobox.val());
                            });
                            
                            $('#infomodal').modal('hide');
                            not_many_clicks_button = 0;
                            input_txt_monto_pago.val('');
                            input_txt_monto_pago.focus();
                        }
                    });
            

        }

        if (!$.isNumeric(valor_input)){
            limpia_con_mensaje('El monto a pagar deber ser un valor numerico valido: Ej: 500.00 o 500', 'Error','');
            return ;
        }
        if (valor_input < 1){
            limpia_con_mensaje('El monto a pagar debe superar el monto de RD$ 1.00', 'Error','');
            return ;
        } 
        if (combobox.val() == 1 && valor_input > sumBalancetotal) {
            limpia_con_mensaje('El valor a pagar no debe ser mayor a la deuda en el pago de Caja Digital', 'Error','');
            return ;
        }
        
        make_payment_message('¿Esta seguro que desea realizar el pago con el monto de RD$$ ' + input_txt_monto_pago.val() + '?', 'Seguridad');
    });

       /*(function($) {
                $.fn.currencyFormat = function() {
                    this.each( function( i ) {
                        $(this).change( function( e ){
                            if( isNaN( parseFloat( this.value ) ) ) return;
                            this.value = parseFloat(this.value).toFixed(2);
                        });
                    });
                    return this; //for chaining
                }
                })( jQuery );

            $( function() {
                $('.currency').currencyFormat();
            });*/

    /*function set_total(total)
    {

        $("#generated_sumbalance").html("<p> Total a pagar: RD$ " + total + "</p>");

        if($('select[name=type]').val() == 1 || $('select[name=type]').val() == 0)
            {
                $("#generated_sumbalance").html("<p> Total a pagar: RD$ " + total + "</p>");
            }
            
    }*/

});