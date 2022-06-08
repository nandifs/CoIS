    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-outline card-primary mt-2">
                        <div class="card-header">
                            <h3 class="card-title">Presensi Tenagakerja</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?php
                        $tgl = waktu();
                        $tglmasuk = date("Y-m-d");
                        $jam = date("H:i:s");
                        $jenisKehadiran = "";
                        $lblFoto1 = "";
                        $setDisplay = "";

                        switch ($dtPresensi['jenis']) {
                            case 1:
                                $jenisKehadiran = "KEHADIRAN";
                                $lblFoto1 = "Foto Presensi Masuk :";
                                $setDisplay = "";
                                break;
                            case 2:
                                $jenisKehadiran = "SAKIT";
                                $lblFoto1 = "Foto Surat Dokter :";
                                $setDisplay = "d-none";
                                break;
                            case 3:
                                $jenisKehadiran = "CUTI";
                                $lblFoto1 = "Foto Surat Cuti :";
                                $setDisplay = "d-none";
                                break;
                            case 4:
                                $jenisKehadiran = "TIDAK HADIR";
                                $setDisplay = "d-none";
                                break;
                            case 1:
                                $jenisKehadiran = "ALPA/TANPA KETERANGAN";
                                $setDisplay = "d-none";
                                break;
                            default:
                                $jenisKehadiran = "NO LABEL";
                                break;
                        }
                        ?>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="titik" class="col-sm-3 col-form-label">Presensi</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="jenis" value="<?= $jenisKehadiran; ?>" readonly>
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
                            <?php  ?>
                            <div class="form-group  <?= $setDisplay; ?>">
                                <label><?= $lblFoto1; ?></label>
                                <div style="text-align: center;">
                                    <?php if ($setDisplay != 'd-none') { ?>
                                        <img class="form-control img-foto" src="<?= $pathUploadImg . "/presensi/f1/" . $dtPresensi['foto_1']; ?>" onerror="this.src='<?= base_url('/uploads') . '/noimage.jpg'; ?>'" />
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group row <?= $setDisplay; ?>">
                                <label for="jam_masuk" class="col-sm-3 col-form-label">Jam Masuk:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="tanggal_1" id="jam_masuk" value="<?= $dtPresensi['tanggal_1']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Keterangan :</label>
                                <input type="text" name="keterangan_1" class="form-control" readonly value="<?= $dtPresensi['keterangan_1']; ?>">
                            </div>
                            <div class="form-group <?= $setDisplay; ?>">
                                <label>Foto Presensi Pulang:</label>
                                <div style="text-align: center;">
                                    <?php if ($setDisplay != 'd-none') { ?>
                                        <img class="form-control img-foto" src="<?= $pathUploadImg . "/presensi/f2/" . $dtPresensi['foto_2']; ?>" onerror="this.src='<?= base_url('/uploads') . '/noimage.jpg'; ?>'" />
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group row <?= $setDisplay; ?>">
                                <label for="jam_keluar" class="col-sm-3 col-form-label">Jam Pulang:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="tanggal_2" id="jam_pulang" value="<?= $dtPresensi['tanggal_2']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group <?= $setDisplay; ?>">
                                <label>Keterangan :</label>
                                <input type="text" name="keterangan_2" class="form-control" value="<?= $dtPresensi['keterangan_2']; ?>">
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-default float-right" onclick="onClickPreviousButton('<?= $mitrakerja_id; ?>', '<?= $periode; ?>', '<?= $actionkey; ?>')">Kembali</button>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.section -->