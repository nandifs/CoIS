'use strict';

function initObject_Add() {    
  $("#cmb-shift").on("change", function () {   
      var jamDinas= getJamDinas(this.value);
      $("#txt-jam-dinas").val(jamDinas);
  }); 

  //disable button submit after click
  $("#form-bukumutasi").submit(function (e) {
    $("#btnSubmit").attr("disabled", true);    
  });
}

function getJamDinas(idx){  
  return dtShift[idx-1].jam_dinas;
}

$(function () {  
  initObject_Add();
});