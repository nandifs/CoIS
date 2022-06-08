<div class="modal fade" id="MdlDetailKegiatan">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card card-success card-outline">
                    <div class="card-body box-profile form-horizontal">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Foto Inspeksi</label>
                                <div class="profile-user-img img-foto img-rounded img-fluid img-responsive">
                                    <img class="stretch" id="img_foto" src="<?php echo base_url(); ?>/uploads/noimage.png" alt="Foto Inspeksi">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jenis" class="col-sm-3 col-form-label">Inspeksi</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="jenis" name="jenis" value="Rutin" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tanggal" class="col-sm-3 col-form-label">Waktu Inspeksi</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal Inspeksi" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="titik" class="col-sm-3 col-form-label">Titik Kontrol</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="titik" name="titik" placeholder="Lokasi Inspeksi" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kondisi" class="col-sm-3 col-form-label">Kondisi</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="kondisi" name="kondisi" placeholder="Kondisi" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kondisi" class="col-sm-3 col-form-label">Keterangan Lain</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Keterangan lain" readonly></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="unitkerja" class="col-sm-3 col-form-label">Unit Kerja</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="unitkerja" name="unitkerja" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="petugas" class="col-sm-3 col-form-label">Petugas</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="petugas" name="petugas" readonly>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>