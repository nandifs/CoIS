<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/satpam_kegiatan"><i class="fas fa-arrow-circle-left"></i> Kembali</a></li>
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
                            <h3 class="card-title">DATA KEGIATAN/KEJADIAN</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?= form_open_multipart('/satpam_kegiatan_save', ['id' => 'form-kegiatan', 'class' => 'form-horizontal', 'onsubmit' => "return validateForm()"]); ?>
                        <?= csrf_field(); ?>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="tanggal" class="col-sm-3 col-form-label">Waktu Kegiatan/Kejadian</label>
                                <div class="col-sm-9">
                                    <input type="hidden" class="form-control" name="bm_id" value="<?= $bukuMutasiId; ?>" readonly>
                                    <input type="text" class="form-control" name="tanggal" value="<?= ambil_tanggal_jam("mysql"); ?>" required readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jenis" class="col-sm-3 col-form-label">Jenis Kegiatan/Kejadian</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='jenis'>
                                        <option>INSPEKSI MENDADAK (SIDAK)</option>
                                        <option>KEHILANGAN</option>
                                        <option>PENCURIAN</option>
                                        <option>KEBAKARAN</option>
                                        <option>INOVASI</option>
                                        <option>KEGIATAN LAINNYA</option>
                                        <option>KEJADIAN LAINNYA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Foto Kegiatan/Kejadian</label>
                                <div class="col-sm-12">

                                    <div class="img-foto" id="foto"></div>
                                    <div style="width: auto; text-align:center;">
                                        <input type=button class="btn btn-primary" id="getfoto" value="Ambil Foto" style="margin-top:-100px;">
                                    </div>
                                    <input type="hidden" class="form-control" name="urifoto" id="urifoto">
                                </div>
                            </div>
                            <div class="form-group row" style="margin-top: -25px;">
                                <label for="titik" class="col-sm-3 col-form-label">Lokasi</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="lokasi" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kondisi" class="col-sm-3 col-form-label">Kondisi</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='kondisi'>
                                        <option>AMAN</option>
                                        <option>KRITIKAL</option>
                                        <option>LOKASI RAWAN</option>
                                        <option>DALAM PROSES</option>
                                        <option>SELESAI</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kondisi" class="col-sm-3 col-form-label">Keterangan</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="keterangan" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="unitkerja" class="col-sm-3 col-form-label">Unit Mitra Kerja</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="mitrakerja" value="<?= $dtTenagakerja['penempatan']; ?>" required readonly>
                                    <input type="hidden" name="mitrakerja_id" value="<?= $dtTenagakerja['penempatan_id']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="petugas" class="col-sm-3 col-form-label">Petugas</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="petugas" value="<?= $dtTenagakerja['nama']; ?>" required readonly>
                                    <input type="hidden" name="petugas_id" value="<?= $dtTenagakerja['id']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-default" onclick="location.href='/satpam_kegiatan';">Batal</button>
                            <button type="submit" class="btn btn-primary float-right mr-1">Simpan</button>
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
    <!-- /.content -->
</div>