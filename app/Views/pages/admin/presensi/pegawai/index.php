    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary mt-2">
                        <div class="card-body pb-0">
                            <?= form_open_multipart('/presensi', ['id' => 'frm-refresh', 'class' => 'form-horizontal']); ?>
                            <?= csrf_field(); ?>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-2 col-form-label">Data Unitkerja</label>
                                <div class="col-sm-6">
                                    <select class="form-control select2" id="dt-akses" name='dtakses' style="width: 100%;">
                                        <?php
                                        if (isset($selDtAkses)) {
                                            foreach ($dtUnitkerja as $unitkerja) :
                                                $space = "";
                                                if ($unitkerja['kelas_id'] == 2) {
                                                    $space = "&nbsp;&nbsp;&nbsp;&nbsp;|&rarr; ";
                                                } else if ($unitkerja['kelas_id'] == 3) {
                                                    $space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&rarr; ";
                                                } ?>
                                                <option value=<?= $unitkerja['id']; ?> <?= ($unitkerja['id'] == $selDtAkses) ? "selected" : ""; ?>><?= $space . $unitkerja['singkatan']; ?></option>
                                        <?php endforeach;
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
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
                                                <button type="submit" class="btn btn-info" name="cmdaksi" value="rekapitulasi">Tampilkan</button>
                                                <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <button type="submit" class="dropdown-item" name="cmdaksi" value="detail">Detail</button>
                                                    <button type="submit" class="dropdown-item" name="cmdaksi" value="rekapitulasi">Rekapitulasi</button>
                                                    <div class="dropdown-divider"></div>
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
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $dtRekapPresensi['persentaseKehadiran']; ?><sup style="font-size: 20px">%</sup></h3>
                            <p>Kehadiran</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $dtRekapPresensi['jmlTidakHadir']; ?><sup style="font-size: 20px">%</sup></h3>
                            <p>Izin Sakit/Cuti/Tidak Masuk</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-people"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= $dtRekapPresensi['jmlTanpaKeterangan']; ?><sup style="font-size: 20px">%</sup></h3>

                            <p>Alpha/Tanpa Kabar</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-people"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $dtRekapPresensi['jmlHadirSaatIni']; ?> <sup style="font-size: 20px">Petugas</sup></h3>
                            <p>Bertugas Saat Ini</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-people"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">DAFTAR <?= strtoupper($title); ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="def-table-1" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pegawai</th>
                                        <th>Tanggal</th>
                                        <th>Presensi</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Pulang</th>
                                        <th>Lama Bekerja</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    if (isset($dtPresensi)) {
                                        foreach ($dtPresensi as $row) {
                                            $rowId = $row['id'];
                                            $jenis = $row['jenis'];

                                            $cekTgl2 = substr($row['tanggal_2'], 0, 4);

                                            $explTgl1 = explode(' ', $row['tanggal_1']);
                                            $explTgl2 = explode(' ', $row['tanggal_2']);

                                            $ttlJam = "";
                                            if (($cekTgl2 != "0000") && ($cekTgl2 != "1900")) {
                                                $ttlJam = hitung_total_jam_to_string($row['tanggal_1'], $row['tanggal_2']);
                                            }
                                    ?>
                                            <tr>
                                                <td><?= $no; ?>.</td>
                                                <td><?= $row['petugas']; ?></td>
                                                <td><?= $explTgl1[0]; ?></td>
                                                <td><?= ($jenis == 1) ?  $row['presensi'] : "<span style='color:red;'>" . $row['presensi'] . "</span>"; ?></td>
                                                <td><?= $row['tanggal_1']; ?></td>
                                                <td><?= ($ttlJam == "") ? "" : $row['tanggal_2']; ?></td>
                                                <td><?= $ttlJam; ?></td>
                                                <td><?= $row['keterangan_1']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-xs" title="Info" onclick="getPresensiDetail('<?= $rowId; ?>')"> &nbsp; <i class="fa fa-info"> </i> &nbsp; </button>
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
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->