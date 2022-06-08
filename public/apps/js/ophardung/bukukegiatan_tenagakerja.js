'use strict';

function initObject() {  
  $("#tbl-kegiatan").DataTable({
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

function onClickPreviousButton(mitrakerja_id, periode){
  var myForm = document.createElement("FORM");
  myForm.setAttribute("id","FromData");
  document.body.appendChild(myForm);

  var myInput1 = document.createElement("INPUT");    
  var myInput2 = document.createElement("INPUT");    

  myInput1.setAttribute("name","dtakses");
  myInput1.setAttribute("type","text");
  myInput1.setAttribute("value",mitrakerja_id);

  myInput2.setAttribute("name","periode");
  myInput2.setAttribute("type","text");
  myInput2.setAttribute("value",periode);

  document.getElementById("FromData").appendChild(myInput1);
  document.getElementById("FromData").appendChild(myInput2);
 
  // To submit the form: 
  myForm.method = "POST";
  myForm.action = "/ophardung_kegiatan";
  myForm.submit();    
}

$(function () {  
  initObject();
});