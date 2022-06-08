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
                                    <th style="text-align: center;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($dtKontrak as $row) {
                                    $data_id = $row['id'];
                                ?>
                                    <tr>
                                        <td><?php echo $no; ?>.</td>
                                        <td><?php echo $row['status_kontrak']; ?></td>
                                        <td><?php echo $row['no_pks_p1']; ?></td>
                                        <td><?php echo $row['mitrakerja']; ?></td>
                                        <td><?php echo $row['uraian_pekerjaan']; ?></td>
                                        <td style="text-align: right;"><?php echo number_format($row['nilai_total_ppn'], 2); ?></td>
                                        <td><?php echo $row['tanggal_mulai']; ?></td>
                                        <td><?php echo $row['tanggal_akhir']; ?></td>
                                        <td style="text-align: center;"><?php echo $row['jumlah_tad']; ?></td>
                                        <td style="text-align: center; width: 160px;">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-success btn-sm" title="Edit" data-id="<?= $data_id; ?>" onclick="updateData(this);"><i class="fa fa-edit"></i> Edit</button>
                                                <button type="button" class="btn btn-danger btn-sm" title="Hapus" data-id="<?= $data_id; ?>" onclick="deleteData(this);"><i class=" fa fa-trash-alt"></i> Hapus</button>
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