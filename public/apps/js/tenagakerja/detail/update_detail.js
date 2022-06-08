'use strict';

var tblTenagakerja;

function initObjPageTenagakerjaEditDetail() {
    
}

function previewFoto() {
    console.log("preview image");
    const fotoFile = document.querySelector('#file-foto');
    const fotoPreview = document.querySelector('#foto-preview');

    const fileReader = new FileReader();
    fileReader.readAsDataURL(fotoFile.files[0]);
    
    fileReader.onload = function(e) {
        fotoPreview.src=e.target.result;
    }
}

$(function () {
    initObjPageTenagakerjaEditDetail();
});