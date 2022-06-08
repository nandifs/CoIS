<div class="modal fade" id="modal-add-petugas">
    <div class="modal-dialog modal-lg">
        <?= form_open('/satpam_bukumutasi_savepetugas', ['class' => 'form-horizontal']); ?>
        <?= csrf_field(); ?>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Petugas Piket</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile form-horizontal">
                        <div class="form-group row">
                            <label for="jenis" class="col-sm-3 col-form-label">Nama Petugas</label>
                            <div class="col-sm-9">

                                <input type="hidden" class="form-control" id="petugas_added" value="<?= $dt_petugas_added; ?>">
                                <input type="hidden" class="form-control" name="buku_mutasi_id" value="<?= (isset($dt_mutasi_aktif)) ? $dt_mutasi_aktif['id'] : "0" ?>">
                                <input type="hidden" class="form-control" name="petugas_id" value="<?= $dtTenagakerja['id']; ?>">
                                <input type="text" class="form-control" value="<?= $dtTenagakerja['nama']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tanggal" class="col-sm-3 col-form-label">Jabatan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?= $dtTenagakerja['jabatan'] ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </div>
        <!-- /.modal-content -->
        <?= form_close(); ?>
    </div>
    <!-- /.modal-dialog -->
</div>