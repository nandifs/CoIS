<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?= strtoupper($title); ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?php
            if (is_null($dtPresensiAktif)) { ?>
                <div class="callout callout-danger">
                    <h5>PERHATIAN !</h5>

                    <p>Anda belum mengisi absensi.</p>
                </div>
                <a href="/" class="btn btn-danger btn-flat"><i class="fa fa-close"></i> Kembali Ke Dashbord</a>
            <?php } else { ?>
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
                                            <label>Penempatan</label>
                                            <input type="text" class="form-control" value="<?= $dtTenagakerja['penempatan']; ?>" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="petugas">Petugas</label>
                                            <input type="text" class="form-control" name="petugas" value="<?= $dtTenagakerja['nama']; ?>" required readonly>
                                            <input type="hidden" name="petugas_id" value="<?= $dtTenagakerja['id']; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div>
                                    <strong><i class="far fa-file-alt mr-1"></i> <span style="color: blue;">DATA INVENTARIS</span></strong>
                                    <?php if ($dcUser["otoritas"] == "TENAGAKERJA") : ?>
                                        <button type="button" class="btn btn-default float-right" style="margin-top: -5px;" data-toggle="modal" data-target="#modal-add-inventaris" title="Tambah/Edit Data">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    <?php endif ?>
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
            <?php } ?>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<?php
include 'add.php';
?>