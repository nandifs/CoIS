<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary mt-2">
                    <div class="card-body pb-0">
                        <?= form_open_multipart('/ophardung_kegiatan', ['id' => 'frm-refresh', 'class' => 'form-horizontal']); ?>
                        <?= csrf_field(); ?>
                        <div class="form-group row">
                            <label for="input1" class="col-sm-2 col-form-label">Data Mitra Kerja</label>
                            <div class="col-sm-5">
                                <select class="form-control select2" id="dt-akses" name='dtakses' style="width: 100%;">
                                    <?php
                                    if (isset($selDtAkses)) {
                                        foreach ($dtMitraKerja as $mitra) :
                                            $space = "";
                                            if ($mitra['kelas'] == 2) {
                                                $space = "&nbsp;&nbsp;&nbsp;&nbsp;|&rarr; ";
                                            } else if ($mitra['kelas'] == 3) {
                                                $space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&rarr; ";
                                            } ?>
                                            <option value=<?= $mitra['id']; ?> <?= ($mitra['id'] == $selDtAkses) ? "selected" : ""; ?>><?= $space . $mitra['singkatan']; ?></option>
                                    <?php endforeach;
                                    } ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control" id="sel-periode" name='periode'>
                                    <?php
                                    $periodeLaporan = ambil_bulan_setahun_kebelakang();
                                    $selected = "selected";
                                    foreach ($periodeLaporan as $value) {
                                        echo "<option value='$value' " . (($value == $selPeriode) ? 'selected' : '') . "> " . ambil_bulan_tahun($value) . "</option>";
                                        $selected = "";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-info" name="cmdaksi" value="rekapitulasi">Tampilkan</button>
                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <button type="submit" class="dropdown-item" name="cmdaksi" value="export_kegiatan_ophar_to_xls">Ekspor Ke Excel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?= form_close() ?>
                        <?= view('templates/notification'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">BUKU KEGIATAN</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tbl-kegiatan" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>UNIT MITRA KERJA</th>
                                    <th>PETUGAS</th>
                                    <th>TANGGAL</th>
                                    <th>JUMLAH KEGIATAN</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
</section>
<!-- /.content -->