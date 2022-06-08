<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/"><i class="fas fa-arrow-circle-left"></i> Kembali</a></li>
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
                            <div class="form-group">
                                <label for="tanggal">Waktu Kegiatan/Kejadian</label>

                                <input type="hidden" class="form-control" name="bm_id" value="<?= $bukuMutasiId; ?>" readonly>
                                <input type="text" class="form-control" name="tanggal" id="tanggal" value="<?= ambil_tanggal_jam("mysql"); ?>" required readonly>
                            </div>

                            <div class="form-group">
                                <label for="jenis">Jenis Kegiatan/Kejadian</label>

                                <select class="form-control" name='jenis'>
                                    <option value="INSP. NON RUTIN" selected>INSPEKSI NON RUTIN</option>
                                    <option value="SIDAK">INSPEKSI MENDADAK (SIDAK)</option>
                                    <option value="KEHILANGAN">KEHILANGAN</option>
                                    <option value="PENCURIAN">PENCURIAN</option>
                                    <option value="KEBAKARAN">KEBAKARAN</option>
                                    <option value="KEGIATAN LAINNYA">KEGIATAN LAINNYA</option>
                                    <option value="KEJADIAN LAINNYA">KEJADIAN LAINNYA</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>FOTO KEGIATAN/KEJADIAN</label>
                                <div class="img-foto" id="foto"></div>
                                <div style="width: auto; text-align:center;">
                                    <input type=button class="btn btn-primary" id="getfoto" value="Ambil Foto" style="margin-top:-100px;">
                                </div>
                                <input type="hidden" class="form-control" name="urifoto" id="urifoto">
                            </div>

                            <div class="form-group">
                                <label for="foto_offline">Ambil Foto dari Galery (Offline)</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="foto_offline" accept="image/png, image/jpeg">
                                        <label class="custom-file-label" for="foto_offline" id="foto_name">Pilih file foto</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label for="titik" class="col-sm-3 col-form-label">Lokasi</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="lokasi" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kondisi" class="col-sm-3 col-form-label">Kondisi</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='kondisi'>
                                        <option value="AMAN" selected>AMAN</option>
                                        <option value="KRITIKAL">KRITIKAL</option>
                                        <option value="LOKASI RAWAN">LOKASI RAWAN</option>
                                        <option value="DALAM PROSES">DALAM PROSES</option>
                                        <option value="SELESAI">SELESAI</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kondisi" class="col-sm-3 col-form-label">Keterangan</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="keterangan" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="unitkerja">Unit Mitra Kerja</label>
                                <input type="text" class="form-control" name="mitrakerja" value="<?= $dtTenagakerja['penempatan']; ?>" required readonly>
                                <input type="hidden" name="mitrakerja_id" value="<?= $dtTenagakerja['penempatan_id']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="petugas">Petugas</label>
                                <input type="text" class="form-control" name="petugas" value="<?= $dtTenagakerja['nama']; ?>" required readonly>
                                <input type="hidden" name="petugas_id" value="<?= $dtTenagakerja['id']; ?>" required>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-default" onclick="location.href='/';">Batal</button>
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