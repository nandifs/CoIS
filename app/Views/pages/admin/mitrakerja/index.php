    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary mt-2">
                        <div class="card-body">
                            <button type="button" class="btn btn-primary" data-id="new" onclick="updateData(this);"><i class="fa fa-plus"></i> Data Mitra Kerja</button>
                        </div>
                    </div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">DAFTAR <?= strtoupper($title); ?>/PENGGUNA JASA</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="def-table-1" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Unit Kerja</th>
                                        <th>Mitra Kerja</th>
                                        <th>Nama Singkat</th>
                                        <th>Kelas Unit</th>
                                        <th>Unit Induk</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($dtMitker as $row) {
                                        $data_id = $row['id'];

                                        $kelas_unit = "-";
                                        if ($row['kelas'] == 1) {
                                            $kelas_unit = "PUSAT/UTAMA";
                                        } else if ($row['kelas'] == 2) {
                                            $kelas_unit = "CABANG";
                                        } else if ($row['kelas'] == 3) {
                                            $kelas_unit = "RANTING";
                                        }
                                    ?>
                                        <tr>
                                            <td><?= $no; ?>.</td>
                                            <td><?= $row['unitkerja']; ?></td>
                                            <td><?= $row['mitrakerja']; ?></td>
                                            <td><?= $row['singkatan']; ?></td>
                                            <td><?= $kelas_unit; ?></td>
                                            <td><?= ($row['kelas'] == 1) ? "-" : $row['mitra_induk']; ?></td>
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