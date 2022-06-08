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
                        <li class="breadcrumb-item active"><?= $title; ?></li>
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
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-table mr-1"></i>DAFTAR <?= strtoupper($title); ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <input type="hidden" id="dt-akses" value="<?= $dcUser["data_akses_id"]; ?>" readonly>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-link" data-id="1"><i class="fa fa-clipboard-list"></i> Jadwal Per Regu</button>
                                                <button type="button" class="btn btn-default btn-link" data-id="2"><i class="fa fa-clipboard-list"></i> Jadwal Per Anggota</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="tbljwlpiket" class="table table-bordered" style="table-layout: fixed;">
                                            <thead style="padding:0">
                                                <tr style="padding:0">
                                                    <th rowspan="3" style="padding:0; vertical-align : middle; text-align: center; font-weight: normal;">#</th>
                                                    <th rowspan="3" style="padding:0; vertical-align : middle; text-align: center; font-weight: normal;">Nama</th>
                                                    <th colspan="31" style="padding:0; text-align: center;">BULAN <?= $blnTahun; ?></th>
                                                </tr>
                                                <tr>
                                                    <?php
                                                    $jmlhari = ambil_jumlah_hari(date('m'), 2021);
                                                    $fdate = date('Y-m-01');
                                                    $fday = date('N', strtotime($fdate));
                                                    $ahari = array(1 => 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', '<span style="color:red;">Min</span>');
                                                    $i = $fday;
                                                    for ($ctr = 1; $ctr <= $jmlhari; $ctr++) {
                                                        if ($i > 7) $i = 1;
                                                        echo "<th style='padding:0; text-align: center; font-weight: normal;'>$ahari[$i]</th>";
                                                        $i++;
                                                    }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <?php
                                                    for ($ctr = 1; $ctr <= $jmlhari; $ctr++) {
                                                        echo "<th style='padding:0; text-align: center; font-weight: normal;'>$ctr</th>";
                                                    }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                if (isset($dtRegu)) {
                                                    $regu = createJadPiket($jmlhari);
                                                    foreach ($dtRegu as $row) {
                                                        $rowId = $row['id'];
                                                        $namaRegu = $row['regu'];
                                                        if ($namaRegu != "Non Shift") {
                                                            echo "<tr>";
                                                            echo "<td style='padding:0; text-align: center;'>$no.</td>";
                                                            echo "<td style='padding:0; padding-left:5px;'>$row[regu]</td>";
                                                            for ($ctr = 1; $ctr <= $jmlhari; $ctr++) {
                                                                $shift = $regu[$no];
                                                                $sfc = $shift[$ctr - 1];
                                                                if ($sfc == "L") {
                                                                    echo "<td style='padding:0; text-align: center; background-color:red;' >" . $shift[$ctr - 1] . "</td>";
                                                                } else {
                                                                    echo "<td style='padding:0; text-align: center;'>" . $shift[$ctr - 1] . "</td>";
                                                                }
                                                            }
                                                            echo "</tr>";
                                                            $no++;
                                                        }
                                                    }
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
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>