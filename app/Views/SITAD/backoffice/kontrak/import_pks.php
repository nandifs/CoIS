<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary mt-2">
                    <div class="card-body pb-0">
                        <?= form_open_multipart('/kontrak_pks_validasi_import_xls', ['class' => 'form-horizontal']); ?>
                        <div class="form-group row">
                            <label for="exampleInputFile" class="col-sm-1 col-form-label">Import Data : </label>
                            <div class="col-sm-3">
                                <select class="form-control" id='imp_data' name='imp_data'>
                                    <option value=1 selected>KONTRAK/SPK</option>
                                    <option value=2>AMENDEMEN</option>
                                    <option value=3>RAB NORMATIF</option>
                                    <option value=4>RAB ALAT/MATERIAL</option>
                                </select>
                            </div>

                            <label for="exampleInputFile" class="col-sm-1 col-form-label">Pilih file Excel : </label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="imp_file">
                                        <label class="custom-file-label" for="exampleInputFile">Klik disini untuk memilih file yang akan di import</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-primary <?= ($dcUser["oid"] != 1) ? "d-none" : ""; ?>">
                                    <i class="fa fa-file-export"></i> Validasi Data
                                </button>
                            </div>
                        </div>
                        <?= form_close(); ?>
                        <?= view('templates/notification'); ?>
                    </div>
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">IMPORT DATA KONTRAK/SPK</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body th-nowarp">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="th-nowarp">
                                    <th>NO</th>
                                    <th>STS IMPORT</th>
                                    <th>VALIDASI DATA</th>
                                    <th>STATUS KONTRAK</th>
                                    <th>JENIS KONTRAK</th>
                                    <th>NO KONTRAK/PERJANJIAN</th>
                                    <th>NAMA UNIT PERUSAHAAN</th>
                                    <th>NAMA UNIT PENGGUNA JASA/CUSTOMER</th>
                                    <th>URAIAN PEKERJAAN</th>
                                    <th>KATEGORI PEKERJAAN</th>
                                    <th>JENIS PEKERJAAN</th>
                                    <th>SUB JENIS PEKERJAAN</th>
                                    <th>NILAI KONTRAK</th>
                                    <th>TANGGAL MULAI SPK</th>
                                    <th>TANGGAL AKHIR SPK</th>
                                    <th>JUMLAH TAD</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($dtKontrak)) {
                                    $no = 1;
                                    foreach ($dtKontrak as $row) {
                                        $data_id = $row['id'];
                                        $jns_kontrak = $row['jenis_kontrak'];

                                        $status_import = $row["status_import"];
                                        if (strtoupper($status_import) == "ON VALIDATION") {
                                            $status_import = "<span style='color:red;'> $status_import </span>";
                                        } else {
                                            $status_import = "<span style='color:green; font-weight:bold;'> $status_import </span>";
                                        }

                                        $validasi = $row["validasi"];
                                        if (strtoupper($validasi) == "UPDATE DATA") {
                                            $validasi = "<span style='color:#ffc107;'> $validasi </span>";
                                        } else {
                                            $validasi = "<span style='color:#0275d8 ; font-weight:bold;'> $validasi </span>";
                                        }

                                        $status_kontrak = $row["status_kontrak"];
                                        if ($row["status_id"] == "2") {
                                            $status_kontrak = "<span style='color:red; font-weight:bold;'> $status_kontrak </span>";
                                        } else {
                                            $status_kontrak = "<span style='color:#5cb85c; font-weight:bold;'> $status_kontrak </span>";
                                        }

                                ?>
                                        <tr>
                                            <td><?php echo $no; ?>.</td>
                                            <td><?php echo $status_import; ?></td>
                                            <td><?php echo $validasi; ?></td>

                                            <td class="text-center"><?php echo $status_kontrak; ?></td>
                                            <td class="text-center"><?php echo $jns_kontrak; ?></td>

                                            <td><?php echo $row['no_pks_p1']; ?></td>
                                            <td><?php echo $row['unitkerja']; ?></td>
                                            <td><?php echo $row['mitrakerja']; ?></td>
                                            <td><?php echo $row['uraian_pekerjaan']; ?></td>

                                            <td><?php echo $row['kategori']; ?></td>
                                            <td><?php echo $row['jenis_pekerjaan']; ?></td>
                                            <td><?php echo $row['sub_jenis_pekerjaan']; ?></td>

                                            <td style="text-align: right;"><?php echo number_format($row['nilai_total_ppn'], 2); ?></td>

                                            <td><?php echo $row['tanggal_mulai']; ?></td>
                                            <td><?php echo $row['tanggal_akhir']; ?></td>

                                            <td style="text-align: center;"><?php echo $row['jumlah_tad']; ?></td>
                                        </tr>
                                <?php
                                        $no++;
                                    }
                                } else {
                                    echo "<tr><td colspan='16'></td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card card-outline card-warning mt-2 <?= (empty($dtKontrak)) ? "d-none" : ""; ?>">
                    <div class="card-body pb-0">
                        <?= form_open_multipart('/kontrak_pks_proses_import_xls', ['class' => 'form-horizontal']); ?>
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