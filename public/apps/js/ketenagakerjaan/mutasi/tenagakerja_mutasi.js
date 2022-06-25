'use strict';

var tblTenagakerja;

function initTblTenagakerja() {
  
}

function initObjPageTenagakerja() { 
  //Date picker  
  $('#tgl-berlaku').datetimepicker({
    format: 'DD-MM-YYYY'
  });

  $('.btn-update').click(function () {
    const upd_id = $(this).data('id');
    let nip = $('#nip').val();
    
    if (nip != ""){
        if (upd_id == "add"){            
            let url_get ="/ketenagakerjaan_mutasi_add";                            
            sendGetData(url_get, nip, "nip");
        }else if(upd_id == "edit"){                                    
            let url_post ="/ketenagakerjaan_mutasi_edit";
            sendPostData(url_post, nip, "nip");
        }else if(upd_id == "cari"){
            let url_get ="/ketenagakerjaan_info";
            sendGetData(url_get, nip,"nip");
        }
    }else{            
        sweetAlertInfo("NIP tenaga kerja belum terisi.");
    }
  });
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
