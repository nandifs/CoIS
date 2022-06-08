'use strict';

function clearForm() {    
    resetForm($('#form-data'));
}

function updateData(cbtn) {
    let dataId = $(cbtn).attr('data-id');
    
    clearForm();

    if (dataId=="new"){
        $("#pop-overlay").hide();

        $(".modal-title").text("Tambah Data Instansi");
        $('#modal-lg').modal('show');
    }else{
        $("#pop-overlay").show();
        
        $(".modal-title").text("Update Data Instansi");
        $('#modal-lg').modal('show');

        $.postJSON("instansi/getdtajax", {data_id : dataId}, function (data, status) {
            if (status=='success'){
                $("#data_id").val(data.id);
                $("#nama_instansi").val(data.instansi);
                $("#nama_singkat").val(data.nama_singkat);
                $("#alamat").val(data.alamat);
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

    dataTable = "data-table" + "|" + iRow;
    postAddr = "instansi/delete/" + dataId;
    
    //Do delete data
    sweetAlertDelete(dataContent, postAddr, dataTable);
}

$(function () {
    $('#modal-lg').on('shown.bs.modal', function () {
        $('#nama_instansi').focus();
        $('#nama_instansi').select();
    })

    $('.btn-submit').click(function(){
        var dataForm = $("#form-data").serializeArray();
        $.LoadingOverlay("show");
        $.postJSON("instansi/update_data", dataForm, function (data, status) {
            if (status=='success'){
                //console.log(data);
                if (data.status=='success'){
                    let newDtCell = dataForm.slice(2,5);
                    newDtCell[0].value=(newDtCell[0].value).toUpperCase();
                    newDtCell[1].value=(newDtCell[1].value).toUpperCase();

                    if (data.data != "-"){
                        let newCol1 = {name: "logo", value: ""}; //Kedepannya update dari hasil input logo
                        let newCol2 = {name: "aksi", value: createDefaultAction(data.data)};
                        
                        newDtCell.push (newCol1, newCol2);
                        
                        let dataTable = {name:"data-table", irow:"last", data: newDtCell};
                        
                        insertTableRow(dataTable);
                    }else{
                        let dataId = $('#data_id').val();
                        let iRow = $('button[data-id="' + dataId + '"]').closest('tr').get(0).rowIndex;
                        let dataTable = {name:"data-table", irow:iRow, data: newDtCell};

                        updateTableRow(dataTable);
                    }
                    sweetAlert(data.message);
                    $('#modal-lg').modal('hide');
                }else if (data.status=='duplicated'){
                    sweetAlertError("Nama instansi telah ada dalam database.", "Duplicated Entry");
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