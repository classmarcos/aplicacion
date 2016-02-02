

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ajax CRUD with Bootstrap modals and Datatables</title>
        <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
<body>
	<div class="container">
		<h1 style="font-size:20pt">Ajax CRUD with Bootstrap modals and Datatables with Server side Validation</h1>
		<h3>Person Data</h3>
		<br/>
		<button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add Person</button>
		<button class="btn btn-default" onclick="reload_table()"> <i class="glyphicon glyphicon-refresh"></i>Reload</button>
        <br/>
        <br/>
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                 <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Date of Birth</th>

                </tr>
            </thead>
            <tbody>
            </tbody>
 
            <tfoot>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Date of Birth</th>

            </tr>
            </tfoot>

        </table>


	</div>






    <script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
    <script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>



    <script type="text/javascript">

        var save_method;
        var table;
        
        $(document).ready(function(){
            //cargar datos al datatable
            table = $('#table').DataTable({
                "processing":true,
                "serverSide":true,
                "order":[],

                "ajax":{
                    "url":"<?php echo site_url('person/ajax_list')?>",
                    "type":"POST"
                },

                "ColumnDefs":[{
                    "targets":[-1],
                    "orderable":false,
                }],



            });

            $('.datepicker').datepicker({
                autoclose:true,
                format:"yyyy-mm-dd",
                todayHighlight:true,
                orientation:"top auto",
                todayBtn:true,
                todayHighlight:true,
            });

            $("input").change(function(){
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });

            $("textarea").change(function(){
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });

            $("select").change(function(){
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });

        });

        function add_person(){
            save_method = 'add';
            $('#form')[0].reset();
            $('.form-group').removeClass('has-error');
            $('.help-block').empty();
            $('#modal_form').modal('show');
            $('.modal-title').text('Add Person');
        }


       /* $(document).ready(function() {
            var table = $('#table').DataTable();

            $('#table tbody').on('click', 'tr', function () {
                var data = table.row( this ).data();
                alert( 'You clicked on '+edit_person(1)+'\'s row' );
            } );
        } );*/

         $(document).ready(function() {
         var table = $('#table').DataTable();

             save_method = 'update';
             $('#form')[0].reset();
             $('.form-group').removeClass('has-error');
             $('.help-block').empty();

         $('#table tbody').on('click', 'tr', function () {
           // $(this).edit_person(1);
         ///alert( 'You clicked on '+edit_person(1)+'\'s row' );
             var data = table.row( this ).data();
             $.ajax({

                 url:"<?php echo site_url('person/ajax_edit')?>/"+data[0],
                 type:"GET",
                 dataType:"JSON",
                 success: function(data){
                     $('[name="id"]').val(data.id);
                     $('[name="firstName"]').val(data.firstName);
                     $('[name="lastName"]').val(data.lastName);
                     $('[name="gender"]').val(data.gender);
                     $('[name="address"]').val(data.address);
                     $('[name="dob"]').datepicker('update',data.dob);
                     $('#modal_form').modal('show');
                     $('.modal-title').text('Edit Person');
                 },
                 error: function(JqXHR, textStatus,errorThown){
                     alert('Error get data from ajax');
                 }

             });
         } );
         } );



        /*function edit_person(id){
            save_method = 'update';
            $('#form')[0].reset();
            $('.form-group').removeClass('has-error');
            $('.help-block').empty();

            $.ajax({
                url:"<?php echo site_url('person/ajax_edit')?>/"+id,
                type:"GET",
                dataType:"JSON",
                success: function(data){
                    $('[name="id"]').val(data.id);
                    $('[name="firstName"]').val(data.firstName);
                    $('[name="lastName"]').val(data.lastName);
                    $('[name="gender"]').val(data.gender);
                    $('[name="address"]').val(data.address);
                    $('[name="dob"]').datepicker('update',data.dob);
                    $('#modal_form').modal('show');
                    $('.modal-title').text('Edit Person');
                },
                error: function(JqXHR, textStatus,errorThown){
                    alert('Error get data from ajax');
                }

            });
        }*/

        function reload_table(){
            table.ajax.reload(null,false);
        }

        function save(){
            $('#btnSave').text('Saving...');
            $('#btnSave').attr('disabled',true);
            var url;

            if(save_method=='add'){
                url = "<?php echo site_url('person/ajax_add')?>";
            } else {
                url = "<?php echo site_url('person/ajax_update')?>";
            }

            $.ajax({
                url:url,
                type:"POST",
                data: $('#form').serialize(),
                dataType:"JSON",
                success: function(data){

                    if(data.status){
                        $('#modal_form').modal('hide');
                        reload_table();
                    }
                    else{

                        for (var i = 0; i < data.inputerror.lenght; i++) {
                            $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error');
                            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                        }
                    }

                    $('btnSave').text('save');
                    $('btnSave').attr('disabled',false);
                },
                error: function(JqXHR,textStatus,errorThown){
                    alert('Error adding/update adta');
                    $('btnSave').text('save');
                    $('btnSave').attr('disabled',false);
                }
            });
        }

        function delete_person(id){
            if(confirm('Are you sure delete this data?')){
                $.ajax({
                    url:"<?php echo site_url('person/ajax_delete')?>",
                    type:"POST",
                    dataType: "JSON",
                    success: function(data){
                        $('#modal_form').modal('hide');
                        reload_table();
                    },
                    error: function (JqXHR,textStatus,errorThown){
                        alert('Error deleting data');
                    } 
                });
            }
        }

    </script>

    <!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">First Name</label>
                            <div class="col-md-9">
                                <input name="firstName" placeholder="First Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Last Name</label>
                            <div class="col-md-9">
                                <input name="lastName" placeholder="Last Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Gender</label>
                            <div class="col-md-9">
                                <select name="gender" class="form-control">
                                    <option value="">--Select Gender--</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Address</label>
                            <div class="col-md-9">
                                <textarea name="address" placeholder="Address" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Date of Birth</label>
                            <div class="col-md-9">
                                <input name="dob" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->


</body>
</html>

