    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-outline card-primary mt-2">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Data Pengguna</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?= form_open('/user_save', ['class' => 'form-horizontal']); ?>
                        <?= csrf_field(); ?>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">User Aplikasi</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='aplikasi'>
                                        <option value=0>** PILIH APLIKASI **</option>
                                        <?php foreach ($dtAplikasi as $aplikasi) : ?>
                                            <option value=<?= $aplikasi['id']; ?> <?= ($aplikasi['id'] == 1) ? "selected" : ""; ?>><?= $aplikasi['nama']; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Nama Akun</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control <?= ($validation->hasError('uid') ? 'is-invalid' : ''); ?>" name="uid" placeholder="Id User/Nama Akun" value="<?= old('uid'); ?>" autofocus>
                                    <div class="invalid-feedback"><?= $validation->getError('uid'); ?></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Nama User</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control <?= ($validation->hasError('uname') ? 'is-invalid' : ''); ?>" name="uname" placeholder="Nama User" value="<?= old('uname'); ?>">
                                    <div class="invalid-feedback"><?= $validation->getError('uname'); ?></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="uemail" placeholder="Email" value="<?= old('uemail'); ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Otoritas</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='otoritas'>
                                        <?php foreach ($dtOtoritas as $otoritas) : ?>
                                            <option value=<?= $otoritas['id']; ?> <?= ($otoritas['id'] == 1) ? "selected" : ""; ?>><?= $otoritas['otorisasi']; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Unit Kerja</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='unitkerja'>
                                        <option value=0>** PILIH UNIT KERJA **</option>
                                        <?php foreach ($dtUnitkerja as $unitkerja) : ?>
                                            <option value=<?= $unitkerja['id']; ?> <?= ($unitkerja['id'] == 1) ? "selected" : ""; ?>><?= $unitkerja['unitkerja']; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Akses Data Unitkerja</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='dtaksesunit'>
                                        <option value=9999>** FULL ACCESS **</option>
                                        <?php foreach ($dtUnitkerja as $unitkerja) : ?>
                                            <option value=<?= $unitkerja['id']; ?> <?= ($unitkerja['id'] == 1) ? "selected" : ""; ?>><?= $unitkerja['unitkerja']; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Akses Data Mitrakerja</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='dtaksesmitrakerja'>
                                        <option value=9999>** FULL ACCESS **</option>
                                        <?php foreach ($dtMitrakerja as $mitra) : ?>
                                            <option value=<?= $mitra['id']; ?> <?= ($mitra['id'] == 1) ? "selected" : ""; ?>><?= $mitra['mitrakerja']; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" name="upassword" placeholder="Password akan terset otomatis sesuai Id User" readonly>
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