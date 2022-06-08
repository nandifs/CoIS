<!-- Main content -->
<?php
$petugas = "";
$mitrakerja = "";
$tanggal = "";

if (isset($dtKegiatan)) {
    $petugas = $dtKegiatan[0]["petugas"];
    $mitrakerja = $dtKegiatan[0]["mitrakerja"];
    $tanggal = $dtKegiatan[0]["tanggal"];
}
?>
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
                <div class="card card-outline card-primary">
                    <div class="card-body pb-0">
                        <div class="form-group row">
                            <label for="tanggal" class="col-sm-3 col-form-label">Waktu Kegiatan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal Kegiatan" value="<?= strtoupper(waktu($tanggal)); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="petugas" class="col-sm-3 col-form-label">Petugas</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="petugas" name="petugas" value="<?= $petugas; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="unitkerja" class="col-sm-3 col-form-label">Unit Kerja</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="unitkerja" name="unitkerja" value="<?= $mitrakerja; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">DAFTAR KEGIATAN</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tbl-kegiatan" class="table table-bordered">
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
        <!-- /.container-fluid -->
</section>
<!-- /.content -->