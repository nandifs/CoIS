<?php
if (is_null($dt_mutasi)) {
    $tanggal = "";
    $shift = "";
    $jam_dinas = "";
} else {

    $tgl_mutasi = $dt_mutasi['tanggal'];

    $tanggal = waktu($tgl_mutasi); //Set format tanggal
    $shift = $dt_mutasi['shift'];
    $jam_dinas = $dt_mutasi['jam_dinas'];
}
?>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <a href="/laporan_bukumutasi/<?= $dt_mutasi['mitrakerja_id']; ?>" class="btn btn-danger btn-flat"><i class="fa fa-arrow-left"></i> Kembali</a>
                        <a href="/bukumutasi/cetak" class="btn btn-primary mt-1 float-right"><i class="fa fa-print"></i> Cetak</a>
                        <?= view('templates/notification'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">BUKU MUTASI / LAPORAN HARIAN</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Hari, Tanggal</label>
                                    <input type="text" class="form-control" value="<?= $tanggal ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Shift</label>
                                    <input type="text" class="form-control" value="<?= $shift ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Jam Dinas</label>
                                    <input type="text" class="form-control" value="<?= $jam_dinas ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Unit Mitra Kerja</label>
                                    <input type="text" class="form-control" value="<?= $dt_mutasi['mitrakerja']; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <strong><i class="far fa-file-alt mr-1"></i> <span style="color: blue;">PETUGAS</span></strong>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="tblpetugas" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Petugas</th>
                                            <th>Jabatan</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        if (isset($dt_petugas_piket)) {
                                            foreach ($dt_petugas_piket as $row) {
                                                $rowId = $row['id'];
                                        ?>
                                                <tr>
                                                    <td><?= $no; ?>.</td>
                                                    <td><?= $row['nama']; ?></td>
                                                    <td><?= $row['jabatan']; ?></td>
                                                    <td><?= $row['keterangan']; ?></td>
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

                        <hr>
                        <div>
                            <strong><i class="far fa-file-alt mr-1"></i> <span style="color: blue;">INVENTARIS</span></strong>
                        </div>
                        <hr>
                        <table id="tblinventaris" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Kondisi</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                if (isset($dt_inventaris)) {
                                    foreach ($dt_inventaris as $row) {
                                        $rowId = $row['id'];
                                ?>
                                        <tr>
                                            <td><?= $no; ?>.</td>
                                            <td><?= $row['barang']; ?></td>
                                            <td><?= $row['jumlah']; ?></td>
                                            <td><?= $row['kondisi']; ?></td>
                                            <td><?= $row['keterangan']; ?></td>
                                        </tr>
                                <?php
                                        $no++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <hr>
                        <strong><i class="far fa-file-alt mr-1"></i> <span style="color: blue;">LAPORAN KEGIATAN/KEJADIAN</span></strong>
                        <hr>
                        <table id="tblkegiatan" class="table table-bordered">
                            <thead>
                                <tr>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal, Jam</th>
                                    <th>Kegiatan</th>
                                    <th>Lokasi</th>
                                    <th>Foto</th>
                                    <th>Kondisi</th>
                                    <th>Keterangan</th>
                                    <th>Petugas</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                if (isset($dt_kegiatan)) {
                                    foreach ($dt_kegiatan as $row) {
                                        $rowId = $row['id']; ?>
                                        <tr>
                                            <td><?= $no; ?>.</td>
                                            <td><?= $row['tanggal']; ?></td>
                                            <td><?= $row['jenis']; ?></td>
                                            <td><?= $row['lokasi']; ?></td>
                                            <td><img src="<?= base_url($pathFotoKegiatan . $row['foto']); ?>" alt="" class="tabel-img"></td>
                                            <td><?= $row['kondisi']; ?></td>
                                            <td><?= $row['keterangan']; ?></td>
                                            <td><?= $row['petugas']; ?></td>
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