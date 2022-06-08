"use strict";

var tblTenagakerja;

function initTblTenagakerja() {
  let url_link = "/pegawai/ajax_data_pegawai";

  tblTenagakerja = $("#tbl-pegawai").DataTable({
    processing: true, //Feature control the processing indicator.
    serverSide: true, //Feature control DataTables' server-side processing mode.
    order: [], //Initial no order.

    // Load data for the table's content from an Ajax source
    ajax: {
      url: url_link,
      type: "POST",
      data: function (d) {
        d.data_id = $("#dt-akses").val();
      },
    },

    //Set column definition initialisation properties.
    columnDefs: [
      {
        targets: [0], //first column / numbering column
        orderable: false, //set not orderable
      },
    ],
  });
}

function initObjPageTenagakerja() {
  bsCustomFileInput.init();

  $("#dt-akses").on("select2:select", function () {
    tblTenagakerja.ajax.reload();
  });

  initTblTenagakerja();
}

function deleteData(pegawai_id, nama_pegawai) {
  console.log(pegawai_id);
  let dataContent, postAddr;
  dataContent = nama_pegawai;

  postAddr = "pegawai/delete_by_ajax/" + pegawai_id;

  //Do delete data
  sweetAlertDelete(dataContent, postAddr, "reload:tbl-pegawai");
}

$(function () {
  initObjPageTenagakerja();
});
