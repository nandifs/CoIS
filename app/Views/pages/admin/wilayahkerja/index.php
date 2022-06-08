    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary mt-2">
                        <div class="card-body">
                            <button type="button" class="btn btn-primary" data-id="new" onclick="updateData(this);"><i class="fa fa-plus"></i> Data Wilayah Kerja</button>
                        </div>
                    </div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">DAFTAR <?= strtoupper($title); ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="def-table-1" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width:60px;">No.</th>
                                        <th>Nama Wilayah</th>
                                        <th>Nama Singkat</th>
                                        <th style="text-align: center;">WILAYAH</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($mitker as $row) {
                                        $data_id = $row['id'];
                                    ?>
                                        <tr>
                                            <td><?= $no; ?>.</td>
                                            <td><?= $row['wilayah']; ?></td>
                                            <td><?= $row['singkatan']; ?></td>
                                            <td style="text-align: center;"><?= $row['kode']; ?></td>
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
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <?= view('pages/modal/modal_update'); ?>