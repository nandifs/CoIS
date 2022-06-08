    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mt-2">
                    <div class="card card-outline card-primary">
                        <div class="card-body pb-0">
                            <div class="form-group row">
                                <label for="input1" class="col-sm-2 col-form-label">Data Mitra Kerja</label>
                                <div class="col-sm-5">
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
                                <div class="col-sm-5">
                                    <div class="panel panel-default float-right">
                                        <div class="panel-body">
                                            <?php if ($dcUser['oid'] != 4) : ?>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-data"><i class="fa fa-plus"></i> Titik Inspeksi </button>
                                            <?php endif; ?>
                                            <a href="<?php echo base_url('titikinspeksi/cetak'); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Cetak Titik Inspeksi</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?= view('templates/notification'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php include 'add.php';  ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?= strtoupper($title); ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tbl-titik-inspeksi" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 30px;">No.</th>
                                        <th>Unit Mitra Kerja</th>
                                        <th>Grup</th>
                                        <th>Lokasi</th>
                                        <th>Aksi</th>
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
    </section>
    <!-- /.content -->