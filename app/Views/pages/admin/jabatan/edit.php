    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mt-2">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Data Jabatan</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?= form_open('jabatan_update/' . $dt_jabatan['id'], ['class' => 'form-horizontal']); ?>
                        <?= csrf_field(); ?>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="input1" class="col-sm-2 col-form-label">Jabatan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama" placeholder="Nama Jabatan" autofocus value="<?= $dt_jabatan['jabatan']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-2 col-form-label">Nama Singkat</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="singkatan" placeholder="Singkatan Jabatan" value="<?= $dt_jabatan['singkatan']; ?>" required>
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