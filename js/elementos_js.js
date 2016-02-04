function ventana_modal(titulo, cuerpo, footer, id_modal, id_generador){

	var modal = '';

	modal += '<div class="modal fade" id="' + id_modal + '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
	modal += '<div class="modal-dialog"><div class="modal-content"><div class="modal-header">';
	modal += '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
	modal += '<h4 class="modal-title" id="myModalLabel">' + titulo +'</h4>';
	modal += '</div><div class="modal-body">' + cuerpo + '</div>';
	modal +=  '<div class="modal-footer">' + footer + '</div>';
	modal += '</div></div></div>';

	$('#' + id_generador).empty().append(modal);

	$('#'+ id_modal).modal('toggle');

};






		