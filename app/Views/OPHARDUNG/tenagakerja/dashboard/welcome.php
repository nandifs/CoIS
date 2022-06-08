<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Welcome Pages -->
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="card card-outline card-primary mt-3">
                        <div class="card-body">
                            <h2>Selamat Datang</h2>
                            <h5><?= $dcUser["uname"]; ?></h5>
                            <div class="photoimg">
                                <img src="/uploads/user/no_foto.png" class="img-fluid" style="height: 200px;" alt="">
                            </div>

                            <h4>Apakah anda akan mengisi presensi hari ini ?</h4>
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item">
                                    <a class="nav-link active" href="/presensi_tk_add">Ya</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/">Tidak</a>
                                </li>
                            </ul>
                            <hr class="d-sm-none">
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.fluid -->
    </section>
    <!-- /.content -->
</div>