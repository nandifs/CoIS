'use strict';
var editor;

function initObjPageLaporanTemplate() {    

    $("#dt-akses").on('select2:select', function (e) {
        //$("#frm-refresh").submit();
    });   
    //{removePlugins: [ 'Heading', 'Link', 'TextPartLanguage', 'CodeBlock', 'HtmlEmbed' ],}
    ClassicEditor
    .create( document.querySelector( '#editor' ) )
    .then( newEditor => {
        editor = newEditor;
        loadTemplate();
        //console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );

    $("#btn-simpan-template").on('click', function () {
        let id_template = $('#dt-akses').val();        
        let laporan_content = editor.getData();

        let send_data = {template_id:id_template, content:laporan_content}

        $.postJSON('ajax_save_template', send_data, function (data, status) {
            console.log(data);
            if (status=='success'){
                alert("Template berhasil disimpan.")
            } else {
                alert('Error Ajax: Data tidak dapat diambil. Silahkan coba beberapa saat lagi.');
            }
        });
    });       
}

function loadTemplate() {    
    $.postJSON('load_template_by_ajax', function (data, status) {            
        if (data.status=='success'){
            //console.log(data.content)            
            editor.setData(data.content);            
        } else {
            alert('Error Ajax: Data tidak dapat diambil. Silahkan coba beberapa saat lagi.');
        }
    });
}

$(function () {    
    initObjPageLaporanTemplate();    
});