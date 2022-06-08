'use strict';

function initObject() {
		
	$("#tabel-kegiatan-rutin").DataTable({
		responsive: true,
		autoWidth: false,
	});

	$("#tabel-kegiatan-lainnya").DataTable({
		responsive: true,
		autoWidth: false,
	});
}

function detailKegiatan(id_inspeksi) {	
  var url1 = "/getkegiatanpegawai/" + id_inspeksi;
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

$(function () {
	initObject();
});

