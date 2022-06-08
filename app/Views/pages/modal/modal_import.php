<div class="modal fade" id="modal-import">
    <div class="modal-dialog modal-default">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Import Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- form start -->
            <?= form_open_multipart("/$pages/import_data", ['id' => 'form-import', 'class' => 'form-horizontal', 'autocomplete' => 'off']); ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <?php echo view("APD/admin/$pages/import"); ?>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Import !</button>
            </div>
            <?= form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->