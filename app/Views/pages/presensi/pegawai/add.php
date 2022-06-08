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
                            <h3 class="card-title">Presensi Pegawai</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?= form_open_multipart('/presensi_save', [
                            'id' => 'form-presensi', 'class' => 'form-horizontal', 'onsubmit' => "return validateForm();"
                        ]); ?>
                        <?= csrf_field(); ?>
                        <?php
                        $tgl = waktu();
                        $tglmasuk = date("Y-m-d");
                        $jam = date("H:i:s")
                        ?>
                        <div class="card-body">
                            <div><?= view('templates/notification'); ?></div>
                            <div class="form-group">
                                <label>Hari, Tanggal :</label>
                                <input class="form-control" type="text" name="tglindo" value="<?php echo $tgl; ?>" readonly>
                                <input class="form-control" type="hidden" name="tanggal" value="<?= $tglmasuk; ?>">
                            </div>
                            <div class="form-group">
                                <label>Nama:</label>
                                <input class="form-control" type="hidden" name="pekerja_id" value="<?= $dtPegawai['id']; ?>" readonly>
                                <input class="form-control" type="text" name="nama" value="<?= $dtPegawai['nama']; ?>" readonly>
                            </div>
                            <hr>
                            <strong><i class="fas fa-tasks mr-1"></i> <span style="color: red;">PRESENSI</span></strong>
                            <hr>
                            <div class="form-group row">
                                <label for="titik" class="col-sm-3 col-form-label">Presensi</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='jenis' id="jenis">
                                        <option value=1>Kehadiran</option>
                                        <option value=2>Izin Sakit</option>
                                        <option value=3>Izin Cuti</option>
                                        <option value=4>Izin Tidak Hadir</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="div_foto1">
                                <label id="lblFoto1">Foto Presensi Masuk:</label>
                                <div style="text-align:center;">
                                    <div class="img-foto" id="foto1"></div>
                                    <input type=button class="btn btn-xs btn-primary" id="getfoto1" value="Ambil Foto" style="display: inline-block; position:absolute; margin-top:-40px; margin-left:-20px;">
                                </div>
                                <input type="hidden" class="form-control" name="urifoto1" id="urifoto1">
                            </div>
                            <div class="form-group row" id="div_jam_masuk">
                                <label for="jam_masuk" class="col-sm-3 col-form-label">Jam Masuk:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="tanggal_1" id="jam_masuk" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Keterangan :</label>
                                <input type="text" name="keterangan_1" class="form-control">
                            </div>
                            <div style="display: none;">
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
                            </div>
                            <div class="form-group" id="div_approval" style="display: none;">
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