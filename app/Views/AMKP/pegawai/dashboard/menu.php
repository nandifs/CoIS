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
                                                <a href="/presensi_add" class="btn btn-danger btn-lg btn-block" role="button"><i class="fas fa-user"></i> PRESENSI </br> (MASUK)</a>
                                            <?php } else { ?>
                                                <a href="/presensi_out/<?= $dtPresensiAktif['id']; ?>" class="btn btn-success btn-lg btn-block" role="button"> PRESENSI </br> <i class="fas fa-door-open"></i> (PULANG)</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-6 col-md-6">
                                            <?php if (is_null($dtPresensiAktif)) { ?>
                                                <a href="#" class="btn btn-secondary btn-lg" role="button"><i class="fas fa-user-shield"></i> <br />Kegiatan</a>
                                            <?php } else { ?>
                                                <a href="/pegawai_kegiatan_add" class="btn btn-info btn-lg" role="button"><i class="fas fa-tasks"></i> <br />Kegiatan</a>
                                            <?php } ?>
                                            <a href="/pegawai_kegiatan_list" class="btn btn-warning btn-lg" role="button"><i class="fas fa-book"></i> <br />Data Kegiatan</a>
                                            <a href="/presensi_data" class="btn btn-primary btn-lg" role="button"><i class="fas fa-user-check"></i><br />Data Presensi</a>
                                        </div>

                                    </div>
                                    <hr>
                                    <a href="/login/user_logout" class="btn btn-danger btn-lg btn-block" role="button"><i class="fas fa-door-open"></i> Keluar Aplikasi</a>
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