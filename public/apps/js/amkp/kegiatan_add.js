'use strict';

function validateForm() {
  let x = document.forms["form-kegiatan"]["urifoto"].value;
  if (x == "") {
    alert("Anda belum mengambil Foto!!!");
    return false;
  }
}

function getDataLokasiAjax(grupLokasi) {
    $('#lokasi').empty();

    let keydata = {data_id:grupLokasi}    
    $.postJSON('/inspeksi/ajax_get_titik_lokasi_by_grup', keydata, function (data, status) {
        if (status=='success'){
            let titikLokasi = data.titik_lokasi;
            titikLokasi.forEach(element => {                
                let newOption = $("<option/>", {
                        value: element.id,
                        text: element.lokasi
                      });
    
                $('#lokasi').append(newOption);
            });            
        } else {            
            alert('Error Ajax: Data tidak dapat diambil. Silahkan coba beberapa saat lagi.');
        }
    });
}

$(function () {
  $("#getfoto").click(function () {
    
    var vFlag = $("#getfoto").val();
    var imgElement = $("#foto");
    var uriElement = $("#urifoto");
	
    if (vFlag == "Ambil Foto" || vFlag == "Ulangi") {      
      startCamera(imgElement, uriElement, 1);
      $("#getfoto").val("Ulangi");
    }
  });

  $("#grup_lokasi").on('change', function (e) {    
    getDataLokasiAjax(this.value);
  });
});

