<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?= strtoupper($title); ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><?= $title; ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Form Edit Data</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?= form_open('/pengawasan_bidang/update/' . $dt_pengawasan['id'], ['class' => 'form-horizontal']); ?>
                        <?= csrf_field(); ?>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="input1" class="col-sm-3 col-form-label">Nomor</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nomor" placeholder="Nomor Berkas Pengawasan" value="<?= $dt_pengawasan['nomor']; ?>" autofocus required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="satker" class="col-sm-3 col-form-label">Nama Satker</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='satker'>
                                        <?php foreach ($dt_satker as $satker) : ?>
                                            <option value=<?= $satker['id']; ?> <?= ($satker['id'] == $dt_pengawasan['unit_kerja_id']) ? "selected" : ""; ?>><?= $satker['nama']; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tahun" class="col-sm-3 col-form-label">Tahun Pengawasan</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='tahun'>
                                        <?php for ($i = 2019; $i <= 2023; $i++) { ?>
                                            <option <?= ($i == $dt_pengawasan['tahun']) ? "selected" : ""; ?>><?= $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="periode" class="col-sm-3 col-form-label">Periode Pengawasan</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name='periode'>
                                        <option <?= ($dt_pengawasan['periode'] == 'I') ? "selected" : ""; ?>>I</option>
                                        <option <?= ($dt_pengawasan['tahun'] == 'II') ? "selected" : ""; ?>>II</option>
                                        <option <?= ($dt_pengawasan['tahun'] = 'III') ? "selected" : ""; ?>>III</option>
                                        <option <?= ($dt_pengawasan['tahun'] == 'IV') ? "selected" : ""; ?>>IV</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tanggal Buat</label>
                                <div class="col-sm-9 input-group date" id="tanggal" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" name="tglbuat" data-target="#tanggal" value="<?= ubah_tgl4($dt_pengawasan['tanggal_dibuat']); ?>" />
                                    <div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-default" onclick="window.history.back()">Batal</button>
                            <button type="submit" class="btn btn-success float-right mr-1">Simpan</button>
                        </div>
                        <!-- /.card-footer -->
                        <?= form_close(); ?>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>