'use strict';

var tblTenagakerja;

function initTblTenagakerja() {
  let url_link = "ajax_getdatatenagakerja";

  tblTenagakerja = $("#tbl-tenagakerja").DataTable({    
    scrollX: true,
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
      }      
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

function editData(nip){  
  let url_post ="/tenagakerja_edit_detail";

  $.postFormData(url_post, nip);
}

function deleteData(tenagakerja_id, nama_tenagakerja) {
  let dataContent, postAddr;
  dataContent = nama_tenagakerja;

  postAddr = "tenagakerja_delete/" + tenagakerja_id;

  //Do delete data
  sweetAlertDelete(dataContent, postAddr, "reload:tbl-tenagakerja");
}

$(function () {
  initObjPageTenagakerja();
});
