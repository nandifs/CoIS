<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/pegawai_kegiatan_list"><i class="fas fa-arrow-circle-left"></i> Kembali</a></li>
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
                        <?= form_open_multipart('/pegawai_kegiatan_update', ['id' => 'form-kegiatan', 'class' => 'form-horizontal']); ?>
                        <?= csrf_field(); ?>
                        <div class="card-body">
                            <div class="form-group row">
                                <input type="hidden" class="form-control" name="kegiatan_id" value="<?= $dtKegiatan["id"]; ?>" readonly>
                                <label for="tanggal">Waktu Update Kegiatan</label>
                                <input type="text" class="form-control" name="tanggal" value="<?= ambil_tanggal_jam("mysql"); ?>" required readonly>
                            </div>
                            <div class="form-group row">
                                <label for="jenis">Jenis Kegiatan</label>
                                <select class="form-control" name='jenis'>
                                    <option value="TUGAS RUTIN" <?= ($dtKegiatan['jenis'] == "TUGAS RUTIN") ? "selected" : ""; ?>>TUGAS RUTIN</option>
                                    <option value="TUGAS NON RUTIN" <?= ($dtKegiatan['jenis'] == "TUGAS NON RUTIN") ? "selected" : ""; ?>>TUGAS NON RUTIN</option>
                                    <option value="KEGIATAN LAINNYA" <?= ($dtKegiatan['jenis'] == "KEGIATAN LAINNYA") ? "selected" : ""; ?>>KEGIATAN LAINNYA</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Foto Kegiatan</label>
                                <div style="text-align: center;">
                                    <?php
                                    $imgFoto = $pathFotoKegiatan . $dtKegiatan['foto'];
                                    $imgFoto = checkUploadImgIfExist($imgFoto); ?>
                                    <img class="form-control img-foto" src="<?= base_url($imgFoto); ?>" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="titik" class="col-sm-3 col-form-label">Lokasi</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="lokasi" value="<?= $dtKegiatan["lokasi"]; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kondisi">Keterangan</label>
                                <textarea class="form-control" name="keterangan" rows="3"><?= $dtKegiatan["keterangan"]; ?></textarea>
                            </div>
                            <div class="form-group row">
                                <label for="kondisi" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='kondisi'>
                                        <option <?= ($dtKegiatan['kondisi'] == "On Progress") ? "selected" : ""; ?>>On Progress</option>
                                        <option <?= ($dtKegiatan['kondisi'] == "Selesai") ? "selected" : ""; ?>>Selesai</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="petugas">Petugas</label>
                                <input type="text" class="form-control" name="petugas" value="<?= $dtPegawai['nama']; ?>" required readonly>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-default" onclick="location.href='/pegawai_kegiatan_list';">Batal</button>
                            <button type="submit" class="btn btn-primary float-right mr-1">Simpan</button>
                        </div>
                        <!-- /.card-footer -->
                        <?= form_close(); ?>
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