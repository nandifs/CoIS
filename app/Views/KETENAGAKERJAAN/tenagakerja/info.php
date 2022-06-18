    <!-- Main content -->
    <?php
    $foto_pegawai = base_url("uploads/user/no_foto.png");
    if (isset($dtTenagakerja)) {
        $nip = $dtTenagakerja->nip;
        $nama = $dtTenagakerja->nama;
        $jabatan = $dtTenagakerja->jabatan;
        $unitkerja = $dtTenagakerja->unitkerja;
        $penempatan = $dtTenagakerja->penempatan;
        $wilkerja = $dtTenagakerja->wilayahkerja;

        $no_identitas = $dtTenagakerja->no_identitas;
        $tmp_lahir = $dtTenagakerja->tempat_lahir;
        $tgl_lahir = $dtTenagakerja->tanggal_lahir;
        $agama = $dtTenagakerja->agama;
        $jns_kelamin = ($dtTenagakerja->jenis_kelamin == "L") ? "LAKI-LAKI" : "PEREMPUAN";
        $alamat = $dtTenagakerja->alamat;
        $telepon = $dtTenagakerja->telepon;
        $email = $dtTenagakerja->email;
        $nm_foto = $dtTenagakerja->foto;

        $pendidikan = $dtTenagakerja->pendidikan_terakhir;
        $prog_studi = $dtTenagakerja->program_studi;

        $pendidikan =  ($pendidikan != "" && $prog_studi != "") ? $pendidikan . "/" . $prog_studi : $pendidikan;

        $no_pks = $dtTenagakerja->no_pks_p1;
        $uraian_pekerjaan = $dtTenagakerja->uraian_pekerjaan;
        $customer = $dtTenagakerja->customer;

        $no_pkwt = $dtTenagakerja->no_pkwt;
        $tgl_awal = $dtTenagakerja->tanggal_awal;
        $tgl_akhir = $dtTenagakerja->tanggal_lahir;

        $bank_rek_payroll = $dtTenagakerja->bank_rek_payroll;
        $no_rek_payroll = $dtTenagakerja->no_rek_payroll;
        $no_rek_dplk = $dtTenagakerja->no_rek_dplk;
        $bank_rek_dplk = $dtTenagakerja->bank_rek_dplk;

        $no_bpjs_kt = $dtTenagakerja->no_bpjs_kt;
        $no_bpjs_ks = $dtTenagakerja->no_bpjs_ks;

        $no_npwp = $dtTenagakerja->no_npwp;

        if ($nm_foto != "") {
            $path_foto = "uploads/user/foto";
            $foto_file = $path_foto . "/" . $nm_foto;
            if (file_exists($foto_file)) {
                $foto_pegawai = base_url($foto_file);
            }
        }
    } else {
        $nip = $nip_tk;
        $nama = "";
        $jabatan = "";
        $unitkerja = "";
        $penempatan = "";
        $wilkerja = "";

        $no_identitas = "";
        $tmp_lahir = "";
        $tgl_lahir = "";
        $agama = "";
        $jns_kelamin = "";
        $alamat = "";
        $telepon = "";
        $email = "";

        $pendidikan = "";

        $no_pks = "";
        $uraian_pekerjaan = "";
        $customer = "";

        $no_pkwt = "";
        $tgl_awal = "";
        $tgl_akhir = "";

        $bank_rek_payroll = "";
        $no_rek_payroll = "";
        $no_rek_dplk = "";
        $bank_rek_dplk = "";

        $no_bpjs_kt = "";
        $no_bpjs_ks = "";

        $no_npwp = "";
    }
    ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary mt-2">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Tenaga Kerja</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <?= view('templates/notification'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">NIP</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="nip" name="nip" placeholder="No Induk Tenaga Kerja" autofocus required value="<?= $nip; ?>">
                                                <span class="input-group-append">
                                                    <button type="submit" class="btn btn-info btn-update" data-id="cari" title="Cari data tenagakerja"><i class="fas fa-search"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">Nama Tenaga kerja</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="nama" placeholder="Nama tenaga kerja" value="<?= $nama; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">Jabatan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="jabatan" placeholder="Jabatan tenaga kerja" value="<?= $jabatan; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">Unit Kerja</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="unitkerja" placeholder="Nama unit Perusahaan tempat tenaga kerja ditempatkan" value="<?= $unitkerja; ?>" readonly title="Nama unit Perusahaan tempat tenaga kerja ditempatkan">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">Penempatan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="penempatan" placeholder="Nama unit Mitra Kerja tempat tenaga kerja ditempatkan" value="<?= $penempatan; ?>" readonly title="Nama unit Mitra Kerja tempat tenaga kerja ditempatkan">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input1" class="col-sm-3 col-form-label">Wilayah Kerja</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="wilkerja" placeholder="Wilayah penempatan tenaga kerja" value="<?= $wilkerja; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="card card-outline card-warning">
                                        <div class="card-body">
                                            <img class="img-thumbnail pad" src="<?= $foto_pegawai; ?>" alt="Photo" style="width: 225px; height: 200px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card card-outline card-warning">
                                        <div class="card-body row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-primary btn-block btn-update" data-id="add"><i class="fas fa-file"></i> &nbsp;&nbsp;Tambah Data Tenagakerja</button>
                                                <button type="button" class="btn btn-success btn-block btn-update" data-id="edit"><i class="fa fa-edit"></i> &nbsp;&nbsp;Edit Data Tenagakerja&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                                                <button type="button" class="btn btn-danger btn-block btn-update" data-id="delete"><i class="fa fa-trash"></i> &nbsp;&nbsp;Hapus Data Tenagakerja&nbsp;&nbsp;</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-outline card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">Biodata Tenaga Kerja</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">No. KTP</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="no_identitas" placeholder="No indentitas kependudukan | Nomor KTP" value="<?= $no_identitas; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">Tempat/Tgl Lahir</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" name="tmp_lahir" placeholder="Tempat Lahir" value="<?= $tmp_lahir; ?>" readonly>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" name="tgl_lahir" placeholder="Tanggal Lahir (YYYY-MM-DD)" value="<?= $tgl_lahir; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">Agama</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="agama" placeholder="Agama" value="<?= $agama; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="jns_kel" placeholder="Jenis kelamin" value="<?= $jns_kelamin; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">Pendidikan Terakhir</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="pddk_terakhir" placeholder="Pendidikan Terakhir" value="<?= $pendidikan; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">Alamat</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="jns_kel" placeholder="Alamat Lengkap Tempat Tinggal" value="<?= $alamat; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">No. Telepon</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="jns_kel" placeholder="Nomor Telepon | Gunakan tanda koma (,) jika nomor telpon lebih dari 1. Contoh: 022 - 727XXXXX, 08122XXXXXXX" value="<?= $telepon; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">Email</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="email" placeholder="Alamat email tenaga kerja" value="<?= $email; ?>" readonly>
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
                                            <h3 class="card-title">Detail Kontrak Pekerjaan</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">No. SPK</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="no_pks" placeholder="Nomor PKS dengan pengguna jasa" value="<?= $no_pks; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">Uraian Pekerjaan</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="pks_uraian_pekerjaan" placeholder="Uraian Pekerjaan" value="<?= $uraian_pekerjaan; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">Pengguna Jasa / Customer</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="customer" placeholder="Pengguna Jasa" value="<?= $customer; ?>" readonly>
                                                </div>
                                            </div>
                                            <hr style="background-color:gray;" />
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">No. PKWT</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="no_pkwt" placeholder="No. PKWT" value="<?= $no_pkwt; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">Tanggal PWKT / PKWTT Awal</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="tgl_kontrak_awal" placeholder="Tanggal PWKT/PKWTT Awal" value="<?= $tgl_awal; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">Tanggal PWKT / PKWTT Akhir</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="tgl_kontrak_akhir" placeholder="Tanggal PWKT/PKWTT Akhir" value="<?= $tgl_akhir; ?>" readonly>
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
                                            <h3 class="card-title">UPAH (PAYROLL)</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">REKENING PAYROLL (BANK)</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" name="payroll_bank" placeholder="NAMA BANK PENYETORAN PAYROLL" value="<?= $bank_rek_payroll; ?>" readonly>
                                                </div>
                                                <label for="input1" class="col-sm-2 col-form-label text-right">NOMOR REKENING</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" name="payroll_norekening" placeholder="NO REKENING BANK" value="<?= $no_rek_payroll; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">GAJI POKOK</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="gaji_pokok" placeholder="GAJI POKOK TENAGA KERJA (UMR/UMP/UMK)" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">TUNJANGAN MASA KERJA</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" name="tunjangan_1" placeholder="TUNJANGAN MASA KERJA" readonly>
                                                </div>
                                                <label for="input1" class="col-sm-2 col-form-label text-right">TUNJANGAN MAKAN</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" name="tunjangan_2" placeholder="TUNJANGAN MAKAN" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">TUNJANGAN KOMPENTENSI/KEAHLIAN</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" name="tunjangan_3" placeholder="TUNJANGAN KOMPENTENSI/KEAHLIAN" readonly>
                                                </div>
                                                <label for="input1" class="col-sm-2 col-form-label text-right">TUNJANGAN TRANSPORT</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" name="tunjangan_4" placeholder="TUNJANGAN TRANSPORT" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-3 col-form-label">TUNJANGAN LAINNYA</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="tunjangan_5" placeholder="TUNJANGAN LAINNYA" readonly>
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
                                                <label for="input1" class="col-sm-2 col-form-label">TUNJANGAN HARI RAYA</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="tunjangan_thr" placeholder="TUNJANGAN HARI RAYA" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-2 col-form-label">NO. BPJS KT</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" name="no_bpjs_kt" title="Nomor Kepesertaan BPJS Ketenagakerjaan" placeholder="NOMOR KEPESERTAAN BPJS KETENAGAKERJAAN" value="<?= $no_bpjs_kt; ?>" readonly>
                                                </div>
                                                <label for="input1" class="col-sm-1 col-form-label text-right">JUMLAH</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" name="persentase_bpjs_kt" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-2 col-form-label">NO. BPJS KS</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" name="no_bpjs_ks" title="Nomor Kepesertaan BPJS Kesehatan" placeholder="NOMOR KEPESERTAAN BPJS KESEHATAN" value="<?= $no_bpjs_ks; ?>" readonly>
                                                </div>
                                                <label for="input1" class="col-sm-1 col-form-label text-right">JUMLAH</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" name="persentase_bpjs_kt" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-2 col-form-label">REKENING DPLK (BANK)</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" name="bank_dplk" placeholder="NAMA BANK PENYETORAN DPLK" value="<?= $bank_rek_dplk; ?>" readonly>
                                                </div>
                                                <label for="input1" class="col-sm-1 col-form-label text-right" style="padding-left: 0px ;">NO. REK.</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" name="no_rek_dlpk" placeholder="NOMOR REKENING DPLK" readonly>
                                                </div>
                                                <label for="input1" class="col-sm-1 col-form-label text-right">JUMLAH</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" name="persentase_dplk" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input1" class="col-sm-2 col-form-label">NO. NPWP</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="no_npwp" placeholder="NOMOR NPWP" value="<?= $no_npwp; ?>" readonly>
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
                                                        <th>No Kontrak/PKWT</th>
                                                        <th>Tanggal Awal</th>
                                                        <th>Tanggal Akhir</th>
                                                        <th style="text-align: center;">Status</th>
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
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-default" onclick="window.history.back()">Batal</button>
                            <button type="button" class="btn btn-primary float-right mr-1">Cetak Data Tenagakerja</button>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->