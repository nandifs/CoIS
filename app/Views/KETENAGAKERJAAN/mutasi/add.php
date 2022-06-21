    <?php
    $nip = "";
    ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary mt-2">
                        <div class="card-header">
                            <h3 class="card-title">Mutasi & Rotasi Tenaga Kerja</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?= form_open('/tenagakerja_save_detail', ['class' => 'form-horizontal']); ?>
                        <?= csrf_field(); ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">NIP</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="nip" placeholder="No Induk Tenaga Kerja" value="<?= $nip; ?>" required readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">Nama Tenaga kerja</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="nama" placeholder="Nama Tenaga kerja" autofocus required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">Jabatan</label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" name='jabatan'>
                                                <?php foreach ($dtJabatan as $jabatan) : ?>
                                                    <option value=<?= $jabatan['id']; ?>><?= $jabatan['jabatan']; ?></option>
                                                <?php endforeach;  ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">Unit Kerja</label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" name='unitkerja'>
                                                <?php foreach ($dtUnitKerja as $unitkerja) : ?>
                                                    <option value=<?= $unitkerja['id']; ?>><?= $unitkerja['singkatan']; ?></option>
                                                <?php endforeach;  ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">Penempatan</label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" name='penempatan'>
                                                <?php foreach ($dtMitraKerja as $mitrakerja) : ?>
                                                    <option value=<?= $mitrakerja['id']; ?>><?= $mitrakerja['singkatan']; ?></option>
                                                <?php endforeach;  ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">Wilayah Kerja</label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" name='wilkerja'>
                                                <?php foreach ($dtWilayahKerja as $wilkerja) : ?>
                                                    <option value=<?= $wilkerja['id']; ?>><?= $wilkerja['wilayah']; ?></option>
                                                <?php endforeach;  ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-outline card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">Riwayat Mutasi & Rotasi Pegawai</h3>
                                        </div>
                                        <div class="card-body">
                                            <table id="tbl-riwayat-pekerjaan" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 30px;">No.</th>
                                                        <th>Jabatan</th>
                                                        <th>Unitkerja</th>
                                                        <th>Penempatan</th>
                                                        <th>Sifat</th>
                                                        <th>Tanggal Awal</th>
                                                        <th>Tanggal Akhir</th>
                                                        <th style="text-align: center;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
                        <?= view('templates/notification'); ?>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->