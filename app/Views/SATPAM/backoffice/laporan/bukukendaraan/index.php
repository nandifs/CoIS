    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <hr>
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $dtRekapKendaraan['jmldidalam']; ?><sup style="font-size: 20px"> Kendaraan</sup></h3>
                            <p>Kendaraan Masuk</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-model-s"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-md-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $dtRekapKendaraan['jmldidalam']; ?><sup style="font-size: 20px"> Kendaraan</sup></h3>
                            <p>Kendaraan Keluar</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-model-s"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-md-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $dtRekapKendaraan['jmldidalam']; ?><sup style="font-size: 20px"> Roda 2</sup></h3>
                            <p>Roda 2 Didalam</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-bicycle"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6md-">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= $dtRekapKendaraan['jmldidalam']; ?><sup style="font-size: 20px"> Roda 4/Lebih</sup></h3>
                            <p>Roda 4 Didalam</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-model-s"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-success">
                        <div class="card-body pb-0">
                            <?= form_open_multipart('/bukukendaraan', ['id' => 'frm-refresh', 'class' => 'form-horizontal']); ?>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-2 col-form-label">Data Mitra Kerja</label>
                                <div class="col-sm-6">
                                    <?= csrf_field(); ?>
                                    <select class="form-control select2" id="dt-akses" name='dtakses' style="width: 100%;">
                                        <?php
                                        if (isset($selDtAkses)) {
                                            foreach ($dtMitraKerja as $mitra) :
                                                $space = "";
                                                if ($mitra['kelas'] == 2) {
                                                    $space = "&nbsp;&nbsp;&nbsp;&nbsp;|&rarr; ";
                                                } else if ($mitra['kelas'] == 3) {
                                                    $space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&rarr; ";
                                                } ?>
                                                <option value=<?= $mitra['id']; ?> <?= ($mitra['id'] == $selDtAkses) ? "selected" : ""; ?>><?= $space . $mitra['singkatan']; ?></option>
                                        <?php endforeach;
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <select class="form-control" id="sel-periode" name='sel_periode'>
                                        <option value="Hari Ini" <?= ($selPeriode == "Hari Ini") ? "selected" : ""; ?>>Hari Ini</option>
                                        <option value="Bulan Ini" <?= ($selPeriode == "Bulan Ini") ? "selected" : ""; ?>>Bulan Ini</option>
                                        <option value="Bulan Lalu" <?= ($selPeriode == "Bulan Lalu") ? "selected" : ""; ?>>Bulan Lalu</option>
                                    </select>
                                    <input type="hidden" id="periode-tanggal">
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-primary" id="btn-tampilkan"><i class="fas fa-th-list"></i> Tampilkan</button>
                                </div>
                            </div>
                            <?= form_close(); ?>
                            <?= view('templates/notification'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">DAFTAR KELUAR MASUK KENDARAAN</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive table-sm">
                                <table class="table table-bordered" id="example1">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Status</th>
                                            <th>No Polisi</th>
                                            <th>Pemilik</th>
                                            <th>Jenis</th>
                                            <th>Waktu Masuk</th>
                                            <th>Keterangan Masuk</th>
                                            <th>Petugas</th>
                                            <th>Waktu Keluar</th>
                                            <th>Keterangan Keluar</th>
                                            <th>Petugas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        if (isset($dtKendaraan)) {
                                            foreach ($dtKendaraan as $row) {
                                                $rowId = $row['id'];
                                                $jenis = ($row['jns_kendaraan'] == 1) ? "Roda 2" : "Roda 4 / Lebih";
                                                $explTgl1 = explode(' ', $row['jam_masuk']);
                                                $explTgl2 = explode(' ', $row['jam_keluar']);

                                                if ($row['status'] == 1) {
                                                    //Jika status = Didalam
                                                    $status = "<span class='text-danger'>Didalam</span>";
                                                    $btnKeluar = "<a href='satpam_kendaraan_keluar/$rowId' class='btn btn-danger btn-sm' data-toggle='tooltip' data-placement='top' title='Keluar'><i class='fa fa-door-open'></i></a>";
                                                } else {
                                                    $status = "<span class='text-success'>Keluar</span>";
                                                    $btnKeluar = "-";
                                                }
                                        ?>
                                                <tr>
                                                    <td><?= $no; ?>.</td>
                                                    <td><?= $status; ?></td>
                                                    <td><?= $row['no_polisi']; ?></td>
                                                    <td><?= $row['pemilik']; ?></td>
                                                    <td><?= $jenis; ?></td>
                                                    <td><?= $row['jam_masuk']; ?></td>
                                                    <td><?= $row['ket_masuk']; ?></td>
                                                    <td><?= $row['petugas_masuk']; ?></td>
                                                    <td><?= $row['jam_keluar']; ?></td>
                                                    <td><?= $row['ket_keluar']; ?></td>
                                                    <td><?= $row['petugas_keluar']; ?></td>
                                                </tr>
                                        <?php
                                                $no++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->