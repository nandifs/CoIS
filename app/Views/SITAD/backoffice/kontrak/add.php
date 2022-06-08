    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary mt-2">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Data Tenaga Kerja</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?= form_open('/kontrak_save', ['class' => 'form-horizontal']); ?>
                        <?= csrf_field(); ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>NO KONTRAK PEKERJAAN</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="no-spk" value=<?= $dtKontrak["no_p1"] ?> readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?= view('templates/notification') ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class='table table-condensed table-bordered'>
                                        <tbody>
                                            <tr>
                                                <th scope='row' width='200px'>No Internal Order (IO)</th>
                                                <td scope='row' style="vertical-align: middle;" id="no-io"><?= $dtKontrak["no_io"] ?></td>
                                            </tr>
                                            <tr>
                                                <th scope='row'>Uraian Pekerjaan</th>
                                                <td scope='row' style="vertical-align: middle;" id="uraian-pekerjaan"><?= $dtKontrak["uraian_pekerjaan"] ?></td>
                                            </tr>
                                            <tr>
                                                <th scope='row'>Nama Cabang</th>
                                                <td scope='row' style="vertical-align: middle;" id="nama-cabang"><?= $dtKontrak["cabang"] ?></td>
                                            </tr>
                                            <tr>
                                                <th scope='row'>No. SPK Cutomer</th>
                                                <td scope='row' style="vertical-align: middle;" id="no-spk-p2"><?= $dtKontrak["no_p2"] ?></td>
                                            </tr>
                                            <tr>
                                                <th scope='row'>Nama Customer</th>
                                                <td scope='row' style="vertical-align: middle;" id="nama-customer"><?= $dtKontrak["mitrakerja"] ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class='table table-condensed table-bordered'>
                                        <tbody>
                                            <tr>
                                                <th scope='row' width='200px'>Jenis Pekerjaan</th>
                                                <td scope='row' style="vertical-align: middle;" id="no-io"><?= $dtKontrak["jenis_pekerjaan"] ?></td>
                                            </tr>
                                            <tr>
                                                <th scope='row'>Sub Jenis Pekerjaan</th>
                                                <td scope='row' style="vertical-align: middle;" id="uraian-pekerjaan"><?= $dtKontrak["sub_jenis_pekerjaan"] ?></td>
                                            </tr>
                                            <tr>
                                                <th scope='row'>Awal Kontrak</th>
                                                <td scope='row' style="vertical-align: middle;" id="nama-cabang"><?= $tgl_awal ?></td>
                                            </tr>
                                            <tr>
                                                <th scope='row'>Berakhir Kontrak</th>
                                                <td scope='row' style="vertical-align: middle;" id="no-spk-p2"><?= $tgl_akhir ?></td>
                                            </tr>
                                            <tr>
                                                <th scope='row'>Status Kontrak</th>
                                                <td scope='row' style="vertical-align: middle;" id="no-spk-p2"><?= $status_kontrak ?></td>
                                            </tr>

                                            <tr>
                                                <th scope='row'>RAB</th>
                                                <td scope='row' style="vertical-align: middle;" id="no-spk-p2">
                                                    <?php
                                                    if ((int)$dtKontrak["nrab"] == 0) {
                                                    ?>
                                                        <a href="/kontrak/rab_detail/<?= $dtKontrak["id"] ?>">
                                                            <button type="button" class="btn btn-danger"><i class="fa fa-clipboard-list"></i> Belum Ada</button>
                                                        </a>
                                                    <?php } else { ?>
                                                        <a href="/kontrak/rab_detail/<?= $dtKontrak["id"] ?>">
                                                            <button type="button" class="btn btn-success"><i class="fa fa-clipboard-list"></i> Tampilkan</button>
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="/kontrak/kontrak_edit/<?= $dtKontrak["id"] ?>">
                                    <button type="button" class="btn btn-primary float-right"><i class="fa fa-edit"></i> UPDATE DATA KONTRAK</button>
                                </a>
                            </div>
                            <hr>
                            <!-- /.card-footer-->
                            <div class="row <?= ($jmlSubKontrak <= 0) ? 'd-none' : ''; ?>">
                                <div class="col-md-12">
                                    <div class="card card-outline card-success">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="far fa-file-alt mr-1"></i> SUB KONTRAK</h3>
                                        </div>
                                        <div class="card-body">
                                            <table id="tblDefault" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>STATUS</th>
                                                        <th>SUB CUSTOMER</th>
                                                        <th>NO. SUB KONTRAK</th>
                                                        <th>URAIAN PEKERJAAN</th>
                                                        <th>RAB SUB KONTRAK</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    if (isset($dtSubKontrak)) {
                                                        foreach ($dtSubKontrak as $row) {
                                                            $rowId = $row['id']; ?>
                                                            <tr>
                                                                <td><?= $no ?>.</td>
                                                                <td><?= $row['status'] ?></td>
                                                                <td nowrap><?= $row['submitrakerja'] ?></td>
                                                                <td nowrap><?= $row['no_p1'] . '[' . $row['id'] . ']'; ?></td>
                                                                <td><?= $row['uraian_pekerjaan'] ?></td>
                                                                <td>
                                                                    <?php if ($row['nrab'] != 0) { ?>
                                                                        <a href="/kontrak/rab_sub_kontrak/<?= $rowId ?>">
                                                                            <button type="button" class="btn btn-success" title="Tampilkan RAB"><i class="fa fa-clipboard-list"></i> Tampilkan</button>
                                                                        </a>
                                                                    <?php } else { ?>
                                                                        <a href="/kontrak/rab_sub_kontrak/<?= $rowId ?>">
                                                                            <button type="button" class="btn btn-danger" title="BELUM ADA RAB"><i class="fa fa-clipboard-list"></i> Belum Ada</button>
                                                                        </a>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                    <?php $no++;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-footer">
                                            <a href="/kontrak/kontrak_sub_update/<?= $dtKontrak["id"] ?>">
                                                <button type="button" class="btn btn-primary float-right"><i class="fa fa-edit"></i> UPDATE SUB KONTRAK</button>
                                            </a>
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
                        <?= view('templates/notification'); ?>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->