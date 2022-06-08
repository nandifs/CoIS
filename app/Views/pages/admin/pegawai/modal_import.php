<div class="modal fade" id="modal-import">
    <div class="modal-dialog">
        <div class="modal-content">
            <?= form_open_multipart('/pegawai/import_data'); ?>
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title">Import Data Pegawai</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="exampleInputFile" id="label-file">File Excel</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file_imp" name="imp_file">
                            <label class="custom-file-label" for="exampleInputFile">Pilih file excel yang akan di import</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-info">Import !</button>
            </div>
            <?= form_close(); ?>
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->