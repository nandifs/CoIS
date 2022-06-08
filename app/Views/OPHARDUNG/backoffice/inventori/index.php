<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary mt-2">
                    <div class="card-body pb-0">
                        <?= form_open_multipart('/ophardung_inventori', ['id' => 'frm-refresh', 'class' => 'form-horizontal']); ?>
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
                                <select class="form-control" id="periode" name='periode'>
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
                                            <button type="submit" class="btn btn-info" name="cmdaksi" value="detail">Tampilkan</button>
                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <button type="submit" class="dropdown-item" name="cmdaksi" value="detail">Detail</button>
                                                <button type="submit" class="dropdown-item" name="cmdaksi" value="rekapitulasi">Rekapitulasi</button>
                                                <div class="dropdown-divider"></div>
                                                <button type="submit" class="dropdown-item" name="cmdaksi" value="cetak_presensi">Cetak Presensi</button>
                                                <button type="submit" class="dropdown-item" name="cmdaksi" value="export_presensi_to_xls">Ekspor Ke Excel</button>
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
                        <h3 class="card-title">INVENTARIS OPHARDUNG</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="def-table-1" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>UNIT MITRA KERJA</th>
                                    <th>JUMLAH ITEM</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                if (isset($dtRekapInventori)) {
                                    foreach ($dtRekapInventori as $rownr) {
                                        $rowKey = $rownr['mitrakerja_id']; ?>
                                        <tr>
                                            <td><?= $no; ?>.</td>
                                            <td><?= $rownr['mitrakerja']; ?></td>
                                            <td><?= $rownr['jml_item']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-xs" onclick="opharInventoriUnit('<?php echo $rowKey; ?>')"><i class="fa fa-eye"></i> Tampilkan</button>
                                            </td>
                                        </tr>
                                <?php
                                        $no++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
</section>
<!-- /.content -->