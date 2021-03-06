<form action="#" id="form2" class="form-horizontal">
<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <div class="col-lg-12">
                <p style="font-size: 23px; font-weight: bold;"> <i class="fa fa-list"> Pack Paket Course </i></p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <legend></legend>
        <div id="isi" class="table-responsive">
            <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" id="example">
                <thead>
                    <tr>
                        <th width="1%">No</th>
                        <th style="text-align: center;">Kategori Paket</th>
                        <th style="text-align: center;">Nama Paket</th>
                        <th style="text-align: center;">Pertemuan</th>
                        <th style="text-align: center;">Jumlah Pertemuan</th>
                        <th style="text-align: center;">Deskripsi</th>
                        <th style="text-align: center;">Harga</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="data_packcourse"></tbody>
            </table>
        </div>
        <legend></legend>
    </div>
</div>
</form>

<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Title</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" id="RecID" name="RecID">
                    <input type="hidden" id="PackDetailID" name="PackDetailID">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Kategori Paket</label>
                            <div class="col-md-9">
                               <select class="form-control" id="CatID" disabled="disabled">
                                   <option value="">Pilih Kategori
                                   </option>
                               </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Paket</label>
                            <div class="col-md-9">
                                <input type="text" name="PackName" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Pertemuan</label>
                            <div class="col-md-9">
                                <input type="text" name="PackDetailName" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Jumlah Pertemuan</label>
                            <div class="col-md-9">
                                <input type="text" name="TotalMeet" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Deskripsi</label>
                            <div class="col-md-9">
                               <textarea id="Description" name="Description" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Harga</label>
                            <div class="col-md-9">
                                <input type="text" name="PriceDetail" class="Idr form-control">
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
<!-- datatables css -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/plugins/datatables/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/plugins/datatables/responsive.bootstrap.min.css">
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?=base_url('assets/js/autoNumeric.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/ckeditor/ckeditor.js')?>"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')?>"></script>
<script type="text/javascript">


$(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('Description');
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
});

$(document).ready(function(){
    $(".Idr").autoNumeric('init', {aSign: 'Rp ', aDec: ',', aSep: '.'});
    reload_data();
        get_kategory();

});
var save_method;
var table;
function modal_form(RecID)
{
    $(".text-danger").remove();
/*    if (!RecID) {
        save_method = 'add';
        $('#modal_form').modal({backdrop: 'static', keyboard: false});
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Paket Course'); 
    } else {*/
        save_method = 'update';
        $('#form')[0].reset();
        $.ajax({
            url : base_url + "mastercourse/edit_packcourse/"+RecID,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                //alert(data.PackDetailID);
                $('#modal_form').modal({backdrop: 'static', keyboard: false});
                $('[name="PackDetailName"]').val(data.PackDetailName);
                $('[name="TotalMeet"]').val(data.TotalMeet);
                $('[name="PriceDetail"]').val(convertToRupiah(data.PriceDetail));
                $('#CatID').val(data.CatID);
                $('[name="PackName"]').val(data.PackName);
                CKEDITOR.instances['Description'].setData(data.Description);
                $('#RecID').val(data.RecID);
                $('#PackDetailID').val(data.PackDetailID);
                $('#modal_form').modal('show');
                $('.modal-title').text('Edit Paket Course');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });/*
    }*/
}

function save()
{

    ck = CKEDITOR.instances['Description'].getData();

    $(".text-danger").remove();
    if($('#CatID').val() == "") {
        $('#CatID').after('<p class="text-danger">This field is Required</p>');
        $('#CatID').focus();
        return false;
    }
    if($('[name="PackName"]').val() == "") {
        $('[name="PackName"]').after('<p class="text-danger">This field is Required</p>');
        $('[name="PackName"]').focus();
        return false;
    }
    if($('[name="PackDetailName"]').val() == "") {
        $('[name="PackDetailName"]').after('<p class="text-danger">This field is Required</p>');
        $('[name="PackDetailName"]').focus();
        return false;
    }
    if($('[name="TotalMeet"]').val() == "") {
        $('[name="TotalMeet"]').after('<p class="text-danger">This field is Required</p>');
        $('[name="TotalMeet"]').focus();
        return false;
    }
    if(ck == "") {
        $('[name="Description"]').after('<p class="text-danger">This field is Required</p>');
        $('[name="Description"]').focus();
        return false;
    }
    if($('[name="PriceDetail"]').val() == "") {
        $('[name="PriceDetail"]').after('<p class="text-danger">This field is Required</p>');
        $('[name="PriceDetail"]').focus();
        return false;
    } else {
        var url;
        
            url = base_url + "mastercourse/update_packcourse";

        $('#data_packcourse').empty();
        $.ajax({
            url : url,
            type: "POST",
            data: ({
                CatID:$('#CatID').val(),
                PackName:$('[name="PackName"]').val(),
                Description:ck,
                TotalMeet:$('[name="TotalMeet"]').val(),
                PackDetailName:$('[name="PackDetailName"]').val(),
                PriceDetail: convertToAngka($('[name="PriceDetail"]').val()),
                PackDetailID:$('[name="PackDetailID"]').val(),
                RecID:$('#RecID').val()}),
            dataType: "JSON",
            success: function(data)
            {
                if(save_method == 'add') {
                    $.notify(data.message,data.notify);
                } else {
                    $.notify(data.message,data.notify);
                }
                $('#modal_form').modal('hide');
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
    }
}

function reload_data() {
    $.ajax({
        url : base_url+"mastercourse/get_data_packcourse",
        type: 'GET',
        dataType: 'json',
        beforeSend: function(){
            $("#ajax-loader").show();
        },
        complete: function() {
            $("#ajax-loader").hide();
        },
        success: function(data){
            var jml_data = Object.keys(data.rows).length;
            if (jml_data > 0) {
                $('#data_packcourse').empty();
                $.each(data.rows, function(i, item) {
                    var $tr = $('<tr>').append(
                        $('<td>').text(i+1),
                        $('<td>').text(item.CatName),
                        $('<td>').text(item.PackName),
                        $('<td>').text(item.PackDetailName),
                        $('<td style="text-align: center;">').text(item.TotalMeet),
                        $('<td>').html(item.Description),
                        $('<td>').text(convertToRupiah(item.PriceDetail)),
                        $('<td>').html('<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" onclick="modal_form('+item.PackDetailID+');"><span class="glyphicon glyphicon-pencil"></span> Edit</button>'),
                    ).appendTo('#data_packcourse');
                });
                $('#example').dataTable();
            } else {
                $('#data_packcourse').empty();
                var $tr = $('<tr>').append(
                          $('<td colspan="12" style="text-align: center;">').text('- - - No Data - - -'),
                          ).appendTo('#data_packcourse');
            }
        }
    });
};

function get_kategory() {
$.getJSON(base_url+"mastercourse/get_kategory", function(json){
    $('#CatID').empty();
    $('#CatID').append($('<option>').text("- - Pilih Kategori - -").attr('value',''));
    $.each(json, function(i, obj){
$('#CatID').append($('<option>').text(obj.CatName).attr('value', obj.RecID));
    });
});
}

</script>