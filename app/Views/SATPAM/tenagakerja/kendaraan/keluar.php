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
                            <h3 class="card-title">Form Kendaraan Keluar</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?= form_open_multipart("/satpam_kendaraan_saveout", ['id' => 'form-kendaraan', 'class' => 'form-horizontal']); ?>
                        <?= csrf_field(); ?>
                        <?php
                        if (isset($dtKendaraan)) {
                            $dataid = $dtKendaraan['id'];
                            $nopol = $dtKendaraan['no_polisi'];
                            $pemilik = $dtKendaraan['pemilik'];
                            $jnskendaraan = $dtKendaraan['jns_kendaraan'];
                            $tglmasuk = $dtKendaraan['jam_masuk'];
                            $fotomasuk = $dtKendaraan['foto_masuk'];
                            $ketmasuk = $dtKendaraan['ket_masuk'];
                        } else {
                            $dataid = "";
                            $tglmasuk = "";
                            $fotomasuk = "noimage.jpg";
                            $ketmasuk = "";
                        }

                        //get waktu saat ini
                        $waktusaatini = waktu();
                        ?>
                        <div class="card-body">
                            <div><?= view('templates/notification'); ?></div>
                            <div class="form-group">
                                <input class="form-control" type="hidden" id="appName" value="<?= $appName; ?>" readonly>
                                <input class="form-control" type="hidden" id="data_id" name="data_id" value="<?= $dataid; ?>" readonly>
                                <label>Hari, Tanggal :</label>
                                <input class="form-control" type="text" name="tglindo" value="<?= $waktusaatini; ?>" readonly>
                            </div>
                            <?php if (isset($dtKendaraan)) { ?>
                                <div class="form-group">
                                    <label>No Polisi:</label>
                                    <input class="form-control" type="text" name="no_polisi" value="<?= $nopol; ?>" readonly>
                                </div>
                                <div class=" form-group">
                                    <label>Nama Pemilik/Pengemudi:</label>
                                    <input class="form-control" type="text" name="pemilik" value="<?= $pemilik; ?>" readonly>
                                </div>
                                <hr>
                                <strong><i class="fas fa-tasks mr-1"></i> <span style="color: red;">KENDARAAN</span></strong>
                                <hr>
                                <div class="form-group row">
                                    <label for="jenis" class="col-sm-3 col-form-label">Jenis</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name='jenis' id="jenis_kendaraan" disabled>
                                            <option value="1" <?= ($jnskendaraan == "1") ? "selected" : ""; ?>>Roda 2</option>
                                            <option value="2" <?= ($jnskendaraan == "2") ? "selected" : ""; ?>>Roda 4 / Lebih</option>
                                        </select>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="form-group">
                                    <label>No Polisi:</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" id="nopol" name="no_polisi" style="text-transform:uppercase;" required>
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-info btn-flat" id="btn-cari">Cari</button>
                                        </span>
                                    </div>
                                </div>
                                <div class=" form-group">
                                    <label>Nama Pemilik/Pengemudi:</label>
                                    <input class="form-control" type="text" id="pemilik" name="pemilik" style="text-transform:uppercase;" required>
                                </div>
                                <hr>
                                <strong><i class="fas fa-tasks mr-1"></i> <span style="color: red;">KENDARAAN</span></strong>
                                <hr>
                                <div class="form-group row">
                                    <label for="titik" class="col-sm-3 col-form-label">Jenis</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name='jenis' id="jenis_kendaraan">
                                            <option value="1">Roda 2</option>
                                            <option value="2">Roda 4 / Lebih</option>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label>Foto Masuk:</label>
                                <div class="img-foto align-items-center justify-content-center">
                                    <?php
                                    $imgFoto = $pathFotoKendaraan .  $fotomasuk;
                                    //dd($imgFoto);
                                    $imgFoto = checkUploadImgIfExist($imgFoto);
                                    $imgFoto = base_url($imgFoto);
                                    ?>
                                    <img class="img-foto" id="img_foto_masuk" src="<?= $imgFoto; ?>" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jam_masuk" class="col-sm-3 col-form-label">Jam Masuk:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="jam_masuk" value="<?= $tglmasuk; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Keterangan :</label>
                                <textarea class="form-control" rows="3" id="ket_masuk" name="ket_masuk" readonly><?= $ketmasuk; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Foto Keluar:</label>
                                <div style="text-align: center;">
                                    <div class="img-foto" id="foto2"><img class="img-foto" style="display: none;" id="img_foto_keluar" src="<?= $imgFoto; ?>" /></div>
                                    <input type=button class="btn btn-xs btn-primary" id="getfoto2" value="Ambil Foto" style="display: inline-block; position:absolute; margin-top:-40px; margin-left:-20px;">
                                </div>
                                <input type="hidden" class="form-control" name="urifoto2" id="urifoto2">
                            </div>
                            <div class="form-group row">
                                <label for="jam_keluar" class="col-sm-3 col-form-label">Jam Keluar:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="jam_keluar" id="jam_keluar" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Keterangan :</label>
                                <textarea class="form-control" rows="3" id="ket_keluar" name="ket_keluar"></textarea>
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