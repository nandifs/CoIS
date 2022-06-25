    <?php
    //dd($dtTenagakerja);
    if (is_array($dtTenagakerja)) {
        $pegawai_id = $dtTenagakerja['id'];
        $nip = $dtTenagakerja['nip'];
        $nama = $dtTenagakerja['nama'];

        $jabatan_id = $dtTenagakerja['jabatan_id'];
        $unitkerja_id = $dtTenagakerja['unitkerja_id'];
        $penempatan_id = $dtTenagakerja['penempatan_id'];
        $wilayahkerja_id = $dtTenagakerja['wilayah_id'];

        $jabatan = $dtTenagakerja['jabatan'];
        $unitkerja = $dtTenagakerja['unitkerja'];
        $penempatan = $dtTenagakerja['penempatan'];
        $wilayahkerja = $dtTenagakerja['wilayahkerja'];
    } else {
        $nip = old("nip");
        $pegawai_id = "";
        $nama = "";

        $jabatan_id = "";
        $unitkerja_id = "";
        $penempatan_id = "";
        $wilayahkerja_id = "";

        $jabatan = "";
        $unitkerja = "";
        $penempatan = "";
        $wilayahkerja = "";
    }


    ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary mt-2">
                        <div class="card-header">
                            <h3 class="card-title">MUTASI & ROTASI TENAGA KERJA</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <!-- form start -->
                                    <?= form_open('/ketenagakerjaan_mutasi', ['class' => 'form-horizontal']); ?>
                                    <?= csrf_field(); ?>
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">NIP</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="nip" name="nip" placeholder="No Induk Tenaga Kerja" autofocus required value="<?= $nip; ?>">
                                                <span class="input-group-append">
                                                    <button type="submit" class="btn btn-info btn-update" data-id="cari" title="Cari data tenagakerja"><i class="fas fa-search"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <?= view('templates/notification'); ?>
                                    <?= form_close(); ?>

                                    <?= form_open_multipart('/ketenagakerjaan_mutasi_save', ['class' => 'form-horizontal']); ?>
                                    <?= csrf_field(); ?>
                                    <input type="hidden" class="form-control" name="pegawai_id" required value="<?= $pegawai_id; ?>">
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">Nama Tenaga kerja</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Nama Tenaga kerja" value="<?= $nama; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">Jabatan</label>
                                        <div class="col-sm-9">
                                            <input type="hidden" class="form-control" name="jabatan_id" value="<?= $jabatan_id; ?>">
                                            <input type="text" class="form-control" placeholder="Jabatan saat ini" value="<?= $jabatan; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">Penempatan</label>
                                        <div class="col-sm-9">
                                            <input type="hidden" class="form-control" name="penempatan_id" value="<?= $penempatan_id; ?>">
                                            <input type="text" class="form-control" placeholder="Penempatan saat ini" value="<?= $penempatan; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">Wilayah Kerja</label>
                                        <div class="col-sm-9">
                                            <input type="hidden" class="form-control" name="wilayahkerja_id" value="<?= $wilayahkerja_id; ?>">
                                            <input type="text" class="form-control" placeholder="Wilayah kerja saat ini" value="<?= $wilayahkerja; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-outline card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">Tujuan Mutasi & Rotasi</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div class="form-group row">
                                                        <label for="input1" class="col-sm-3 col-form-label">Jenis Mutasi</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control" name='jenis_mutasi'>
                                                                <option value="0" selected></option>
                                                                <option value="1">Rotasi Penempatan Kerja</option>
                                                                <option value="2">Rotasi Jabatan</option>
                                                                <option value="3">Rotasi Jabatan & Penempatan Kerja</option>
                                                                <option value="4">Sanksi</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="input1" class="col-sm-3 col-form-label">Sifat Mutasi</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control" name='sifat_mutasi'>
                                                                <option value="0" selected></option>
                                                                <option value="1">Tetap</option>
                                                                <option value="2">Sementara</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="input1" class="col-sm-3 col-form-label">Wilayah Kerja Baru</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control select2" name='wilkerja_baru'>
                                                                <option value="0" selected></option>
                                                                <?php foreach ($dtWilayahKerja as $rwilkerja) : ?>
                                                                    <option value=<?= $rwilkerja['id']; ?>><?= $rwilkerja['wilayah']; ?></option>
                                                                <?php endforeach;  ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="input1" class="col-sm-3 col-form-label">Unit Kerja Baru</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control select2" name='unitkerja_baru'>
                                                                <option value="0" selected></option>
                                                                <?php foreach ($dtUnitKerja as $runitkerja) : ?>
                                                                    <option value=<?= $runitkerja['id']; ?>><?= $runitkerja['singkatan']; ?></option>
                                                                <?php endforeach;  ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="input1" class="col-sm-3 col-form-label">Penempatan Baru</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control select2" name='penempatan_baru'>
                                                                <option value="0" selected></option>
                                                                <?php foreach ($dtMitraKerja as $rmitrakerja) : ?>
                                                                    <option value=<?= $rmitrakerja['id']; ?>><?= $rmitrakerja['singkatan']; ?></option>
                                                                <?php endforeach;  ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="input1" class="col-sm-3 col-form-label">Jabatan Baru</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control select2" name='jabatan_baru'>
                                                                <option value="0" selected></option>
                                                                <?php foreach ($dtJabatan as $rjabatan) : ?>
                                                                    <option value=<?= $rjabatan['id']; ?>><?= $rjabatan['jabatan']; ?></option>
                                                                <?php endforeach;  ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="input1" class="col-sm-3 col-form-label">Keterangan Mutasi</label>
                                                        <div class="col-sm-9">
                                                            <textarea class="form-control" rows="3" name="ket_mutasi" placeholder="Keterangan Mutasi" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="input1" class="col-sm-3 col-form-label">Tanggal Berlaku</label>
                                                        <div class="col-sm-9">
                                                            <div class="input-group date" id="tgl-berlaku" data-target-input="nearest">
                                                                <input type="text" class="form-control datetimepicker-input" data-target="#tgl-berlaku" name="tgl_berlaku" required />
                                                                <div class="input-group-append" data-target="#tgl-berlaku" data-toggle="datetimepicker">
                                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="input1" class="col-sm-3 col-form-label">Berkas Pendukung</label>
                                                        <div class="col-sm-9">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="exampleInputFile" name="file_berkas">
                                                                <label class="custom-file-label" for="exampleInputFile">Klik disini untuk memilih file yang akan di import</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-default" onclick="window.history.back()">Batal</button>
                                            <button type="submit" class="btn btn-primary float-right mr-1">Simpan</button>
                                        </div>
                                        <!-- /.card-footer -->
                                        <?= form_close(); ?>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row Form Tujuan Mutasi-->
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
                                                        <th>Wilayah</th>
                                                        <th>Unitkerja</th>
                                                        <th>Penempatan</th>
                                                        <th>Jabatan</th>
                                                        <th>Jenis</th>
                                                        <th>Sifat</th>
                                                        <th>Tanggal Berlaku</th>
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
                            <!-- /.row tabel riwayat-->
                        </div>
                        <!-- /.card-body utama-->
                    </div>
                    <!-- /.card utama-->
                </div>
                <!-- /.col utama-->
            </div>
            <!-- /.row utama-->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->