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

    $(".btn-link").click(function () {
        let linkid=$(this).data('id');
        let aksesId = $("#dt-akses").val();
        
        if (linkid==1) {
            window.location.href="/satpam_jadwalpiket_petugas/" + aksesId;
        }else if (linkid==2) {
            window.location.href="/satpam_jadwalpiket_anggota/" + aksesId;
        }
    });
});