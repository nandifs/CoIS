<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/satpam_kendaraan"><i class="fas fa-arrow-circle-left"></i> Kembali</a></li>
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
                            <h3 class="card-title">Kendaraan Masuk</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?= form_open_multipart('/satpam_kendaraan_save', [
                            'id' => 'form-presensi', 'class' => 'form-horizontal', 'onsubmit' => "return validateForm();"
                        ]); ?>
                        <?= csrf_field(); ?>
                        <?php
                        //get waktu saat ini
                        $waktusaatini = waktu();
                        ?>
                        <div class="card-body">
                            <div><?= view('templates/notification'); ?></div>
                            <div class="form-group">
                                <label>Hari, Tanggal :</label>
                                <input class="form-control" type="text" value="<?php echo $waktusaatini; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>No Polisi:</label>
                                <input class="form-control" type="text" name="no_polisi" style="text-transform:uppercase;" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Pemilik:</label>
                                <input class="form-control" type="text" name="pemilik" style="text-transform:uppercase;" required>
                            </div>
                            <hr>
                            <strong><i class="fas fa-tasks mr-1"></i> <span style="color: red;">KENDARAAN</span></strong>
                            <hr>
                            <div class="form-group row">
                                <label for="titik" class="col-sm-3 col-form-label">Jenis</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='jenis' id="jenis">
                                        <option value=1>Roda 2</option>
                                        <option value=2>Roda 4 / Lebih</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="div_foto1">
                                <label id="lblFoto1">Foto Kendaraan:</label>
                                <div style="text-align:center;">
                                    <div class="img-foto" id="foto1"></div>
                                    <input type=button class="btn btn-xs btn-primary" id="getfoto1" value="Ambil Foto" style="display: inline-block; position:absolute; margin-top:-40px; margin-left:-20px;">
                                </div>
                                <input type="hidden" class="form-control" name="urifoto1" id="urifoto1">
                            </div>
                            <div class="form-group row" id="div_jam_masuk">
                                <label for="jam_masuk" class="col-sm-3 col-form-label">Jam Masuk:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="jam_masuk" name="jam_masuk" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Keterangan :</label>
                                <textarea class="form-control" rows="3" name="ket_masuk"></textarea>
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