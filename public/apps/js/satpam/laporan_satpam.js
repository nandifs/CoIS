'use strict';
var editor;

function initObjPageLaporanSatpam() {    

    $("#dt-akses").on('select2:select', function (e) {
        //$("#frm-refresh").submit();
    });   
    
    DecoupledDocumentEditor
        .create( document.querySelector( '.document-editor__editable' ) )
        .then( newEditor => {
            const toolbarContainer = document.querySelector( '.document-editor__toolbar' );

            toolbarContainer.appendChild( newEditor.ui.view.toolbar.element );
            
            editor = newEditor;

            loadLaporan();
            //console.log( Array.from( editor.ui.componentFactory.names() ) );
        } )
        .catch( err => {
            console.error( err );
        } );    

    $("#btn-simpan-laporan").on('click', function () {
        let id_mitrakerja = $('#dt-akses').val();
        let laporan_periode = $('#periode').val();
        let laporan_content = editor.getData();

        let send_data = {mitrakerja_id:id_mitrakerja, periode:laporan_periode, content:laporan_content}

        $.postJSON('ajax_save_laporan', send_data, function (data, status) {
            console.log(data);
            if (status=='success'){
                alert("Laporan berhasil disimpan.")
            } else {
                alert('Error Ajax: Data tidak dapat diambil. Silahkan coba beberapa saat lagi.');
            }
        });
    });   

    $("#btn-exp-words").on('click', function () {
        let laporan = editor.getData();
        console.log(editor.text());
        // let send_data = {mitrakerja_id:id_mitrakerja, content:laporan}

        // $.postJSON('export_to_word', function (data, status) {
        //     console.log(data)
        //     if (status=='success'){                
        //         console.log(data)
        //     } else {
        //         alert('Error Ajax: Data tidak dapat diambil. Silahkan coba beberapa saat lagi.');
        //     }
        // });
    });   

    $("#btn-exp-pdf").on('click', function () {
        $.postJSON('export_to_pdf', function (data, status) {
            console.log(data)
            if (status=='success'){                
                console.log(data)
            } else {
                alert('Error Ajax: Data tidak dapat diambil. Silahkan coba beberapa saat lagi.');
            }
        });
    }); 

    $("#btn-print-doc").on('click', function () {
        editor.execute('print');
    });
}

function loadLaporan(){
    let id_mitrakerja = $('#dt-akses').val();
    let laporan_periode = $('#periode').val();
    
    let send_data = {mitrakerja_id:id_mitrakerja, periode:laporan_periode}
    $.postJSON('/ajax_load_laporan_satpam', send_data, function (data, status) {                    
        if (data.status == 'success'){            
            editor.setData(data.content);
        }else if (data.status == 'tidak ditemukan'){
            loadTemplate();            
        }else {
            alert('Error Ajax: Data tidak dapat diambil. Silahkan coba beberapa saat lagi.');
        }
    });
}

function loadTemplate() {    
    $.postJSON('load_template_laporan_satpam_by_ajax', function (data, status) {            
        if (data.status=='success'){
            //console.log(data.content)
            let edTemp = data.content;
                        
            edTemp = edTemp.replaceAll('unit_kerja',"PT. MANDIRI INSAN USAHA");
            edTemp = edTemp.replaceAll('mitra_kerja',"PT. PLN (PERSERO) CABANG KALIMANTAN");
            
            edTemp = edTemp.replaceAll('nomor_laporan',"001/BTM/XI/2021");
            edTemp = edTemp.replaceAll('tanggal_pembuatan',"02 April 2021");
            edTemp = edTemp.replaceAll('lokasi_pembuatan',"Kalimantan");

            edTemp = edTemp.replaceAll('departement',"Operation Security");
            
            edTemp = edTemp.replaceAll('no_kontrak',"004.PJ/DAN.01.06/UPBSBT/2018");
            edTemp = edTemp.replaceAll('unit_penempatan',"PT. PLN (PERSERO) UP ASAM ASAM");
            edTemp = edTemp.replaceAll('jml_personil',"9");

            edTemp = edTemp.replaceAll('laporan_bulan',"MARET 2021");
            edTemp = edTemp.replaceAll('laporan_periode',"01 s.d 31 MARET 2021");
            edTemp = edTemp.replaceAll('laporan_bln_lalu',"PEBRUARI 2021");
            edTemp = edTemp.replaceAll('laporan_bln_kedepan',"APRIL 2021");
                        
            
            editor.setData(edTemp);            
        } else {
            alert('Error Ajax: Data tidak dapat diambil. Silahkan coba beberapa saat lagi.');
        }
    });
}

$(function () {    
    initObjPageLaporanSatpam();    
});