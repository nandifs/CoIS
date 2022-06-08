<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary mt-2">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-id="new" onclick="updateData(this);"><i class="fa fa-plus"></i> Data UMR/UMK</button>
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
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Wilayah</th>
                                    <th class="text-center">Jenis</th>
                                    <th class="text-center">Tahun</th>
                                    <th class="text-center">Upah</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($dtUpahRegional as $row) {
                                    $data_id = $row['id'];
                                ?>
                                    <tr>
                                        <td><?= $no; ?>.</td>
                                        <td><?= $row['wilayah']; ?></td>
                                        <td class="text-center"><?= $row['jenis']; ?></td>
                                        <td class="text-center"><?= $row['tahun']; ?></td>
                                        <td class="text-right"><?= number_format($row['upah'], 2); ?></td>
                                        <td class="text-center" style="width: 160px;">
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
<?php //= view('pages/modal/modal_update'); 
?>