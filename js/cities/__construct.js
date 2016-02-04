$(document).ready(function(){
    $('#el_botonaso').on('click', function(){
        var view = '<div title=""><table id="grid_list" class="scroll"></table><div id="grid_pager" class="scroll"></div></div>';
        $(view).dialog({
            width:'auto',
            height:'auto',
            modal:true,
            resizable:false,
            open:function(){
                load_data();
            },
            buttons:{
                "Cancelar":function(){
                    $(this).dialog('close').remove();
                },
                "Aceptar":function(){
                    var row = jQuery("#grid_list").jqGrid('getGridParam','selrow');
                    var city = jQuery("#grid_list").jqGrid('getRowData',row);
                    alert('la ciudad seleccionada es ' + city.cities_name);

                    $(this).dialog('close').remove();
                }
            }
        });
    });
    load_data();
});

load_data = function(){
    var _colNames = 
        [ 
            'cities_id',
            'cities_name',
            'cities_type'
        ];
    var _colModel =
        [ 
            { name: 'cities_id', /*width:100, align: 'right',*/ hidden: false},
            { name: 'cities_name', /*width:100, align: 'right',*/ hidden: false},
            { name: 'cities_type', /*width:100, align: 'right',*/ hidden: false}
        ];


$("#grid_list").jqGrid({ 
        datatype:'json',
        url: link_to('load_cities'),
        colNames: _colNames,
        colModel: _colModel,
        sortname: 'cities_id',
        pager: $('#grid_pager'),
    }).navGrid('#grid_pager',{ add:false, edit:false, del:false, search:false })
      .navButtonAdd('#grid_pager',{
        caption:"", 
        buttonimg: 'ui-icon ui-icon-newwin'
    });
    $('#grid_list').setGridWidth(500);
}


