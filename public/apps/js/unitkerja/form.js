'use strict';
var tableName = "def-table-1";

function initObjPageUnitkerja(){
    $('#modal-lg').on('shown.bs.modal', function () {
        $('#nama_unitkerja').focus();
        $('#nama_unitkerja').select();
    })

    $('.btn-submit').click(function(){
        var dataForm = $("#form-data").serializeArray();
        $.LoadingOverlay("show");
        $.postJSON("unitkerja_update", dataForm, function (data, status) {
            if (status=='success'){                
                if (data.status=='success'){
                    let newDtCell = dataForm.slice(2,5);
                    
                    let namaUnit = newDtCell[0].value;
                    let namaSingkat = newDtCell[1].value;
                    let kelas_unit = newDtCell[2].value;

                    if (kelas_unit == "1"){
                        kelas_unit = "UTAMA/PUSAT";
                    }else if (kelas_unit == "2"){
                        kelas_unit = "CABANG";
                    }else if (kelas_unit == "3"){
                        kelas_unit = "RANTING";
                    }else{
                        kelas_unit = "-";
                    }

                    newDtCell[0].value=(namaSingkat).toUpperCase();
                    newDtCell[1].value=(namaUnit).toUpperCase();
                    newDtCell[2].value=(kelas_unit).toUpperCase();

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
                    sweetAlertError("Nama unit kerja telah ada dalam database.", "Duplicated Entry");
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

    $('#kelas_id').on('change', function() {
        if (this.value==1){
            $('#induk_id').val(0).change();
        }

        loadComboUnitInduk(this.value);
    });
}

function clearForm() {
    resetForm($('#form-data'));
}

function updateData(cbtn) {
    let dataId = $(cbtn).attr('data-id');
    
    clearForm();

    if (dataId=="new"){
        $("#pop-overlay").hide();

        $(".modal-title").text("Tambah Data Unit Kerja");
        $('#modal-lg').modal('show');
    }else{
        $("#pop-overlay").show();
        
        $(".modal-title").text("Update Data Unit Kerja");
        $('#modal-lg').modal('show');

        $.postJSON("ajax_getunitkerja", {data_id : dataId}, function (data, status) {
            if (status=='success'){
                $("#data_id").val(data.id);
                $("#kode_unit").val(data.kode);
                $("#nama_unitkerja").val(data.unitkerja);
                $("#nama_singkat").val(data.singkatan);
                $("#kelas_id").val(data.kelas_id);
                $("#induk_id").val(data.induk_id);
                $("#wilayah_id").val(data.wilayah_id);
                $("#pre_kelas_id").val(data.kelas_id);
                $("#pre_induk_id").val(data.induk_id);
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
    postAddr = "unitkerja_delete/" + dataId;
    
    //Do delete data
    sweetAlertDelete(dataContent, postAddr, dataTable);
}

function loadComboUnitInduk(kelas_id) {
    $('#induk_id').empty();

    if (kelas_id==1){
        let newOption = $("<option/>", {
            value: 0,
            text: "UNIT UTAMA"
        });
        
        $('#induk_id').append(newOption);
    }else{
        $.postJSON('ajax_getunitkerjabykelas/' + (kelas_id-1), function (data, status) {
            if (status=='success'){
                data.forEach(element => {
                    let newOption = $("<option/>", {
                        value: element.id,
                        text: element.singkatan
                    });
                    
                    $('#induk_id').append(newOption);
                });
            } else {
                alert('Error Ajax: Data tidak dapat diambil. Silahkan coba beberapa saat lagi.');
            }
        });
    }    
}

$(function () {
    initObjPageUnitkerja();
});