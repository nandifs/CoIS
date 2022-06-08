<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/presensi_data"><i class="fas fa-arrow-circle-left"></i> Kembali</a></li>
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
                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Form Presensi Tenagakerja</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?= form_open_multipart('/presensi/save_pulang/' . $dtPresensi['id'], ['class' => 'form-horizontal']); ?>
                        <?= csrf_field(); ?>
                        <?php
                        $tgl = waktu();
                        $tglmasuk = date("Y-m-d");
                        $jam = date("H:i:s")
                        ?>
                        <div class="card-body">
                            <div><?= view('templates/notification'); ?></div>
                            <div class="form-group row">
                                <label for="titik" class="col-sm-3 col-form-label">Presensi</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='jenis'>
                                        <option value=1>Kehadiran</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Hari, Tanggal :</label>
                                <input class="form-control" type="text" name="tglindo" value="<?php echo $tgl; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nama:</label>
                                <input class="form-control" type="hidden" name="pekerja_id" value="<?= $dtTenagakerja['id']; ?>" readonly>
                                <input class="form-control" type="text" name="nama" value="<?= $dtTenagakerja['nama']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Unit Kerja :</label>
                                <input type="text" name="instansi" class="form-control" value="<?= $dtTenagakerja['unitkerja']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Penempatan :</label>
                                <input type="text" name="instansi" class="form-control" value="<?= $dtTenagakerja['penempatan']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Foto Presensi Masuk:</label>
                                <div class="img-foto align-items-center justify-content-center">
                                    <img class="img-foto" src="<?= base_url('/uploads/presensi/f1/') . '/' . $dtPresensi['foto_1']; ?>" onerror="this.src='<?= base_url('/uploads') . '/noimage.jpg'; ?>'" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jam_masuk" class="col-sm-3 col-form-label">Jam Masuk:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="tanggal_1" id="jam_masuk" value="<?= $dtPresensi['tanggal_1']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Keterangan :</label>
                                <input type="text" name="keterangan_1" class="form-control" value="<?= $dtPresensi['keterangan_1']; ?>" readonly>
                            </div>
                            <div class="form-group" id="div_approval">
                                <div id="signArea" class="sign-area">
                                    <ul class="sigNav">
                                        <li style="color:red;"><b>Approval Supervisor/Kordinator</b></li>
                                        <li class="clearButton"><a href="#clear">Ulangi</a></li>
                                    </ul>
                                    <div class="sig sigWrapper" style="height:auto;">
                                        <div class="typed"></div>
                                        <canvas class="sigPad" id="sign-pad"></canvas>
                                    </div>
                                    <textarea class="form-control" name="urittd" id="ttd_tamu" style="display:none;"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-default" onclick="window.history.back()">Batal</button>
                            <button type="submit" class="btn btn-success float-right mr-1">Simpan</button>
                        </div>
                        <!-- /.card-footer -->
                        <?= form_close(); ?>
                        <?php include "webcam.php"; ?>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.section -->
</div>