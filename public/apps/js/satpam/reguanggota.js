"use strict";
var dt_tenagakerja;
function getDtTenagakerja(idTenagakerja) {
  /**
   * Gunakan AJAX jika data tenagakerja lebih dari 20
   */
  // $.postJSON('ajax_get_tenagakerja/' + idTenagakerja,function (data, status) {
  //     console.log(data);
  //     if (status=='success'){
  //         $('#jabatan').val(data.jabatan);
  //         $('#unit_kerja').val(data.penempatan);
  //     } else {
  //         alert('Error Ajax: Data tidak dapat diambil. Silahkan coba beberapa saat lagi.');
  //     }
  // });

  /**
   * Jika data tenagakerja < dari 20 gunakan array
   */
  let data = $.grep(dt_tenagakerja, function (e) {
    return e.id === idTenagakerja;
  });
  console.log(data);
  if (data.length === 1) {
    $("#jabatan").val(data[0].jabatan);
    $("#unit_kerja").val(data[0].penempatan);
    $("#penempatan_id").val(data[0].penempatan_id);
  } else {
    $("#jabatan").val("");
    $("#unit_kerja").val("");
    $("#penempatan_id").val("");
  }
}

function loadEvent() {
  dt_tenagakerja = $.parseJSON($("#dtpetugas-js").val());

  $("#petugas_id").on("change", function () {
    getDtTenagakerja(this.value);
  });
}

$(function () {
  loadEvent();
});
