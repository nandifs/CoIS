'use strict';

function initObjPagePresensi() {
    		
	$("#tabel-presensi").DataTable({
		
        "searching": false,
        
        "responsive": true,
		"autoWidth": false,
	});
}

$(function () {    
    initObjPagePresensi();    
});