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
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <input class="form-control" type="hidden" id="appName" value="<?= $appName; ?>" readonly>
                            <?php if ($dcUser['otoritas'] == "PEGAWAI") {
                                if (is_null($dtPresensiAktif)) { ?>
                                    <a href='/' class='btn btn-primary mt-1 float-right'><i class='fas fa-arrow-left'></i> Kembali</a>
                                <?php } else { ?>
                                    <a href="/pegawai_kegiatan_add" class="btn btn-success mt-1"><i class="fa fa-plus"></i> Kegiatan</a>
                                    <a href='/' class='btn btn-primary mt-1 float-right'><i class='fas fa-arrow-left'></i> Kembali</a>
                            <?php }
                            } ?>
                            <a href="<?php echo base_url('kegiatan/cetak'); ?>" class="btn btn-primary mt-1" style="display:none"><i class="fa fa-print"></i> Cetak Daftar Pekerjaan</a>
                            <?= view('templates/notification'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">DAFTAR TUGAS RUTIN/HARIAN</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tabel-kegiatan-rutin" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Kegiatan</th>
                                        <th>Lokasi</th>
                                        <th>Foto</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Petugas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    if (isset($dtKegiatan)) {
                                        foreach ($dtKegiatan as $row) {
                                            if ($row['jenis'] == "TUGAS RUTIN") {
                                                $rowId = $row['id'];
                                                $explTgl = explode(' ', $row['tanggal']); ?>
                                                <tr>
                                                    <td><?= $no; ?>.</td>
                                                    <td><?= $explTgl[0]; ?></td>
                                                    <td><?= $explTgl[1]; ?></td>
                                                    <td><?= $row['jenis']; ?></td>
                                                    <td><?= $row['lokasi']; ?></td>
                                                    <td><img src="<?= $pathFotoKegiatan . $row['foto']; ?>" alt="" class="tabel-img"></td>
                                                    <td><?= $row['keterangan']; ?></td>
                                                    <td><?= $row['kondisi']; ?></td>
                                                    <td><?= $row['petugas']; ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm" style="width: 40px;" onclick="detailKegiatan('<?php echo $rowId; ?>')"><i class="fa fa-info"></i></button>

                                                        <a href="<?php echo base_url('pegawai_kegiatan_edit/' . $rowId); ?>" data-toggle="tooltip" data-placement="top" title="Update Data">
                                                            <button type="button" class="btn btn-success btn-sm" style="width: 50px;"><i class="fa fa-edit"></i></button>
                                                        </a>

                                                        <a href="<?php echo base_url('pegawai_kegiatan_delete/' . $rowId); ?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data <?= $title; ?> ?')" style="display:none;">
                                                            <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-alt"></i></button>
                                                        </a>
                                                    </td>
                                                </tr>
                                    <?php
                                                $no++;
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">DAFTAR KEGIATAN LAIN / NON RUTIN</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tabel-kegiatan-lainnya" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Kegiatan</th>
                                        <th>Lokasi</th>
                                        <th>Foto</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Petugas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    if (isset($dtKegiatan)) {
                                        foreach ($dtKegiatan as $row) {
                                            if ($row['jenis'] != "TUGAS RUTIN") {
                                                $rowId = $row['id'];
                                                $explTgl = explode(' ', $row['tanggal']); ?>
                                                <tr>
                                                    <td><?= $no; ?>.</td>
                                                    <td><?= $explTgl[0]; ?></td>
                                                    <td><?= $explTgl[1]; ?></td>
                                                    <td><?= $row['jenis']; ?></td>
                                                    <td><?= $row['lokasi']; ?></td>
                                                    <td><img src="<?= $pathFotoKegiatan . $row['foto']; ?>" alt="" class="tabel-img"></td>
                                                    <td><?= $row['keterangan']; ?></td>
                                                    <td><?= $row['kondisi']; ?></td>
                                                    <td><?= $row['petugas']; ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm" style="width: 40px;" onclick="detailKegiatan('<?php echo $rowId; ?>')"><i class="fa fa-info"></i></button>

                                                        <a href="<?php echo base_url('pegawai_kegiatan_edit/' . $rowId); ?>" data-toggle="tooltip" data-placement="top" title="Update Data">
                                                            <button type="button" class="btn btn-success btn-sm" style="width: 50px;"><i class="fa fa-edit"></i></button>
                                                        </a>

                                                        <a href="<?php echo base_url('kegiatan/delete/' . $rowId); ?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data <?= $title; ?> ?')" style="display:none;">
                                                            <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-alt"></i></button>
                                                        </a>
                                                    </td>
                                                </tr>
                                    <?php
                                                $no++;
                                            }
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
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<?php
include 'mdldetail.php';
?>