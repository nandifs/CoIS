$(function () {
    $("#tbljwlpiket").DataTable({
        paging: false,
        lengthChange: false,
        searching: false,
        ordering: false,
        info: true,
        autoWidth: false,
        responsive: false,
        sScrollX: "110%",
        sScrollXInner: "110%",
        bScrollCollapse: true,
        colReorder: true,
        columnDefs: [
        { targets: 0, width: "50px" },
        { targets: 1, width: "200px" },
        { targets: 2, width: "100px" },
        { targets: 3, width: "100px" },
        ],
    });

    $("#dt-akses").on('select2:select', function (e) {        
        let data_id = e.params.data.id;        
        window.location.href="/jadwalpiket/" + data_id;
    });

    $(".btn-link").click(function () {
        let linkid=$(this).data('id');
        let aksesId = $("#dt-akses").val();
        
        if (linkid==1) {
            window.location.href="/jadwalpiket/" + aksesId;
        }else if (linkid==2) {
            window.location.href="/jadwalpiket_anggota/" + aksesId;
        }else if (linkid==3) {
            window.location.href="/reguanggota/" + aksesId;
        }
    });
});