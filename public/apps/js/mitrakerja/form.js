'use strict';
var tableName = "def-table-1";

function initObjPageUnitkerja(){
    $('#modal-lg').on('shown.bs.modal', function () {
        $('#nama_mitrakerja').focus();
        $('#nama_mitrakerja').select();
    })

    $('.btn-submit').click(function(){
        var dataForm = $("#form-data").serializeArray();
        let unitKerja = $("#unitkerja_id option:selected").text();
        let kelas = $("#kelas_id option:selected").text();
        let induk = $("#induk_id option:selected").val();
        
        if (induk!=0){
            induk = $("#induk_id option:selected").text();
        }else{
            induk = "-";
        }

        $.LoadingOverlay("show");
        $.postJSON("mitrakerja_update", dataForm, function (data, status) {            
            if (status=='success'){
                if (data.status=='success'){
                    let newDtCell = dataForm.slice(2,5);
                    newDtCell[0].value=(unitKerja).toUpperCase();
                    newDtCell[1].value=(newDtCell[1].value).toUpperCase();
                    newDtCell[2].value=(newDtCell[2].value).toUpperCase();

                    if (data.data != "-"){
                        let newCol1 = {name: "kelas", value: kelas};
                        let newCol2 = {name: "induk", value: induk};
                        let newCol3 = {name: "aksi", value: createDefaultAction(data.data)};
                        
                        newDtCell.push (newCol1, newCol2, newCol3);
                        
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
                    sweetAlertError("Nama mitra kerja telah ada dalam database.", "Duplicated Entry");
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

        loadComboUnitInduk(this.value, "new");
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

        $(".modal-title").text("Tambah Data Mitra Kerja");
        $('#modal-lg').modal('show');
    }else{
        $("#pop-overlay").show();
        
        $(".modal-title").text("Update Data Mitra Kerja");
        $('#modal-lg').modal('show');

        $.postJSON("ajax_getmitrakerja", {data_id : dataId}, function (data, status) {
            if (status=='success'){
                loadComboUnitInduk(data.kelas, "update");
                
                $("#data_id").val(data.id);
                $("#unitkerja_id").val(data.unitkerja_id);
                $("#kode_unit").val(data.kode);
                $("#nama_mitrakerja").val(data.mitrakerja);
                $("#nama_singkat").val(data.singkatan);
                $("#kelas_id").val(data.kelas);
                $("#induk_id").val(data.induk_id);
                $("#pre_kelas_id").val(data.kelas);
                $("#pre_induk_id").val(data.induk_id);
            }
            $("#pop-overlay").hide();
        });
    }
}

function deleteData(cbtn){
    let dataId, dataContent, postAddr, dataTable;
    let iRow = $(cbtn).closest('tr').get(0).rowIndex;
    let iText = $(cbtn).closest('tr').get(0).cells[2].innerHTML;
    
    dataId = $(cbtn).attr('data-id');
    dataContent = iText;

    dataTable = tableName + "|" + iRow;
    postAddr = "mitrakerja_delete/" + dataId;
    
    //Do delete data
    sweetAlertDelete(dataContent, postAddr, dataTable);
}

function loadComboUnitInduk(kelas_id, stat_call) {
    $('#induk_id').empty();

    if (kelas_id==1){
        let newOption = $("<option/>", {
            value: 0,
            text: "UNIT UTAMA"
        });
        
        $('#induk_id').append(newOption);
    }else{
        if (stat_call=="new"){
            $("#pop-overlay").show();
        }        
                
        $.postJSON('ajax_getmitrakerjabykelas/' + (kelas_id-1), function (data, status) {            
            if (status=='success'){
                data.forEach(element => {
                    let newOption = $("<option/>", {
                        value: element.id,
                        text: element.singkatan
                    });
                    
                    $('#induk_id').append(newOption);
                });
                if (stat_call=="new"){
                    $("#pop-overlay").hide();
                }
            } else {
                if (stat_call=="new"){
                    $("#pop-overlay").hide();
                }
                alert('Error Ajax: Data tidak dapat diambil. Silahkan coba beberapa saat lagi.');
            }
        });
    }    
}

$(function () {
    initObjPageUnitkerja();
});