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
                            echo "<a href='/satpam_kendaraan_masuk' class='btn btn-primary btn-lg mt-1 btn-block'><i class='fas fa-car'></i> Kendaraan Masuk</a>";
                            echo "<a href='/satpam_kendaraan_keluar' class='btn btn-danger btn-lg mt-1 btn-block float-right'><i class='fas fa-car'></i> Kendaraan Keluar</a>";
                            ?>
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
                <div class="col-lg-3 col-6">
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
                <div class="col-lg-3 col-6">
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
                <div class="col-lg-3 col-6">
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
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">DAFTAR KELUAR MASUK KENDARAAN</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive table-sm">
                                <table id="def-table-1" class="table table-bordered">
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
                                            <th>Aksi</th>
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
                                                    <td><?= $btnKeluar; ?></td>
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