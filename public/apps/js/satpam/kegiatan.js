'use strict';

function initObject() {
	$("#tabel-inspeksi").DataTable({
		responsive: true,
		autoWidth: false,
	});

	$("#tabel-kritikal").DataTable({
		paging: true,
		lengthChange: false,
		searching: false,
		ordering: true,
		info: true,
		autoWidth: false,
		responsive: true,
	});

	$("#tabel-kegiatan").DataTable({
		responsive: true,
		autoWidth: false,
	});
}

function detailInspeksi(id_inspeksi) {	
  var url1 = "kegiatan/ajax_get_kegiatan/" + id_inspeksi;
	$.postJSON(url1, function (data, status) {
		if (status=='success'){            

			var id_foto = data.foto;
			var foto_inspeksi = getBaseUrl("uploads/kegiatan/") + id_foto;
                
			$('#img_foto').attr('src', foto_inspeksi);
			$('#jenis').val(data.jenis);
			$('#tanggal').val(data.tanggal);
			$('#titik').val(data.lokasi);
			$('#kondisi').val(data.kondisi);
			$('#keterangan').val(data.keterangan);
			$('#unitkerja').val(data.mitrakerja);
			$('#petugas').val(data.petugas);
			
			$('#MdlDetailInspeksi').modal('show');
		} else {
			alert('Error Ajax: Data tidak dapat dibuka. Silahkan coba beberapa saat lagi.');
		}
	});
}

$(function () {
	initObject();
});

