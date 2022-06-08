    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary mt-2">
                        <div class="card-body pb-0">
                            <div class="form-group row">
                                <label for="input1" class="col-sm-2 col-form-label">Data Mitra Kerja</label>
                                <div class="col-sm-5">
                                    <select class="form-control select2" id="dt-akses" name='dtakses' style="width: 100%;">
                                        <?php foreach ($dtMitraKerja as $mitra) : ?>
                                            <option value=<?= $mitra['id']; ?> <?= ($mitra['id'] == 1) ? "selected" : ""; ?>><?= $mitra['singkatan']; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <select class="form-control" id="periode" name='periode'>
                                        <?php
                                        $periodeLaporan = ambil_bulan_setahun_kebelakang();
                                        $selected = "selected";
                                        foreach ($periodeLaporan as $value) {
                                            echo "<option value='$value' $selected> " . ambil_bulan_tahun($value) . "</option>";
                                            $selected = "";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <div class="panel panel-default float-right">
                                        <div class="panel-body">
                                            <a href="<?php echo base_url('bukumutasi/cetak'); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Cetak Laporan</a>
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
                <div class="col-md-3">
                    <div class="sticky-top mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">HALAMAN</h4>
                            </div>
                            <div class="card-body">
                                <!-- the events -->
                                <?php
                                $btn_style = "btn btn-primary btn-block external-event text-left";
                                $btn_pages = [
                                    ['title' => "Cover", 'style' => $btn_style . ' btn-success'],
                                    ['title' => "Kata Pengantar", 'style' => $btn_style . ' btn-warning'],
                                    ['title' => "Daftar Isi", 'style' => $btn_style . ' btn-danger'],
                                    ['title' => "Pendahuluan", 'style' => $btn_style . ' btn-primary'],
                                    ['title' => "- Kekuatan Personil", 'style' => $btn_style . ' btn-info'],
                                    ['title' => "- Inventaris", 'style' => $btn_style . ' btn-info'],
                                    ['title' => "- Daftar Nama Personil", 'style' => $btn_style . ' btn-info'],
                                    ['title' => "- Data Mutasi, Disersi dan Grafik Absensi", 'style' => $btn_style . ' btn-info'],
                                    ['title' => "- Pelanggaran & Sanksi", 'style' => $btn_style . ' btn-info'],
                                    ['title' => "- Rangkuman Laporan Kejadian", 'style' => $btn_style . ' btn-info'],
                                    ['title' => "Penutup", 'style' => $btn_style . ' btn-success']
                                ];
                                ?>
                                <div id="external-events">
                                    <?php
                                    echo "<button type='button' class='btn btn-primary btn-block external-event text-center' id='btn-setting-laporan'>Setting Template</button><hr>";

                                    foreach ($btn_pages as $button) {
                                        echo "<button type='button' class='" . $button['style'] . "'>" . $button['title'] . "</button>";
                                    }

                                    echo "<hr> <button type='button' class='btn btn-primary btn-block external-event' id='btn-simpan-laporan'>Simpan Laporan</button>";

                                    echo "<hr> <button type='button' class='btn btn-primary btn-block external-event' id='btn-exp-words'>Export To Words</button>";
                                    echo "<button type='button' class='btn btn-primary btn-block external-event' id='btn-exp-pdf'>Export To PDF</button>";
                                    echo "<button type='button' class='btn btn-primary btn-block external-event' id='btn-print-doc'>PRINT</button>";
                                    ?>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-body" style="color: black !important;">
                            <!-- THE EDITOR -->
                            <div class="document-editor">
                                <div class="document-editor__toolbar"></div>
                                <div class="document-editor__editable-container">
                                    <div class="document-editor__editable" id="editor">
                                        <p>Load template laporan. Please Wait... </p>
                                    </div>
                                </div>
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