<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary mt-2">
                    <div class="card-body pb-0">
                        <?= form_open_multipart('/tenagakerja_validasi_import_xls', ['class' => 'form-horizontal']); ?>
                        <div class="form-group row">
                            <label for="imp_data" class="col-sm-1.1 col-form-label">Import Data : </label>
                            <div class="col-sm-3">
                                <select class="form-control" id='imp_data' name='imp_data'>
                                    <option value=1 selected>TENAGA KERJA</option>
                                    <option value=2>HAK NORMATIF</option>
                                    <option value=3>PAYROLL</option>
                                </select>
                            </div>

                            <label for="exampleInputFile" class="col-sm-1.1 col-form-label">Pilih file Excel : </label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="imp_file">
                                        <label class="custom-file-label" for="exampleInputFile">Klik disini untuk memilih file yang akan di import</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <button type="submit" class="btn btn-primary <?= ($dcUser["oid"] != 1) ? "d-none" : ""; ?>" data-toggle="modal" data-target="#modal-import">
                                            <i class="fa fa-file-export"></i> Proses Import
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
                        <h3 class="card-title">DATA TENAGA KERJA</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body th-nowarp">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="th-nowarp">
                                    <th style="width: 30px;">No.</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Unit Kerja</th>
                                    <th>Penempatan</th>
                                    <th>Wilayah</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan=13></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
</section>
<!-- /.content -->