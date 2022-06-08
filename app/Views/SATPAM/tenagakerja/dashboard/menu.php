<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header p-2">

    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Application Menus -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><strong> MENU APLIKASI</strong> </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-body text-center">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-12">
                                            <?php if (is_null($dtPresensiAktif)) { ?>
                                                <a href="/presensi_tk_add" class="btn btn-danger btn-lg btn-block" role="button"><i class="fas fa-user"></i> PRESENSI </br> (MASUK)</a>
                                            <?php } else { ?>
                                                <a href="/presensi_tk_out/<?= $dtPresensiAktif['id']; ?>" class="btn btn-success btn-lg btn-block" role="button"> PRESENSI </br> <i class="fas fa-door-open"></i> (PULANG)</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-6 col-md-6">
                                            <?php if (is_null($dtPresensiAktif)) { ?>
                                                <a href="/satpam_bukumutasi" class="btn btn-secondary btn-lg" role="button"><i class="fas fa-book"></i> <br />Buku Mutasi</a>
                                                <a href="/satpam_inspeksi" class="btn btn-secondary btn-lg" role="button"><i class="fas fa-user-shield"></i> <br />Inspeksi</a>
                                                <a href="/satpam_kegiatan" class="btn btn-secondary btn-lg" role="button"><i class="fas fa-user-shield"></i> <br /><small>Kegiatan/Kejadian</small></a>
                                            <?php } else { ?>
                                                <a href="/satpam_bukumutasi" class="btn btn-primary btn-lg" role="button"><i class="fas fa-book"></i> <br />Buku Mutasi</a>
                                                <a href="/satpam_inspeksi_add" class="btn btn-info btn-lg" role="button"><i class="fas fa-user-shield"></i> <br />Inspeksi</a>
                                                <a href="/satpam_kegiatan_add" class="btn btn-info btn-lg" role="button"><i class="fas fa-user-shield"></i> <br /><small>Kegiatan/Kejadian</small></a>
                                            <?php } ?>
                                        </div>
                                        <div class="col-xs-6 col-md-6">
                                            <?php if (is_null($dtPresensiAktif)) { ?>
                                                <a href="/satpam_bukutamu" class="btn btn-secondary btn-lg" role="button"><i class="fas fa-users"></i> <br />Buku Tamu</a>
                                                <a href="/satpam_kendaraan" class="btn btn-secondary btn-lg" role="button"><i class="fas fa-car"></i> <br />Kendaraan</a>
                                            <?php } else { ?>
                                                <a href="/satpam_bukutamu" class="btn btn-info btn-lg" role="button"><i class="fas fa-users"></i> <br />Buku Tamu</a>
                                                <a href="/satpam_kendaraan" class="btn btn-warning btn-lg" role="button"><i class="fas fa-car"></i> <br />Kendaraan</a>
                                            <?php } ?>
                                            <a href="/presensi_tk_data" class="btn btn-primary btn-lg" role="button"><i class="fas fa-user-check"></i><br />Data Presensi</a>
                                            <a href="/satpam_jadwalpiket_petugas" class="btn btn-default btn-lg" role="button"><i class="fas fa-calendar-alt"></i> <br />Jadwal Piket</a>
                                            <!--<a href="#" class="btn btn-info btn-lg" role="button"><i class="fas fa-list-alt"></i> <br />Catatan</a>
                                            <a href="#" class="btn btn-warning btn-lg" role="button"><i class="fas fa-envelope"></i> <br />Pesan</a>-->
                                        </div>
                                    </div>
                                    <hr>
                                    <a href="/login/user_logout" class="btn btn-danger btn-lg btn-block" role="button">> Keluar Aplikasi</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./card-body -->
                <div class="card-footer">
                    <span id="lbl-status">Status: </span>
                </div>
            </div>
            <!-- ./card -->
        </div>
        <!-- /.fluid -->
    </section>
    <!-- /.content -->
</div>