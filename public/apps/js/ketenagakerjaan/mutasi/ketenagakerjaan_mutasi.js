'use strict';

var tblTenagakerja;

function initTblTenagakerja() {
  
}

function initObjPageTenagakerja() {
  bsCustomFileInput.init();
}

function editData(nip){  
  let url_post ="/tenagakerja_mutasi_edit";

  $.postFormData(url_post, nip);
}

function deleteData(tenagakerja_id, nama_tenagakerja) {
  let dataContent, postAddr;
  dataContent = nama_tenagakerja;

  postAddr = "tenagakerja_mutasi_delete/" + tenagakerja_id;

  //Do delete data
  sweetAlertDelete(dataContent, postAddr, "reload:tbl-tenagakerja");
}

$(function () {
  initObjPageTenagakerja();
});
