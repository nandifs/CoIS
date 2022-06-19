    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary mt-2">
                        <div class="card-body pb-0">
                            <?= form_open('/tenagakerja_add', ['class' => 'form-horizontal']); ?>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-2 col-form-label">Data Mitra Kerja</label>
                                <div class="col-sm-6">
                                    <select class="form-control select2" id="dt-akses" name='dtakses'>
                                        <?php foreach ($dtMitraKerja as $mitra) {
                                            $space = "";
                                            if ($mitra['kelas'] == 2) {
                                                $space = "&nbsp;&nbsp;&nbsp;&nbsp;|&rarr; ";
                                            } else if ($mitra['kelas'] == 3) {
                                                $space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&rarr; ";
                                            }
                                        ?>
                                            <?php if ($selMitraKerja == "") { ?>
                                                <option value=<?= $mitra['id']; ?> <?= ($mitra['id'] == 1) ? "selected" : ""; ?>><?= $space . $mitra['singkatan']; ?></option>
                                            <?php } else { ?>
                                                <option value=<?= $mitra['id']; ?> <?= ($mitra['id'] == $selMitraKerja) ? "selected" : ""; ?>><?= $space . $mitra['singkatan']; ?></option>
                                            <?php } ?>
                                        <?php
                                        }  ?>
                                    </select>
                                </div>
                                <div class="col-sm-5 d-none">
                                    <div class="panel panel-default float-right">
                                        <div class="panel-body">
                                            <button type="button" class="btn btn-warning <?= ($dcUser["oid"] != 1) ? "d-none" : ""; ?>" data-toggle="modal" data-target="#modal-import">
                                                <i class="fa fa-file-export"></i> Export Data Tenagakerja
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?= form_close(); ?>
                            <?= view('templates/notification'); ?>
                        </div>
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">DAFTAR TENAGA KERJA</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tbl-tenagakerja" class="table table-bordered display nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 30px;">NO</th>
                                        <th style="text-align: center;">Aksi</th>
                                        <th>STATUS</th>
                                        <th>NIP</th>
                                        <th>NAMA</th>
                                        <th>JABATAN</th>
                                        <th>UNIT KERJA</th>
                                        <th>PENEMPATAN</th>
                                        <th>WILAYAH</th>

                                        <th>NO PKS</th>
                                        <th>NO PKWT/PKWTT</th>
                                        <th>TGL AWAL</th>
                                        <th>TGL AKHIR</th>

                                        <th>NO IDENTITAS/KTP</th>
                                        <th>TMP LAHIR </th>
                                        <th>TGL LAHIR</th>
                                        <th>JNS KEL.</th>
                                        <th>AGAMA</th>
                                        <th>ALAMAT</th>
                                        <th>TELEPON</th>

                                        <th>BANK REK. PAYROL</th>
                                        <th>NO. REK. PAYROL</th>
                                        <th>NO. BPJS KT</th>
                                        <th>NO. BPJS KS</th>
                                        <th>BANK REK DPLK</th>
                                        <th>NO. REK DPLK</th>

                                        <th>NO. K. KELUARGA </th>
                                        <th>NAMA IBU KANDUNG</th>
                                        <th>NAMA PASANGAN</th>
                                        <th>NAMA ANAK KE 1</th>
                                        <th>NAMA ANAK KE 2</th>
                                        <th>NAMA ANAK KE 3</th>

                                        <th>PENDIDIKAN</th>
                                        <th>PROG. STUDI</th>
                                        <th>NO. SKK 1</th>
                                        <th>NO. SKK 2</th>

                                        <th>NO NPWP</th>

                                        <th>KETERANGAN</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

        <?php include "modal_import.php"; ?>
    </section>
    <!-- /.content -->