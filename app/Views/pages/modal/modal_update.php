<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="overlay" id="pop-overlay">
                <i class="fas fa-2x fa-sync fa-spin"></i>
            </div>
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Tambah Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- form start -->
            <?= form_open("", ['id' => 'form-data', 'class' => 'form-horizontal', 'autocomplete' => 'off']); ?>
            <?= csrf_field("token-name"); ?>
            <div class="modal-body">
                <?= view("pages/admin/$page/update"); ?>
            </div>
            <div class="modal-footer justify-content-between bg-primary">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-outline-light btn-submit">Simpan</button>
            </div>
            <?= form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->