var objViewKordinat = document.getElementById("lblGeoLocation");
var actCamera = 0;

function validateForm() {  
	if($('#div_foto1').is(':visible')){
		let x = document.forms["form-presensi"]["urifoto1"].value;
		if (x == "") {      
			alert("Anda belum mengambil Foto Kendaraan !!!");      
			return false;
		}
	}  
}

function getkendaraanbynopol() {  
	let nopol = $("#nopol").val();
	let keydata = {data_key:nopol}
    $.LoadingOverlay("show");
	$.postJSON('/getkendaraanbynopol', keydata, function (data, status) {
        if (status=='success'){            
            if (data===null){                
                let foto_masuk = "uploads/noimage.jpg";
                $('#data_id').val("");
                $('#img_foto_masuk').attr('src', foto_masuk);
    
                $('#pemilik').val("");
                $('#jenis_kendaraan').val("1");
                $('#jam_masuk').val("");
                $('#ket_masuk').val("");

                sweetAlertError("", "Data Kendaraan Tidak Ditemukan");
            }else{
                $('#img_foto_keluar').hide();
                let appName = $("#appName").val();
                let mkid = addZeroSpaces(data.mitrakerja_id,"mk",5);
                let blnthn = ubah_tgl_mtmy(data.jam_masuk);
    
                let id_foto_masuk = data.foto_masuk;
                let foto_masuk = "uploads/" + appName + "/" + mkid + "/" + blnthn + "/kendaraan/"  + id_foto_masuk;
    
                $('#data_id').val(data.id);
                $('#img_foto_masuk').attr('src', foto_masuk);
    
                $('#pemilik').val(data.pemilik);
                $('#jenis_kendaraan').val(data.jns_kendaraan);
                $('#jam_masuk').val(data.jam_masuk);
                $('#ket_masuk').val(data.ket_masuk);

                //Jika data jam keluar telah terisi
                if (data.jam_keluar!==null){
                    $('#jam_keluar').val(data.jam_keluar);
                    $('#ket_keluar').val(data.ket_keluar);
                    let id_foto_keluar = data.foto_keluar;
                    let foto_keluar = "uploads/" + appName + "/" + mkid + "/" + blnthn + "/kendaraan/"  + id_foto_keluar;                    
                    $('#img_foto_keluar').attr('src', foto_keluar);
                    $('#img_foto_keluar').show();
                    $('#getfoto2').hide();                    
                    $("#btnSubmit").attr("disabled", true);
                    sweetAlertError("Kendaraan sudah KELUAR pada tanggal " + data.jam_keluar, "PERHATIAN!!!");
                }else{
                    $('#jam_keluar').val("");
                    $('#ket_keluar').val("");                    
                    let foto_keluar = "uploads/noimage.jpg";
                    $('#img_foto_keluar').attr('src', foto_keluar);
                    $('#img_foto_keluar').hide();
                    $('#getfoto2').show();
                    $("#btnSubmit").attr("disabled", false);
                }                
            }
        } else {            
            sweetAlertError("Data tidak dapat diambil. Cek koneksi internet anda atau silahkan coba beberapa saat lagi.", "Error Ajax");
        }
        $.LoadingOverlay("hide");
	});
}

$(function () {  
  
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
            $("#jam_keluar").val(CurrentDate("mysql") + " " + CurrentTime());
        }
    });
  
    $("#btn-cari").click(function () {
        getkendaraanbynopol();
    });
  
    //disable button submit after click
    $("#form-kendaraan").submit(function (e) {
        $("#btnSubmit").attr("disabled", true);
    });    
  });
  