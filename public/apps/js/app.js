'use strict';

$(function () {   
    //Initialize Table Elements
    if (isObjExist("def-table-1")){
        $("#def-table-1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    }

    if (isObjExist("def-table-2")){
        $("#def-table-2").DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    }

    if (isObjExist("example1")){
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    }

    //Initialize Select2 Elements
    if (isObjExistByClassName("select2")){
        $('.select2').select2()
    }

    //Initialize Input File Elements
    if (isObjExistByClassName("custom-file-input")){
        bsCustomFileInput.init();
    }    
});
