    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-outline card-primary mt-2">
                        <div class="card-header">
                            <h3 class="card-title">Edit Data User</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?= form_open('user_update/' . $dtUser['id'], ['class' => 'form-horizontal', 'autocomplete' => 'off']); ?>
                        <?= csrf_field(); ?>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">User Aplikasi</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='aplikasi'>
                                        <option value=0>** PILIH APLIKASI **</option>
                                        <?php foreach ($dtAplikasi as $aplikasi) : ?>
                                            <option value=<?= $aplikasi['id']; ?> <?= ($aplikasi['id'] == $dtUser['apps_id']) ? "selected" : ""; ?>><?= $aplikasi['nama']; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Nama Akun</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="uid" placeholder="Id Akun" autofocus required value="<?= $dtUser['uid']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Nama User</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="uname" placeholder="Nama User" required value="<?= $dtUser['uname']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="uemail" placeholder="Email" required value="<?= $dtUser['email']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Otoritas</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='otoritas'>
                                        <?php foreach ($dtOtoritas as $otoritas) : ?>
                                            <option value=<?= $otoritas['id']; ?> <?= ($otoritas['id'] == $dtUser['otoritas_id']) ? "selected" : ""; ?>><?= $otoritas['otorisasi']; ?></option>
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
                                            <option value=<?= $unitkerja['id']; ?> <?= ($unitkerja['id'] == $dtUser['unitkerja_id']) ? "selected" : ""; ?>><?= $unitkerja['unitkerja']; ?></option>
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
                                            <option value=<?= $unitkerja['id']; ?> <?= ($unitkerja['id'] == $dtUser['data_unit_id']) ? "selected" : ""; ?>><?= $unitkerja['unitkerja']; ?></option>
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
                                            <option value=<?= $mitra['id']; ?> <?= ($mitra['id'] == $dtUser['data_akses_id']) ? "selected" : ""; ?>><?= $mitra['mitrakerja']; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-7">
                                    <input type="password" class="form-control" id="password" name="upassword" placeholder="Click tombol Reset untuk meriset password" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-warning" onclick="resetPassword()" title="Reset Password">Reset</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='status'>
                                        <option value="1" <?= ($dtUser['status_id'] == 1) ? "selected" : ""; ?>>AKTIF</option>
                                        <option value="2" <?= ($dtUser['status_id'] == 2) ? "selected" : ""; ?>>TIDAK AKTIF</option>
                                        <option value="3" <?= ($dtUser['status_id'] == 3) ? "selected" : ""; ?>>BANNED (DILARANG LOGIN)</option>
                                    </select>
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


    <script>
        function resetPassword() {
            $("#password").val("#reset");
        }
    </script>