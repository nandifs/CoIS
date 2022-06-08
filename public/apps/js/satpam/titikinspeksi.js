'use strict';

var tblTitikInspeksi;

function initObjPageTitikInspeksi() {
    tblTitikInspeksi = $('#tbl-titik-inspeksi').DataTable({
        responsive: true,
        autoWidth: false,
        processing : true,
    });        

    $("#dt-akses").on('select2:select', function (e) {        
        let data_id = e.params.data.id;        
        getDataTabelAjax(data_id)        
    });
}

function getDataTabelAjax(vdata_id) {
    let keydata = {data_id:vdata_id}
    $('.dataTables_processing', $('#tbl-titik-inspeksi').closest('.dataTables_wrapper')).show();
    $.postJSON('/gettitikinspeksiwithajax', keydata, function (data, status) {
        if (status=='success'){
            //console.log(data);
            tblTitikInspeksi.clear();
            tblTitikInspeksi.rows.add(data);
            tblTitikInspeksi.draw();
            $('.dataTables_processing', $('#tbl-titik-inspeksi').closest('.dataTables_wrapper')).hide();
        } else {
            $('.dataTables_processing', $('#tbl-titik-inspeksi').closest('.dataTables_wrapper')).hide();
            alert('Error Ajax: Data tidak dapat diambil. Silahkan coba beberapa saat lagi.');
        }
    });
}

$(function () {    
    let dtAkses = $("#dt-akses").val();

    initObjPageTitikInspeksi();
    getDataTabelAjax(dtAkses);
});