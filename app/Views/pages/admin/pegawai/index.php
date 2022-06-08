    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary mt-2">
                        <div class="card-body pb-0">
                            <?= form_open('/pegawai/add', ['class' => 'form-horizontal']); ?>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-2 col-form-label">Data Unitkerja</label>
                                <div class="col-sm-5">
                                    <select class="form-control select2" id="dt-akses" name='dtakses'>
                                        <?php foreach ($dtUnitkerja as $unitkerja) {
                                            $space = "";
                                            if ($unitkerja['kelas_id'] == 2) {
                                                $space = "&nbsp;&nbsp;&nbsp;&nbsp;|&rarr; ";
                                            } else if ($unitkerja['kelas_id'] == 3) {
                                                $space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&rarr; ";
                                            }
                                        ?>
                                            <?php if ($selUnitkerja == "") { ?>
                                                <option value=<?= $unitkerja['id']; ?> <?= ($unitkerja['id'] == 1) ? "selected" : ""; ?>><?= $space . $unitkerja['singkatan']; ?></option>
                                            <?php } else { ?>
                                                <option value=<?= $unitkerja['id']; ?> <?= ($unitkerja['id'] == $selUnitkerja) ? "selected" : ""; ?>><?= $space . $unitkerja['singkatan']; ?></option>
                                            <?php } ?>
                                        <?php
                                        }  ?>
                                    </select>
                                </div>
                                <div class="col-sm-5">
                                    <div class="panel panel-default float-right">
                                        <div class="panel-body">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Data Pegawai</button>
                                            <a href="pegawai/cetak" class="btn btn-primary" style="display:none"><i class="fa fa-print"></i> Cetak Daftar Pegawai</a>
                                            <button type="button" class="btn btn-warning <?= ($dcUser["oid"] != 1) ? "d-none" : ""; ?>" data-toggle="modal" data-target="#modal-import">
                                                <i class="fa fa-file-import"></i> Impor Data Pegawai
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
                            <h3 class="card-title">DAFTAR PEGAWAI</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tbl-pegawai" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 30px;">No.</th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Unit Kerja</th>
                                        <th>Penempatan</th>
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