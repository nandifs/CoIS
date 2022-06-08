<div class="modal fade" id="modal-add-inventaris">
    <div class="modal-dialog modal-lg">
        <?= form_open('/ophardung_inventori_save', ['class' => 'form-horizontal']); ?>
        <?= csrf_field(); ?>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Inventaris</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile form-horizontal">
                        <div class="form-group row">
                            <label for="jenis" class="col-sm-3 col-form-label">Alat/Material</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="inv_produk" name='inv_produk' style="width: 100%;">
                                    <?php
                                    if (isset($dtAlatMaterial)) {
                                        foreach ($dtAlatMaterial as $produk) :
                                            echo "<option value='" . $produk['id'] . "'>" . $produk['produk'] . "</option>";
                                        endforeach;
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tanggal" class="col-sm-3 col-form-label">Jumlah</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="inv_jumlah" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kondisi" class="col-sm-3 col-form-label">Kondisi</label>
                            <div class="col-sm-9">
                                <select class="form-control" name='inv_kondisi'>
                                    <option selected>BAIK</option>
                                    <option>RUSAK</option>
                                    <option>HILANG</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="inv_keterangan" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
        <!-- /.modal-content -->
        <?= form_close(); ?>
    </div>
    <!-- /.modal-dialog -->
</div>