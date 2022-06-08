<hr>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <?php if ($dcUser['otoritas'] == "TENAGAKERJA") : ?>
                            <a href="/satpam_inspeksi_add" class="btn btn-primary mt-1"><i class="fa fa-plus"></i> Inspeksi Rutin</a>
                            <a href="/satpam_kegiatan_add" class="btn btn-warning mt-1 float-right"><i class="fa fa-plus"></i> Kegiatan/Kejadian</a>
                        <?php endif ?>
                        <a href="<?php echo base_url('kegiatan/cetak'); ?>" class="btn btn-primary mt-1" style="display:none"><i class="fa fa-print"></i> Cetak Daftar Pengawasan</a>
                        <?= view('templates/notification'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">DAFTAR INSPEKSI RUTIN</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabel-inspeksi" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Kegiatan</th>
                                    <th>Titik Kontrol</th>
                                    <th>Foto</th>
                                    <th>Kondisi</th>
                                    <th>Keterangan</th>
                                    <th>Petugas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                if (isset($dtKegiatan)) {
                                    foreach ($dtKegiatan as $row) {
                                        if ($row['jenis'] == "INSPEKSI") {
                                            $rowId = $row['id'];
                                            $explTgl = explode(' ', $row['tanggal']); ?>
                                            <tr>
                                                <td><?= $no; ?>.</td>
                                                <td><?= $explTgl[0]; ?></td>
                                                <td><?= $explTgl[1]; ?></td>
                                                <td><?= $row['jenis']; ?></td>
                                                <td><?= $row['lokasi']; ?></td>

                                                <td><img src="<?= $pathFotoKegiatan . $row['foto']; ?>" alt="" class="tabel-img"></td>
                                                <td><?= $row['kondisi']; ?></td>
                                                <td><?= $row['keterangan']; ?></td>
                                                <td><?= $row['petugas']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-info btn-xs" style="width:25px;" onclick="detailInspeksi('<?php echo $rowId; ?>')"><i class="fa fa-info"></i></button>

                                                    <a href="<?php echo base_url('inspeksi/delete/' . $rowId); ?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data <?= $title; ?> ?')" style="display:none;">
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
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">DAFTAR KEGIATAN KONDISI KRITIKAL</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabel-kritikal" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Kegiatan</th>
                                    <th>Lokasi</th>
                                    <th>Foto</th>
                                    <th>Kondisi</th>
                                    <th>Keterangan</th>
                                    <th>Petugas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                if (isset($dtKegiatan)) {
                                    foreach ($dtKegiatan as $rownr) {
                                        if ($rownr['kondisi'] == "KRITIKAL") {
                                            $rowNrId = $rownr['id'];
                                            $explTgl = explode(' ', $rownr['tanggal']); ?>
                                            <tr>
                                                <td><?= $no; ?>.</td>
                                                <td><?= $explTgl[0]; ?></td>
                                                <td><?= $explTgl[1]; ?></td>
                                                <td><?= $rownr['jenis']; ?></td>
                                                <td><?= $rownr['lokasi']; ?></td>
                                                <td><img src="<?= $pathFotoKegiatan . $rownr['foto']; ?>" alt="" class="tabel-img"></td>
                                                <td><?= $rownr['kondisi']; ?></td>
                                                <td><?= $rownr['keterangan']; ?></td>
                                                <td><?= $rownr['petugas']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-info btn-xs" style="width:25px;" onclick="detailInspeksiNR('<?php echo $rowNrId; ?>')"><i class="fa fa-info"></i></button>

                                                    <a href="<?php echo base_url('pengawasan/delete_nr/' . $rowNrId); ?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data <?= $title; ?> ?')" style="display:none;">
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
                        <h3 class="card-title">DAFTAR KEGIATAN/KEJADIAN</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabel-kegiatan" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Kegiatan</th>
                                    <th>Lokasi</th>
                                    <th>Foto</th>
                                    <th>Kondisi</th>
                                    <th>Keterangan</th>
                                    <th>Petugas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                if (isset($dtKegiatan)) {
                                    foreach ($dtKegiatan as $row) {
                                        $rowId = $row['id'];
                                        $explTgl = explode(' ', $row['tanggal']); ?>
                                        <tr>
                                            <td><?= $no; ?>.</td>
                                            <td><?= $explTgl[0]; ?></td>
                                            <td><?= $explTgl[1]; ?></td>
                                            <td><?= $row['jenis']; ?></td>
                                            <td><?= $row['lokasi']; ?></td>
                                            <td><img src="<?= $pathFotoKegiatan . $row['foto']; ?>" alt="" class="tabel-img"></td>
                                            <td><?= $row['kondisi']; ?></td>
                                            <td><?= $row['keterangan']; ?></td>
                                            <td><?= $row['petugas']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-xs" style="width:25px;" onclick="detailInspeksi('<?php echo $rowId; ?>')"><i class="fa fa-info"></i></button>

                                                <a href="<?php echo base_url('kegiatan/delete/' . $rowId); ?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data <?= $title; ?> ?')" style="display:none;">
                                                    <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-alt"></i></button>
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
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

<?php
include 'mdldetail.php';
?>