    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary mt-2">
                        <div class="card-body pb-0">
                            <div class="form-group row">
                                <label for="input1" class="col-sm-2 col-form-label">Data Mitra Kerja</label>
                                <div class="col-sm-6">
                                    <select class="form-control select2" id="dt-akses" name='dtakses'>
                                        <?php
                                        //dd($selComboDtAkses);

                                        foreach ($dtMitraKerja as $mitra) :
                                            $space = "";
                                            if ($mitra['kelas'] == 2) {
                                                $space = "&nbsp;&nbsp;&nbsp;&nbsp;|&rarr; ";
                                            } else if ($mitra['kelas'] == 3) {
                                                $space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&rarr; ";
                                            } ?>
                                            <option value=<?= $mitra['id']; ?> <?= ($mitra['id'] == $selComboDtAkses) ? "selected" : ""; ?>><?= $space . $mitra['singkatan']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <select class="form-control" id="sel-periode" name='periode'>
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
                                    <button type="button" class="btn btn-primary" id="btn-tampilkan"><i class="fas fa-th-list"></i> Tampilkan</a>
                                </div>
                            </div>
                            <?= view('templates/notification'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">DAFTAR BUKU MUTASI</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tbl-buku-mutasi" class="table table-bordered">
                                <thead>
                                    <tr>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Shift</th>
                                        <th>Jam Dinas</th>
                                        <th>Petugas</th>
                                        <th>Unit Mitra Kerja</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
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