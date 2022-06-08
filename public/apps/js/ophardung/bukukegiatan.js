'use strict';

var tblBukuKegiatan;

function initObjPageBukuKegiatan() { 
    tblBukuKegiatan = $("#tbl-kegiatan").DataTable({
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

    $('.dataTables_processing', $('#tbl-kegiatan').closest('.dataTables_wrapper')).show();
    $.postJSON('/getrekapkegiatanophardung', keydata, function (data, status) {
        if (status=='success'){
            //console.log(data);
            tblBukuKegiatan.clear();
            tblBukuKegiatan.rows.add(data);
            tblBukuKegiatan.draw();
            $('.dataTables_processing', $('#tbl-kegiatan').closest('.dataTables_wrapper')).hide();
        } else {
            $('.dataTables_processing', $('#tbl-kegiatan').closest('.dataTables_wrapper')).hide();
            alert('Error Ajax: Data tidak dapat diambil. Silahkan coba beberapa saat lagi.');
        }
    });
}

function opharKegiatanPetugasPerTgl(keydata){    
    let mitrakerja_id= document.getElementById("dt-akses").value;
    let periode = document.getElementById("sel-periode").value;

    let sendData = keydata + "|" + mitrakerja_id + "|" + periode;

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
    myForm.action = "/ophardung_kegiatanperpetugas";
    myForm.submit();    
}

$(function () {
    initObjPageBukuKegiatan();
    getDataTabelKegiatanAjax();
});