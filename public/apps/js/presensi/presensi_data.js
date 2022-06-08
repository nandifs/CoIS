'use strict';

function initObjPagePresensi() {
    console.log("load page presensi");
    $("#dt-akses").on('select2:select', function (e) {                
        $("#frm-refresh").submit();
    });
}

function getPresensiDetail(keydata){    
    console.log("get presensi detail");
    let mitrakerja_id= document.getElementById("dt-akses").value;
    let periode = document.getElementById("periode").value;

    let sendData = keydata + "|" + mitrakerja_id + "|" + periode;
    //alert(sendData);

    var myForm = document.createElement("FORM");
    myForm.setAttribute("id","FromData");
    document.body.appendChild(myForm);

    var myInput = document.createElement("INPUT");
    myInput.setAttribute("name","key_data");
    myInput.setAttribute("type","text");
    myInput.setAttribute("value",sendData);
    document.getElementById("FromData").appendChild(myInput);
   
    // To submit the form: 
    myForm.method = "POST";
    myForm.action = "/presensi_detail";
    myForm.submit();    
}

$(function () {    
    initObjPagePresensi();    
});