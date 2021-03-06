    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary mt-2">
                        <div class="card-body pb-0">
                            <?= form_open('/tenagakerja_add', ['class' => 'form-horizontal']); ?>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-2 col-form-label">Unit/Area</label>
                                <div class="col-sm-6">
                                    <select class="form-control select2" id="dt-akses" name='dtakses'>
                                        <?php foreach ($dtMitraKerja as $mitra) {
                                            $space = "";
                                            if ($mitra['kelas'] == 2) {
                                                $space = "&nbsp;&nbsp;&nbsp;&nbsp;|&rarr; ";
                                            } else if ($mitra['kelas'] == 3) {
                                                $space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&rarr; ";
                                            }
                                        ?>
                                            <?php if ($selMitraKerja == "") { ?>
                                                <option value=<?= $mitra['id']; ?> <?= ($mitra['id'] == 1) ? "selected" : ""; ?>><?= $space . $mitra['singkatan']; ?></option>
                                            <?php } else { ?>
                                                <option value=<?= $mitra['id']; ?> <?= ($mitra['id'] == $selMitraKerja) ? "selected" : ""; ?>><?= $space . $mitra['singkatan']; ?></option>
                                            <?php } ?>
                                        <?php
                                        }  ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-2 col-form-label">No SPK</label>
                                <div class="col-sm-6">
                                    <select class="form-control select2" name='no_spk'>
                                        <option value=1>0028.PJ/DAN.0102/C35000000/2021</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-2 col-form-label">Jenis Pekerjaan</label>
                                <div class="col-sm-6">
                                    <select class="form-control select2" name='no_spk'>
                                        <option value=1>SEMUA</option>
                                        <option value=1>SATUAN PENGAMANAN</option>
                                        <option value=1>OPHARDUNG</option>
                                    </select>
                                </div>
                            </div>
                            <?= form_close(); ?>
                            <?= view('templates/notification'); ?>
                        </div>
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">DAFTAR BPJS KETENAGAKERJAAN</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tbl-mutasi-pegawai" class="table table-bordered display nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 30px;">No.</th>
                                        <th>NIP</th>
                                        <th>Nama Tenaga Kerja</th>
                                        <th>Wilayah Baru</th>
                                        <th>Unitkerja Baru</th>
                                        <th>Penempatan Baru</th>
                                        <th>Jabatan Baru</th>
                                        <th>Jenis</th>
                                        <th>Sifat</th>
                                        <th>Tanggal Berlaku</th>
                                        <th>Berkas Pendukung</th>
                                        <th style="text-align: center;">Aksi</th>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($dtMutasiTK)) {
                                        $no = 1;
                                        foreach ($dtMutasiTK as $row) {
                                            $data_id = $row['id']; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $row['nip']; ?></td>
                                                <td><?= $row['nama_pegawai']; ?></td>
                                                <td><?= $row['wilayahkerja_baru']; ?></td>
                                                <td><?= $row['unitkerja_baru']; ?></td>
                                                <td><?= $row['penempatan_baru']; ?></td>
                                                <td><?= $row['jabatan_baru']; ?></td>
                                                <td><?= $row['jenis_mutasi']; ?></td>
                                                <td><?= $row['sifat_mutasi']; ?></td>
                                                <td><?= $row['tanggal_berlaku']; ?></td>
                                                <td><?= ($row['berkas'] == "") ? "&nbsp;&nbsp;&nbsp;-" : $row['berkas']; ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-warning btn-sm" title="Edit" data-id="<?= $data_id; ?>" onclick="updateData(this);"><i class="fa fa-edit"></i> Edit</button>
                                                        <button type="button" class="btn btn-danger btn-sm" title="Hapus" data-id="<?= $data_id; ?>" onclick="deleteData(this);"><i class=" fa fa-trash-alt"></i> Hapus</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                            $no++;
                                        }
                                    } else { ?>
                                        <tr>
                                            <td>1.</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->