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
    $.postJSON('/gettitiklokasibygrup', keydata, function (data, status) {
        if (status=='success'){
            let titikLokasi = data.titik_lokasi;
            titikLokasi.forEach(element => {                
                let newOption = $("<option/>", {
                        value: element.lokasi,
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
  
    /* For foto offline */
    const foto_offline = document.querySelector("#foto_offline") ;
    const foto_name = document.querySelector("#foto_name") ;
    const tgl_kegiatan = document.querySelector("#tanggal") ;
    const uri_foto = document.querySelector("#urifoto") ;

    var upload_foto = "";
  
    foto_offline.addEventListener("change", function(){
        const reader = new FileReader();
        
        reader.addEventListener("load", ()=> {            
            upload_foto = reader.result;
            
            //Compress Image Uploader
            const imgElement = document.createElement("img");

            imgElement.src = upload_foto;
            imgElement.onload = function(e){
                const canvas = document.createElement("canvas")
                const MAX_WIDTH = 600;

                const scaleSize = MAX_WIDTH / e.target.width;
                canvas.width = MAX_WIDTH;
                canvas.height = e.target.height * scaleSize;

                const ctx = canvas.getContext("2d");

                ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);

                const srcEncode = ctx.canvas.toDataURL(e.target, "image/jpeg");                
                let url_foto = `${srcEncode}`;

                document.querySelector("#foto").style.backgroundImage = `url(${url_foto})`;
                uri_foto.value = url_foto.replace(/^data:image\/(png|jpg|jpeg);base64,/, "");
            }

            foto_name.textContent = this.files[0].name;
        });

        const lastModifiedDate = new Date(this.files[0].lastModified);
        tgl_kegiatan.value = ubah_tanggal_to_mysql(lastModifiedDate);
        
        reader.readAsDataURL(this.files[0]);

        document.querySelector("#getfoto").style.display="none";
    });
    /* end foto offline */
    
    //disable button submit after click
    // $("#form-kegiatan").submit(function (e) {
    //   if (validateForm()){
    //     $("#btnSubmit").attr("disabled", true);    
    //   }else{
    //     return false;
    //   }
    // });
});
  