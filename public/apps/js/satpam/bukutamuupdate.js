function validateForm() {
  let x1 = document.forms["form-bukutamu"]["urifoto1"].value;
  let x2 = document.forms["form-bukutamu"]["urifoto2"].value;
  let x3 = document.forms["form-bukutamu"]["ttd_tamu"].value;

  if (x1 == "") {
      alert("Anda belum mengambil Foto Identitas Tamu!!!");
      return false;
  }else if (x2 == "") {
      alert("Anda belum mengambil Foto Tamu!!!");
      return false;
  }else if (x3 == "") {
  }else{
    $("#btnSubmit").attr("disabled", true);
  }  
}

$(function () {
    if (isObjExist("signArea")){
      $("#signArea").signaturePad({
        drawOnly: true,
        drawBezierCurves: true,
        lineTop: 130,
        onDrawEnd: function () {
          var canvas = document.getElementById("sign-pad");
          var canvas_img_data = canvas.toDataURL("image/png");
          var img_data = canvas_img_data.replace(
            /^data:image\/(png|jpg);base64,/, ""
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
        startCamera(imgElement, uriElement, 1);
        $("#getfoto1").val("Ulangi");
    }
    });
    
    $("#getfoto2").click(function () {
    vFlag = $("#getfoto2").val();
    imgElement = $("#foto2");
    uriElement = $("#urifoto2");
    if (vFlag == "Ambil Foto" || vFlag == "Ulangi") {
        startCamera(imgElement, uriElement, 1);
        $("#getfoto2").val("Ulangi");
    }
    });
});
    