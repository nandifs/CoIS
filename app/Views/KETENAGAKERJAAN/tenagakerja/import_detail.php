<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary mt-2">
                    <div class="card-body pb-0">
                        <?= form_open_multipart('/ketenagakerjaan_validasi_import_tenagakerja_xls', ['class' => 'form-horizontal']); ?>
                        <div class="form-group row">
                            <label for="imp_data" class="col-sm-1.1 col-form-label">Import Data : </label>
                            <div class="col-sm-3">
                                <select class="form-control" id='imp_data' name='imp_data'>
                                    <option value=1 selected>TENAGA KERJA</option>
                                    <option value=2>HAK NORMATIF</option>
                                    <option value=3>PAYROLL</option>
                                </select>
                            </div>

                            <label for="exampleInputFile" class="col-sm-1.1 col-form-label">Pilih file Excel : </label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="imp_file">
                                        <label class="custom-file-label" for="exampleInputFile">Klik disini untuk memilih file yang akan di import</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <button type="submit" class="btn btn-primary <?= ($dcUser["oid"] != 1) ? "d-none" : ""; ?>" data-toggle="modal" data-target="#modal-import">
                                            <i class="fa fa-file-export"></i> Proses Import
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?= form_close(); ?>
                        <?= view('templates/notification'); ?>
                    </div>
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">VALIDASI IMPORT DATA TENAGA KERJA</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body th-nowarp">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="th-nowarp text-center">
                                    <th style="width: 30px;">No.</th>
                                    <th>Status Import</th>
                                    <th>Validasi</th>
                                    <th>NO SPK</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Tempat & Tgl Lahir</th>
                                    <th>Jabatan</th>
                                    <th>Unit Kerja</th>
                                    <th>Penempatan</th>
                                    <th>Wilayah</th>
                                    <th>NO PKWT/PKWTT</th>
                                    <th>TGL AWAL</th>
                                    <th>TGL AKHIR</th>
                                    <th>LAINNYA</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($dtTenagakerjaTemp)) {
                                    $no = 1;
                                    foreach ($dtTenagakerjaTemp as $row) {
                                        $data_id = $row['id'];
                                        $status_import = $row["status_import"];
                                        if (strtoupper($status_import) == "IMPORT DATA") {
                                            $status_import = "<span style='color:green;'> $status_import </span>";
                                        } else {
                                            $status_import = "<span style='color:red; font-weight:bold;'> $status_import </span>";
                                        }

                                        $validasi = $row["validasi"];
                                        if (strtoupper($validasi) == "MENUNGGU KONFIRMASI") {
                                            $validasi = "<span style='color:#ffc107;'> $validasi </span>";
                                        } else {
                                            $validasi = "<span class='text-warning'> $validasi </span>";
                                        }

                                        $tgl_lahir = strtoupper(ubah_tgl_mti($row['tanggal_lahir'], "-"));
                                        $tgl_lahir =  ($tgl_lahir == "00/00/0000") ? "" : $tgl_lahir;
                                        $tmp_tgl_lahir = $row['tempat_lahir'] . ", " . $tgl_lahir;

                                        $tgl_awal = strtoupper(ubah_tgl_mti($row['tanggal_awal']));
                                        $tgl_awal =  ($tgl_awal == "00/00/0000") ? "" : $tgl_awal;

                                        $tgl_akhir = strtoupper(ubah_tgl_mti($row['tanggal_akhir']));
                                        $tgl_akhir =  ($tgl_akhir == "00/00/0000") ? "" : $tgl_akhir;
                                ?>
                                        <tr>
                                            <td><?= $no; ?>.</td>
                                            <td><?= $status_import; ?></td>
                                            <td><?= $validasi; ?></td>
                                            <td><?= $row['no_pks_p1']; ?></td>
                                            <td><?= $row['nip']; ?></td>
                                            <td><?= $row['nama']; ?></td>
                                            <td><?= $tmp_tgl_lahir; ?></td>
                                            <td><?= $row['jabatan']; ?></td>
                                            <td><?= $row['unitkerja']; ?></td>
                                            <td><?= $row['penempatan']; ?></td>
                                            <td><?= $row['wilayahkerja']; ?></td>
                                            <td><?= $row['no_pkwt']; ?></td>
                                            <td class="text-center"><?= $tgl_awal; ?></td>
                                            <td class="text-center"><?= $tgl_akhir; ?></td>
                                            <td class="text-center">...</td>
                                            <td><?= $row['keterangan']; ?></td>
                                        </tr>
                                <?php
                                        $no++;
                                    }
                                } else {
                                    echo "<tr><td colspan='11'></td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card card-outline card-warning mt-2 <?= (empty($dtTenagakerjaTemp)) ? "d-none" : ""; ?>">
                    <div class="card-body pb-0">
                        <?= form_open_multipart('/ketenagakerjaan_proses_import_tenagakerja_xls', ['class' => 'form-horizontal']); ?>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <div class="panel panel-default text-right">
                                    <div class="panel-body">
                                        Klik tombol KONFIRMASI untuk melanjutkan proses Import Data. &nbsp;&nbsp;&nbsp;
                                        <button type="submit" class="btn btn-primary <?= ($dcUser["oid"] != 1) ? "d-none" : ""; ?>">
                                            <i class="fa fa-check"></i> Konfirmasi Data
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
</section>
<!-- /.content -->