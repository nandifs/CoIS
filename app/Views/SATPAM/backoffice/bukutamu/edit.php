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
                        <li class="breadcrumb-item"><?= $title; ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Data</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <?= form_open_multipart('/bukutamu/update', ['class' => 'form-horizontal']); ?>
                <?= csrf_field(); ?>
                <?php
                $tgl = waktu();
                $tglkeluar = date("Y-m-d");
                $jam = date("H:i:s")
                ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Hari, Tanggal Datang :</label>
                                <input class="form-control" type="text" name="tglindo" value="<?= $tgl; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nama Tamu:</label>
                                <input class="form-control" type="text" name="nama_tamu" value="<?= $dtTamu['nama_tamu']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Alamat :</label>
                                <textarea class="form-control" rows="3" name="alamat"><?= $dtTamu['alamat']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>No Telpon :</label>
                                <input class="form-control" type="text" name="telp" value="<?= $dtTamu['telepon']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Pekerjaan/Instansi :</label>
                                <input type="text" name="instansi" class="form-control" value="<?= $dtTamu['instansi_pekerjaan']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Bertemu dengan:</label>
                                <input type="text" name="bertemu" class="form-control" value="<?= $dtTamu['bertemu']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Keperluan :</label>
                                <textarea class="form-control" rows="3" name="keperluan"><?= $dtTamu['keperluan']; ?></textarea>
                            </div>
                            <div class="form-group row">
                                <label for="jam_masuk" class="col-sm-3 col-form-label">Jam Datang:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="jam_masuk" value="<?= $dtTamu['jam_masuk']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jam_keluar" class="col-sm-3 col-form-label">Jam Keluar:</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="jam_keluar" value="<?= $dtTamu['jam_keluar']; ?>" readonly>
                                    <input class="form-control" type="hidden" name="tanggal" value="<?= $tglkeluar; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Foto KTP/Identitas:</label>
                                <div class="img-foto"><img class="img-foto" src="<?= base_url('/uploads/tamu/id') . '/fid' . $dtTamu['file_foto_dan_ttd']; ?>.jpg" /></div>
                            </div>
                            <div class="form-group">
                                <label>Foto Tamu:</label>
                                <div class="img-foto"><img class="img-foto" src="<?= base_url('/uploads/tamu/foto') . '/ftm' . $dtTamu['file_foto_dan_ttd']; ?>.jpg" /></div>
                            </div>
                            <div class="form-group">
                                <label>Tanda Tangan:</label>
                                <div class="sign-area"><img src="<?= base_url('/uploads/tamu/ttd') . '/ttd' . $dtTamu['file_foto_dan_ttd']; ?>.png" /></div>
                            </div>
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
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.section -->
</div>