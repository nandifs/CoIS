    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <a href="<?php echo base_url('jabatan_add'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Jabatan</a>
                            <?= view('templates/notification'); ?>
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
                                        <th>No.</th>
                                        <th>Jabatan</th>
                                        <th>Nama Singkat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($dt_jabatan as $row) {
                                        $data_id = $row['id'];
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?>.</td>
                                            <td><?php echo $row['jabatan']; ?></td>
                                            <td><?php echo $row['singkatan']; ?></td>
                                            <td style="width: 200px;">
                                                <a href="<?php echo base_url('jabatan_edit/' . $data_id); ?>" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <button type="button" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Edit</button>
                                                </a>
                                                <a href="<?php echo base_url('jabatan_delete/' . $data_id); ?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data <?= $title; ?> : <?php echo $row['jabatan']; ?> ?')">
                                                    <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash-alt"></i> Hapus</button>
                                                </a>
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