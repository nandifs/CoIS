'use strict';

var tblBukuMutasi;

function initObjPageBukuMutasi() {
    $("#tblpetugas").DataTable({
        paging: false,
        lengthChange: false,
        searching: false,
        ordering: false,
        info: false,
        autoWidth: false,
        responsive: true,
        columnDefs: [
            { width: "30px", targets: [0] }
            ],
    });

    $("#tblinventaris").DataTable({
        paging: false,
        lengthChange: false,
        searching: false,
        ordering: false,
        info: false,
        autoWidth: false,
        responsive: true,
        columnDefs: [
            { width: "30px", targets: [0] }
            ],
    });

    $("#tblkegiatan").DataTable({
        paging: true,
        lengthChange: false,
        searching: false,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true,
        columnDefs: [
            { width: "30px", targets: [0] }
          ],
    });

    tblBukuMutasi = $("#tbl-buku-mutasi").DataTable({
        processing: true,
        paging: true,
        lengthChange: false,
        searching: false,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true,
        columnDefs: [
            { width: "30px", targets: [0] }
            ],
    });

    $("#btn-tampilkan").click(function () {       
        getDataTabelKegiatanAjax()
    });
}

function getDataTabelKegiatanAjax() {
    let vdtid = $("#dt-akses").val();
    let vperiode = $("#sel-periode").val();

    let keydata = {data_id:vdtid, periode:vperiode}

    $('.dataTables_processing', $('#tbl-buku-mutasi').closest('.dataTables_wrapper')).show();
    $.postJSON('/getbukumutasisatpam', keydata, function (data, status) {
        if (status=='success'){
            //console.log(data);
            tblBukuMutasi.clear();
            tblBukuMutasi.rows.add(data);
            tblBukuMutasi.draw();
            $('.dataTables_processing', $('#tbl-buku-mutasi').closest('.dataTables_wrapper')).hide();
        } else {
            $('.dataTables_processing', $('#tbl-buku-mutasi').closest('.dataTables_wrapper')).hide();
            alert('Error Ajax: Data tidak dapat diambil. Silahkan coba beberapa saat lagi.');
        }
    });
}

$(function () {
    initObjPageBukuMutasi();    
    getDataTabelKegiatanAjax();
});