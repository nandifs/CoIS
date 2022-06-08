'use strict';
var tableName = "def-table-1";

function clearForm() {    
    resetForm($('#form-data'));
}

function updateData(cbtn) {
    let dataId = $(cbtn).attr('data-id');
    
    clearForm();

    if (dataId=="new"){
        $("#pop-overlay").hide();

        $(".modal-title").text("Tambah Data Wilayah Kerja");
        $('#modal-lg').modal('show');
    }else{
        $("#pop-overlay").show();
        
        $(".modal-title").text("Update Data Wilayah Kerja");
        $('#modal-lg').modal('show');

        $.postJSON("ajax_getwilayahkerja", {data_id : dataId}, function (data, status) {
            if (status=='success'){
                $("#data_id").val(data.id);
                $("#nama_wilayah").val(data.wilayah);
                $("#nama_singkat").val(data.singkatan);
                $("#kode_wilayah").val(data.kode);
            }
            $("#pop-overlay").hide();
        });
    }                
}

function deleteData(cbtn){
    let dataId, dataContent, postAddr, dataTable;
    let iRow = $(cbtn).closest('tr').get(0).rowIndex;
    let iText = $(cbtn).closest('tr').get(0).cells[1].innerHTML;
    
    dataId = $(cbtn).attr('data-id');    
    dataContent = iText;    

    dataTable = tableName + "|" + iRow;
    postAddr = "wilayahkerja_delete/" + dataId;
    
    //Do delete data
    sweetAlertDelete(dataContent, postAddr, dataTable);
}

$(function () {
    $('#modal-lg').on('shown.bs.modal', function () {
        $('#nama_wilayah').focus();
        $('#nama_wilayah').select();
    })

    $('.btn-submit').click(function(){
        var dataForm = $("#form-data").serializeArray();
        $.LoadingOverlay("show");
        $.postJSON("wilayahkerja_update", dataForm, function (data, status) {
            if (status=='success'){                
                if (data.status=='success'){
                    let newDtCell = dataForm.slice(2,5);
                    
                    newDtCell[0].value=(newDtCell[0].value).toUpperCase();
                    newDtCell[1].value=(newDtCell[1].value).toUpperCase();

                    if (data.data != "-"){                        
                        let newCol1 = {name: "aksi", value: createDefaultAction(data.data)};
                        
                        newDtCell.push (newCol1);
                        
                        let dataTable = {name:tableName, irow:"last", data: newDtCell};
                        
                        insertTableRow(dataTable);                        
                    }else{
                        
                        let dataId = $('#data_id').val();
                        let iRow = $('button[data-id="' + dataId + '"]').closest('tr').get(0).rowIndex;
                        
                        let dataTable = {name:tableName, irow:iRow, data: newDtCell};

                        updateTableRow(dataTable);
                    }
                    sweetAlert(data.message);
                    $('#modal-lg').modal('hide');
                }else if (data.status=='duplicated'){
                    sweetAlertError("Nama Wilayah telah ada dalam database.", "Duplicated Entry");
                }else{
                    alert("Failed updated data ajax!!!");
                }
                $.LoadingOverlay("hide");
            }else{
                let msgx="Error Post Ajax: Failed!!!";
                console.log(msgx);
                $.LoadingOverlay("hide");
            }
        });
    });
});