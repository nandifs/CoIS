<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary mt-2">
                    <div class="card-header">
                        <h3 class="card-title">DATA KONTRAK</h3>
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
                                    <th>NO</th>
                                    <th>STATUS</th>
                                    <th>NO PERJANJIAN/AMD</th>
                                    <th>NAMA CUSTOMER</th>
                                    <th>URAIAN PEKERJAAN</th>
                                    <th>NILAI KONTRAK</th>
                                    <th>TANGGAL MULAI</th>
                                    <th>TANGGAL AKHIR</th>
                                    <th>JML TAD</th>
                                    <th>RAB NORMATIF</th>
                                    <th>RAB ALAT/MATERIAL</th>
                                    <th style="text-align: center;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($dtKontrak as $row) {
                                    $data_id = $row['id'];
                                    $rab_normatif = ($row['rab_normatif'] == "") ? "Belum Ada" : $row['rab_normatif'];
                                    $rab_material = ($row['rab_material'] == "") ? "Belum Ada" : $row['rab_material'];
                                    $status_kontrak = $row["status_kontrak"];
                                    if ($row["status_id"] == "2") {
                                        $status_kontrak = "<span style='color:red; font-weight:bold;'> $status_kontrak </span>";
                                    } else {
                                        $status_kontrak = "<span style='color:green; font-weight:bold;'> $status_kontrak </span>";
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo $no; ?>.</td>
                                        <td><?php echo $status_kontrak; ?></td>
                                        <td><?php echo $row['no_pks_p1']; ?></td>
                                        <td><?php echo $row['mitrakerja']; ?></td>
                                        <td><?php echo $row['uraian_pekerjaan']; ?></td>
                                        <td style="text-align: right;"><?php echo number_format($row['nilai_total_ppn'], 2); ?></td>
                                        <td><?php echo $row['tanggal_mulai']; ?></td>
                                        <td><?php echo $row['tanggal_akhir']; ?></td>
                                        <td style="text-align: center;"><?php echo $row['jumlah_tad']; ?></td>
                                        <td style="text-align: center;"><?php echo $rab_normatif; ?></td>
                                        <td style="text-align: center;"><?php echo $rab_material; ?></td>
                                        <td style="text-align: center; width: 160px;">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info btn-sm btn-aksi" title="Detail" data-id="detail|<?= $data_id; ?>"><i class="fa fa-eye"></i></button>
                                                <button type="button" class="btn btn-success btn-sm btn-aksi" title="Update Data Kontrak" data-id="edit|<?= $data_id; ?>"><i class="fa fa-edit"></i></button>
                                                <button type="button" class="btn btn-danger btn-sm btn-aksi" title="Hapus" data-id="delete|<?= $data_id; ?>"><i class=" fa fa-trash-alt"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
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