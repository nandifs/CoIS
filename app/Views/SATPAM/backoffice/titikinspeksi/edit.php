    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Data Titik Inspeksi</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?= form_open('titikinspeksi_update', ['class' => 'form-horizontal']); ?>
                        <?= csrf_field(); ?>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Unit Kerja</label>
                                <div class="col-sm-9">
                                    <input type="hidden" class="form-control" name="data_id" readonly value="<?= $dtTitikInspeksi['id']; ?>">
                                    <input type="hidden" class="form-control" name="mitrakerja_id" readonly value="<?= $dtTitikInspeksi['mitrakerja_id']; ?>">
                                    <input type="text" class="form-control" name="unit_kerja" placeholder="Unit Mitra Kerja" readonly value="<?= $dtTitikInspeksi['singkatan']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Grup Lokasi</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="grup_lokasi" placeholder="Grup Lokasi Pengawasan" autofocus required value="<?= $dtTitikInspeksi['grup']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Nama Lokasi</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama_lokasi" placeholder="Nama Lokasi Pengawasan" autofocus required value="<?= $dtTitikInspeksi['lokasi']; ?>">
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-default" onclick="window.history.back()">Batal</button>
                            <button type="submit" class="btn btn-primary float-right mr-1">Simpan</button>
                        </div>
                        <!-- /.card-footer -->
                        <?= form_close(); ?>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->