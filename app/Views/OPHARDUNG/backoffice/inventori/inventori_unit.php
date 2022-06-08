<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#" onclick="onClickPreviousButton('<?= $mitrakerja_id; ?>', '<?= $periode; ?>');"><i class="fas fa-arrow-circle-left"></i> Kembali</a></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">BUKU INVENTORI</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Mitra Kerja</label>
                                    <input type="text" class="form-control" value="<?= $dtMitraKerja['singkatan']; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <strong><i class="far fa-file-alt mr-1"></i> DATA INVENTARIS</strong>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="tabel-inventori" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Alat/Material</th>
                                            <th>Jumlah</th>
                                            <th>Kondisi</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        if (isset($dtInventori)) {
                                            foreach ($dtInventori as $row) {
                                                $rowId = $row['id'];
                                        ?>
                                                <tr>
                                                    <td><?= $no; ?>.</td>
                                                    <td><?= $row['produk']; ?></td>
                                                    <td><?= $row['jumlah']; ?></td>
                                                    <td><?= $row['kondisi']; ?></td>
                                                    <td><?= $row['keterangan']; ?></td>
                                                    <td>
                                                        <a href="<?php echo base_url('ophardung_inventaris_delete/' . $rowId); ?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data Alat/Material : <?php echo $row['produk']; ?> ?')">
                                                            <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-alt"></i> Hapus</button>
                                                        </a>
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
            </div>
        </div>
        <!-- /.container-fluid -->
</section>
<!-- /.content -->