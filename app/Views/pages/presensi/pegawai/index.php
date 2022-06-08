<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?= strtoupper($title); ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-success">
                        <div class="card-body">
                            <?php
                            if (is_null($dtPresensiAktif)) {
                                echo "<a href='presensi_add' class='btn btn-primary mt-1'><i class='fas fa-calendar-check'></i> Isi Presensi</a>";
                            } else {
                                echo "<a href='presensi_out/" . $dtPresensiAktif['id'] . "' class='btn btn-danger mt-1'><i class='fas fa-door-closed'></i> Abensi Pulang</a>";

                                echo "<a href='/' class='btn btn-primary mt-1 float-right'><i class='fas fa-arrow-left'></i> Kembali</a>";
                            }
                            ?>

                            <a href="presensi/cetak_presensi" class="btn btn-primary mt-1 d-none"><i class="fa fa-print"></i> Cetak Presensi</a>

                            <a href="presensi/kalendar" class="btn btn-primary mt-1 d-none"><i class="fas fa-calendar-alt"></i> Kalender Kerja</a>
                            <?= view('templates/notification'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $dtKehadiran['persentaseKehadiran']; ?><sup style="font-size: 20px">%</sup></h3>
                            <p>Kehadiran</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $dtKehadiran['jmlHadir']; ?><sup style="font-size: 20px"> Hari</sup></h3>
                            <p>Hadir</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-calendar"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $dtKehadiran['jmlTidakHadir']; ?><sup style="font-size: 20px"> Hari</sup></h3>
                            <p>Izin Sakit/Tidak Hadir/Cuti</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-checkbox"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= $dtKehadiran['jmlTanpaKeterangan']; ?><sup style="font-size: 20px"> Hari</sup></h3>
                            <p>Tanpa Keterangan</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-close-circled"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">DAFTAR KEHADIRAN</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive table-sm">
                                <table id="tabel-presensi" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Aksi</th>
                                            <th>Tanggal</th>
                                            <th>Presensi</th>
                                            <th>Masuk</th>
                                            <th>Pulang</th>
                                            <th>Lama Bekerja</th>
                                            <th>Keterangan</th>
                                            <th>Approval</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        if (isset($dtPresensi)) {
                                            foreach ($dtPresensi as $row) {
                                                $rowId = $row['id'];
                                                $jenis = $row['jenis'];
                                                $explTgl1 = explode(' ', $row['tanggal_1']);
                                                $explTgl2 = explode(' ', $row['tanggal_2']);
                                                $ttlJam = "";
                                                if (substr($explTgl2[0], -2) != "00") {
                                                    $ttlJam = hitung_total_jam_to_string($row['tanggal_1'], $row['tanggal_2']);
                                                }
                                        ?>
                                                <tr>
                                                    <td><?= $no; ?>.</td>
                                                    <td>
                                                        <a href="presensi_pegawai_detail/<?= $rowId; ?>" data-toggle="tooltip" data-placement="top" title="Detail">
                                                            <button type="button" class="btn btn-success btn-xs"><i class="fas fa-info-circle"></i> Detail</button>
                                                        </a>
                                                    </td>
                                                    <td><?= $explTgl1[0]; ?></td>
                                                    <td><?= ($jenis == 1) ?  $row['presensi'] : "<span style='color:red;'>" . $row['presensi'] . "</span>"; ?></td>
                                                    <td><?= ($jenis == 1) ?  $row['tanggal_1'] : ""; ?></td>
                                                    <td><?= ($ttlJam == "") ? "" : $row['tanggal_2']; ?></td>
                                                    <td><?= $ttlJam; ?></td>
                                                    <td><?= $row['keterangan_1']; ?></td>
                                                    <td></td>
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
</div>