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
                            <table id="tbl-tenagakerja" class="table table-bordered display nowrap">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="width: 30px;">NO</th>
                                        <th rowspan="2" style="text-align: center;">Aksi</th>
                                        <th rowspan="2">STATUS</th>
                                        <th rowspan="2">NIP</th>
                                        <th rowspan="2">NAMA</th>
                                        <th rowspan="2">JABATAN</th>
                                        <th rowspan="2">WILAYAH</th>

                                        <th rowspan="2">NOMOR PESERTA</th>
                                        <th rowspan="2">UPAH/UMK</th>
                                        <th rowspan="2">Iuran JKK</th>
                                        <th rowspan="2">Iuran JKM</th>
                                        <th colspan="2" class="text-center">Iuran JHT</th>
                                        <th colspan="2" class="text-center">Iuran JP</th>
                                        <th rowspan="2">TOTAL IURAN</th>
                                        <th colspan="2" class="text-center">Ditanggung</th>

                                        <th rowspan="2">KETERANGAN</th>
                                        <th rowspan="2" style="text-align: center;">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th>Perusahaan</th>
                                        <th>Tenaga Kerja</th>
                                        <th>Perusahaan</th>
                                        <th>Tenaga Kerja</th>
                                        <th>Perusahaan</th>
                                        <th>Tenagakerja</th>
                                    </tr>
                                </thead>
                                <tbody>

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