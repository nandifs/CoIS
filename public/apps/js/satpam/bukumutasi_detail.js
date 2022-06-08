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
}

$(function () {
    initObjPageBukuMutasi();    
});