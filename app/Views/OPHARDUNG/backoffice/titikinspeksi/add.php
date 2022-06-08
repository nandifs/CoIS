<div class="modal fade" id="modal-add-data">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data Lokasi Inspeksi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <?= form_open('titikinspeksi_save', ['class' => 'form-horizontal']); ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="input1" class="col-sm-3 col-form-label">Unit Mitra Kerja</label>
                    <div class="col-sm-9">
                        <select class="form-control" name='penempatan_id'>
                            <?php foreach ($dtMitraKerja as $mitra) : ?>
                                <option value=<?= $mitra['id']; ?> <?= ($mitra['id'] == 1) ? "selected" : ""; ?>><?= $mitra['singkatan']; ?></option>
                            <?php endforeach;  ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input1" class="col-sm-3 col-form-label">Grup Lokasi</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="grup_lokasi" placeholder="Grup Lokasi Pengawasan" autofocus required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input1" class="col-sm-3 col-form-label">Nama Lokasi</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama_lokasi" placeholder="Nama Lokasi Pengawasan" autofocus required>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            <?= form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->