<?php
$foto_pegawai = base_url("uploads/user/no_foto.png");

if (isset($dtTenagakerja)) {
    $pegawai_id = $dtTenagakerja->id;
    $nip = $dtTenagakerja->nip;
    $nama = $dtTenagakerja->nama;
    $jabatan = $dtTenagakerja->jabatan_id;
    $unitkerja = $dtTenagakerja->unitkerja_id;
    $penempatan = $dtTenagakerja->penempatan_id;
    $wilkerja = $dtTenagakerja->wilayah_id;

    $no_identitas = $dtTenagakerja->no_identitas;
    $tmp_lahir = $dtTenagakerja->tempat_lahir;
    $tgl_lahir = $dtTenagakerja->tanggal_lahir;
    $jns_kelamin = $dtTenagakerja->jenis_kelamin;
    $alamat = $dtTenagakerja->alamat;
    $telepon = $dtTenagakerja->telepon;
    $email = $dtTenagakerja->email;
    $nm_foto = $dtTenagakerja->foto;

    if ($nm_foto != "") {
        $path_foto = "uploads/user/foto";
        $foto_file = $path_foto . "/" . $nm_foto;
        if (file_exists($foto_file)) {
            $foto_pegawai = base_url($foto_file);
        }
    }
} else {
    $pegawai_id = "";
    $nip = "";
    $nama = "";
    $jabatan = "";
    $unitkerja = "";
    $penempatan = "";
    $wilkerja = "";

    $no_identitas = "";
    $tmp_lahir = "";
    $tgl_lahir = "";
    $jns_kelamin = "";
    $alamat = "";
    $telepon = "";
    $email = "";
}
?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary mt-2">
                    <div class="card-header">
                        <h3 class="card-title">Pembaruan Data Tenaga Kerja</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <?= form_open_multipart('/tenagakerja_update_detail', ['class' => 'form-horizontal']); ?>
                    <?= csrf_field(); ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group row">
                                    <label for="input1" class="col-sm-3 col-form-label">NIP</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" class="form-control" name="pegawai_id" required value="<?= $pegawai_id; ?>">
                                        <input type="text" class="form-control" name="nip" placeholder="No Induk Tenaga Kerja" autofocus required value="<?= $nip; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="input1" class="col-sm-3 col-form-label">Nama Tenaga kerja</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="nama" placeholder="Nama Tenaga kerja" required value="<?= $nama; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="input1" class="col-sm-3 col-form-label">Jabatan</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name='jabatan'>
                                            <?php foreach ($dtJabatan as $sjabatan) : ?>
                                                <option value=<?= $sjabatan['id']; ?> <?= ($jabatan == $sjabatan['id']) ? "selected" : ""; ?>><?= $sjabatan['jabatan']; ?></option>
                                            <?php endforeach;  ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="input1" class="col-sm-3 col-form-label">Unit Kerja</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name='unitkerja'>
                                            <?php foreach ($dtUnitKerja as $sunitkerja) : ?>
                                                <option value=<?= $sunitkerja['id']; ?> <?= ($unitkerja == $sunitkerja['id']) ? "selected" : ""; ?>><?= $sunitkerja['singkatan']; ?></option>
                                            <?php endforeach;  ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="input1" class="col-sm-3 col-form-label">Penempatan</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name='penempatan'>
                                            <?php foreach ($dtMitraKerja as $smitrakerja) : ?>
                                                <option value=<?= $smitrakerja['id']; ?> <?= ($penempatan == $smitrakerja['id']) ? "selected" : ""; ?>><?= $smitrakerja['singkatan']; ?></option>
                                            <?php endforeach;  ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="input1" class="col-sm-3 col-form-label">Wilayah Kerja</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name='wilkerja'>
                                            <?php foreach ($dtWilayahKerja as $swilkerja) : ?>
                                                <option value=<?= $swilkerja['id']; ?> <?= ($wilkerja == $swilkerja['id']) ? "selected" : ""; ?>><?= $swilkerja['wilayah']; ?></option>
                                            <?php endforeach;  ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="card card-outline card-warning">
                                    <div class="card-body">
                                        <img class="img-thumbnail pad" src="<?= $foto_pegawai; ?>" id="foto-preview" alt="Photo" style="width: 225px; height: 200px;">
                                        <input type="file" style="display:none;" class="form-control" name="foto_pegawai" id="file-foto" onchange="previewFoto()">
                                    </div>
                                    <div class="card-footer text-center">
                                        <label for="file-foto" class="btn btn-primary" style="margin-bottom: 0px;">Upload Foto</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-outline card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Detail Tenaga Kerja</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="input1" class="col-sm-3 col-form-label">No. KTP</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="no_identitas" placeholder="No indentitas kependudukan | Nomor KTP" required value="<?= $no_identitas; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input1" class="col-sm-3 col-form-label">Tempat/Tanggal Lahir</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="tmp_lahir" placeholder="Tempat Lahir" required value="<?= $tmp_lahir; ?>">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" name="tgl_lahir" placeholder="Tanggal Lahir (YYYY-MM-DD)" title="Format Tanggal: YYYY-MM-DD" required value="<?= $tgl_lahir; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input1" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                            <div class="col-sm-2">
                                                <select class="form-control" name='jns_kel'>
                                                    <option value="L" <?= ($jns_kelamin == "L") ? "selected" : ""; ?>>LAKI-LAKI</option>
                                                    <option value="P" <?= ($jns_kelamin == "P") ? "selected" : ""; ?>>PEREMPUAN</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input1" class="col-sm-3 col-form-label">Alamat</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="alamat" placeholder="Alamat Lengkap Tempat Tinggal" required value="<?= $alamat; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input1" class="col-sm-3 col-form-label">No. Telepon</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="telepon" placeholder="Gunakan tanda koma (,) jika nomor telpon lebih dari 1. Contoh: 022 - 727XXXXX, 08122XXXXXXX" required value="<?= $telepon; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input1" class="col-sm-3 col-form-label">Email</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="email" placeholder="Alamat email tenaga kerja" required value="<?= $email; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-outline card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Detail Kontrak</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="input1" class="col-sm-3 col-form-label">No. PKS</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="no_pks" placeholder="Nomor PKS dengan pengguna jasa">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input1" class="col-sm-3 col-form-label">No. PKWT</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="no_pkwt" placeholder="No. PKWT">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input1" class="col-sm-3 col-form-label">Kontrak Awal</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="tgl_kontrak_awal" placeholder="Tanggal Kontrak Awal">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input1" class="col-sm-3 col-form-label">Kontrak Akhir</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="tgl_kontrak_akhir" placeholder="Tanggal Kontrak Akhir">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-outline card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Riwayat Pekerjaan</h3>
                                    </div>
                                    <div class="card-body">
                                        <table id="tbl-riwayat-pekerjaan" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 30px;">No.</th>
                                                    <th>Jabatan</th>
                                                    <th>Unitkerja</th>
                                                    <th>Penempatan</th>
                                                    <th>Sifat</th>
                                                    <th>Tanggal Awal</th>
                                                    <th>Tanggal Akhir</th>
                                                    <th style="text-align: center;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1.</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-outline card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">UPAH (PAYROLL)</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="input1" class="col-sm-3 col-form-label">GAJI POKOK</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="gaji_pokok" placeholder="GAJI POKOK TENAGA KERJA" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input1" class="col-sm-3 col-form-label">TUNJANGAN I</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="tunjangan_1" placeholder="TUNJANGAN I">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input1" class="col-sm-3 col-form-label">TUNJANGAN II</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="tunjangan_2" placeholder="TUNJANGAN II">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input1" class="col-sm-3 col-form-label">TUNJANGAN III</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="tunjangan_3" placeholder="TUNJANGAN III">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input1" class="col-sm-3 col-form-label">TUNJANGAN LAINNYA</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="tunjangan_3" placeholder="TUNJANGAN LAINNYA">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-outline card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">BIAYA LAINNYA</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="input1" class="col-sm-2 col-form-label">NO. BPJS KETENAGAKERJAAN</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="no_bpjs_kt" placeholder="NOMOR KEPESERTAAN BPJS KETENAGAKERJAAN">
                                            </div>
                                            <div class="col-sm-2">
                                            </div>
                                            <label for="input1" class="col-sm-3 col-form-label text-right">PERSENTASI (%) DARI UPAH POKOK</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" name="persentase_bpjs_kt">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input1" class="col-sm-2 col-form-label">NO. BPJS KESEHATAN</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="no_bpjs_ks" placeholder="NOMOR KEPESERTAAN BPJS KESEHATAN">
                                            </div>
                                            <div class="col-sm-2">
                                            </div>
                                            <label for="input1" class="col-sm-3 col-form-label text-right">PERSENTASI (%) DARI UPAH POKOK</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" name="persentase_bpjs_kt">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input1" class="col-sm-2 col-form-label">NO. REKENING DPLK</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" name="no_rek_dlpk" placeholder="NOMOR REKENING DPLK">
                                            </div>
                                            <label for="input1" class="col-sm-1 col-form-label text-right">NAMA BANK</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="persentase_bpjs_kt" placeholder="NAMA BANK PENYETORAN DPLK">
                                            </div>
                                            <label for="input1" class="col-sm-3 col-form-label text-right">PERSENTASI (%) DARI UPAH POKOK</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" name="persentase_bpjs_kt">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-default" onclick="window.history.back()">Batal</button>
                            <button type="submit" class="btn btn-primary float-right mr-1">Simpan</button>
                        </div>
                        <!-- /.card-footer -->
                        <?= form_close(); ?>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->