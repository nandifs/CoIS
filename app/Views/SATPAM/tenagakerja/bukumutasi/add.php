<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/satpam_bukumutasi"><i class="fas fa-arrow-circle-left"></i> Kembali</a></li>
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
                            <h3 class="card-title">BUKU MUTASI BARU</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?= form_open_multipart('satpam_bukumutasi_save', ['class' => 'form-horizontal', 'id' => 'form-bukumutasi']); ?>
                        <?= csrf_field(); ?>
                        <?php
                        $tgl_indo = waktu();
                        $tanggal = date("Y-m-d");
                        ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Hari, Tanggal</label>
                                        <input type="hidden" name="pre_mutasi_id" value="<?= $pre_mutasi_id; ?>" readonly>
                                        <input class="form-control" type="text" value="<?php echo $tgl_indo; ?>" readonly>
                                        <input class="form-control" type="hidden" name="tanggal" value="<?php echo $tanggal; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Shift</label>
                                        <select class="form-control" id='cmb-shift' name='shift'>
                                            <?php
                                            $jam_dinas = "";
                                            if (isset($dt_shift)) {
                                                $selected = " selected";
                                                foreach ($dt_shift as $rowshift) {
                                                    echo "<option value='" . $rowshift['id'] . "' $selected>" . $rowshift['shift'] . "</option>";
                                                    if ($jam_dinas == "") {
                                                        $jam_dinas = $rowshift['jam_dinas'];
                                                    }
                                                    $selected = "";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jam Dinas</label>
                                        <input type="text" class="form-control" id="txt-jam-dinas" name="jam_dinas" value="<?= $jam_dinas; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Unit Mitra Kerja</label>
                                        <input type="hidden" name="mitrakerja_id" value="<?= $dtTenagakerja['penempatan_id']; ?>" required>
                                        <input type="text" class="form-control" name="mitrakerja" value="<?= $dtTenagakerja['penempatan']; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Dibuat Oleh</label>
                                        <input type="hidden" name="created_by_id" value="<?= $dtTenagakerja['id']; ?>" required>
                                        <input type="text" class="form-control" name="created_by" value="<?= $dtTenagakerja['nama']; ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-default" onclick="location.href='/satpam_bukumutasi';">Batal</button>
                            <button type="submit" class="btn btn-primary float-right mr-1" id="btnSubmit">Simpan</button>
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