    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary mt-2">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Data Tenagakerja</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?= form_open('/tenagakerja_save', ['class' => 'form-horizontal']); ?>
                        <?= csrf_field(); ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">NIP</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="nip" placeholder="No Induk Tenagakerja" autofocus required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">Nama Tenagakerja</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="nama" placeholder="Nama Tenagakerja" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">Jabatan</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name='jabatan'>
                                                <?php foreach ($dtJabatan as $jabatan) : ?>
                                                    <option value=<?= $jabatan['id']; ?>><?= $jabatan['jabatan']; ?></option>
                                                <?php endforeach;  ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">Unit Kerja</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name='unitkerja'>
                                                <?php foreach ($dtUnitKerja as $unitkerja) : ?>
                                                    <option value=<?= $unitkerja['id']; ?>><?= $unitkerja['singkatan']; ?></option>
                                                <?php endforeach;  ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">Penempatan</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name='penempatan'>
                                                <?php foreach ($dtMitraKerja as $mitrakerja) : ?>
                                                    <option value=<?= $mitrakerja['id']; ?>><?= $mitrakerja['singkatan']; ?></option>
                                                <?php endforeach;  ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="card card-outline card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">User Tenagakerja</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">Email</label>
                                                <div class="col-sm-9">
                                                    <input type="email" class="form-control" name="email" placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">Otoritas</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name='otoritas'>
                                                        <option value=3>Kordinator</option>
                                                        <option value=4 selected>Tenagakerja</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">Password</label>
                                                <div class="col-sm-9">
                                                    <input type="password" class="form-control" name="upass" placeholder="Password otomatis sesuai NIP" readonly>
                                                </div>
                                            </div>
                                        </div>
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
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->