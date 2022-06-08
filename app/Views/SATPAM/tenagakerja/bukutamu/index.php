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
            <?php
            if (is_null($dtPresensiAktif)) { ?>
                <div class="callout callout-danger">
                    <h5>PERHATIAN !</h5>

                    <p>Anda belum mengisi absensi.</p>
                </div>
                <a href="/" class="btn btn-danger btn-flat"><i class="fa fa-close"></i> Kembali Ke Dashbord</a>
            <?php } else { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-success">
                            <div class="card-body pb-0">
                                <div class="form-group row">
                                    <input class="form-control" type="hidden" id="appName" value="<?= $appName; ?>" readonly>
                                    <label for="input1" class="col-sm-2 col-form-label  <?= ($dcUser["otoritas"] == "TENAGAKERJA") ? "d-none" : ""; ?>">Data Mitra Kerja</label>
                                    <div class="<?= ($dcUser["otoritas"] == "TENAGAKERJA") ? "d-none" : "col-sm-5"; ?>">
                                        <?= form_open_multipart('/satpam_bukutamu', ['id' => 'frm-refresh', 'class' => 'form-horizontal']); ?>
                                        <?= csrf_field(); ?>
                                        <select class="form-control select2" id="dt-akses" name='dtakses' style="width: 100%;">
                                            <?php
                                            if (isset($selDtAkses)) {
                                                if (is_null($selDtAkses)) $selDtAkses = "1";
                                                foreach ($dtMitraKerja as $mitra) : ?>
                                                    <option value=<?= $mitra['id']; ?> <?= ($mitra['id'] == $selDtAkses) ? "selected" : ""; ?>><?= $mitra['mitrakerja']; ?></option>
                                            <?php endforeach;
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="<?= ($dcUser["otoritas"] == "TENAGAKERJA") ? "col-sm-12" : "col-sm-5"; ?>">
                                        <div class="panel panel-default <?= ($dcUser["otoritas"] == "TENAGAKERJA") ? "" : "float-right"; ?>">
                                            <div class="panel-body">
                                                <?php if ($dcUser["otoritas"] == "TENAGAKERJA") : ?>
                                                    <a href="<?php echo base_url('satpam_bukutamu_add'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Data Tamu</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                    <div class="col-lg-3 col-6">
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
                    <div class="col-lg-3 col-6">
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
                    <div class="col-lg-3 col-6">
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
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">DAFTAR <?= strtoupper($title); ?></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <div class="form-group row">
                                                    <div class="col-sm-4"></div>
                                                    <label class="col-sm-1 col-form-label">Periode : </label>
                                                    <div class="col-sm-3">
                                                        <select class="form-control" id="sel-periode" name='sel_periode'>
                                                            <option value="Hari Ini" <?= ($selPeriode == "Hari Ini") ? "selected" : ""; ?>>Hari Ini</option>
                                                            <option value="Bulan Ini" <?= ($selPeriode == "Bulan Ini") ? "selected" : ""; ?>>Bulan Ini</option>
                                                            <option value="Bulan Lalu" <?= ($selPeriode == "Bulan Lalu") ? "selected" : ""; ?>>Bulan Lalu</option>
                                                        </select>
                                                        <input type="hidden" id="periode-tanggal">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?= form_close(); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="tbl-buku-tamu" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Nama Tamu</th>
                                                    <th>Alamat</th>
                                                    <th>Pekerjaan/Instansi</th>
                                                    <th>Jam Masuk</th>
                                                    <th>Jam Keluar</th>
                                                    <th>Aksi</th>
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
                                                            <td><?= ($expTglKeluar[1] != "00:00:00") ? $expTglKeluar[1] : '
                                                     <a data-toggle="tooltip" data-placement="top" title="Tamu Keluar/Pulang">
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="setJamKeluar(' . $rowId . ')"><i class="fa fa-door-open"></i></button>
                                                    </a>'; ?>
                                                            <td>
                                                                <a data-toggle="tooltip" data-placement="top" title="Detail Tamu">
                                                                    <button type="button" class="btn btn-info btn-sm" onclick="detailTamu('<?php echo $rowId; ?>')" title="Detail Tamu"><i class="far fa-address-card"></i></button>
                                                                </a>
                                                                <?php if ($dcUser["otoritas"] != "TAMU") : ?>
                                                                    <a href="<?php echo base_url('satpam_bukutamu_edit/' . $rowId); ?>" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                        <button type="button" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
                                                                    </a>
                                                                    <a href="<?php echo base_url('satpam_bukutamu_delete/' . $rowId); ?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data <?= $title; ?> : <?php echo $row['nama_tamu']; ?> ?')" style="display:none">
                                                                        <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash-alt"></i></button>
                                                                    </a>
                                                                <?php endif; ?>
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
            <?php } ?>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.section -->
</div>
<!-- /.content -->
<?php
include 'mdldetail.php';
include 'mdljamkeluar.php';
?>