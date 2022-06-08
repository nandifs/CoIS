    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary mt-2">
                        <div class="card-body pb-0">
                            <div class="form-group row">
                                <label for="input1" class="col-sm-2 col-form-label">Template</label>
                                <div class="col-sm-5">
                                    <select class="form-control select2" id="dt-akses" name='dtakses' style="width: 100%;">
                                        <?php foreach ($dtTemplate as $template) : ?>
                                            <option value=<?= $template['id']; ?> <?= ($template['id'] == 1) ? "selected" : ""; ?>><?= $template['nama']; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                </div>
                                <div class="col-sm-5">
                                    <div class="panel panel-default float-right">
                                        <div class="panel-body">
                                            <button type="button" class="btn btn-primary" id="btn-simpan-template"><i class="fa fa-save"></i> Simpan Template</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?= view('templates/notification'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body" style="color:black;">
                            <!-- THE EDITOR -->
                            <div class="ck-content" id="editor">
                                <p>Load template laporan. Please Wait...</p>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->