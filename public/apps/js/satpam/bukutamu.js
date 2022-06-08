'use strict';

function setJamKeluar(id_tamu) {		
  var url1 = "bukutamu_ajax_get_tamu/" + id_tamu;  
	$.postJSON(url1, function (data, status) {		
		if (status=='success'){				
				var i = 0;
				
				$('#up_id_tamu').val(data.id);
				$('#up_nama_tamu').val(data.nama_tamu);
				$('#up_alamat').val(data.alamat);
				$('#up_telepon').val(data.telepon);
				$('#up_jam_masuk').val(data.jam_masuk);
				$('#up_jam_keluar').val(CurrentDate("mysql") + " " + CurrentTime());	

				$('#MdlSetKeluar').modal('show');			
		} else {
			alert('Error Ajax: Data tidak dapat dibuka. Silahkan coba beberapa saat lagi.');
		}
	});
}

function detailTamu(id_tamu) {	
  var url1 = "bukutamu_ajax_get_tamu/" + id_tamu;    
	$.postJSON(url1, function (data, status) {
		if (status=='success'){			
			let appName = $("#appName").val();
			let mkid = addZeroSpaces(data.mitrakerja_id,"mk",5);
			let blnthn = ubah_tgl_mtmy(data.jam_masuk);

			var id_foto = data.file_foto_dan_ttd;				
			
			let foto_tamu = "uploads/" + appName + "/" + mkid + "/" + blnthn + "/bukutamu/foto/ftm"  + id_foto + ".jpg";
			var foto_id = "uploads/" + appName + "/" + mkid + "/" + blnthn + "/bukutamu/id/fid" + id_foto + ".jpg";
			var img_ttd = "uploads/" + appName + "/" + mkid + "/" + blnthn + "/bukutamu/ttd/ttd" + id_foto + ".png";        

			$('#img_foto_tamu').attr("src", foto_tamu);        
			$('#lbl_nama_tamu').text(data.nama_tamu);
			$('#lbl_instansi').text(data.instansi_pekerjaan);
			$('#lbl_alamat').text(data.alamat);
			$('#lbl_telepon').text(data.telepon);
			$('#lbl_bertemu').text(data.bertemu);
			$('#lbl_keperluan').text(data.keperluan);
			$('#lbl_jam_masuk').text(data.jam_masuk);
			$('#lbl_jam_keluar').text(data.jam_keluar);
			$('#img_foto_id').attr("src",foto_id);
			$('#img_ttd').attr("src",img_ttd);

			$('#MdlDetailTamu').modal('show');
		} else {
			alert('Error Ajax: Data tidak dapat dibuka. Silahkan coba beberapa saat lagi.');
		}
	});
}

$(function () {
	$("#tbl-buku-tamu").DataTable({
		responsive: true,
		autoWidth: false,
	});

	// $("#dt-akses").on('select2:select', function (e) {
	// 	$("#frm-refresh").submit();
	// });

	// $("#sel-periode").on('change', function (e) {		
	// 	$("#frm-refresh").submit();
	// });	
	
});