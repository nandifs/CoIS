<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/satpam_buku_tamu">Buku Tamu</a></li>
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
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Form Tambah Data Tamu</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?= form_open_multipart('/satpam_bukutamu_save', ['class' => 'form-horizontal', 'id' => 'form-bukutamu', 'onsubmit' => "return validateForm()"]); ?>
                        <?= csrf_field(); ?>
                        <?php
                        $tgl = waktu();
                        $tglmasuk = date("Y-m-d");
                        $jam = date("H:i:s")
                        ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Hari, Tanggal :</label>
                                        <input class="form-control" type="text" name="tglindo" value="<?php echo $tgl; ?>" readonly>
                                        <input class="form-control" type="hidden" name="tanggal" value="<?= $tglmasuk; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Tamu:</label>
                                        <input class="form-control" type="text" name="nama_tamu">
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat :</label>
                                        <textarea class="form-control" rows="3" name="alamat"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>No Telpon :</label>
                                        <input class="form-control" type="text" name="telp" id="telp">
                                    </div>
                                    <div class="form-group">
                                        <label>Pekerjaan/Instansi :</label>
                                        <input type="text" name="instansi" class="form-control" id="instansi">
                                    </div>
                                    <div class="form-group">
                                        <label>Bertemu dengan :</label>
                                        <input type="text" name="bertemu" class="form-control" id="bertemu">
                                    </div>
                                    <div class="form-group">
                                        <label>Keperluan :</label>
                                        <textarea class="form-control" rows="3" name="keperluan"></textarea>
                                    </div>
                                    <div class="form-group row">
                                        <label for="jam_masuk" class="col-sm-3 col-form-label">Jam Datang:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="jam_masuk" value="<?= $jam; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="jam_keluar" class="col-sm-3 col-form-label">Jam Keluar:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="jam_keluar" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Foto KTP/Identitas:</label>
                                        <div style="text-align:center;">
                                            <div class="img-foto" id="foto1"></div>
                                            <input type=button class="btn btn-xs btn-primary" id="getfoto1" value="Ambil Foto" style="display: inline-block; position:absolute; margin-top:-40px; margin-left:-20px;">
                                        </div>
                                        <input type="hidden" class="form-control" name="urifoto1" id="urifoto1">
                                    </div>
                                    <div class="form-group">
                                        <label>Foto Tamu:</label>
                                        <div class="img-foto" id="foto2"></div>
                                        <div style="text-align:center;">
                                            <input type=button class="btn btn-xs btn-primary" id="getfoto2" value="Ambil Foto" style="display: inline-block; position:absolute; margin-top:-40px; margin-left:-20px;">
                                        </div>
                                        <input type="hidden" class="form-control" name="urifoto2" id="urifoto2">
                                    </div>
                                    <div class="form-group">
                                        <div id="signArea" class="sign-area">
                                            <ul class="sigNav">
                                                <li><b>Tanda Tangan</b></li>
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
                            </div>
                            <!-- /.row -->
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
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.section -->
</div>