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
                            <h3 class="card-title">Form Presensi Pegawai</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?= form_open_multipart("/presensi_saveout", ['id' => 'form-presensi', 'class' => 'form-horizontal']); ?>
                        <?= csrf_field(); ?>
                        <?php
                        $tgl = waktu();
                        $tglmasuk = date("Y-m-d");
                        $jam = date("H:i:s")
                        ?>
                        <div class="card-body">
                            <div><?= view('templates/notification'); ?></div>
                            <div class="form-group row">
                                <input class="form-control" type="hidden" name="data_id" value="<?= $dtPresensi['id']; ?>" readonly>
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
                                <input class="form-control" type="hidden" name="pekerja_id" value="<?= $dtPegawai['id']; ?>" readonly>
                                <input class="form-control" type="text" name="nama" value="<?= $dtPegawai['nama']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Unit Kerja :</label>
                                <input type="text" name="instansi" class="form-control" value="<?= $dtPegawai['unitkerja']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Penempatan :</label>
                                <input type="text" name="instansi" class="form-control" value="<?= $dtPegawai['penempatan']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Foto Presensi Masuk:</label>
                                <div class="img-foto align-items-center justify-content-center">
                                    <?php
                                    $imgFoto = $pathFotoPresensiF1 . '/' . $dtPresensi['foto_1'];
                                    $imgFoto = checkUploadImgIfExist($imgFoto);
                                    ?>
                                    <img class="img-foto" src="<?= base_url($imgFoto); ?>" />
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
                            <div class="form-group">
                                <label>Foto Presensi Pulang:</label>
                                <div style="text-align: center;">
                                    <div class="img-foto" id="foto2"></div>
                                    <input type=button class="btn btn-xs btn-primary" id="getfoto2" value="Ambil Foto" style="display: inline-block; position:absolute; margin-top:-40px; margin-left:-20px;">
                                </div>
                                <input type="hidden" class="form-control" name="urifoto2" id="urifoto2">
                            </div>
                            <div class="form-group row">
                                <label for="jam_keluar" class="col-sm-3 col-form-label">Jam Pulang:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="tanggal_2" id="jam_pulang" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Keterangan :</label>
                                <input type="text" name="keterangan_2" class="form-control">
                            </div>
                            <div class="form-group row">
                                <label for="koordinat" class="col-sm-3 col-form-label">Geolocation :</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" id="lblGeoLocation" name="koordinat" readonly>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-default" onclick="window.history.back()">Batal</button>
                            <button type="submit" class="btn btn-success float-right mr-1" id="btnSubmit">Simpan</button>
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