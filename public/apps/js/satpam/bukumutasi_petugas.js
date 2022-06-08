'use strict';

function initObject() {  
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

  cekPetugasAdded();
}

function cekPetugasAdded(){
  let petugasAlreadyAdd = $("#petugas_added").val();
  if (petugasAlreadyAdd == "not_yet"){
    $("#modal-add-petugas").modal("toggle");
    console.log(petugasAlreadyAdd);
  }
}

$(function () {  
  initObject();
});