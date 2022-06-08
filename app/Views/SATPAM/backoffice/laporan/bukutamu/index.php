    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6 mt-2">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $jmlTamu; ?></h3>
                            <p>Tamu Hari Ini</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-people"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6 mt-2">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $jmlTamuKeluar; ?></h3>
                            <p>Tamu Keluar</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-people"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6 mt-2">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $jmlTamuDidalam; ?></h3>
                            <p>Tamu Didalam</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6 mt-2">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>0</h3>
                            <p>Agenda Hari Ini</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-bookmarks"></i>
                        </div>
                        <a href="#" class="small-box-footer">Info Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-success">
                        <div class="card-body pb-0">
                            <?= form_open_multipart('/bukutamu', ['id' => 'frm-refresh', 'class' => 'form-horizontal']); ?>
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
                            <h3 class="card-title">DAFTAR <?= strtoupper($title); ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="example1" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Nama Tamu</th>
                                                <th>Alamat</th>
                                                <th>Pekerjaan/Instansi</th>
                                                <th>Jam Masuk</th>
                                                <th>Jam Keluar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            if (isset($dtTamu)) {
                                                foreach ($dtTamu as $row) {
                                                    $rowId = $row['id'];
                                                    $expTglMasuk = explode(' ', $row['jam_masuk']);
                                                    $expTglKeluar = explode(' ', $row['jam_keluar']);
                                            ?>
                                                    <tr>
                                                        <td><?php echo $no; ?>.</td>
                                                        <td><?php echo $row['tanggal']; ?></td>
                                                        <td><?php echo $row['nama_tamu']; ?></td>
                                                        <td><?php echo $row['alamat']; ?></td>
                                                        <td><?php echo $row['instansi_pekerjaan']; ?></td>
                                                        <td><?= ($expTglMasuk[1] != "00:00:00") ? $expTglMasuk[1] : ""; ?></td>
                                                        <td><?= ($expTglKeluar[1] != "00:00:00") ? $expTglKeluar[1] : ""; ?></td>

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
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.section -->
    <?php
    include 'mdldetail.php';
    ?>