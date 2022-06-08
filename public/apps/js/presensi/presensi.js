var objViewKordinat = document.getElementById("lblGeoLocation");
var actCamera = 0;

function validateForm() {  
  if($('#div_foto1').is(':visible')){
    let x = document.forms["form-presensi"]["urifoto1"].value;
    if (x == "") {
      let jenis = $('#jenis').val();
      if (jenis == 1){
        alert("Anda belum mengambil Foto Selfie !!!");
      }else if (jenis==2){
        alert("Anda belum mengambil Foto Surat Dokter/Keterangan Sakit !!!");
      }else if (jenis==3){
        alert("Anda belum mengambil Foto Surat Izin Cuti !!!");
      }      
      return false;
    }
  }  
}

$("#jenis").on("change", function () {
  $("#div_foto1").show();

  if (this.value == 1) {
    $("#lblFoto1").html("Foto Absensi Masuk");
    actCamera = 0;
  } else {
    if (this.value == 2) {
      $("#lblFoto1").html("Foto Surat Dokter");
      actCamera = 1;
    } else if (this.value == 3) {
      $("#lblFoto1").html("Foto Surat Cuti");
      actCamera = 1;
    } else if (this.value == 4) {
      $("#div_foto1").hide();
    }
    $("#div_jam_masuk").hide();
  }
});

$(function () {  
  if($('#div_foto1').is(':visible')){
    $("#signArea").signaturePad({
      drawOnly: false,
      drawBezierCurves: true,
      lineTop: 130,
      onDrawEnd: function () {
        var canvas = document.getElementById("sign-pad");
        var canvas_img_data = canvas.toDataURL("image/png");
        var img_data = canvas_img_data.replace(
          /^data:image\/(png|jpg);base64,/,
          ""
        );
        $("#ttd_tamu").val(img_data);
      },
    });
  }

  $("#getfoto1").click(function () {
    vFlag = $("#getfoto1").val();
    imgElement = $("#foto1");
    uriElement = $("#urifoto1");
    if (vFlag == "Ambil Foto" || vFlag == "Ulangi") {      
      startCamera(imgElement, uriElement, actCamera);
      $("#getfoto1").val("Ulangi");
      $("#jam_masuk").val(CurrentDate("mysql") + " " + CurrentTime());
    }
  });

  $("#getfoto2").click(function () {
    vFlag = $("#getfoto2").val();
    imgElement = $("#foto2");
    uriElement = $("#urifoto2");
    if (vFlag == "Ambil Foto" || vFlag == "Ulangi") {
      startCamera(imgElement, uriElement, actCamera);
      $("#getfoto2").val("Ulangi");
      $("#jam_pulang").val(CurrentDate("mysql") + " " + CurrentTime());
    }
  });

  //disable button submit after click
  $("#form-presensi").submit(function (e) {
    $("#btnSubmit").attr("disabled", true);    
  });
  
  if (typeof getGeoLocation === "function") { 
    getGeoLocation(objViewKordinat);
  }  
});
