    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-default mt-2">
                        <div class="card-header">
                            <h3 class="card-title">PENGATURAN DATA AKSES (<?= strtoupper($title); ?>)</h3>
                        </div>

                        <?= view('templates/notification'); ?>
                        <!-- /.card-header -->
                        <?= form_open('/satpam/dashboard/save_dtakses', ['class' => 'form-horizontal']); ?>
                        <?= csrf_field(); ?>
                        <?php //dd($dcUser)
                        ?>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Data Akses Unit Kerja</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name='dtakses_unitkerja'>
                                        <option value=9999>** FULL ACCESS **</option>
                                        <?php foreach ($dtUnitKerja as $unitkerja) : ?>
                                            <option value=<?= $unitkerja['id']; ?> <?= ($unitkerja['id'] == $dcUser['data_unit_id']) ? "selected" : ""; ?>><?= $unitkerja['singkatan']; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Data Akses Mitra Kerja</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name='dtakses_mitrakerja'>
                                        <option value=9999>** FULL ACCESS **</option>
                                        <?php foreach ($dtMitraKerja as $mitra) {
                                            //d($mitra['id']);
                                            $space = "";
                                            if ($mitra['kelas'] == 2) {
                                                $space = "&nbsp;&nbsp;&nbsp;&nbsp;|&rarr; ";
                                            } else if ($mitra['kelas'] == 3) {
                                                $space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&rarr; ";
                                            }
                                        ?>
                                            <option value=<?= $mitra['id']; ?> <?= ($mitra['id'] == $dcUser['data_akses_id']) ? "selected" : ""; ?>><?= $space . $mitra['singkatan']; ?></option>
                                        <?php
                                        }  ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer justify-content-between">
                            <button type="submit" class="btn btn-primary float-right">Simpan</button>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>

            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>0</h3>
                            <p>Pengguna Aplikasi</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>0</h3>
                            <p>Pengguna Aktif </p>
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
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>0</h3>
                            <p>Pengguna Online</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>0</h3>
                            <p>List Pekerjaan</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.section -->