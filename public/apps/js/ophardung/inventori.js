'use strict';

function initObject() {
	$("#tabel-inventori").DataTable({
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
}

function opharInventoriUnit(keydata){    
    
	let periode = document.getElementById("periode").value;

    let sendData = keydata + "|" + periode;

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
    myForm.action = "/ophardung_inventoriunit";
    myForm.submit();    
}

function data_inventori(id_inspeksi) {
  var url1 = "/getkegiatanophardung/" + id_inspeksi;
	$.postJSON(url1, function (data, status) {            
		if (status=='success'){

				let appName = $("#appName").val();
				let mkid = addZeroSpaces(data.mitrakerja_id,"mk",5);
				let blnthn = ubah_tgl_mtmy(data.tanggal);

				var id_foto = data.foto;			
				var foto_kegiatan = "uploads/" + appName + "/" + mkid + "/" + blnthn + "/kegiatan/" + id_foto;
						
				$('#img_foto').attr('src', foto_kegiatan);
				$('#jenis').val(data.jenis);
				$('#tanggal').val(data.tanggal);
				$('#titik').val(data.lokasi);
				$('#kondisi').val(data.kondisi);
				$('#keterangan').val(data.keterangan);
				$('#unitkerja').val(data.mitrakerja);
				$('#petugas').val(data.petugas);
				
				$('#MdlDetailKegiatan').modal('show');
		} else {
			alert('Error Ajax: Data tidak dapat dibuka. Silahkan coba beberapa saat lagi.');
		}
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
    myForm.action = "/ophardung_inventori";
    myForm.submit();    
}

$(function () {
	initObject();
});

