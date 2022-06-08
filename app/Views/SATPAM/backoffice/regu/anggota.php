    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mt-2">
                    <?= form_open('reguanggota_tambah', ['class' => 'form-horizontal']); ?>
                    <?= csrf_field(); ?>
                    <div class="card card-primary card-outline collapsed-card">
                        <div class="card-header">

                            <button type="button" class="btn btn-default" data-card-widget="collapse" data-toggle="tooltip"><i class="fa fa-users"></i> Set Anggota Regu</button>

                            <div class="card-tools">
                                <a href="<?php echo base_url('satpam/jadwalpiket/' . $selDtAkses); ?>" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Kembali Ke Jadwal Piket</a>
                                <?= view('templates/notification'); ?>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">REGU</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='regu_id' autofocus>
                                        <?php foreach ($dtRegu as $regu) : ?>
                                            <option value=<?= $regu['id']; ?>><?= $regu['regu']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Petugas</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" style="width: 100%;" id="petugas_id" name="petugas_id">
                                        <option value="" selected>-- PILIH PETUGAS --</option>
                                        <?php foreach ($dtTenagakerja as $petugas) : ?>
                                            <option value=<?= $petugas['id']; ?>><?= $petugas['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Jabatan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="jabatan" placeholder="Jabatan" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Penempatan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="unit_kerja" placeholder="Unit Mitra Kerja" disabled>
                                    <input type="hidden" class="form-control" id="penempatan_id" name="penempatan_id" readonly>
                                </div>
                            </div>

                            <div class="form-group row d-none">
                                <label>Textarea</label>
                                <textarea class="form-control" id="dtpetugas-js" rows="3" placeholder="data_petugas"><?= json_encode($dtTenagakerja); ?></textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-default" onclick="window.history.back()">Batal</button>
                            <button type="submit" class="btn btn-success float-right mr-1">Simpan</button>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">DAFTAR ANGGOTA <?= strtoupper($title); ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="def-table-1" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 30px;">No.</th>
                                                <th>Penempatan</th>
                                                <th style="width: 100px;">Nama Regu</th>
                                                <th>Nama Anggota</th>
                                                <th>Jabatan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($dtAnggotaRegu as $row) {
                                                $id_row = $row['id'];
                                            ?>
                                                <tr>
                                                    <td><?php echo $no; ?>.</td>
                                                    <td><?php echo $row['penempatan']; ?></td>
                                                    <td><?php echo $row['regu']; ?></td>
                                                    <td><?php echo $row['petugas']; ?></td>
                                                    <td><?php echo $row['jabatan']; ?></td>
                                                    <td>
                                                        <a href="<?php echo base_url('satpam/reguanggota/delete/' . $id_row); ?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus data <?= $title; ?> : <?php echo $row['regu_id']; ?> ?')">
                                                            <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-alt"></i></button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->